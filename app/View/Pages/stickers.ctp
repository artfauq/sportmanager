<?php $this->assign('title', 'Sport Manager | Stickers'); ?>
<h1><i class="fa fa-trophy"></i> Stickers</h1>
<p class="middle">List of all the stickers and who won it</p>
<div class="row">
    <?php foreach ($stickers as $sticker): ?>
        <hr class="separator">
        <a class="anchor" id="<?php echo str_replace(' ', '_', $sticker['Sticker']['name']); ?>"></a>
        <div class="row">
            <div class="col-sm-3 col-xs-12" style="text-align: center">
                <?php
                echo $this->Html->image(str_replace(' ', '_', 'stickers/' . $sticker['Sticker']['name']) . '.png', array(
                    'class' => 'sticker'));
                ?>
                </a>
            </div>
            <div class="col-sm-9 col-xs-12" style="min-height: 100%">
                <div class="bigbox" style="height: 100%">
                    <h3><?php echo $sticker['Sticker']['name']; ?></h3>
                    <p><?php echo $sticker['Sticker']['description']; ?></p>
                    <br>
                    <?php
                    $count = 0;
                    foreach ($sticker['Earning'] as $earning):
                        foreach ($members as $member):
                            if ($member['Member']['id'] == $earning['member_id']) {
                                $count++;
                            }
                        endforeach;
                    endforeach;
                    if ($count == 0) {
                        echo 'Nobody won this sticker.';
                    } else {
                        ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Won by</th>
                                    <th class="small-hidden">Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($sticker['Earning'] as $earning):
                                    foreach ($members as $member):
                                        if ($member['Member']['id'] == $earning['member_id']) {
                                            ?>
                                            <tr>
                                                <td><?php
                                                    echo
                                                    substr($member['Member']['email'], 0, strrpos($member['Member']['email'], "@"));
                                                    ?></th>
                                                <td class="small-hidden"><?php
                                                    $date = date_create($earning['date']);
                                                    echo $date->format('d/m/Y');
                                                    ?></th>
                                            </tr>
                                            <?php
                                        }
                                    endforeach;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
    <?php } ?>
                </div>
            </div>
        </div>
<?php endforeach; ?>
</div>