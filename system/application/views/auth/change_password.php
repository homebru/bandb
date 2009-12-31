			<div>
				<div>
					<?= isset($msg) ? $msg : ''; ?>
				</div>
				 <div style="display:<?= isset($msg) ? "none" : "block"; ?>">
				 <form id="change_password_form" method="post">
				<table cellspacing="0" cellpadding="0" border="0" id="register" style="width:650px;border-collapse:collapse;">
					<tr>
						<td><?php echo validation_errors(); ?></td>
					</tr>
					<tr style="height:100%;">
						<td align="left">
							<table cellspacing="0" cellpadding="0" border="0" style="height:100%;width:100%;border-collapse:collapse;">
								<tr>
									<td style="height:100%;width:100%;">
										<table border="0" style="font-size: 100%; width: 650px">
											<tr>
												<td align="center" colspan="2">
													<p>Change your Account Password<br />
													<em>(All fields are required)</em></p>
												</td>
											</tr>
											<tr>
												<td align="right">
													<label for="Password" id="PasswordLabel">New Password:</label></td>
												<td>
													<input name="Password" type="password" id="Password" style="width:200px;" />
												</td>
											</tr>
											<tr>
												<td align="right">
													<label for="ConfirmPassword" id="ConfirmPasswordLabel">Confirm New Password:</label></td>
												<td>
													<input name="ConfirmPassword" type="password" id="ConfirmPassword" style="width:200px;" />
												</td>
											</tr>
											<tr>
												<td align="center" colspan="2">&nbsp;
													</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
									</td>
								</tr>
								<tr>
									<td align="right">
										<input type="submit" value="Submit" name="submit" />
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