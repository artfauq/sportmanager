<?php

App::uses('AppModel', 'Model');

class Device extends AppModel {

    public $belongsTo = array(
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id',
        )
    );
    public $hasMany = array(
        'Log' => array(
            'className' => 'Log',
            'foreignKey' => 'device_id'
        )
    );
    public $validate = array(
        'serial' => array(
            array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Invalid serial'
            ),
            array(
                'rule' => 'isUnique',
                'message' => 'Serial already used'
            )),
        'description' => array(
            'rule' => array('maxLength', 15),
            'message' => 'Please enter a description',
            'allowEmpty' => false
        )
    );
    public function addDevice($memberid, $deviceserial, $devicedescription)
    {  
       $this->create();
       $this->save(array(
           'Device'=>array(
               'member_id'=>$memberid,
               'serial'=>$deviceserial,
               'description'=>$devicedescription,
               'trusted'=>0
           )
       ));
       if($this->id){
           return true;
       }else{
           return false;
       }
    }
}
