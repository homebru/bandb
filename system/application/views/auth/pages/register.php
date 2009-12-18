<div id="login" style="margin-left:50px;">
	
	<?php if(empty($username)) { ?>
		<p><strong>Sign Up for a New Account</strong><br /><span style="font-style:italic; color:#990000;">(All fields are required)</span></p>
	<?php } else { ?>
	<h2>Update</h2>
	<?php } ?>
	
	<div class="box" style="margin-left:50px;">
			<form method="post">
			<?php if(empty($username)) { ?>
			Username:<br />
			<input type="text" name="username" size="50" class="form" value="<?php echo set_value('username'); ?>" /><br /><?php echo form_error('username'); ?><br />
			Password:<br />
			<input type="password" name="password" size="43" class="form" value="<?php echo set_value('password'); ?>" /><?php echo form_error('password'); ?><br /><br />
			Password confirmation:<br />
			<input type="password" name="conf_password" size="43" class="form" value="<?php echo set_value('conf_password'); ?>" /><?php echo form_error('conf_password'); ?><br /><br />
			<?php } ?>
			Email:<br />
			<?php if(empty($username)){ ?>
				<input type="text" name="email" size="50" class="form" value="<?php echo set_value('email'); ?>" /><?php echo form_error('email'); ?><br /><br />
			<?php }else{ ?>
			<input type="text" name="email" size="50" class="form" value="<?php echo set_value('email', $email); ?>" /><?php echo form_error('email'); ?><br /><br />
			<?php } if(empty($username)) { ?>
			<div style="width:310px; text-align:right">
			<input type="submit" value="Register" name="register" />
			</div>
			<?php } else { ?>
			<input type="submit" value="Update" name="register" />
			<?php } ?>
			</form>
	</div>
</div>