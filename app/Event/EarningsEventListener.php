<?php

App::uses('CakeEventListener', 'Event');

class EarningsEventListener implements CakeEventListener {

    public $components = array('Flash');

    public function implementedEvents() {
        return array(
            'Model.Member.create' => 'firstConnection',
            'Model.Member.sign' => 'memberSince',
            'Model.Workout.add' => 'updateWorkouts',
            'Model.Device.trust' => 'connectedDevice',
            'Model.Device.homeDevice' => 'connectedDevice',
            'Model.Log.add' => 'firstLog',
            'Rankings' => 'rankingsTop'
        );
    }

    public function firstConnection($event) {
        $member_id = $event->subject->id;
        $members = ClassRegistry::init('Member');
        $stickers = ClassRegistry::init('Sticker');
        $member = $members->find('first', array(
            'conditions' => array('Member.id' => $member_id)));
        $sticker = $stickers->find('first', array(
            'conditions' => array('Sticker.name' => 'First Connection')));
        $sticker_id = $sticker['Sticker']['id'];
        $this->unlock($sticker_id, $member_id);
    }

    public function memberSince($event) {
        $member_id = $event->subject['Member']['id'];
        $members = ClassRegistry::init('Member');
        $stickers = ClassRegistry::init('Sticker');
        $earnings = ClassRegistry::init('Earnings');
        $member = $members->find('first', array(
            'conditions' => array('Member.id' => $member_id)));
        
        $connectionSticker = $stickers->find('first', array(
            'conditions' => array('Sticker.name' => 'First Connection')));
        $connectionSticker_id = $connectionSticker['Sticker']['id'];
        $sticker = $stickers->find('first', array(
            'conditions' => array('Sticker.name' => '24H Member')));
        $sticker_id = $sticker['Sticker']['id'];
        $earnings = $member['Earning'];
        
        foreach ($earnings as $earning):
            if ($earning['sticker_id'] == $connectionSticker_id) {
                if ((strtotime(date('Y-m-d H:i:s')) - strtotime($earning['date'])) > 24 * 60 * 60) {
                    $this->unlock($sticker_id, $member_id);
                }
            }
        endforeach;
    }

    public function updateWorkouts($event) {
        $workout_id = $event->subject->id;
        $member_id = $event->data['member_id'];
        $workouts = ClassRegistry::init('Workout');
        $stickers = ClassRegistry::init('Sticker');
        $logs = ClassRegistry::init('Log');
        $sport = $event->data['sport'];
        $var = 0;

        // Workouts dont le member est propriétaire
        $myworkouts = $workouts->find('all', array(
            'conditions' => array('Workout.member_id' => $member_id)
        ));
        $count = count($myworkouts);

        foreach ($myworkouts as $myworkout):
            // Workouts d'autres membres auxquels il a participé
            $count += $logs->find('count', array(
                'conditions' => array(
                    'Log.member_id' => $member_id,
                    'NOT' => array(
                        'Log.workout_id' => $myworkout['Workout']['id']
                    )
                )
            ));
            if ($myworkout['Workout']['sport'] == $sport) {
                $var++;
            }
        endforeach;

        if ($count >= 1) {
            $sticker = $stickers->find('first', array(
                'conditions' => array('Sticker.name' => 'First Workout')));
            $sticker_id = $sticker['Sticker']['id'];
            $this->unlock($sticker_id, $member_id);
        }
        if ($count >= 10) {
            $sticker = $stickers->find('first', array(
                'conditions' => array('Sticker.name' => 'Tenth Workout')));
            $sticker_id = $sticker['Sticker']['id'];
            $this->unlock($sticker_id, $member_id);
        }
        if ($var == 1) {
            $sticker = $stickers->find('first', array(
                'conditions' => array('Sticker.name' => 'First Workout - ' . $sport)));
            $sticker_id = $sticker['Sticker']['id'];
            $this->unlock($sticker_id, $member_id);
        }
    }

    public function connectedDevice($event) {
        $member_id = $event->data['id'];
        $stickers = ClassRegistry::init('Sticker');
        $sticker = $stickers->find('first', array(
            'conditions' => array('Sticker.name' => 'Connected Device')));
        $sticker_id = $sticker['Sticker']['id'];
        $this->unlock($sticker_id, $member_id);
    }

    public function firstLog($event) {
        $member_id = $event->data['id'];
        $logs = ClassRegistry::init('Log');
        $stickers = ClassRegistry::init('Sticker');
        $mylogs = $logs->find('all', array(
            'conditions' => array(
                'Log.member_id' => $member_id
        )));
        $count = count($mylogs);
        if ($count >= 1) {
            $sticker = $stickers->find('first', array(
                'conditions' => array('Sticker.name' => 'First Log')));
            $sticker_id = $sticker['Sticker']['id'];
            $this->unlock($sticker_id, $member_id);
        }
    }

    public function rankingsTop($event) {
        $member_id = $event->data[0]['id'];
        $stickers = ClassRegistry::init('Sticker');
        $rankings = $event->data[1];
//        pr($rankings[0]['logs']['member_id']);
//        pr($member_id);
//        die();
        if ($rankings[0]['logs']['member_id'] == $member_id) {
            $sticker = $stickers->find('first', array(
                'conditions' => array('Sticker.name' => 'Top 1')));
            $sticker_id = $sticker['Sticker']['id'];
            $this->unlock($sticker_id, $member_id);
        }
    }

    public function unlock($sticker_id, $member_id) {
        $earnings = ClassRegistry::init('Earning');
        $earning = $earnings->find('first', array(
            'conditions' => array(
                'Earning.sticker_id' => $sticker_id,
                'Earning.member_id' => $member_id)
        ));

        if (empty($earning)) {
            $earnings->create();
            $earnings->save(array(
                'sticker_id' => $sticker_id,
                'member_id' => $member_id,
                'date' => date("Y-m-d H:i:s")
            ));
        }
    }

}
