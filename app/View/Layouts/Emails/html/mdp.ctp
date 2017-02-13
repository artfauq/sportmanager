<p>Bonjour <strong><?php echo $email;?></strong></p>
<p>Réinitialisez votre email en cliquant sur le lien ci-dessous:</p>
<p><?php echo $this->Html->link('Réinitialisation', $this->Html->url($link,'true'));?></p>
