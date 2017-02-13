<?php

App::uses('Controller', 'Controller');
App::uses('CakeEmail', '/Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

App::import('Vendor', 'google-api-php-client-2.1.1/vendor/autoload.php');

class AppController extends Controller {

    public $uses = array('Member', 'Workout', 'Device', 'Log', 'Earning', 'Sticker', 'Contact');
    public $helpers = array('Facebook.Facebook', 'Form', 'Html');
    public $components = array(
        'Cookie',
        'Session',
        'Facebook.Connect' => array('model' => 'Member'),
        'Flash',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'Member',
                    'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    ),
                    'passwordHasher' => array(
                        'className' => 'Simple',
                        'hashType' => 'sha1'
                    ))),
            'loginRedirect' => array('controller' => 'members', 'action' => 'profile'),
            'logoutRedirect' => array('controller' => 'members', 'action' => 'signin'),
            'loginAction' => array('controller' => 'members', 'action' => 'signin')
        )
    );

    function beforeRender() {
        $this->set('loggedIn', $this->Auth->loggedIn());

        if ($this->Auth->loggedIn()) {
            $id = $this->Session->read('memberId');
            $user = $this->Member->find('first', array('conditions' => array('Member.id' => $id)));

            $this->set('user', $user['Member']);
            $this->set('username', substr($user['Member']['email'], 0, strrpos($user['Member']['email'], "@")));
            $this->set('googleLogin', $this->Session->read('googleLogin'));
            $this->set('facebookLogin', $this->Session->read('facebookLogin'));

            if ($this->Session->read('googleLogin')) {
                $this->set('username', $this->Session->read('givenName') . ' ' . $this->Session->read('familyName'));
                $this->set('givenName', $this->Session->read('givenName'));
                $this->set('familyName', $this->Session->read('familyName'));
                $this->set('picture', $this->Session->read('picture'));
            } else if ($this->Session->read('facebookLogin')) {
                $this->set('username', $this->Session->read('firstName') . ' ' . $this->Session->read('lastName'));
                $this->set('firstName', $this->Session->read('firstName'));
                $this->set('lastName', $this->Session->read('lastName'));
                $this->set('picture', $this->Session->read('picture'));
            } else {
                $avatarsFolder = new Folder('../webroot/img/avatars');
                $avatars = $avatarsFolder->find('.*\.png');
                foreach ($avatars as $avatar) {
                    $avatar = new File($avatarsFolder->pwd() . DS . $avatar);
                    if (str_replace('.png', '', $avatar->name) == $user['Member']['id']) {
                        $this->Session->write('picture', 'avatars/' . $avatar->name);
                        $this->set('picture', $this->Session->read('picture'));
                    }
                    $avatar->close();
                }
            }
        }
    }

}
