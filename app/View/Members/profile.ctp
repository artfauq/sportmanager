<?php $this->assign('title', $username . ' | Profile'); ?>

<div class="row">
    <div class="smallbox">
        <h1>
            <?php
            if ($this->Session->read('picture')) {
                echo $this->Html->image($picture, array('style' => 'height: 80px; margin-right: 10px'));
            } else {
                ?>
                <i class="fa fa-user"></i> 
            <?php }
            ?>
            My profile
        </h1>
        <br>
        <div class="row">
            <div>
                <h3>
                    <a class="collapseLink" href="#" onclick="return false;"><i class="fa fa-angle-double-right"></i> My stickers</a>
                    <hr class="separator">
                </h3>
            </div>

            <div class="row">
                <div class="collapseElement">
                    <?php
                    foreach ($earnings as $earning):
                        foreach ($stickers as $sticker):
                            if ($earning['Earning']['sticker_id'] == $sticker['Sticker']['id']):
                                ?>
                                <div class="row">
                                    <div class="col-sm-4 col-sm-offset-0 col-xs-6 col-xs-offset-3 left-side">
                                        <?php
                                        echo $this->Html->image(str_replace(' ', '_', 'stickers/' . $sticker['Sticker']['name']) . '.png', array(
                                            'style' => 'width: 100%'));
                                        ?>
                                        </a>
                                    </div>
                                    <div class="col-sm-8 col-sm-offset-0 col-xs-12 right-side vmiddle">
                                        <h3><?php echo $sticker['Sticker']['name']; ?></h3>
                                        <p><?php echo $sticker['Sticker']['description']; ?></p>
                                        <br>
                                        <p><?php
                                            echo $this->Html->link('See who else won this sticker', array(
                                                'controller' => 'pages',
                                                'action' => 'stickers',
                                                '#' => str_replace(' ', '_', $sticker['Sticker']['name'])
                                            ))
                                            ?></p>
                                    </div>
                                    <hr class="separator">
                                </div>
                                <?php
                            endif;
                        endforeach;
                    endforeach;
                    ?>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div>
                <h3>
                    <a class="collapseLink" href="#" onclick="return false;"><i class="fa fa-angle-double-right"></i> My last workouts</a>
                    <hr class="separator">
                </h3>
            </div>

            <div class="row">
                <div class="collapseElement">
                    <?php if (count($workouts) == 0) { ?>
                        <div style="text-align: center">
                            <?php echo $this->Html->link('Add a workout', array('action' => 'myWorkouts')); ?>
                        </div>
                        <?php
                    } else {
                        $count = 0;
                        foreach ($workouts as $workout):
                            if ($count < 3) {
                                $count++;
                                ?>
                                <div class="row bigbox">
                                    <h3>Workout n°<?php echo $count; ?></h3>
                                    <hr class="separator">
                                    <div class="col-sm-6">
                                        <h4><i class="fa fa-calendar"></i> Date</h4>
                                        <?php
                                        $date = date_create($workout['Workout']['date']);
                                        echo $date->format('d/m/Y');
                                        ?>
                                        <hr class="separator">
                                    </div>
                                    <div class="col-sm-6">
                                        <h4><i class="fa fa-clock-o"></i> Start Time</h4>
                                        <?php
                                        echo $date->format('H:i');
                                        ?>
                                        <hr class="separator">
                                    </div>
                                    <div class="col-sm-6">
                                        <h4><i class="fa fa-map-marker"></i> Location </h4>
                                        <?php echo $workout['Workout']['location_name']; ?>
                                        <hr class="separator">
                                    </div>
                                    <div class="col-sm-6">
                                        <h4><i class="fa fa-heartbeat"></i> Sport </h4>
                                        <?php echo $workout['Workout']['sport']; ?>
                                        <hr class="separator">
                                    </div>
                                </div>
                                <?php
                            }
                        endforeach;
                        ?>
                        <div style="text-align: center"><?php
                            echo $this->Html->link('See all my workouts', array('action' => 'myWorkouts'), array(
                                'style' => 'text-align: center'));
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div>
                <h3>
                    <a class="collapseLink" href="#" onclick="return false;"><i class="fa fa-angle-double-right"></i> My trusted devices</a>
                    <hr class="separator">
                </h3>
            </div>
            <?php $count = count($devices); ?>

            <div class="row">
                <div class="collapseElement">
                    <?php
                    $count = 0;
                    foreach ($devices as $device):
                        if ($device['trusted']) {
                            $count++;
                        }
                    endforeach;
                    if ($count == 0) {
                        ?>
                        <div style="text-align: center">
                            <?php
                            echo $this->Html->link('See my devices\' requests', array('action' => 'myDevices'));
                            ?>
                        </div>
                        <?php
                    } else {
                        $count = 1;
                        foreach ($devices as $device):
                            if ($device['trusted']) {
                                ?> 
                                <div class="row bigbox">
                                    <h3>Device n°<?php echo $count; ?></h3>
                                    <hr class="separator">
                                    <div class="col-sm-7">
                                        <h4><i class="fa fa-barcode"></i> Serial</h4>
                                        <?php
                                        echo $device['serial'];
                                        ?>
                                    </div>
                                    <div class="col-sm-5">
                                        <h4><i class="fa fa-quote-right"></i> Description</h4>
                                        <?php
                                        echo $device['description'];
                                        ?>
                                    </div>
                                </div>
                                <br>
                                <?php
                                $count++;
                            }
                        endforeach;
                        ?>
                        <div style="text-align: center"><?php
                            echo $this->Html->link('See all my devices', array('action' => 'myDevices'));
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>