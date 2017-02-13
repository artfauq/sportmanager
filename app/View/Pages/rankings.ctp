<?php $this->assign('title', 'Sport Manager | Rankings'); ?>

<h1><i class="glyphicon glyphicon-bookmark"></i> Rankings</h1>
<br>
<div class="row">
    <?php
    $count = 0;
    foreach ($maxiTableau as $sport) :
        ?>
        <div class="col-lg-12">
            <div class="bigbox">
                <h2><?php echo array_keys($maxiTableau)[$count]; ?></h2>
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <?php
                    $count1 = 0;
                    foreach ($sport as $log_type):
                        ?>
                        <li role="presentation" class="<?php echo ($count1 == 0) ? 'active' : ''; ?>">
                            <a class="changes" role="tab" 
                               data-toggle="tab" 
                               aria-expanded="false"
                               aria-controls="<?php echo str_replace(' ', '_', array_keys($sport)[$count1]); ?>" 
                               href="#<?php echo str_replace(' ', '_', array_keys($sport)[$count1]); ?>">
                                   <?php echo array_keys($sport)[$count1]; ?>
                            </a>
                        </li>
                        <?php
                        $count1++;
                    endforeach;
                    ?>
                </ul>
                <br>
                <div class="row">
                    <div class="tab-content">
                        <?php
                        $count1 = 0;
                        foreach ($sport as $log_type):
                            ?>
                            <div role="tabpanel" 
                                 class="tab-pane fade <?php echo ($count1 == 0) ? 'active in' : ''; ?>"
                                 aria-labelledby="<?php echo str_replace(' ', '_', array_keys($sport)[$count1]); ?>"
                                 id="<?php echo str_replace(' ', '_', array_keys($sport)[$count1]); ?>">
                                     <?php
                                     if (count($log_type) == 0) {
                                         echo 'There are currently no rankings for ' . array_keys($sport)[$count1];
                                     } else {
                                         ?>
                                    <table>
                                        <thead>
                                            <tr class="row">
                                                <th class="col-sm-4">Ranking</th>                
                                                <th class="col-sm-4">Member</th>
                                                <th class="col-sm-4 small-hidden">Count</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($log_type as $totalPerMember):
                                                ?>
                                                <tr class="row">
                                                    <td class="col-sm-4"><?php
                                                        if ($i == 1)
                                                            echo '<i class="fa fa-trophy" style="color: #D1B606"></i> ';
                                                        if ($i == 2)
                                                            echo '<i class="fa fa-trophy" style="color: #C1C1C1"></i> ';
                                                        if ($i == 3)
                                                            echo '<i class="fa fa-trophy" style="color: #614E1A"></i> ';
                                                        echo $i;
                                                        $i++;
                                                        ?>
                                                    </td>
                                                    <td class="col-sm-4">
                                                        <?php
                                                        foreach ($members as $member):
                                                            if ($member['Member']['id'] == $totalPerMember['logs']['member_id'])
                                                                echo substr($member['Member']['email'], 0, strrpos($member['Member']['email'], "@"));
                                                        endforeach;
                                                        ?>
                                                    </td>
                                                    <td class="col-sm-4 small-hidden"><?php echo $totalPerMember[0]['SUM(log_value)']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php
                                }
                                $count1++;
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $count++;
    endforeach;
    ?>
</div>

