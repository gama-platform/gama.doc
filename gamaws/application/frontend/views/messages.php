<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
?>
<?php
if(isset($messages) && $messages){
?>
<div class="alert-message alert-message-success">
	<div>
		<?php echo $messages; ?>
	</div>
</div>
<?php } ?>
<?php
if(isset($danger ) && $danger){ 
?>
<div class="alert-message alert-message-danger">
	<div>
		<?php echo $danger; ?>
	</div>
</div>
<?php } ?>
<?php
if(isset($error ) && $error){ 
?>
<div class="alert-message alert-message-danger">
	<div>
		<?php echo $error; ?>
	</div>
</div>
<?php } ?>
<?php
if(isset($warning ) && $warning){ 
?>
<div class="alert-message alert-message-warning">
	<div>
		<?php echo $warning; ?>
	</div>
</div>
<?php } ?>

<?php
if(isset($message_info ) && $message_info){ 
?>
<div class="alert-message alert-message-info">
	<div>
		<?php echo $message_info; ?>
	</div>
</div>
<?php } ?>
<?php
if(isset($message_default ) && $message_default){ 
?>
<div class="alert-message alert-message-default">
	<div>
		<?php echo $message_default; ?>
	</div>
</div>
<?php } ?>

<?php
if(isset($message_notice ) && $message_notice){ 
?>
<div class="alert-message alert-message-notice">
	<div>
		<?php echo $message_notice; ?>
	</div>
</div>
<?php } ?>