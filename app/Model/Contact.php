<?php

App::uses('CakeEmail', 'Network/Email');

class Contact extends AppModel {

    var $name = 'Contact';
    public $useTable = false;
    public $validate = array(
        'name' => array(
            'name_required' => array(
                'rule' => 'notBlank',
                'message' => 'Name is required',
                'allowEmpty' => false
            )
        ),
        'email' => array(
            'email_required' => array(
                'rule' => 'notBlank',
                'message' => 'Email is required',
                'allowEmpty' => false
            ),
            'email_format' => array(
                'rule' => 'email',
                'message' => 'Email not valid'
            )
        ),
        'message' => array(
            'message_required' => array(
                'rule' => 'notBlank',
                'message' => 'Message is required',
                'allowEmpty' => false
            )
        )
    );
    var $_schema = array(
        'name' => array('type' => 'string', 'length' => 100),
        'email' => array('type' => 'string', 'length' => 255),
        'message' => array('type' => 'text')
    );

    public function sendMessage($d) {
        $this->set($d);
        if ($this->validates()) {
            $mail = new CakeEmail('default');
            $mail->to('contact.sportmanager@gmail.com')
                    ->sender($d['email'])
                    ->from($d['email'])
                    ->subject('Sportmanager - Contact')
                    ->emailFormat('html')
                    ->template('contact')
                    ->viewVars(array('name' => $d['name'], 'message' => $d['message']));
            return $mail->send();
        } else {
            return false;
        }
    }

}
