<?php $this->assign('title', $username . ' | Account'); ?>

<div class="row">
    <div class="smallbox">
        <h1><i class="fa fa-cogs"></i> My account</h1>
        <br>
        <?php if (($facebookLogin == false) && ($googleLogin == false)) { ?>
            <div class = "row">
                <div>
                    <h3>
                        <a class="collapseLink" href = "#" onclick = "return false;"><i class = "fa fa-angle-double-right"></i> Change email address</a>
                        <hr class="separator">
                    </h3>
                </div>

                <div class="row">
                    <div class = "collapseElement" style="margin-left: 6%">
                        <?php
                        echo $this->Form->create('Member', array('url' => array(
                                'controller' => 'members', 'action' => 'account'),
                            'class' => 'form-horizontal',
                            'type' => 'file'
                        ));
                        echo $this->Form->input('email', array(
                            'label' => array(
                                'text' => '<i class="fa fa-user"></i> Email address'
                            ),
                            'escape' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Email address',
                            'type' => 'email',
                            'value' => $member['Member']['email'],
                            'required' => false
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div>
                    <h3>
                        <a class="collapseLink" href="#" onclick="return false;"><i class="fa fa-angle-double-right"></i> Change password</a>
                        <hr class="separator">
                    </h3>
                </div>

                <div class="row">
                    <div class="collapseElement" style="margin: 10px 6%">
                        <?php
                        echo $this->Html->link(
                                '<i class="fa fa-repeat"></i>  Reset my password', array('controller' => 'Members', 'action' => 'forgottenPassword'), array('class' => 'btn btn-primary', 'escape' => false));
                        ?>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div>
                    <h3>
                        <a class="collapseLink" href="#" onclick="return false;"><i class="fa fa-angle-double-right"></i> Change avatar</a>
                        <hr class="separator">
                    </h3>
                </div>

                <div class="row">
                    <div class="collapseElement" style="margin-left: 6%">
                        <?php
                        echo $this->Form->input('avatar', array(
                            'label' => array(
                                'text' => '<i class="fa fa-file-image-o"></i> Avatar (.png or .jpg)'
                            ),
                            'type' => 'file',
                            'escape' => false
                        ));
                        ?><br><?php
                        if (file_exists(WWW_ROOT . 'img' . DS . 'avatars' . DS . $id . '.png')) {
                            echo $this->Html->image('avatars/' . $id . '.png', array('alt' => 'Avatar Not Found', 'style' => 'width: 200px; margin-top: 20px'));
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <br>
        <div class="row">
            <div>
                <h3>
                    <a class="collapseLink" href="#" onclick="return false;"><i class="fa fa-angle-double-right"></i> Delete account</a>
                    <hr class="separator">
                </h3>
            </div>

            <div class="row">
                <div class="collapseElement" style="margin: 10px 6%">
                    <?php
                    echo $this->Html->link(
                            '<i class="fa fa-trash"></i>  Delete my Account', array('controller' => 'Members', 'action' => 'DeleteAccount'), array('class' => 'btn btn-danger', 'escape' => false), "Are you sure you wish to delete your account?"
                    );
                    ?>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <hr>
            <?php
            echo $this->Form->submit('Edit', array(
                'class' => 'btn btn-success'));
            echo $this->Form->end();
            ?>
            <hr>
        </div>
    </div>
</div>
