<?php

App :: uses('AppModel', 'Model');

class Member extends AppModel {

    public $displayField = 'email';
    public $hasMany = array(
        'Device' => array(
            'className' => 'Device',
            'foreignKey' => 'member_id'
        ),
        'Log' => array(
            'className' => 'Log',
            'foreignKey' => 'member_id'
        ),
        'Workout' => array(
            'className' => 'Workout',
            'foreignKey' => 'member_id'
        ),
        'Earning' => array(
            'className' => 'Earning',
            'foreignKey' => 'member_id'
        )
    );
    public $validate = array(
        'email' => array(
            'email_format' => array(
                'rule' => 'email',
                'message' => 'Invalid email'
            ),
            'email_unique' => array(
                'rule' => 'isUnique',
                'message' => 'Email already used'
            ),
            'email_required' => array(
                'rule' => 'notBlank',
                'message' => 'Enter an email',
                'allowEmpty' => false
            )),
        'password' => array(
            'password_required' => array(
                'rule' => 'notBlank',
                'message' => 'Enter a password',
                'allowEmpty' => false
            ))
    );

    public function saveImage($file, $extension) {
        $sizeImg = getimagesize($file);

        $width = 500;
        $Reduction = (($width * 100) / $sizeImg[0]);
        $height = (($sizeImg[1] * $Reduction) / 100);
        
        $destimg = ImageCreateTrueColor($width, $height);

        if ($extension == 'png') {
            $tmpImg = imageCreateFromPng($file)or die('Problem In opening Source Image');
            imagealphablending($destimg, false);
            $colorTransparent = imagecolorallocatealpha($destimg, 0, 0, 0, 0x7fff0000);
            imagefill($destimg, 0, 0, $colorTransparent);
            imagesavealpha($destimg, true);
        } elseif ($extension == 'jpg' || $extension == 'jpeg') {
            $tmpImg = imagecreatefromjpeg($file);
        }

        imagecopyresampled($destimg, $tmpImg, 0, 0, 0, 0, $width, $height, imagesX($tmpImg), imagesY($tmpImg));
        return $destimg;
    }

}
