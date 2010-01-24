			<div>
				<div>
					<?= isset($msg) ? $msg : ''; ?>
				</div>
				 <div style="display:<?= isset($msg) ? "none" : "block"; ?>">
				 <form id="forgot_password_form" method="post">
				<table cellspacing="0" cellpadding="0" border="0" id="register" style="width:650px;border-collapse:collapse;">
					<tr>
						<td><?php echo validation_errors(); ?></td>
					</tr>
					<tr style="height:100%;">
						<td align="left">
							<table cellspacing="0" cellpadding="0" border="0" style="height:100%;width:400px;border-collapse:collapse;">
								<tr>
									<td style="height:100%;width:100%;" align="center">
										<table border="0" style="font-size: 100%; width: 300px">
											<tr>
												<td align="center" colspan="2">
													<p>Forgotten Account Password<br />
													<em>(All fields are required)</em></p>
												</td>
											</tr>
											<tr>
												<td align="right">
													<label for="Email" id="EmailLabel">E-mail:</label></td>
												<td>
													<input name="Email" type="text" id="Email" style="width:200px;" value="<?php echo set_value('Email'); ?>" />
												</td>
											</tr>
											<tr>
												<td align="center" colspan="2">&nbsp;
													</td>
											</tr>
								<tr>
									<td colspan="2" align="right">
										<input type="submit" value="Submit" name="submit" />
									</td>
								</tr>
										</table>
									</td>
								</tr>
							</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>