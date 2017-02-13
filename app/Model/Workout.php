<?php

App :: uses('AppModel', 'Model');

class Workout extends AppModel {

    public $hasMany = array(
        'Log' => array(
            'className' => 'Log',
            'foreignKey' => 'workout_id'
        )
    );
    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id'
        )
    );
    public $validate = array(
        'location_name' => array(
            'location_required' => array(
                'rule' => 'notBlank',
                'message' => 'Enter a location',
                'allowEmpty' => false
            )
        ),
        'description' => array(
            'description_required' => array(
                'rule' => 'notBlank',
                'message' => 'Enter a description',
                'allowEmpty' => false
            ),
            'description_text' => array(
                'rule' => array('minLength', '5'),
                'message' => 'Description must be more than 5 characters'
            )
        ),
        'date' => array(
            'date_format' => array(
                'rule' => array('datetime', 'ymd'),
                'message' => 'Enter a valid date'
            ),
            'date_required' => array(
                'rule' => 'notBlank',
                'message' => 'Enter a start date',
                'allowEmpty' => false
            ),
            'validateDate' => array(
                'rule' => 'sameDay',
                'message' => 'Start and end date must on the same day',
                'allowEmpty' => false
            ),
            'validateTime' => array(
                'rule' => 'compareTime',
                'message' => 'End date must be greater than start date',
                'allowEmpty' => false
            )
        ),
        'end_date' => array(
            'date_format' => array(
                'rule' => array('datetime', 'ymd'),
                'message' => 'Enter a valid date'
            ),
            'date_required' => array(
                'rule' => 'notBlank',
                'message' => 'Enter an end date',
                'allowEmpty' => false
            ),
            'validateDate' => array(
                'rule' => 'sameDay',
                'message' => 'Start and end date must on the same day',
                'allowEmpty' => false
            ),
            'validateTime' => array(
                'rule' => 'compareTime',
                'message' => 'End date must be greater than start date',
                'allowEmpty' => false
            )
        )
    );

    public function sameDay() {
        if (strtotime(substr($this->data['Workout']['date'], 0, 10)) ==
                strtotime(substr($this->data['Workout']['end_date'], 0, 10))) {
            return true;
        }
        return false;
    }

    public function compareTime() {
        if (strtotime($this->data['Workout']['date']) <
                strtotime($this->data['Workout']['end_date'])) {
            return true;
        }
        return false;
    }

}
