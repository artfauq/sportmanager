<?php

App::uses('AppController', 'Controller');

class ApisController extends AppController {

    public $uses = array('Member', 'Workout', 'Device', 'Log');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public function signup() {
        $this->layout = 'ajax';
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = Security::hash($_POST['password'], 'sha1', true);
            $member = $this->Member->find('first', array(
                'conditions' => array(
                    'email' => $email
                )
            ));

            if (!$member) {
                $this->Member->create();
                $data['Member']['id'] = null;
                $data['Member']['email'] = $email;
                $data['Member']['password'] = Security::hash($_POST['password'], 'sha1', true);
                if ($this->Member->save($data, true, array('id', 'email', 'password'))) {
                    $response = $this->Member->id;
                } else {
                    $response = "Could not sign up your profile";
                }
            } else {
                $response = "Email already used";
            }
        } else {
            $response = "Could not sign up your profile";
        }

        $this->set('response', $response);
    }

    public function checkdevice() {
        $this->layout = 'ajax';

        if (isset($_POST['member_id']) && isset($_POST['serial'])) {
            $memberid = $_POST['member_id'];
            $serial = $_POST['serial'];

            $member = $this->Member->find('first', array('conditions' => array(
                    'id' => $memberid
            )));

            $member = $this->Member->findById($memberid);
            $response = "";
            $memberdevices = $member['Device'];

            // If this member has registered devices
            if ($memberdevices) {
                // We search for this particular device
                foreach ($memberdevices as $memberdevice) {
                    if ($memberdevice['serial'] == $serial) {
                        if ($memberdevice['trusted'] == 1) {
                            $response = "This device is trusted.";
                        } else {
                            $response = "This device is currently not trusted.";
                        }
                    }
                }
                if ($response == "") {
                    $response = "This device is not registered.";
                }
            } else {
                $response = "This device is not registered.";
            }
        } else {
            $response = "An error occured, please try again.";
        }

        $this->set('response', $response);
    }

    public function registerdevice() {
        $this->layout = 'ajax';

        if (isset($_POST['member_id']) && isset($_POST['description']) && isset($_POST['serial'])) {
            $memberid = $_POST['member_id'];
            $description = $_POST['description'];
            $serial = $_POST['serial'];

            $device = $this->Device->find('first', array(
                'conditions' => array(
                    'member_id' => $memberid,
                    'serial' => $serial
            )));

            if (!$device) {
                if ($this->Device->addDevice($memberid, $serial, $description)) {
                    $response = "Device registered successfully.";
                } else {
                    $response = "An error occured while registering the device.";
                }
            } else {
                $response = "This device is already registered or this serial is already used.";
            }
        } else {
            $response = "An error occured, please try again.";
        }

        $this->set('response', $response);
    }

    public function workoutparameters($deviceserial, $workoutid) {
        $this->layout = 'ajax';
        $device = $this->Device->find('first', array(
            'conditions' => array(
                'Device.serial' => $deviceserial,
                'Device.trusted' => 1
            )
        ));
        if ($device) {
            $Logs = $this->Log->find('all', array(
                'conditions' => array(
                    'Log.workout_id' => $workoutid,
                    'Log.device_id' => $device['Device']['id']
                )
            ));
            $this->set('Logs', $Logs);
        } else {
            $this->set('message', 'NOT OK');
        }
    }

    public function addlog($deviceserial, $workoutid, $memberid, $type, $valeur, $created, $latitude, $longitude) {
        $this->layout = 'ajax';
        $isDevice = $this->Device->find('first', array(
            'conditions' => array(
                'Device.serial' => $deviceserial,
                'Device.trusted' => 1
            )
        ));
        $isWorkout = $this->Workout->findById($workoutid);
        $isMember = $this->Member->findById($memberid);
        if ($isDevice && $isWorkout && $isMember) {
            if ($this->Log->addLog($isDevice['Device']['id'], $workoutid, $memberid, $type, $valeur, $created, $latitude, $longitude)) {
                $this->set('Res', 'OK');
            } else {
                $this->set('Res', 'NOT OK');
            }
        } else {
            $this->set('Res', 'NOT OK');
        }
    }

    public function getsummary($serial) {
        $this->layout = 'ajax';
        $device = $this->Device->find('first', array(
            'conditions' => array(
                'Device.serial' => $serial,
                'Device.trusted' => 1
            )
        ));
        if ($device) {
            $workouts = $this->Workout->find('all', array(
                'conditions' => array(
                    'Workout.member_id' => $device['Member']['id']),
                'order' => array('Workout.end_date DESC'),
                'limit' => 3,
            ));
            $futureWorkout = $this->Workout->find('first', array(
                'conditions' => array(
                    'Workout.member_id' => $device['Member']['id'],
                    'Workout.date >=' => date('Y-m-d H:i:s')
                )
            ));

            if (empty($workouts)) {
                $this->set('message', 'NO WORK OUT');
            } else {
                $this->set('workouts', $workouts);
            }
            if ($futureWorkout) {
                $this->set('futureWorkout', $futureWorkout);
            } else {
                $this->set('message', 'NO WORK OUT');
            }
        } else {
            $this->set('message', 'NO WORK OUT');
        }
    }

    public function getmembers() {
        $this->layout = 'ajax';
        $members = $this->Member->find('list', array(
            'fields' => array(
                'Member.id', 'Member.email'
            )
        ));
        $this->set('members', $members);
    }

    public function getmember() {
        $this->layout = 'ajax';

        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $password = Security::hash($password, 'sha1', true);

            $member = $this->Member->find('first', array(
                'conditions' => array(
                    'email' => $email,
                    'password' => $password
                )
            ));

            if ($member) {
                $response = $member['Member']['id'];
            } else {
                $response = "An error occured, please try again.";
            }
        } else {
            $response = "An error occured, please try again.";
        }

        $this->set('response', $response);
    }

}
