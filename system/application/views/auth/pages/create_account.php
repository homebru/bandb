			<div>
				 <div>
				 <form id="create_user_form" method="post">
				<table cellspacing="0" cellpadding="0" border="0" id="register" style="width:650px;border-collapse:collapse;">
					<tr style="height:100%;">
						<td align="left">
							<table cellspacing="0" cellpadding="0" border="0" style="height:100%;width:100%;border-collapse:collapse;">
								<tr>
									<td style="height:100%;width:100%;">
										<table border="0" style="font-size: 100%; width: 650px">
											<tr>
												<td align="center" colspan="2">
													<p>Sign Up for New Account<br />
													<em>(All fields are required)</em></p>
												</td>
											</tr>
											<tr>
												<td align="right">
													<label for="UserName" id="UserNameLabel">User Name:</label></td>
												<td>
													<input name="UserName" type="text" id="UserName" style="width:200px;" value="<?php echo set_value('UserName'); ?>" />
													</td>
											</tr>
											<tr>
												<td align="right">
													<label for="Password" id="PasswordLabel">Password:</label></td>
												<td>
													<input name="Password" type="password" id="Password" style="width:200px;" />
												</td>
											</tr>
											<tr>
												<td align="right">
													<label for="ConfirmPassword" id="ConfirmPasswordLabel">Confirm Password:</label></td>
												<td>
													<input name="ConfirmPassword" type="password" id="ConfirmPassword" style="width:200px;" />
												</td>
											</tr>
											<tr>
												<td align="right">
													<label for="Email" id="EmailLabel">E-mail:</label></td>
												<td>
													<input name="Email" type="text" id="Email" style="width:200px;" value="<?php echo set_value('Email'); ?>" />
												</td>
											</tr>
											<!--tr>
												<td align="right">
													<label for="Question" id="QuestionLabel">Security Question:</label></td>
												<td>
													<input name="Question" type="text" id="Question" style="width:200px;" value="<?php echo set_value('Question'); ?>" />
												</td>
											</tr>
											<tr>
												<td align="right">
													<label for="Answer" id="AnswerLabel">Security Answer:</label></td>
												<td>
													<input name="Answer" type="text" id="Answer" style="width:200px;" value="<?php echo set_value('Answer'); ?>" />
												</td>
											</tr-->
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
										<input type="submit" value="Register" name="register" />
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