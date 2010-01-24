<?php
 // Create the error handler
 function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) {
 	global $debug, $contact_email;
	
	// Build the error message
	$message = "An error has occurred in script '$e_file' on line $e_line: \n<br />$e_message\n<br />";
	
	// Add the date and time
	$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n<br />";
	
	// Add the vars to the message
	$message .= "<pre>" . print_r($e_vars, 1) . "</pre>\n<br />";
	
	if ($debug) { // show the error onscreen
		echo '<p class="error">' . $message . '</p>';
	} else {
		// log the error
		error_log($message, 1, $contact_email); // send the email
		
		// Only print an error message if the error isn't a notice or strict
		if (($e_number != E_NOTICE) && ($e_number < 2048)) {
			echo '<p class="error">A system error has occurred.  We apologize for the inconvenience.</p>';
		echo '<p class="error">' . $message . '</p>';
			}
			
		} // end of IF $debug
		
	} // end of FUNCTION my_error_handler
	
// Use my error handler
set_error_handler('my_error_handler');
?>
			<div>
				 <div class="contactus">
					<table style=" height:600px;">
						<tr>
							<td style="vertical-align: top">
								<fieldset>
									<legend>Maintenance</legend>
									<table cellspacing="0" cellpadding="0" border="0"  style="background-color: #F7F6F3;">
										<tbody>
											<tr>
												<td nowrap>
													<div style="padding-right: 15px; padding-left: 15px; padding-bottom: 5px; padding-top: 7px">
														<a class="SideNavLink" href="/pricetype">Price Type</a></div>
												</td>
											</tr>
											<tr>
												<td nowrap>
													<div style="padding-right: 15px; padding-left: 15px; padding-bottom: 5px;">
														<a class="SideNavLink" href="/classification">Classification</a></div>
												</td>
											</tr>
											<tr>
												<td nowrap>
													<div style="padding-right: 15px; padding-left: 15px; padding-bottom: 5px;">
														<a class="SideNavLink" href="/editmethod">Edit Method</a></div>
												</td>
											</tr>
											<tr>
												<td nowrap>
													<div style="padding-right: 15px; padding-left: 15px; padding-bottom: 5px;">
														<a class="SideNavLink" href="/processor">Processor</a></div>
												</td>
											</tr>
											<tr>
												<td nowrap>
													<div style="padding-right: 15px; padding-left: 15px; padding-bottom: 5px;">
														<a class="SideNavLink" href="/sitepassword">Site Passwords</a></div>
												</td>
											</tr>
											  <tr>
												<td nowrap>
													<div style="padding-right: 15px; padding-left: 15px; padding-bottom: 5px;">
														<a class="SideNavLink" href="/adpackage">AdPackage</a></div>
												</td>
											</tr>
											  <tr>
												<td nowrap>
													<div style="padding-right: 15px; padding-left: 15px; padding-bottom: 5px;">
														<a class="SideNavLink" href="/linktype">Link Type</a></div>
												</td>
											</tr>
											   <tr>
												<td nowrap>
													<div style="padding-right: 15px; padding-left: 15px; padding-bottom: 5px;">
														<a class="SideNavLink" href="/scripts">Scripts</a></div>
												</td>
											</tr>
										</tbody>
									</table>
								</fieldset>
							</td>
							<td valign="top">
								<?= $this->load->vars($data); ?>
							</td>
						</tr>
					</table>
  				</div>
			</div>
		</div>
	</div>
</body>
</html>