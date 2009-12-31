    <div id="AccountPanel">
	
    <div style="clear: left; text-align: right;">
    <?php if($this->uri->segment(2) !== 'demo'): ?><a id="HyperLink1" href="ChangePassword.aspx" style="display:inline-block;width:652px;">Change password?</a><?php endif; ?></div>
        <div>
       &nbsp;<strong><span style="font-size: 10pt"> Registered information for  </span></strong> 
            <span id="lblEmail1Value" style="font-size:10pt;font-weight:bold;"><?= $client->PropertyName; ?></span><strong><span style="font-size: 10pt">
            </span></strong><br /><br />
		<form name="profileForm" method="post" id="profileForm" class="cmxform">
             <table border="0" style="font-size: 100%; width: 683px;" >
				<tr>
					<td>
						<?php echo validation_errors(); ?>
					</td>
				</tr>
			</table>
       <fieldset>
            <legend>Account Information</legend>
            <table border="0" style="font-size: 100%; width: 683px;" >
                <tr>
                    <td>
                        <span id="lblPropertyName" style="color:DimGray;">Property Name:</span>
                    </td>
                    <td>
                        <input name="txtPropertyName" type="text" id="txtPropertyName" class="texta" style="width:210px;" value="<?= set_value('PropertyName', $client->PropertyName); ?>" />
                        <!--span id="RequiredFieldValidator2" style="color:Red;visibility:hidden;">*</span-->
					</td>
                </tr>
                <tr>
                    <td>
                        <span id="lblAddress" style="color:DimGray;font-family:Tahoma;">Address :</span>
                    </td>
                    <td>
                        <input name="txtAddress" type="text" id="txtAddress1" class="texta" style="width:210px;" value="<?= set_value('Address', $client->Address); ?>" />
                        <!--span id="RequiredFieldValidator3" style="color:Red;visibility:hidden;">*</span-->
					</td>
                </tr>
                <tr>
                    <td>
                        <span id="lblCity" style="color:DimGray;">City:</span>
                    </td>
                    <td>
                        <input name="txtCity" type="text" id="txtCity" class="texta" style="width:210px;" value="<?= set_value('City', $client->City); ?>" />
                        <!--span id="RequiredFieldValidator4" style="color:Red;visibility:hidden;">*</span-->
					</td>
                </tr>
                <tr>
                    <td>
                        <span id="lblStates" style="color:DimGray;">State :</span></td>
                    <td>
                        <select name="ddlState" id="ddlState" class="texta">
							<option value="" <?= $client->State === '' ? 'selected="selected"' : ''; ?>></option>
        	                    <?php foreach($states->result_array() as $row):?>
									<option value="<?= $row['StatesCode']; ?>" <?= set_select('ddlState', $row['StatesCode'], $client->State === $row['StatesCode']); ?>><?= $row['StatesDescription']; ?></option>
                                <?php endforeach;?>
						</select>
                        <!--span id="RequiredFieldValidator5" style="color:Red;visibility:hidden;">.</span-->
					</td>
                </tr>
                <tr>
                    <td style="height: 15px">
                        <span id="lblZip" style="color:DimGray;">ZIP Code :</span></td>
                    <td style="height: 15px">
                        <input name="txtZip" type="text" id="txtZip" class="texta" style="width:80px;" value="<?= set_value('Zip', $client->Zip); ?>" />
                        <!--span id="RegularExpressionValidator1" style="color:Red;visibility:hidden;">*</span>
                        <span id="RequiredFieldValidator7" style="color:Red;visibility:hidden;">*</span-->
					</td>
                </tr>
                <tr>
                    <td>
                        <span id="lblPropertyURL" style="color:DimGray;">URL:</span>
                    </td>
                    <td>
                        <input name="txtPropertyURL" type="text" id="txtPropertyURL" class="texta" style="width:210px;" value="<?= set_value('URL', $client->URL); ?>" />
                        <!--span id="RegularExpressionValidator3" style="color:Red;visibility:hidden;">*</span>
                        <span id="RequiredFieldValidator6" style="color:Red;visibility:hidden;">*</span-->
					</td>
                </tr>
                <tr>
                    <td>&nbsp;
                
                    </td>
                    <td>
                    (e.g.  http://www.bedandbreakfast.com)
                </td>
                </tr>
            </table>
            <br />
        </fieldset>
    </div>
    <div>
        <fieldset>
            <legend>Contact Details</legend>
            <table border="0" style="font-size: 100%; width: 683px;" >
                <tr>
                    <td>
                        <span id="lblContact1" style="color:DimGray;">Contact 1:</span>
                    </td>
                    <td>
                        <input name="txtContact1" type="text" id="txtContact1" class="texta" style="width:210px;" value="<?= set_value('Contact1', $client->Contact1); ?>" />
                        <!--span id="RequiredFieldValidator1" style="color:Red;visibility:hidden;">*</span-->
					</td>
                    <td>
                    </td>
                    <td>
                        <span id="Label13" style="color:DimGray;">Contact 2:</span>
                    </td>
                    <td>
                        <input name="txtContact2" type="text" id="txtContact2" class="texta" style="width:210px;" value="<?= set_value('Contact2', $client->Contact2); ?>" />
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id="lblTitle1" style="color:DimGray;">Title:</span>
                    </td>
                    <td>
                        <input name="txtTitle1" type="text" id="txtTitle1" class="texta" style="width:210px;" value="<?= set_value('Title1', $client->Title1); ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                        <span id="Label14" style="color:DimGray;">Title:</span>
                    </td>
                    <td>
                        <input name="txtTitle2" type="text" id="txtTitle2" class="texta" style="width:210px;" value="<?= set_value('Title2', $client->Title2); ?>" />
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id="lblEmail1" style="color:DimGray;">Email :</span>
                    </td>
                    <td>
                        <input name="txtEmail1" type="text" id="txtEmail1" class="texta" style="width:210px;" value="<?= set_value('Email1', $client->Email1); ?>" />
					</td>
                    <td>
                    </td>
                    <td>
                        <span id="lblEmail2" style="color:DimGray;">Email:</span>
                    </td>
                    <td>
                        <input name="txtEmail2" type="text" id="txtEmail2" class="texta" style="width:210px;" value="<?= set_value('Email2', $client->Email2); ?>" />
                        <!--span id="RegularExpressionValidator5" style="color:Red;visibility:hidden;">*</span-->
					</td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id="lblPhone1" style="color:DimGray;">Phone:</span>
                    </td>
                    <td>
                        <input name="txtPhone1" type="text" id="txtPhone1" class="texta" style="width:210px;" value="<?= set_value('Phone1', $client->Phone1); ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                        <span id="lblPhone2" style="color:DimGray;">Phone:</span>
                    </td>
                    <td>
                        <input name="txtPhone2" type="text" id="txtPhone2" class="texta" style="width:210px;" value="<?= set_value('Phone2', $client->Phone2); ?>" />
                        </td>
                    <td>
                    </td>
                </tr>
            </table>
            <br />
        </fieldset>
        
    </div>
     <br />
            <input type="submit" name="Save" value="Save" id="Save" />
			</form>
        <br />
	</div>
</div>