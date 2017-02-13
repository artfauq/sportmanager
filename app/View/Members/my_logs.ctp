<?php

$this->assign('title', $username . ' | My Logs'); ?>

<?php
$count = 0;
foreach ($logs as $log):
    if ($log['Log']['member_id'] == $member['Member']['id']) {
        $count++;
    }
endforeach;
$newLog = ($count == 0) ? 1 : 0;
?>
<br>
<div class="row">
    <a class="btn btn-default" href="<?php echo $this->Html->url(array('action' => 'myWorkouts')); ?>">
        <i class="fa fa-arrow-left"></i> Back to my workouts
    </a>

    <h2><i class="glyphicon glyphicon-flag"></i>Workout's resume</h2>
    <hr class="separator">

    <div class="row bigbox">
        <div class="col-sm-4">
            <h4><i class="fa fa-calendar"></i> Date</h4>
            <?php
            $date = date_create($workout['Workout']['date']);
            echo $date->format('d/m/Y');
            ?>
            <hr class="separator">
        </div>
        <div class="col-sm-4">
            <h4><i class="fa fa-clock-o"></i> Start Time</h4>
            <?php
            echo $date->format('H:i');
            ?>
            <hr class="separator">
        </div>
        <div class="col-sm-4">
            <h4><i class="fa fa-hourglass-half"></i> Duration </h4>
            <?php
            $start = date_create(substr($workout['Workout']['date'], 11));
            $end = date_create(substr($workout['Workout']['end_date'], 11));
            $duration = date_diff($start, $end);
            echo $duration->format('%h hours and %m minutes')
            ?>
            <hr class="separator">
        </div>

        <div class="col-sm-3">
            <h4><i class="fa fa-map-marker"></i> Location </h4>
            <?php echo $workout['Workout']['location_name']; ?>
        </div>
        <div class="col-sm-3">
            <h4><i class="fa fa-heartbeat"></i> Sport </h4>
            <?php echo $workout['Workout']['sport']; ?>
        </div>
        <div class="col-sm-3">
            <h4><i class="fa fa-quote-right"></i> Description </h4>
            <?php echo $workout['Workout']['description']; ?>
        </div>
        <div class="col-sm-3">
            <h4><i class="fa fa-user"></i> Owner </h4>
            <?php
            foreach ($members as $owner) {
                if ($workout['Workout']['member_id'] == $owner['Member']['id']) {
                    echo substr($owner['Member']['email'], 0, strrpos($owner['Member']['email'], "@"));
                }
            }
            ?>
        </div>
    </div>

    <br>

    <?php 
    if (($workout['Workout']['date'] < $dateNow) && ($workout['Workout']['end_date'] > $dateNow)) { ?>
    <div class="row">
        <div class="text-right">
            <a href="#" onclick="return false;" class="btn btn-default addObject">
                <i class="fa fa-plus"
                   style="<?php echo ($newLog == 1) ? 'transform: rotate(45deg)' : null; ?>"></i> Add log
            </a> 
        </div>

        <div class="row">
            <div class="smallbox newObject <?php echo $var; ?>" style="<?php echo ($newLog == 1) ? ' display: block' : null; ?>">
                <h2><i class="fa fa-pencil"></i>New log</h2>
                <?php
                echo $this->Form->create(null, array(
                    'class' => 'form-horizontal'
                ));
                echo $this->Form->input('Log.workout_id', array('type' => 'hidden', 'value' => $id));
                ?><div>
                    <a href='#' style="padding: .5em" class="btn btn-primary" id="test" onclick="return false;"><i class="fa fa-map-marker"></i> Get location</a></div>
                <?php
                echo $this->Form->input('Log.location_latitude', array(
                    'class' => 'form-control',
                    'id' => 'location_latitude',
                    'required' => false
                ));
                echo $this->Form->input('Log.location_logitude', array(
                    'class' => 'form-control',
                    'id' => 'location_logitude',
                    'required' => false
                ));
                echo $this->Form->input('Log.log_type', array(
                    'type' => 'select',
                    'options' => $type,
                    'class' => 'form-control'
                ));
                echo $this->Form->input('Log.log_value', array(
                    'class' => 'form-control',
                    'required' => false
                ));
                echo $this->Form->submit('Add log', array(
                    'class' => 'btn btn-primary submitButton',
                    'data-loading-text' => 'Adding log...'
                ));
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
    <?php } ?>

    <div>
        <h2>
            <a href="#" onclick="return false;" class="collapseLink">
                <i class="fa fa-navicon"></i> My logs
            </a>
            <hr class="separator">
        </h2>
    </div>

    <div class="row">
        <div class="collapseElement" style="display: block">
            <?php
            if ($count == 0) {
                echo 'You have no log for this workout.';
            } else {
                $count = 1;
                foreach ($logs as $log) :
                    if ($log['Log']['member_id'] == $member['Member']['id']) {
                        ?>
            <div class="row bigbox">
                <h3>Log n°<?php echo $count; ?></h3>
                <hr class="separator">

                <div class="col-sm-6">
                    <h4><i class="fa fa-calendar"></i> Date</h4>
                                <?php
                                $date = date_create($log['Log']['date']);
                                echo $date->format('d/m/Y');
                                ?>
                    <hr class="separator">
                </div>
                <div class="col-sm-6">
                    <h4><i class="fa fa-clock-o"></i> Time</h4>
                                <?php
                                echo $date->format('H:i');
                                ?>
                    <hr class="separator">
                </div>
                <div class="col-sm-4">
                    <h4><i class="fa fa-tag"></i> Type </h4>
                                <?php echo $log['Log']['log_type']; ?>
                    <hr class="separator">
                </div>
                <div class="col-sm-4">
                    <h4><i class="fa fa-tachometer"></i> Value </h4>
                                <?php echo $log['Log']['log_value']; ?>
                    <hr class="separator">
                </div>
                <div class="col-sm-4">
                    <h4><i class="fa fa-tablet"></i> Device</h4>
                                <?php
                                foreach ($devices as $device) {
                                    if ($device['Device']['id'] == $log['Log']['device_id']) {
                                        echo $device['Device']['description'];
                                    }
                                }
                                ?>
                    <hr class="separator">
                </div>
                <div class="col-sm-6">
                    <h4><i class="fa fa-map-marker"></i> Position </h4>
                    <div class="googleMap" 
                         id="<?php echo $log['Log']['location_latitude']; ?>_<?php echo $log['Log']['location_logitude']; ?>"></div>
                </div>
            </div>
                        <?php
                        $count++;
                    }
                endforeach;
            }
            ?>
        </div>
    </div>
    <br>
    <div>
        <h2>
            <a href="#" onclick="return false;" class="collapseLink">
                <i class="fa fa-navicon"></i> Other members' logs
            </a>
            <hr class="separator">
        </h2>
    </div>

    <div class="row">
        <div class="collapseElement" style="display: block">
            <?php
            $count = 0;
            foreach ($logs as $log):
                if ($log['Log']['member_id'] != $member['Member']['id']) {
                    $count++;
                }
            endforeach;
            if ($count == 0) {
                echo 'There are no logs from other members for this workout.';
            } else {
                $count = 1;
                foreach ($logs as $log) :
                    if ($log['Log']['member_id'] != $member['Member']['id']) {
                        ?>
            <div class="row bigbox">
                <h3>Log n°<?php echo $count; ?></h3>
                <hr class="separator">

                <div class="col-sm-6">
                    <h4><i class="fa fa-calendar"></i> Date</h4>
                                <?php
                                $date = date_create($log['Log']['date']);
                                echo $date->format('d/m/Y');
                                ?>
                    <hr class="separator">
                </div>
                <div class="col-sm-6">
                    <h4><i class="fa fa-clock-o"></i> Time</h4>
                                <?php
                                echo $date->format('H:i');
                                ?>
                    <hr class="separator">
                </div>
                <div class="col-sm-4">
                    <h4><i class="fa fa-tag"></i> Type </h4>
                                <?php echo $log['Log']['log_type']; ?>
                    <hr class="separator">
                </div>
                <div class="col-sm-4">
                    <h4><i class="fa fa-tachometer"></i> Value </h4>
                                <?php echo $log['Log']['log_value']; ?>
                    <hr class="separator">
                </div>
                <div class="col-sm-4">
                    <h4><i class="fa fa-tablet"></i> Device</h4>
                                <?php
                                foreach ($devices as $device) {
                                    if ($device['Device']['id'] == $log['Log']['device_id']) {
                                        echo $device['Device']['description'];
                                    }
                                }
                                ?>
                    <hr class="separator">
                </div>
                <div class="col-sm-4">
                    <h4><i class="fa fa-map-marker"></i> Position </h4>
                    <div class="googleMap" 
                         id="<?php echo $log['Log']['location_latitude']; ?>_<?php echo $log['Log']['location_logitude']; ?>"></div>
                </div>
            </div>
                        <?php
                        $count++;
                    }
                endforeach;
            }
            ?>
        </div>
    </div>
</div>


