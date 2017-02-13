<?php $this->assign('title', $username . ' | My Devices'); ?>
<h1><i class="fa fa-tablet"></i> Devices</h1>
<?php
$tdevices = 0;
$ndevices = 0;
foreach ($devices as $device):
    if ($device['trusted']) {
        $tdevices++;
    } else {
        $ndevices++;
    }
endforeach;
?>

<div class="row">
    <div class="col-md-3" style="margin-top: 20px">
        <ul class="nav nav-pills nav-stacked-justified">
            <li class="active" style="width: 100%"><a href="#tdevices" data-toggle="pill">Trusted Devices</a></li>
            <li style="width: 100%"><a href="#ntdevices" data-toggle="pill">Devices' Requests <span class="badge" style="vertical-align: middle"><?php echo $nbuntrusteddevice; ?></span></a></li>
    </div>
    <div class="tab-content col-md-9">
        <div class="tab-pane fade in active" id="tdevices">
            <h2><i class="fa fa-navicon"></i>Trusted Devices</h2>
            <hr class="separator">
            <?php
            if ($tdevices == 0) {
                echo 'You currently have no trusted device.';
            } else {
                $tdevices = 1;
                foreach ($devices as $device):
                    if ($device['trusted']) {
                        ?>
                        <div class="row bigbox">
                            <h3>Device n°<?php echo $tdevices; ?></h3>
                            <hr class="separator">
                            <div class="col-sm-8">
                                <h4><i class="fa fa-barcode"></i> Serial</h4>
                                <?php
                                echo $device['serial'];
                                ?>
                                <hr class="separator">
                            </div>
                            <div class="col-sm-4">
                                <h4><i class="fa fa-quote-right"></i> Description</h4>
                                <?php
                                echo $device['description'];
                                ?>
                                <hr class="separator">
                            </div>
                            <div class="col-xs-12" style="text-align: center">
                                <?php
                                echo $this->Form->postLink('<i class="fa fa-close"></i> Untrust device', array(
                                    'action' => 'unTrustDevice', $device['id']), array(
                                    'class' => 'btn btn-danger',
                                    'escape' => false));
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    $tdevices++;
                endforeach;
            }
            ?>
        </div>

        <div class="tab-pane fade" id="ntdevices">
            <h2><i class="fa fa-navicon"></i>Non-Trusted Devices</h2>
            <hr class="separator">
            <?php
            if ($ndevices == 0) {
                echo 'You currently have no request.';
            } else {
                $ndevices = 1;
                foreach ($devices as $device):
                    if (!$device['trusted']) {
                        ?>
                        <div class="row bigbox">
                            <h3>Device n°<?php echo $ndevices; ?></h3>
                            <hr class="separator">
                            <div class="col-sm-8">
                                <h4><i class="fa fa-barcode"></i> Serial</h4>
                                <?php
                                echo $device['serial'];
                                ?>
                                <hr class="separator">
                            </div>
                            <div class="col-sm-4">
                                <h4><i class="fa fa-quote-right"></i> Description</h4>
                                <?php
                                echo $device['description'];
                                ?>
                                <hr class="separator">
                            </div>
                            <div class="col-xs-6" style="text-align: center">
                                <?php
                                echo $this->Form->postLink('<i class="fa fa-check"></i> Trust device', array(
                                    'action' => 'trustDevice', $device['id']), array(
                                    'class' => 'btn btn-success',
                                    'escape' => false));
                                ?>
                            </div>
                            <div class="col-xs-6" style="text-align: center">
                                <?php
                                echo $this->Form->postLink('<i class="fa fa-trash-o"></i> Deny request', array(
                                    'action' => 'denyRequest', $device['id']), array(
                                    'confirm' => 'Are you sure you want to deny this request ?',
                                    'class' => 'btn btn-danger',
                                    'escape' => false));
                                ?>
                            </div>
                        </div>
                        <?php
                        $ndevices++;
                    }
                endforeach;
            }
            ?>
        </div>
    </div>
</div>

