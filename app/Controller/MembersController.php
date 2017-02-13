<?php

define('GOOGLE_OAUTH_CLIENT_ID', '224622734092-vjvk608ujl9hvq7gegaogs9bdclkvbb9.apps.googleusercontent.com');
define('GOOGLE_OAUTH_CLIENT_SECRET', 'Cs_j3NEzsFI4fMtoUcAsSTJz');
define('GOOGLE_OAUTH_REDIRECT_URI', 'http://s627959079.onlinehome.fr/members/google_login');

App::uses('CakeEmail', 'Network/Email');
App::uses('EarningsEventListener', 'Event');

require_once '../Vendor/google-api-php-client-2.1.1/vendor/autoload.php'; 

class MembersController extends AppController {

    public $uses = array('Member', 'Workout', 'Device', 'Log');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('signup', 'signin', 'facebook', 'googlelogin', 'google_login', 'forgottenPassword');
    }

    public function index() {
        if ($this->Auth->loggedIn()) {
            $this->redirect(array('controller' => 'members', 'action' => 'profile'));
        }
        $this->redirect(array('controller' => 'pages', 'action' => 'home'));
    }

    public function signup() {
        $listener = new EarningsEventListener();
        $this->Member->getEventManager()->attach($listener);

        if ($this->Auth->loggedIn()) {
            $this->redirect(array('controller' => 'pages', 'action' => 'home'));
        }
        if ($this->request->is('post')) {
            if ($this->request->data['Member']['password'] != $this->request->data['Member']['confirmPassword']) {
                $this->Flash->error('Please confirm password.');
            } else {
                $data = $this->request->data;
                $this->Member->create();
                $data['Member']['id'] = null;
                $data['Member']['password'] = Security::hash($data['Member']['password'], 'sha1', true);
                if ($this->Member->save($data, true, array('id', 'email', 'password'))) {
                    $event = new CakeEvent('Model.Member.create', $this->Member);
                    $this->Member->getEventManager()->dispatch($event);
                    $this->Auth->login();
                    $this->Session->write('memberId', $this->Auth->user('id'));
                    $this->Session->write('googleLogin', false);
                    $this->Session->write('facebookLogin', false);

                    $mail = new CakeEmail();
                    $mail->to($data['Member']['email'])
                            ->from('contact.sportmanager@gmail.com')
                            ->subject('Sportmanager - Registration')
                            ->emailFormat('html')
                            ->template('registration')
                            ->viewVars(array('email' => $data['Member']['email']));
                    if ($mail->send()) {
                        $this->Flash->success('Registration complete, welcome to Sportmanager !');
                    }
                    return $this->redirect($this->Auth->redirect());
                } else {
                    $this->Flash->error('A registration problem occured.');
                }
            }
        }
    }

    public function signin() {
        $listener = new EarningsEventListener();
        $this->Member->getEventManager()->attach($listener);

        if ($this->Auth->loggedIn()) {
            $this->redirect(array('controller' => 'pages', 'action' => 'home'));
        }
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $member = $this->Member->find('first', array('conditions' => array('Member.email' => $data['Member']['email'])));
            if ($member) {
                $event = new CakeEvent('Model.Member.sign', $member);
                $this->Member->getEventManager()->dispatch($event);
                if ($this->Auth->login()) {
                    $this->Session->write('memberId', $this->Auth->user('id'));
                    $this->Session->write('googleLogin', false);
                    $this->Session->write('facebookLogin', false);
                    return $this->redirect($this->Auth->redirect());
                } else {
                    $this->Flash->error('Invalid email or password');
                }
            } else {
                $this->Flash->error('User doesn\'t exist.');
            }
        }
    }

    public function logout() {
        $this->Session->destroy();
        $this->Auth->logout();
        $this->Flash->notify('Logged out.');
        $this->redirect($this->Auth->logout());
    }

    function sendPasswordEmail($email = null) {
        $data = $this->Member->find('first', array('conditions' => array('Member.email' => $email)));
        if (!$data) {
            return 3;
        } else {
            $mail = $data['Member']['email'];
            $link = array('controller' => 'Members', 'action' => 'forgottenPassword', 'token' => substr($data['Member']['id'], 0, 8) . '-' . md5($data['Member']['password']));
            $email = new CakeEmail();
            $email->from('contact.sportmanager@gmail.com');
            $email->to($mail);
            $email->emailFormat('html');
            $email->subject('Password reset instructions from');
            $email->viewVars(array('email' => $data['Member']['email'], 'link' => $link));
            $email->template('reset');
            if ($email->send('reset')) {
                return 1;
            } else {
                return 2;
            }
        }
    }

    public function forgottenPassword() {
        //Si un lien a été suivi il y a un token dans l'url
        if (!empty($this->request->params['named']['token'])) {
            $token = $this->request->params['named']['token'];
            $this->Session->write('token', $token);
            $token = explode('-', $token);
            $user = $this->Member->find('first', array(
                'conditions' => array(
                    'id LIKE' => $token[0] . '%',
                    'MD5(password)' => $token[1]
            )));
            if ($user) {
                $this->Session->write('userid', $user['Member']['id']);
                $this->set('valide', 1);
            } else {
                $this->Flash->error("Invalid link");
            }
        }

        //If there is a post
        if ($this->request->is('post')) {
            if (isset($this->request->data['Password'])) {
                if ($this->request->data['Password']['password'] != $this->request->data['Password']['confirmPassword']) {
                    $this->Flash->error('Please confirm password');
                    $this->set('valide', 1);
                } else {
                    $data = $this->request->data['Password'];
                    $passwordresult = $this->newPassword($data);
                    switch ($passwordresult) {
                        case 1:
                            $this->Flash->success('Your password has been updated !');
                            $this->redirect(array('controller' => 'Members', 'action' => 'signin'));
                            break;
                        case 2:
                            break;
                    }
                }
            } elseif (isset($this->request->data['Member'])) {
                $email = $this->request->data['Member']['email'];
                $sentreturn = $this->sendPasswordEmail($email);
                switch ($sentreturn) {
                    case 1 :
                        $this->Flash->notify('Please check your mailbox for reset instructions');
                        break;
                    case 2 :
                        $this->Flash->error('Something went wrong with activation mail. Please try again later.');
                        break;
                    case 3 :
                        $this->Flash->error('No such e-mail address registerd with us.');
                        break;
                }
            }
        }
    }

    function newPassword($data = null) {
        $data['password'] = Security::hash($data['password'], 'sha1', true);
        $this->Member->id = $this->Session->read('userid');
        if ($this->Member->saveField('password', $data['password'])) {
            $this->Session->delete('userid');
            return 1;
        } else {
            return 2;
        }
    }

    public function facebook() {
        if ($this->Auth->loggedIn()) {
            $this->redirect(array('controller' => 'pages', 'action' => 'home'));
        }

        require APPLIBS . 'Facebook' . DS . 'Facebook.php';

        $facebook = new Facebook(array(
            'appId' => '1280842021932545',
            'secret' => '9e02e1006b91d1784a37f0b8385631ed',
            'cookie' => true,
        ));

        $user = $facebook->getUser();

        if ($user) {
            try {
                $infos = $facebook->api('/' . $user . '?fields=id,first_name,last_name,email,picture');
                $password = Security::hash($infos['id'], 'sha1', true);
                $email = $infos['email'];
                $data = array('email' => $email, 'password' => $password);
                $listener = new EarningsEventListener();
                $this->Member->getEventManager()->attach($listener);
                $member = $this->Member->find('first', array('conditions' => array('Member.email' => $data['email'])));

                if ($member) {
                    $this->request->data['Member']['id'] = $member['Member']['id'];
                    if ($this->Auth->login($this->request->data['Member'])) {
                        $event = new CakeEvent('Model.Member.sign', $member);
                        $this->Member->getEventManager()->dispatch($event);
                        $this->Session->write('memberId', $this->Auth->user('id'));
                        $this->Session->write('facebookLogin', true);
                        $this->Session->write('firstName', $infos['first_name']);
                        $this->Session->write('lastName', $infos['last_name']);
                        $this->Session->write('picture', $infos['picture']['data']['url']);
                        return $this->redirect($this->Auth->redirect());
                    } else {
                        $this->Flash->error('Authentication error.');
                    }
                } else {
                    $this->Member->create();
                    if ($this->Member->save($data, true, array('email', 'password'))) {
                        $event = new CakeEvent('Model.Member.create', $this->Member);
                        $this->Member->getEventManager()->dispatch($event);
                        $this->request->data['Member']['id'] = $this->Member->getLastInsertID();
                        if ($this->Auth->login($this->request->data['Member'])) {
                            $this->Session->write('memberId', $this->Auth->user('id'));
                            $this->Session->write('facebookLogin', true);
                            $this->Session->write('firstName', $infos['first_name']);
                            $this->Session->write('lastName', $infos['last_name']);
                            $this->Session->write('picture', $infos['picture']['data']['url']);
                            $this->Flash->success('Registration complete, welcome to Sportmanager !');
                            return $this->redirect($this->Auth->redirect());
                        } else {
                            $this->Flash->error(('Authentication error.'));
                        }
                    } else {
                        $this->Flash->error('A problem occured. Please try again.');
                    }
                }
            } catch (FacebookApiException $e) {
                debug($e);
            }
        } else {
            $this->Flash->error('Identification error.');
        }
    }

    // Google authentication request
    public function googlelogin() {
        if ($this->Auth->loggedIn()) {
            $this->redirect(array('controller' => 'pages', 'action' => 'home'));
        }
        $this->autoRender = false;
        $client = new Google_Client();
        $client->setClientId(GOOGLE_OAUTH_CLIENT_ID);
        $client->setClientSecret(GOOGLE_OAUTH_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_OAUTH_REDIRECT_URI);
        $client->setScopes(array(
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/userinfo.profile'));
        $this->redirect($client->createAuthUrl());
    }

    // Google authentication callback
    public function google_login() {
        if ($this->Auth->loggedIn()) {
            $this->redirect(array('controller' => 'pages', 'action' => 'home'));
        }
        $client = new Google_Client();
        $client->setClientId(GOOGLE_OAUTH_CLIENT_ID);
        $client->setClientSecret(GOOGLE_OAUTH_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_OAUTH_REDIRECT_URI);
        $client->setScopes(array(
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/userinfo.profile'));
        $client->setApprovalPrompt('auto');

        if (isset($this->request->query['code'])) {
            $client->authenticate($this->request->query['code']);
            $this->Session->write('access_token', $client->getAccessToken());
        }

        if ($this->Session->check('access_token') && ($this->Session->read('access_token'))) {
            $client->setAccessToken($this->Session->read('access_token'));
        }

        $accessToken = $client->getAccessToken();
        if ($accessToken) {
            $this->Session->write('access_token', $accessToken);

            $oauth2 = new Google_Service_Oauth2($client);
            $user = $oauth2->userinfo->get();

            try {
                if (!empty($user)) {
                    $listener = new EarningsEventListener();
                    $this->Member->getEventManager()->attach($listener);
                    $member = $this->Member->find('first', array('conditions' => array('Member.email' => $user['email'])));
                    if ($member) {
                        $this->request->data['Member']['id'] = $member['Member']['id'];
                        if ($this->Auth->login($this->request->data['Member'])) {
                            $event = new CakeEvent('Model.Member.sign', $member);
                        $this->Member->getEventManager()->dispatch($event);
                            $this->Session->write('memberId', $this->Auth->user('id'));
                            $this->Session->write('googleLogin', true);
                            $this->Session->write('givenName', $user['givenName']);
                            $this->Session->write('familyName', $user['familyName']);
                            $this->Session->write('picture', $user['picture']);
                            return $this->redirect($this->Auth->redirect());
                        } else {
                            $this->Flash->error('A problem occured. Please try again.');
                        }
                    } else {
                        $email = $user['email'];
                        $password = Security::hash($user['id'], 'sha1', true);
                        $data = array('email' => $email, 'password' => $password);
                        $this->Member->create();
                        if ($this->Member->save($data, true, array('email', 'password'))) {
                            $event = new CakeEvent('Model.Member.create', $this->Member);
                            $this->Member->getEventManager()->dispatch($event);
                            $this->request->data['Member']['id'] = $this->Member->getLastInsertID();
                            $this->Auth->login($this->request->data['Member']);
                            $this->Session->write('memberId', $this->Auth->user('id'));
                            $this->Session->write('googleLogin', true);
                            $this->Session->write('givenName', $user['givenName']);
                            $this->Session->write('familyName', $user['familyName']);
                            $this->Session->write('picture', $user['picture']);
                            $this->Flash->success('Registration complete, welcome to Sportmanager !');
                            return $this->redirect($this->Auth->redirect());
                        } else {
                            pr($data);
                            $this->Flash->error('There was a problem with your registration. Please, try again.');
                        }
                    }
                } else {
                    $this->Flash->error('Google information not found.');
                    $this->redirect($this->Auth->redirect());
                }
            } catch (\Exception $e) {
                $this->Flash->error('Google error.');
                return $this->redirect($this->Auth->redirect());
            }
        }
    }

    public function profile() {
        $member = $this->Member->find('first', array('conditions' => array('Member.id' => $this->Session->read('memberId'))));

        $this->set('earnings', $this->Earning->find('all', array('conditions' => array('Member.id' => $this->Auth->user()))));
        $this->set('stickers', $this->Sticker->find('all'));
        $this->set('workouts', $this->Workout->find('all', array(
                    'conditions' => array('Workout.member_id' => $this->Session->read('memberId')),
                    'order' => array('Workout.end_date' => 'DESC'))
        ));
        $this->set('devices', $member['Device']);
    }

    public function myWorkouts() {
        $members = $this->Member->find('all');
        $workouts = $this->Workout->find('all', array(
            'conditions' => array(
                'Workout.member_id' => $this->Auth->user()),
            'fields' => array('Workout.id', 'Workout.member_id', 'Workout.date', 'Workout.end_date', 'Workout.location_name', 'Workout.description', 'Workout.sport')
        ));
        $lworkouts = $this->Log->find('all', array(
            'conditions' => array(
                'Log.member_id' => $this->Auth->user())
        ));

        $sports = array(
            '100m hurdles' => '100m hurdles',
            'Tennis' => 'Tennis',
            'Quidditch' => 'Quidditch',
            'Beer Pong' => 'Beer Pong',
            'Cricket' => 'Cricket',
            'Soccer' => 'Soccer');

        $tabCurrent = array();
        $tabPast = array();
        $tabFuture = array();
        foreach ($workouts as $workout):
            if ((strtotime($workout['Workout']['end_date']) < strtotime(date('Y-m-d H:i'))) &&
                    (!in_array($workout['Workout'], $tabPast))) {
                array_push($tabPast, $workout['Workout']);
            } elseif ((strtotime($workout['Workout']['date']) < strtotime(date('Y-m-d H:i'))) &&
                    (strtotime($workout['Workout']['end_date']) > strtotime(date('Y-m-d H:i'))) &&
                    (!in_array($workout['Workout'], $tabCurrent))) {
                array_push($tabCurrent, $workout['Workout']);
            } elseif ((strtotime($workout['Workout']['date']) > strtotime(date('Y-m-d H:i'))) &&
                    (!in_array($workout['Workout'], $tabFuture))) {
                array_push($tabFuture, $workout['Workout']);
            }
        endforeach;

        foreach ($lworkouts as $lworkout):
            if (($lworkout['Workout']['member_id'] != $lworkout['Member']['id'])) {
                if ((strtotime($lworkout['Workout']['end_date']) < strtotime(date('Y-m-d H:i'))) &&
                        (!in_array($lworkout['Workout'], $tabPast))) {
                    array_push($tabPast, $lworkout['Workout']);
                } elseif ((strtotime($lworkout['Workout']['date']) < strtotime(date('Y-m-d H:i'))) &&
                        (strtotime($lworkout['Workout']['end_date']) > strtotime(date('Y-m-d H:i'))) &&
                        (!in_array($lworkout['Workout'], $tabCurrent))) {
                    array_push($tabCurrent, $lworkout['Workout']);
                } elseif ((strtotime($lworkout['Workout']['date']) > strtotime(date('Y-m-d H:i'))) &&
                        (!in_array($lworkout['Workout'], $tabFuture))) {
                    array_push($tabFuture, $lworkout['Workout']);
                }
            }
        endforeach;

        if ($tabPast) {
            $tabDes = $tabPast;
            $tabAsc = $tabPast;
            foreach ($tabPast as $key => $row) {
                $date[$key] = $row['date'];
            }
            array_multisort($date, SORT_DESC, $tabDes);
            foreach ($tabPast as $key => $row) {
                $date[$key] = $row['date'];
            }
            array_multisort($date, SORT_ASC, $tabAsc);

            $this->set('tabAsc', $tabAsc);
            $this->set('tabDes', $tabDes);
        } else {
            $this->set('tabAsc', null);
            $this->set('tabDes', null);
        }

        $this->set('sports', $sports);
        $this->set('members', $members);

        $this->set('pastWorkouts', $tabPast);
        $this->set('currentWorkouts', $tabCurrent);
        $this->set('futureWorkouts', $tabFuture);

        if ((count($tabPast) != 0) || (count($tabCurrent) != 0) || (count($tabFuture) != 0)) {
            $this->Stat();
        }

        if ($this->request->is('post')) {
            $this->addWorkout();
            $this->set('var', 'displayedContent');
        } else {
            $this->set('var', 'hiddenContent');
        }
    }

    public function addWorkout() {
        $listener = new EarningsEventListener();
        $this->Workout->getEventManager()->attach($listener);
        $data = $this->request->data;
        $member = $this->Member->find('first', array('conditions' => array('Member.id' => $this->Session->read('memberId'))));
        $data['Workout']['member_id'] = $member['Member']['id'];
        $data['Workout']['id'] = null;
        $this->Workout->create();
        if ($this->Workout->save($data, true, array('id', 'member_id', 'date', 'end_date', 'location_name', 'description', 'sport'))) {
            $event = new CakeEvent('Model.Workout.add', $this->Workout, $data['Workout']);
            $this->Workout->getEventManager()->dispatch($event);
            $this->Flash->success('A new workout has been added.');
            return $this->redirect(array('action' => 'myWorkouts'));
        }
        $this->Flash->error('Unable to add new workout.');
    }

    public function Stat() {
        $statTable = array();

        $bonMec = $this->Session->read('memberId');

        $statTable["nombre2Logs"] = $this->Log->query("SELECT COUNT(*) FROM logs WHERE member_id='$bonMec';");
        $statTable["nombre2Workout"] = $this->Log->query("SELECT COUNT(*) FROM workouts WHERE member_id='$bonMec';");

        $matin = $this->Log->query("SELECT count(EXTRACT(DAY_HOUR FROM date)) FROM workouts WHERE member_id='2' AND EXTRACT(DAY_HOUR FROM date)>=5 AND EXTRACT(DAY_HOUR FROM date)<13 AND member_id='$bonMec';");
        $Aprem = $this->Log->query("SELECT count(EXTRACT(DAY_HOUR FROM date)) FROM workouts WHERE member_id='2' AND EXTRACT(DAY_HOUR FROM date)>=13 AND EXTRACT(DAY_HOUR FROM date)<18 AND member_id='$bonMec';");
        $Soir = $this->Log->query("SELECT count(EXTRACT(DAY_HOUR FROM date)) FROM workouts WHERE member_id='2' AND EXTRACT(DAY_HOUR FROM date)>=18 AND EXTRACT(DAY_HOUR FROM date)<22 AND member_id='$bonMec';");
        $Zarbi = $this->Log->query("SELECT count(EXTRACT(DAY_HOUR FROM date)) FROM workouts WHERE member_id='2' AND EXTRACT(DAY_HOUR FROM date)>=22 AND EXTRACT(DAY_HOUR FROM date)<5 AND member_id='$bonMec';");

        switch (max($matin, $Aprem, $Soir, $Zarbi)) {
            case $matin:
                $moment = "morning";
                break;

            case $Aprem:
                $moment = "afternoon";
                break;

            case $Soir:
                $moment = "evening";
                break;

            case $Zarbi:
                $moment = "strange moment";
                break;
        }

        $statTable["momentSportif"] = $moment;

        $dureeTot = $this->Log->query("SELECT FLOOR(SUM(TIMEDIFF(end_date, date))) FROM workouts WHERE member_id='2';");

        $a = $dureeTot[0][0];
        $b = $statTable["nombre2Workout"][0][0];
        $duree = ($a["FLOOR(SUM(TIMEDIFF(end_date, date)))"] / $b["COUNT(*)"]);

        $heures = intval($duree / 3600);
        $minutes = intval(($duree % 3600) / 60);

        $statTable["TrainTime"]["heure"] = $heures;
        $statTable["TrainTime"]["minutes"] = $minutes;

        $this->set('statTable', $statTable);
    }

    public function myLogs($id = null, $sport = null) {
        $workout = $this->Workout->findById($id);
        if ((!$id) || (!$sport) || (!$workout)) {
            return $this->redirect(array('action' => 'myWorkouts'));
        }
        $member = $this->Member->find('first', array('conditions' => array('Member.id' => $this->Session->read('memberId'))));
        $members = $this->Member->find('all');
        $logs = $this->Log->findAllByWorkoutId($id);
        $devices = $this->Device->find('all');

        switch ($sport) {
            case 'Tennis':
                $type = array(
                    'Smashes' => 'Smashes',
                    'Aces' => 'Aces',
                    'Volleys' => 'Volleys');
                break;

            case '100m hurdles':
                $type = array(
                    'Seconds' => 'Seconds',
                    'Steps' => 'Steps',
                    'Hurdles jumped' => 'Hurdles jumped');
                break;
            case 'Quidditch':
                $type = array(
                    'Golden Snitch catched' => 'Golden Snitch catched',
                    'Quaffle scored' => 'Quaffle scored',
                    'Bludgers knocked' => 'Bludgers knocked');
                break;
            case 'Beer Pong':
                $type = array(
                    'Bounce shots' => 'Bounce shots',
                    'Normal shots' => 'Normal shots',
                    'Blown balls' => 'Blown balls');
                break;
            case 'Cricket':
                $type = array(
                    'Full toss' => 'Full toss',
                    'Caught out' => 'Caught out',
                    'Penalty' => 'Penalty');
                break;
            case 'Soccer':
                $type = array(
                    'Goals' => 'Goals',
                    'Passes' => 'Passes',
                    'Shots' => 'Shots');
                break;
        }

        $this->set('member', $member);
        $this->set('members', $members);
        $this->set('logs', $logs);
        $this->set('type', $type);
        $this->set('id', $id);
        $this->set('sport', $sport);
        $this->set('workout', $workout);
        $this->set('dateNow', date('Y-m-d H:i'));
        $this->set('devices', $devices);

        if ($this->request->is('post')) {
            $this->set('var', 'displayedContent');
            $this->addLog($sport);
        } else {
            $this->set('var', 'hiddenContent');
        }
    }

    public function addLog($sport) {
        $listener = new EarningsEventListener();
        $this->Log->getEventManager()->attach($listener);

        if ($this->request->is('post')) {
            $member = $this->Member->find('first', array('conditions' => array('Member.id' => $this->Session->read('memberId'))));
            $userDevice = $this->Device->findBySerial('serial' . $member['Member']['id']);

            // Add the device to trusted device if not already in database
            if (!$userDevice) {
                $this->Device->create();
                $device = array(
                    'id' => null,
                    'member_id' => $member['Member']['id'],
                    'description' => 'User device',
                    'trusted' => 1,
                    'serial' => 'serial' . $member['Member']['id']);
                if ($this->Device->save($device, false, array('id', 'member_id', 'description', 'serial', 'trusted'))) {
                    $userDevice = $this->Device->findBySerial('serial' . $member['Member']['id']);
                    $deviceEvent = new CakeEvent('Model.Device.homeDevice', $this->Device, $member['Member']);
                    $this->Log->getEventManager()->dispatch($deviceEvent);
                } else {
                    $this->Flash->error('An error occured while trusting this device.');
                }
            }

            if ($userDevice) {
                if ($userDevice['Device']['trusted'] == 0) {
                    $this->Flash->error('Device not trusted');
                } else {
                    $data = $this->request->data;
                    $workoutId = $data['Log']['workout_id'];
                    $workout = $this->Workout->findById($workoutId);
                    $data['Log']['member_id'] = $member['Member']['id'];
                    $data['Log']['date'] = date('Y-m-d H:i', time());
                    if (($data['Log']['date'] > $workout['Workout']['date']) && ($data['Log']['date'] < $workout['Workout']['end_date'])) {
                        $data['Log']['device_id'] = $userDevice['Device']['id'];
                        if ($this->Log->addLog($data)) {
                            $rankings = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='" . $data['Log']['log_type'] . "' GROUP BY member_id ORDER BY SUM(log_value) DESC");
                            $rankingsEvent = new CakeEvent('Rankings', $member, array($member['Member'], $rankings));
                            $firstLog = new CakeEvent('Model.Log.add', $member, $member['Member']);
                            $this->Log->getEventManager()->dispatch($rankingsEvent);
                            $this->Log->getEventManager()->dispatch($firstLog);
                            $this->Flash->success('A new log has been added.');
                            return $this->redirect(array('action' => 'myLogs', $data['Log']['workout_id'], $sport));
                        } else {
                            $this->Flash->error('Unable to add new log.');
                        }
                    } else {
                        $this->Flash->error('Date incompatible with workout\'s dates');
                    }
                }
            }
        }
    }

    public function myDevices() {
        $member = $this->Member->find('first', array('conditions' => array('Member.id' => $this->Auth->user())));
        $devices = $member['Device'];
        $this->set('member', $member);
        $this->set('devices', $devices);
        $nbuntrustedDevice = $this->Device->find('count', array(
            'conditions' => array(
                'Device.trusted' => 0,
                'Device.member_id' => $this->Session->read('memberId')
            )
        ));
        $this->set('nbuntrusteddevice', $nbuntrustedDevice);
    }

    public function denyRequest($id) {
        if ($this->request->is('post')) {
            if ($this->Device->delete($id)) {
                $this->Flash->success('The device has been deleted.');
            } else {
                $this->Flash->error('The device could not be deleted.');
            }
            return $this->redirect(array('action' => 'myDevices'));
        }
    }

    public function unTrustDevice($id) {
        $this->Device->id = $id;
        if ($this->Device->saveField('trusted', '0')) {
            $this->Flash->notify('Device untrusted');
            return $this->redirect(array('action' => 'myDevices'));
        } else {
            $this->Flash->error('An error occurred while trying to untrust the device');
            return $this->redirect(array('action' => 'myDevices'));
        }
    }

    public function trustDevice($id) {
        $listener = new EarningsEventListener();
        $this->Device->getEventManager()->attach($listener);
        $this->Device->id = $id;
        $member = $this->Member->find('first', array('conditions' => array('Member.id' => $this->Session->read('memberId'))));
        if ($this->Device->saveField('trusted', '1')) {
            $event = new CakeEvent('Model.Device.trust', $this->Device, $member['Member']);
            $this->Device->getEventManager()->dispatch($event);
            $this->Flash->success('Device trusted');
            return $this->redirect(array('controller' => 'Members', 'action' => 'myDevices'));
        } else {
            $this->Flash->success('An error occurred when trusting the device');
            return $this->redirect(array('controller' => 'Members', 'action' => 'myDevices'));
        }
    }

    public function account() {
        $this->set('id', $this->Session->read('memberId'));
        $this->set('member', $this->Member->findById($this->Session->read('memberId')));
        if ($this->request->is('post')) {
            if (!empty($this->request->data['Member'])) {
                if (!empty($this->request->data['Member']['email'])) {
                    $member = $this->Member->findById($this->Session->read('memberId'));
                    $this->Member->id = $this->Session->read('memberId');
                    if ($this->request->data['Member']['email'] != $member['Member']['email']) {
                        if ($this->Member->saveField('email', $this->request->data['Member']['email'])) {
                            $this->Flash->success('Profile edited with success');
                        } else {
                            $this->Flash->error('An unexpected error appeared. Call 06.37.17.08.87 for debugging ');
                        }
                    }
                }

                if (!empty($this->request->data['Member']['avatar']['tmp_name'])) {
                    $extension = strtolower(pathinfo($this->request->data['Member']['avatar']['name'], PATHINFO_EXTENSION));
                    if (in_array($extension, array('jpg', 'jpeg', 'png'))) {
                        if ($this->request->data['Member']['avatar']['size'] < 2000000) {
                            $FinalImg = $this->Member->saveImage($this->request->data['Member']['avatar']['tmp_name'], $extension);
                            if (imagepng($FinalImg, WWW_ROOT . 'img/avatars/' . DS . $this->Session->read('memberId') . '.' . 'png', 0)) {
                                $this->Flash->success('Avatar uploaded with success');
                            } else {
                                $this->Flash->error('An unexpected error appeared. Call 06.37.17.08.87 for debugging ');
                            }
                        } else {
                            $this->Flash->error('This file is too big. File must be under 1 Mo.');
                        }
                    } else {
                        $this->Flash->error('You cannot send this type of file');
                    }
                }
            }
            return $this->redirect(array('controller' => 'members', 'action' => 'account'));
        }
    }

    public function DeleteAccount() {
        if ($this->Member->delete($this->Session->read('memberId'), false)) {
            $this->logout();
        }
    }

}
