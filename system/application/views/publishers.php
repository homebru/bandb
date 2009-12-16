			<div>
              <div style="padding:20px">
                <span style="font-weight:bold; font-style:italic; font-size:12pt; color:#ffce62; font-family:Arial, Helvetica, sans-serif;">Publishers</span>
                <strong>- Is your site in our database?</strong>
                <br />
                <span style="color:#F00;">Please enter your website name (e.g.  bedandbreakfast.com)</span>
                <br />
				<form id="find_form" action="<?=base_url()?>index.php/publishers/find" method="post">
				<?php //echo form_open('publishers/find');?>
                Search Here <span style="color:#666;">www</span>.
                <?php $data = array(
						  'name'  => 'txtSearch',
						  'id'    => 'txtSearch',
						  'value' => '',
						  'size'  => '25',
						);
				$attributes = array('id' => 'myform');?>
				<input type="text" id="txtSearch" name="txtSearch" size="25" />
                <button id="search" name="search">Search</button>
				<?php echo form_close('<br />');?>

				<div id="View2" style="display:none;">
					<br />
					<span  style="font-weight:bold; font-style:italic; font-family:Arial, Helvetica, sans-serif; font-size:12pt; color:#ffce62;">Congratulations and Welcome. Your web site has been successfully added.<br />We will contact you to complete your free listing in our Internet Advertising Database.</span>
					<br />
					<br />
					<!--button id="add" name="add">Add Another Website</button-->
				</div>

				<div id="View3" style="display:none;">
					<!--br />
					Yes, <strong></strong> is in our system.
					<br />
					<br /-->
				</div>

				<div id="View4" style="display:none;">
					<br />
					No,<strong>
						
					</strong>is not in our system, Please make sure you entered .com, .net, etc. Also do not include www., we have done it for you. Only exact matches are displayed.
					<br />
				</div>

				<!--div id="View5" style="display:none">
					<br />
					<strong>
						<script>response.write(searchToVal);</script>
					</strong> already exists in our system.<br />
					<br />
				</div-->

                    <div id="AddPanel" style="color: #000000; width:400px; display:none;">
						<form id="add_form" action="<?=base_url()?>index.php/publishers/add" method="post">
                        <table style="width: 390px; background-color: #F7F6F3;">
                            <tr>
                                <td colspan="2" valign="top">
                                    <p>Please fill out the following form to be included in system:<br />
									<em>(Required fields are marked with an <span style="color:#990000; font-weight:bold; font-size:1.2em;">*</span>)</em></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 138px">
                                    <label for="txtWebsite">Your Website URL</label></td>
                                <td>
                                    <input type="text" id="txtWebsite" name="txtWebsite" width="150" class="texta" disabled="disabled" value="" />
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 138px">
                                    <label for="txtPricingURL">Link to your pricing page</label></td>
                                <td>
                                    <input type="text" id="txtPricingURL" name="txtPricingURL" width="220" class="texta" value="<?php echo set_value('txtPricingURL'); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 138px">
                                    <label for="txtLogonURL">Link to you logon page</label></td>
                                <td>
                                    <input type="text" id="txtLogonURL" name="txtLogonURL" width="220" class="texta" value="<?php echo set_value('txtLogonURL'); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" valign="middle">
                                    <label for="rblUserReview">Your site allows user reviews?</label>
									<input type="radio" name="rblUserReview" value="1" id="rblUserReview_0" checked="checked" />Yes&nbsp;&nbsp;
									<input type="radio" name="rblUserReview" value="0" id="rblUserReview_1" />No</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <label for="rblBBListSpecials">Your site allows lodging properties to list specials?</label>
									<input type="radio" name="rblBBListSpecials" value="1" id="rblBBListSpecials_0" checked="checked" />Yes&nbsp;&nbsp;
									<input type="radio" name="rblBBListSpecials" value="0" id="rblBBListSpecials_1" />No</td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="rblQuantified">Your web site is Quantified?</label></td>
                                <td>
									<input type="radio" name="rblQuantified" value="1" id="rblQuantified_0" />Yes&nbsp;&nbsp;
									<input type="radio" name="rblQuantified" value="0" id="rblQuantified_1" checked="checked" />No</td>
                            </tr>
                            <tr>
                                <td style="width: 146px">
                                </td>
                                <td>
                                    (Highly recommended - go to <a href="http://www.quantcast.com/docs/faq">Quantcast.com</a>)</td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td colspan="3">
                                    Sales contact information:</td>
                            </tr>
                            <tr>
                                <td style="width: 101px">
                                    <label for="txtContact">Contact Name<span style="color:#990000; font-weight:bold;">*</span> :</label></td>
                                <td>
                                    <input type="text" id="txtContact" name="txtContact" width="190" class="texta" value="<?php echo set_value('txtContact'); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 101px">
                                    <label for="txtTitle">Title :</label></td>
                                <td>
                                    <input type="text" id="txtTitle" name="txtTitle" width="190" class="texta" value="<?php echo set_value('txtTitle'); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 101px">
                                    <label for="txtEmail">Email Sales<span style="color:#990000; font-weight:bold;">*</span> :</label></td>
                                <td>
                                    <input type="text" id="txtEmail" name="txtEmail" width="190" class="texta" value="<?php echo set_value('txtEmail'); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 101px">
                                    <label for="txtPhone">Phone :</label></td>
                                <td>
                                    <input type="text" id="txtPhone" name="txtPhone" width="190" class="texta" value="<?php echo set_value('txtPhone'); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 101px">
                                    <label for="txtTollFree">Toll Free :</label></td>
                                <td>
                                    <input type="text" id="txtTollFree" name="txtTollFree" width="190" class="texta" value="<?php echo set_value('txtTollFree'); ?>" /></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <label for="txtNotes">Comments</label></td>
                            </tr>
                            <tr>
                                <td colspan="2"><textarea id="txtNotes" name="txtNotes" cols="52" rows="10" class="texta"><?php echo set_value('txtNotes'); ?></textarea>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td style="width: 298px; height: 63px">&nbsp;
                                </td>
                                <td style="text-align: right; vertical-align: top; width: 147px; height: 63px;">
                                    <button id="btnAddSite" name="btnAddSite" class="texta">Add Website</button>
                                </td>
                            </tr>
                        </table>
					<?php echo form_close('<br />');?>
                    </div>
              </div>
			</div>
		</div>
	</div>
</body>
</html>