<?php

App :: uses('AppModel', 'Model');

class Log extends AppModel {

    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id',
        ),
        'Workout' => array(
            'className' => 'Workout',
            'foreignKey' => 'workout_id',
        ),
        'Device' => array(
            'className' => 'Device',
            'foreignKey' => 'device_id',
        )
    );
    public $validate = array(
        'location_latitude' => array(
            'latitude_required' => array(
                'rule' => 'notBlank',
                'message' => 'Latitude is required.'
            ),
            'latitude_coordinate' => array(
                'rule' => array('geoCoordinate', array('format' => 'lat')),
                'message' => 'Latitude must be a valid coordinate.'
            )
        ),
        'location_logitude' => array(
            'logitude_required' => array(
                'rule' => 'notBlank',
                'message' => 'Logitude is required.'
            ),
            'logitude_coordinate' => array(
                'rule' => array('geoCoordinate', array('format' => 'lat')),
                'message' => 'Logitude must be a valid coordinate.'
            )
        ),
        'log_value' => array(
            'value_required' => array(
                'rule' => 'notBlank',
                'message' => 'Value is required.',
            ),
            'valid_value' => array(
                'rule' => array('range', 0, 100000),
                'message' => 'Value must be positive and less than 100 000.'
            )
        )
    );

    public function addLog($data) {
        $this->create();
        if ($this->save($data, true)) {
            return true;
        }
    }

}
