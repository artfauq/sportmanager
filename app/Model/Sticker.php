<?php

App::uses('AppModel', 'Model');

class Sticker extends AppModel {
    
    public $hasMany = array(
        'Earning' => array(
            'className' => 'Earning',
            'foreignKey' => 'sticker_id'
    ));
}
