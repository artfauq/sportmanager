<?php $this->assign('title', $username . ' | My Workouts'); ?>
<h1><i class="fa fa-calendar"></i> Workouts</h1>

<?php
$count = count($pastWorkouts) + count($currentWorkouts) + count($futureWorkouts);
$newWorkout = ($count == 0) ? 1 : 0;
?>

<div class="row">
    <div class="row">
        <div class="text-right">
            <a href="#" onclick="return false;" class="btn btn-default addObject">
                <i class="fa fa-plus" 
                   style="<?php echo ($newWorkout == 1) ? ' transform: rotate(45deg)' : null; ?>"></i> Add workout
            </a> 
        </div>

        <div class="row">
            <div class="smallbox newObject <?php echo $var; ?>" style="<?php echo ($newWorkout == 1) ? 'display: block' : 'display: none'; ?>">
                <h2><i class="fa fa-pencil"></i>New Workout</h2>
                <?php
                echo $this->Form->create(null, array(
                    'class' => 'form-horizontal'
                ));
                echo $this->Form->input('Workout.date', array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => 'date_timepicker_start',
                    'required' => false
                ));
                echo $this->Form->input('Workout.end_date', array(
                    'type' => 'text',
                    'class' => 'form-control',
                    'id' => 'date_timepicker_end',
                    'required' => false
                ));
                echo $this->Form->input('Workout.location_name', array(
                    'class' => 'form-control',
                    'required' => false
                ));
                echo $this->Form->input('Workout.description', array(
                    'class' => 'form-control',
                    'required' => false
                ));
                echo $this->Form->input('Workout.sport', array(
                    'type' => 'select',
                    'options' => $sports,
                    'class' => 'form-control'
                ));
                echo $this->Form->submit('Add workout', array(
                    'class' => 'btn btn-primary submitButton',
                    'data-loading-text' => 'Adding workout...'
                ));
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>

    <div>
        <h2>
            <a href="#" onclick="return false;" class="collapseLink">
                <i class="fa fa-navicon"></i> Current workouts
            </a>
        </h2>
        <hr class="separator">
    </div>

    <div class="row">
        <div class="collapseElement" style="display: block">
            <?php
            $count = count($currentWorkouts);
            if ($count == 0) {
                echo 'You currently have no current workout.';
                $newWorkout = 1;
            } else {
                $newWorkout = 0;
                $count = 1;
                foreach ($currentWorkouts as $workout) :
                    ?>
                    <div class="row bigbox">
                        <h3>Workout n°<?php echo $count; ?></h3>
                        <hr class="separator">
                        <div class="col-sm-4">
                            <h4><i class="fa fa-calendar"></i> Date</h4>
                            <?php
                            $date = date_create($workout['date']);
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
                            <h4><i class="fa fa-clock-o"></i> End Time </h4>
                            <?php
                            $date = date_create($workout['end_date']);
                            echo $date->format('H:i');
                            ?>
                            <hr class="separator">
                        </div>
                        <div class="col-sm-4">
                            <h4><i class="fa fa-map-marker"></i> Location </h4>
                            <?php echo $workout['location_name']; ?>
                            <hr class="separator">
                        </div>
                        <div class="col-sm-4">
                            <h4><i class="fa fa-heartbeat"></i> Sport </h4>
                            <?php echo $workout['sport']; ?>
                            <hr class="separator">
                        </div>
                        <div class="col-sm-4">
                            <h4><i class="fa fa-quote-right"></i> Description </h4>
                            <p>
                            <?php echo $workout['description']; ?>
                                </p>
                            <hr class="separator">
                        </div>
                        <div class="col-sm-8">
                            <h4><i class="fa fa-user"></i> Owner </h4>
                            <?php
                            foreach ($members as $owner) {
                                if ($workout['member_id'] == $owner['Member']['id']) {
                                    echo substr($owner['Member']['email'], 0, strrpos($owner['Member']['email'], "@"));
                                }
                            }
                            ?>
                            <hr class="separator">
                        </div>
                        <div class="col-sm-4">
                            <h4><i class="fa fa-flag"></i> Logs </h4>
                            <?php
                            echo $this->Html->link('Show <i class="fa fa-search-plus"></i>', array(
                                'action' => 'myLogs', $workout['id'], $workout['sport']), array('escape' => false));
                            ?>
                            <hr class="separator">
                        </div>
                    </div>
                    <?php
                    $count++;
                endforeach;
            }
            ?>
        </div>
    </div>



    <div>
        <h2>
            <a href="#" onclick="return false;" class="collapseLink">
                <i class="fa fa-navicon"></i> Future workouts
            </a>
        </h2>
        <hr class="separator">
    </div>

    <div class="row">
        <div class="collapseElement" style="display: block">
            <?php
            if (count($futureWorkouts) == 0) {
                echo 'You currently have no past workout.';
            } else {
                $futureWorkout = 1;
                foreach ($futureWorkouts as $workout) :
                    ?>
                    <div class="row bigbox">
                        <h3>Future workout n°<?php echo $futureWorkout; ?></h3>
                        <hr class="separator">
                        <div class="col-sm-4">
                            <h4><i class="fa fa-calendar"></i> Date</h4>
                            <?php
                            $date = date_create($workout['date']);
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
                            <h4><i class="fa fa-clock-o"></i> End Time </h4>
                            <?php
                            $date = date_create($workout['end_date']);
                            echo $date->format('H:i');
                            ?>
                            <hr class="separator">
                        </div>
                        <div class="col-sm-4">
                            <h4><i class="fa fa-map-marker"></i> Location </h4>
                            <?php echo $workout['location_name']; ?>
                            <hr class="separator">
                        </div>
                        <div class="col-sm-4">
                            <h4><i class="fa fa-heartbeat"></i> Sport </h4>
                            <?php echo $workout['sport']; ?>
                            <hr class="separator">
                        </div>
                        <div class="col-sm-4">
                            <h4><i class="fa fa-quote-right"></i> Description </h4>
                            <p>
                            <?php echo $workout['description']; ?>
                                </p>
                            <hr class="separator">
                        </div>
                        <div class="col-sm-8">
                            <h4><i class="fa fa-user"></i> Owner </h4>
                            <?php
                            foreach ($members as $owner) {
                                if ($workout['member_id'] == $owner['Member']['id']) {
                                    echo substr($owner['Member']['email'], 0, strrpos($owner['Member']['email'], "@"));
                                }
                            }
                            ?>
                            <hr class="separator">
                        </div>
                        <div class="col-sm-4">
                            <h4><i class="fa fa-flag"></i> Logs </h4>
                            <?php
                            echo $this->Html->link('Show <i class="fa fa-search-plus"></i>', array(
                                'action' => 'myLogs', $workout['id'], $workout['sport']), array('escape' => false));
                            ?>
                            <hr class="separator">
                        </div>
                    </div>
                    <?php
                    $count++;
                endforeach;
            }
            ?>
        </div>
    </div>

    <div>
        <h2>
            <a href="#" onclick="return false;" class="collapseLink">
                <i class="fa fa-navicon"></i> Past workouts
            </a>
        </h2>
        <hr class="separator">
    </div>

    <div class="row">
        <div class="collapseElement" style="display: block">
            <?php
            $count = count($pastWorkouts);
            if ($count == 0) {
                echo 'You currently have no past workouts.';
            } else {
                if ($count > 1) {
                    $count = 1;
                    ?>
            <ul class="nav nav-tabs nav-justified" style="margin: auto 6%; width: auto" role="tablist">
                        <li role="presentation" class="active">
                            <a class="changes" 
                               role="tab" 
                               data-toggle="tab" 
                               aria-expanded="false"
                               aria-controls="tabDes" 
                               href="#tabDes">
                                Sort by most recent
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="changes" 
                               role="tab" 
                               data-toggle="tab" 
                               aria-expanded="false"
                               aria-controls="tabAsc" 
                               href="#tabAsc">
                                Sort by oldest
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="tabAsc"
                             role="tabpanel"
                             class="tab-pane fade"
                             aria-labelledby="tabAsc">
                                 <?php
                                 $count = count($tabAsc);
                                 foreach ($tabAsc as $workout) {
                                     ?>
                                <div class="row bigbox">
                                    <h3>Past workout n°<?php echo $count; ?></h3>
                                    <hr class="separator">
                                    <div class="col-sm-4">
                                        <h4><i class="fa fa-calendar"></i> Date</h4>
                                        <?php
                                        $date = date_create($workout['date']);
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
                                        <h4><i class="fa fa-clock-o"></i> End Time </h4>
                                        <?php
                                        $date = date_create($workout['date']);
                                        echo $date->format('H:i');
                                        ?>
                                        <hr class="separator">
                                    </div>
                                    <div class="col-sm-4">
                                        <h4><i class="fa fa-map-marker"></i> Location </h4>
                                        <?php echo $workout['location_name']; ?>
                                        <hr class="separator">
                                    </div>
                                    <div class="col-sm-4">
                                        <h4><i class="fa fa-heartbeat"></i> Sport </h4>
                                        <?php echo $workout['sport']; ?>
                                        <hr class="separator">
                                    </div>
                                    <div class="col-sm-4">
                                        <h4><i class="fa fa-comment"></i> Description </h4>
                                        <p>
                                        <?php echo $workout['description']; ?>
                                            </p>
                                        <hr class="separator">
                                    </div>
                                    <div class="col-sm-8">
                                        <h4><i class="fa fa-user"></i> Owner </h4>
                                        <?php
                                        foreach ($members as $owner) {
                                            if ($workout['member_id'] == $owner['Member']['id']) {
                                                echo substr($owner['Member']['email'], 0, strrpos($owner['Member']['email'], "@"));
                                            }
                                        }
                                        ?>
                                        <hr class="separator">
                                    </div>
                                    <div class="col-sm-4">
                                        <h4><i class="fa fa-flag"></i> Logs </h4>
                                        <?php
                                        echo $this->Html->link('Show <i class="fa fa-search-plus"></i>', array(
                                            'action' => 'myLogs', $workout['id'], $workout['sport']), array('escape' => false));
                                        ?>
                                        <hr class="separator">
                                    </div>
                                </div>
                                <?php
                                $count--;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div id="tabDes"
                         role="tabpanel"
                         class="tab-pane fade active in"
                         aria-labelledby="tabDes">
                             <?php
                             $count = 1;
                             foreach ($tabDes as $workout) :
                                 ?>
                            <div class="row bigbox">
                                <h3>Past workout n°<?php echo $count; ?></h3>
                                <hr class="separator">
                                <div class="col-sm-4">
                                    <h4><i class="fa fa-calendar"></i> Date</h4>
                                    <?php
                                    $date = date_create($workout['date']);
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
                                    $start = date_create(substr($workout['date'], 11));
                                    $end = date_create(substr($workout['end_date'], 11));
                                    $duration = date_diff($start, $end);
                                    echo $duration->format('%h hour(s) and %m minute(s)')
                                    ?>
                                    <hr class="separator">
                                </div>
                                <div class="col-sm-4">
                                    <h4><i class="fa fa-map-marker"></i> Location </h4>
                                    <?php echo $workout['location_name']; ?>
                                    <hr class="separator">
                                </div>
                                <div class="col-sm-4">
                                    <h4><i class="fa fa-heartbeat"></i> Sport </h4>
                                    <?php echo $workout['sport']; ?>
                                    <hr class="separator">
                                </div>
                                <div class="col-sm-4">
                                    <h4><i class="fa fa-quote-right"></i> Description </h4>
                                    <p class="ellipsis">
                                        <?php echo $workout['description']; ?>
                                    </p>
                                    <hr class="separator">
                                </div>
                                <div class="col-sm-8">
                                    <h4><i class="fa fa-user"></i> Owner </h4>
                                    <?php
                                    foreach ($members as $owner) {
                                        if ($workout['member_id'] == $owner['Member']['id']) {
                                            echo substr($owner['Member']['email'], 0, strrpos($owner['Member']['email'], "@"));
                                        }
                                    }
                                    ?>
                                    <hr class="separator">
                                </div>
                                <div class="col-sm-4">
                                    <h4><i class="fa fa-flag"></i> Logs </h4>
                                    <?php
                                    echo $this->Html->link('Show <i class="fa fa-search-plus"></i>', array(
                                        'action' => 'myLogs', $workout['id'], $workout['sport']), array('escape' => false));
                                    ?>
                                    <hr class="separator">
                                </div>
                            </div>
                            <?php
                            $count++;
                        endforeach;
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <?php if ((count($pastWorkouts) != 0) || (count($currentWorkouts) != 0) || (count($futureWorkouts) != 0)) { ?>
            <h2><i class="fa fa-bar-chart"></i>Statistics</h2>
            <hr class="separator">
            <div class="col-lg-12">
                <ul class="list-group">
                    <?php if ($statTable["nombre2Logs"][0][0]["COUNT(*)"] != 0) { ?>
                        <li class="list-group-item list-group-item-info">
                            Well done ! You have <?php echo $statTable["nombre2Logs"][0][0]["COUNT(*)"]; ?> logs on our website.
                        </li>
                    <?php } ?>
                    <li class="list-group-item list-group-item-info">
                        What a sportive ! You have done <?php echo $statTable["nombre2Workout"][0][0]["COUNT(*)"]; ?> workout(s).
                    </li>
                    <li class="list-group-item list-group-item-info">
                        Crazy ! You are a sportive of the <?php echo $statTable["momentSportif"]; ?>.
                    </li>
                    <li class="list-group-item list-group-item-info">
                        Wahou ! Your workouts average duration is <?php echo $statTable["TrainTime"]["heure"]; ?>h<?php echo $statTable["TrainTime"]["minutes"]; ?>.
                    </li>
                </ul>
            </div>
        <?php }
        ?>
    </div>
</div>