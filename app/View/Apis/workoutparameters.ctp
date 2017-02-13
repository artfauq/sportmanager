<?php 
if($Logs){
    foreach ($Logs as $Log)
            echo json_encode ($Log['Log']);
}else{
    echo json_encode('NO LOGS');
}
?>