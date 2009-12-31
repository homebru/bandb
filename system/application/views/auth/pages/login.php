				<div class="cnt">
					<div id="login" style="text-align:left; width:610px;">
						<form method="POST">
							<table width="100%">
								<tr>
									<td align="center">
										<table cellspacing="0" cellpadding="1" border="0" id="Login1" style="border-width:0px;border-collapse:collapse;">
											<tr>
												<td><table cellpadding="0" border="0" style="font-family:Verdana;font-size:10pt;height:153px;">
													<tr>
														<td align="right"><label for="username">User Name:</label></td><td><input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50" class="form" /><?php echo form_error('username'); ?></td>
													</tr><tr>
														<td align="right"><label for="password">Password:</label></td><td><input type="password" name="password" value="<?php echo set_value('password'); ?>" size="43" class="form" /><?php echo form_error('password'); ?></td>
													</tr><tr>
														<td colspan="2"><input id="remember_me" type="checkbox" name="remember_me" /><label for="remember_me">Remember me next time.</label></td>
													</tr><tr>
														<td align="right" colspan="2"><input type="submit" value="Login" name="login" /></td>
													</tr><tr>
														<td colspan="2"><a id="CreateUserLink" href="register">Don't have an account? Create one!</a><br /><a id="PasswordRecoveryLink" href="forgot">Forgot your password?</a></td>
													</tr>
												</table></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</form>						
					<!--/div-->
				</div>
			</div>
		</div>
	</div>
</body>
</html>