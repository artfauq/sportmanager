<div class="row smallbox">
    <h1>Reset Password</h1>
    <?php
        if(!isset($valide)){
            echo $this->Form->create('Member', array('url' => array(
                'controller' => 'members', 'action' => 'forgottenPassword'),
                'class' => 'form-horizontal'));
            echo $this->Form->input('email', array(
            'label' => array(
                'text' => 'Email address',
            ),
            'div' => 'form-group',
            'class' => 'form-control',
            'placeholder' => 'Email address',
            'type' => 'email'
            ));
            echo $this->Form->submit('Send Mail', array(
                'class' => 'btn btn-primary submitButton',
                'data-loading-text' => 'Sending...'
            ));
            echo $this->Form->end();
        }
        else{
            echo $this->Form->create('Password', array('url' => array(
                    'controller' => 'members', 'action' => 'forgottenPassword'),
                    'class' => 'form-horizontal'));
            echo $this->Form->input('password', array(
                'class' => 'form-control',
                'div' => 'form-group required',
                'placeholder' => 'Password',
                'type' => 'password'
            ));
            echo $this->Form->input('confirmPassword', array(
                'class' => 'form-control',
                'div' => 'form-group required',
                'placeholder' => 'Confirm Password',
                'type' => 'password',
                'error' => array(
                    'attributes' => array('escape' => false)
                )
            ));
            echo $this->Form->submit('Send', array(
                'class' => 'btn btn-success submitButton',
                'data-loading-text' => 'Sending...'
            ));
            echo $this->Form->end();
        }
        ?>
</div>