<?php

App::uses('AppModel', 'Model');

class Earning extends AppModel {

    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id',
        )
    );

}
