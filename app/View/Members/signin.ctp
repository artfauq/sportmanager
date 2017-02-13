<?php $this->assign('title', 'Sign In'); ?>

<div class="row smallbox">
    <h1>Sign In</h1>
    <div class="row middle separator">
        <div class="col-xs-12">
            <a class="btn btn-social btn-facebook facebookConnect socialButton" href="<?php echo $this->Html->url(array("action" => "facebook")); ?>"><span class="fa fa-facebook"></span> Sign in with Facebook</a>
        </div>
        <div class="col-xs-12">
            <a class="btn btn-social btn-google google socialButton" href="<?php echo $this->Html->url(array("action" => "googlelogin")); ?>"><span class="fa fa-google"></span> Sign in with Google </a>
        </div>
    </div>
    <div class="separator middle">
        <hr style="width: 40%; float: left">
        <span>or</span>
        <hr style="width: 40%; float: right">
    </div>
    <div class="row">
        <?php
        echo $this->Form->create(null, array('url' => array(
                'controller' => 'members', 'action' => 'signin'),
            'class' => 'form-horizontal'));
        echo $this->Form->input('email', array(
            'label' => false,
            'escape' => false,
            'class' => 'form-control',
            'placeholder' => 'Email address',
            'type' => 'email',
            'required' => false
        ));
        echo $this->Form->input('password', array(
            'label' => false,
            'escape' => false,
            'class' => 'form-control',
            'placeholder' => 'Password',
            'type' => 'password',
            'required' => false
        ));
        echo $this->Form->submit('Sign in', array(
            'class' => 'btn btn-success submitButton',
            'data-loading-text' => 'Signin in...'
        ));
        echo $this->Form->end();
        ?>


        <div class="row separator">
            <?php
            echo $this->Html->link('Don\'t have an account ', array('controller' => 'Members', 'action' => 'signup'));
            ?><span> or </span><?php
            echo $this->Html->link('forgotten password', array('controller' => 'Members', 'action' => 'forgottenPassword'));
            ?><span> ? </span>
        </div>
    </div>
</div>