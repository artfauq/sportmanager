<?php $this->assign('title', 'Sign Up'); ?>


<div class="row smallbox">
    <h1>Sign Up</h1>
    <?php
    echo $this->Form->create(null, array('url' => array(
            'controller' => 'members', 'action' => 'signup'),
        'class' => 'form-horizontal'));
    echo $this->Form->input('email', array(
        'label' => array(
            'text' => 'Email address'
        ),
        'class' => 'form-control',
        'placeholder' => 'Email address',
        'type' => 'email'
    ));
    echo $this->Form->input('password', array(
        'label' => array(
            'text' => 'Password'
        ),
        'class' => 'form-control',
        'placeholder' => 'Password',
        'type' => 'password'
    ));
    echo $this->Form->input('confirmPassword', array(
        'label' => array(
            'text' => 'Confirm Password'
        ),
        'class' => 'form-control',
        'div' => 'required',
        'placeholder' => 'Confirm Password',
        'type' => 'password',
        'error' => array(
            'attributes' => array('escape' => false)
        )
    ));
    echo $this->Form->submit('Sign up', array(
        'class' => 'btn btn-primary submitButton',
        'data-loading-text' => 'Signin up...'
    ));
    echo $this->Form->end();
    ?>
    <div class="row separator">
        <?php
        echo $this->Html->link('Sign in with Facebook or Google', array('controller' => 'Members', 'action' => 'signin'));
        ?><span> or </span><?php
        echo $this->Html->link('Already have an account ?', array('controller' => 'Members', 'action' => 'signin'));
        ?>
    </div>
</div>
