<?php $this->assign('title', 'Sport Manager | Contact'); ?>

<div class="row smallbox">
    <h1>Contact Us</h1>
    <?php
    echo $this->Form->create('Contact', array(
        'class' => 'form-horizontal'
    ));
    echo $this->Form->input('Contact.name', array(
        'class' => 'form-control',
        'placeholder' => 'Name',
        'required' => false
    ));
    echo $this->Form->input('Contact.email', array(
        'label' => array(
            'text' => 'Email address'
        ),
        'class' => 'form-control',
        'placeholder' => 'Email address',
        'type' => 'email',
        'required' => false
    ));
    echo $this->Form->input('Contact.message', array(
        'type' => 'textarea',
        'class' => 'form-control',
        'placeholder' => 'Your message...',
        'required' => false
    ));
    echo $this->Form->submit('Send', array(
        'class' => 'btn btn-primary submitButton',
        'data-loading-text' => 'Sending mail...'
    ));
    echo $this->Form->end();
    ?>
</div>

