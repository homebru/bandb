    <div id="AccountPanel" style="height:450px;">
	
    <div style="clear: left; text-align: right;">
    <a id="HyperLink1" href="ChangePassword.aspx" style="display:inline-block;width:652px;">Change password?</a></div>
        <div>
       &nbsp;<strong><span style="font-size: 10pt"> Registered information for  </span></strong> 
            <span id="lblEmail1Value" style="font-size:10pt;font-weight:bold;"><?php //echo username(); ?></span><strong><span style="font-size: 10pt">
            </span></strong><br /><br />
        <fieldset>
            <legend>Account Information</legend>
            <table border="0" style="font-size: 100%; width: 683px;" >
                <tr>
                    <td>
                        <span id="lblPropertyName" style="color:DimGray;">Property Name:</span>
                    </td>
                    <td>
                        <input name="txtPropertyName" type="text" value="Inn at Weston" id="txtPropertyName" class="texta" style="width:210px;" value="<?php echo $client->PropertyName; ?>" />
                        <!--span id="RequiredFieldValidator2" style="color:Red;visibility:hidden;">*</span-->
					</td>
                </tr>
                <tr>
                    <td>
                        <span id="lblAddress" style="color:DimGray;font-family:Tahoma;">Address :</span>
                    </td>
                    <td>
                        <input name="txtAddress1" type="text" id="txtAddress1" class="texta" style="width:210px;" value="<?php echo $client->Address; ?>" />
                        <!--span id="RequiredFieldValidator3" style="color:Red;visibility:hidden;">*</span-->
					</td>
                </tr>
                <tr>
                    <td>
                        <span id="lblCity" style="color:DimGray;">City:</span>
                    </td>
                    <td>
                        <input name="txtCity" type="text" id="txtCity" class="texta" style="width:210px;" value="<?php echo $client->City; ?>" />
                        <!--span id="RequiredFieldValidator4" style="color:Red;visibility:hidden;">*</span-->
					</td>
                </tr>
                <tr>
                    <td>
                        <span id="lblStates" style="color:DimGray;">State :</span></td>
                    <td>
                        <select name="ddlState" id="ddlState" class="texta">
							<option value="" <?php echo $client->State === '' ? 'selected="selected"' : ''; ?>></option>
							<option value="AL" <?php echo $client->State === 'AL' ? 'selected="selected"' : ''; ?>>Alabama</option>
							<option value="AK" <?php echo $client->State === 'AK' ? 'selected="selected"' : ''; ?>>Alaska</option>
							<option value="AZ" <?php echo $client->State === 'AZ' ? 'selected="selected"' : ''; ?>>Arizona</option>
							<option value="AR" <?php echo $client->State === 'AR' ? 'selected="selected"' : ''; ?>>Arkansas</option>
							<option value="CA" <?php echo $client->State === 'CA' ? 'selected="selected"' : ''; ?>>California</option>
							<option value="CO" <?php echo $client->State === 'CO' ? 'selected="selected"' : ''; ?>>Colorado</option>
							<option value="CT" <?php echo $client->State === 'CT' ? 'selected="selected"' : ''; ?>>Connecticut</option>
							<option value="DE" <?php echo $client->State === 'DE' ? 'selected="selected"' : ''; ?>>Delaware</option>
							<option value="DC" <?php echo $client->State === 'DC' ? 'selected="selected"' : ''; ?>>District of Columbia</option>
							<option value="FL" <?php echo $client->State === 'FL' ? 'selected="selected"' : ''; ?>>Florida</option>
							<option value="GA" <?php echo $client->State === 'GA' ? 'selected="selected"' : ''; ?>>Georgia</option>
							<option value="HI" <?php echo $client->State === 'HI' ? 'selected="selected"' : ''; ?>>Hawaii</option>
							<option value="ID" <?php echo $client->State === 'ID' ? 'selected="selected"' : ''; ?>>Idaho</option>
							<option value="IL" <?php echo $client->State === 'IL' ? 'selected="selected"' : ''; ?>>Illinois</option>
							<option value="IN2" <?php echo $client->State === 'IN2' ? 'selected="selected"' : ''; ?>>Indiana</option>
							<option value="IA" <?php echo $client->State === 'IA' ? 'selected="selected"' : ''; ?>>Iowa</option>
							<option value="KS" <?php echo $client->State === 'KS' ? 'selected="selected"' : ''; ?>>Kansas</option>
							<option value="KY" <?php echo $client->State === 'KY' ? 'selected="selected"' : ''; ?>>Kentucky</option>
							<option value="LA" <?php echo $client->State === 'LA' ? 'selected="selected"' : ''; ?>>Louisiana</option>
							<option value="ME2" <?php echo $client->State === 'ME2' ? 'selected="selected"' : ''; ?>>Maine</option>
							<option value="MD" <?php echo $client->State === 'MD' ? 'selected="selected"' : ''; ?>>Maryland</option>
							<option value="MA" <?php echo $client->State === 'MA' ? 'selected="selected"' : ''; ?>>Massachusetts</option>
							<option value="MI" <?php echo $client->State === 'MI' ? 'selected="selected"' : ''; ?>>Michigan</option>
							<option value="MN" <?php echo $client->State === 'MN' ? 'selected="selected"' : ''; ?>>Minnesota</option>
							<option value="MS" <?php echo $client->State === 'MS' ? 'selected="selected"' : ''; ?>>Mississippi</option>
							<option value="MO" <?php echo $client->State === 'MO' ? 'selected="selected"' : ''; ?>>Missouri</option>
							<option value="MT" <?php echo $client->State === 'MT' ? 'selected="selected"' : ''; ?>>Montana</option>
							<option value="NE" <?php echo $client->State === 'NE' ? 'selected="selected"' : ''; ?>>Nebraska</option>
							<option value="NV" <?php echo $client->State === 'NV' ? 'selected="selected"' : ''; ?>>Nevada</option>
							<option value="NH" <?php echo $client->State === 'NH' ? 'selected="selected"' : ''; ?>>New Hampshire</option>
							<option value="NJ" <?php echo $client->State === 'NJ' ? 'selected="selected"' : ''; ?>>New Jersey</option>
							<option value="NM" <?php echo $client->State === 'NM' ? 'selected="selected"' : ''; ?>>New Mexico</option>
							<option value="NY" <?php echo $client->State === 'NY' ? 'selected="selected"' : ''; ?>>New York</option>
							<option value="NC" <?php echo $client->State === 'NC' ? 'selected="selected"' : ''; ?>>North Carolina</option>
							<option value="ND" <?php echo $client->State === 'ND' ? 'selected="selected"' : ''; ?>>North Dakota</option>
							<option value="OH" <?php echo $client->State === 'OH' ? 'selected="selected"' : ''; ?>>Ohio</option>
							<option value="OK" <?php echo $client->State === 'OK' ? 'selected="selected"' : ''; ?>>Oklahoma</option>
							<option value="OR2" <?php echo $client->State === 'OR2' ? 'selected="selected"' : ''; ?>>Oregon</option>
							<option value="PA" <?php echo $client->State === 'PA' ? 'selected="selected"' : ''; ?>>Pennsylvania</option>
							<option value="RI" <?php echo $client->State === 'RI' ? 'selected="selected"' : ''; ?>>Rhode Island</option>
							<option value="SC" <?php echo $client->State === 'SC' ? 'selected="selected"' : ''; ?>>South Carolina</option>
							<option value="SD" <?php echo $client->State === 'SD' ? 'selected="selected"' : ''; ?>>South Dakota</option>
							<option value="TN" <?php echo $client->State === 'TN' ? 'selected="selected"' : ''; ?>>Tennessee</option>
							<option value="TX" <?php echo $client->State === 'TX' ? 'selected="selected"' : ''; ?>>Texas</option>
							<option value="UT" <?php echo $client->State === 'UT' ? 'selected="selected"' : ''; ?>>Utah</option>
							<option value="VT" <?php echo $client->State === 'VT' ? 'selected="selected"' : ''; ?>>Vermont</option>
							<option value="VI" <?php echo $client->State === 'VI' ? 'selected="selected"' : ''; ?>>Virginia</option>
							<option value="WA" <?php echo $client->State === 'WA' ? 'selected="selected"' : ''; ?>>Washington</option>
							<option value="WV" <?php echo $client->State === 'WV' ? 'selected="selected"' : ''; ?>>West Virginia</option>
							<option value="WI" <?php echo $client->State === 'WI' ? 'selected="selected"' : ''; ?>>Wisconsin</option>
							<option value="WY" <?php echo $client->State === 'WY' ? 'selected="selected"' : ''; ?>>Wyoming</option>
						</select>
                        <!--span id="RequiredFieldValidator5" style="color:Red;visibility:hidden;">.</span-->
					</td>
                </tr>
                <tr>
                    <td style="height: 15px">
                        <span id="lblZip" style="color:DimGray;">ZIP Code :</span></td>
                    <td style="height: 15px">
                        <input name="txtZip" type="text" value="5161" id="txtZip" class="texta" style="width:80px;" value="<?php echo $client->Zip; ?>" />
                        <!--span id="RegularExpressionValidator1" style="color:Red;visibility:hidden;">*</span>
                        <span id="RequiredFieldValidator7" style="color:Red;visibility:hidden;">*</span-->
					</td>
                </tr>
                <tr>
                    <td>
                        <span id="lblPropertyURL" style="color:DimGray;">URL:</span>
                    </td>
                    <td>
                        <input name="txtPropertyURL" type="text" id="txtPropertyURL" class="texta" style="width:210px;" value="<?php echo $client->URL; ?>" />
                        <!--span id="RegularExpressionValidator3" style="color:Red;visibility:hidden;">*</span>
                        <span id="RequiredFieldValidator6" style="color:Red;visibility:hidden;">*</span-->
					</td>
                </tr>
                <tr>
                    <td>
                &nbsp;
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
                        <input name="txtContact1" type="text" id="txtContact1" class="texta" style="width:210px;" value="<?php echo $client->Contact1; ?>" />
                        <!--span id="RequiredFieldValidator1" style="color:Red;visibility:hidden;">*</span-->
					</td>
                    <td>
                    </td>
                    <td>
                        <span id="Label13" style="color:DimGray;">Contact 2:</span>
                    </td>
                    <td>
                        <input name="txtContact2" type="text" id="txtContact2" class="texta" style="width:210px;" value="<?php echo $client->Contact2; ?>" />
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id="lblTitle1" style="color:DimGray;">Title:</span>
                    </td>
                    <td>
                        <input name="txtTitle1" type="text" id="txtTitle1" class="texta" style="width:210px;" value="<?php echo $client->Title1; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                        <span id="Label14" style="color:DimGray;">Title:</span>
                    </td>
                    <td>
                        <input name="txtTitle2" type="text" id="txtTitle2" class="texta" style="width:210px;" value="<?php echo $client->Title2; ?>" />
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span id="lblEmail1" style="color:DimGray;">Email :</span>
                    </td>
                    <td>
                        &nbsp;<span id="txtWebEmail" style="font-weight:bold;"></span></td>
                    <td>
                    </td>
                    <td>
                        <span id="lblEmail2" style="color:DimGray;">Email:</span>
                    </td>
                    <td>
                        <input name="txtEmail2" type="text" id="txtEmail2" class="texta" style="width:210px;" value="<?php echo $client->Email2; ?>" />
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
                        <input name="txtPhone1" type="text" id="txtPhone1" class="texta" style="width:210px;" value="<?php echo $client->Phone1; ?>" />
                    </td>
                    <td>
                    </td>
                    <td>
                        <span id="lblPhone2" style="color:DimGray;">Phone:</span>
                    </td>
                    <td>
                        <input name="txtPhone2" type="text" id="txtPhone2" class="texta" style="width:210px;" value="<?php echo $client->Phone2; ?>" />
                        </td>
                    <td>
                    </td>
                </tr>
            </table>
            <br />
        </fieldset>
        
    </div>
     <br />
            <input type="submit" name="btnSave" value="Save" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnSave&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))" id="btnSave" />
        <br />
	</div>
</div>