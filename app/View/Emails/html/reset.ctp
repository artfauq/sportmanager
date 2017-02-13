<h2><?php echo substr($email, 0, strrpos($email, "@"));?></h2>
<p>Password reset : </p>
<p><?php echo $this->Html->link('Reset my password',$this->Html->url($link,true));?></p>