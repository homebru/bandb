    <table width="100%" >
		<tr>            
            <td style="vertical-align: middle; text-align: right; height: 16px;">
				<label for="chkListing">Add to my Advertising Sites?</label>
				<input type="checkbox" id="chkListing" name="chkListing" onchange="chkListing_CheckedChanged" <?php echo $ad_log_count == 0 ? '' : 'checked="checked"'; ?> />
			</td>
		</tr>
    </table>
    
    <div>
        <fieldset class="content">
            <legend>Travel Directory Detail Page</legend>
            <table style="width: 867px; background-color: #F7F6F3;">
                <tr>
                    <td colspan="2" style="padding-left: 10px;" rowspan="2">
						&nbsp;<a href="<?php echo $bbdata->Website; ?>" id="hlWebsiteValue" style="font-weight:bold; font:Arial; font-size:16pt; text-decoration:underline; color:SteelBlue"><?php echo $bbdata->WebsiteText; ?></a>
					</td>
                    <td style="text-align: right; height: 15px;">
                    </td>
                    <td style="text-align: left; height: 15px;">
                    </td>
                    <td style="text-align: right; width: 113px; height: 15px;">
                    </td>
                    <td style="height: 15px">&nbsp;
                     </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label id="lblClassificationValue" style="color:Firebrick;"><?php echo $bbdata->ClassficationText; ?></label>
					</td>
                    <td style="text-align: left; width: 113px;">
                        <label id="lblRankingValue" ><?php for($i=0; $i<$bbdata->Rating; $i++) { echo "<IMG src='". base_url() ."images/star_active.gif'>"; } ?></label>
					</td>
                    <td>
                        <label id="Label3">Price :</label>
                        <label id="lblPriceValue" style="color:Firebrick;"><?php echo $bbdata->Price; ?></label>
					</td>
                </tr>
            </table>
            <table style="width: 867px; background-color: #F7F6F3;">
                <tr>
                    <td>
                        <a href="<?php echo $bbdata->PricingPageURL; ?>" id="hlPriceURL" Target="_blank">Price Page</a>
					</td>
                    <td>
                        <label id="lblPriceType">Price Type :</label>
                        <label id="lblPriceTypeValue"style="color:Firebrick;" class="texta"><?php echo $bbdata->PriceTypeText; ?></label>
					</td>
                    <td style="width: 188px">
                        <label id="Label1">B&amp;B Category :</label>
                        <label id="lblBBCategory" style="color:Firebrick;"><?php echo $bbdata->BBCategory == 1 ? 'Yes' : 'No'; ?></label>
					</td>
                </tr>
                <tr>
                    <td>
                        <a href="<?php echo $bbdata->LogonPageURL; ?>" id="hlLogonURL" Target="_blank">Logon Page</a>
					</td>
                    <td>
                        <label id="lblEditMethod">Edit Method :</label>
                        <label id="lblMethodValue" style="color:Firebrick;" class="texta"><?php echo $bbdata->Method; ?></label>
					</td>
                    <td style="width: 188px">
                        <label id="lblUserReview">User Review :</label>
                        <label id="lblUserReview1" style="color:Firebrick;"><?php echo $bbdata->UserReview; ?></label>
					</td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="<?php echo $bbdata->SpecialPageURL; ?>" id="hlSpecialsURL" Target="_blank">Specials Page</a>
					</td>
                    <td>
                        <label id="lblBBListSpecial">List Specials :</label>
                        <label id="lblBBListSpecialsValue" style="color:Firebrick;"><?php echo $bbdata->BBListSpecials; ?></label>
					</td>
                    <td style="width: 188px">
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>
    <div>
        <fieldset class="content">
            <legend>Notes</legend>
            <table style="width: 867px; background-color: #F7F6F3;">
                <tr>
                    <td colspan="4" style="height: 14px">
                        <textarea id="txtNotesValue" readonly="readonly" TextMode="MultiLine"
                            style="width:690px; height:100px; background-color:#FFFFFF;" class="texta"><?php echo $bbdata->Notes; ?></textarea>
					</td>
                </tr>
            </table>
        </fieldset>
    </div>
    <div id="adlog" style="display: <?php echo $ad_log_count == 0 ? 'none' : 'block'; ?>;">
        <fieldset class="content">
            <legend>Innkeeper Advertising Log</legend>
            <table cellpadding="2px" style="background-color: lightsteelblue; width: 867px;">
                <tr>
                    <td style="text-align: left; width: 550px;" >
                        <input type="hidden" id="AdLogID" name="AdLogID" />
                        <input type="hidden" id="JSApprResp" name="JSApprResp" />
                        <button class="texta" id="btnSave" name="btnSave" value="Save" >Save</button>
                        <button id="btnSaveReturn" name="btnSaveReturn" value="Save Return to Search" class="texta">Save &amp; Return to Search</button>
                        
                    </td>
                </tr>
                </table>
                <table style="background-color: lightsteelblue; width: 867px;">
                <tr>
                	<td style="width: 154px">
                        <label id="Label10">Price :</label>
					</td>
                    <td >
                        <input type="text" id="txtAdPrice" name="txtAdPrice" class="texta" style="width:70px" value="<?php echo $ad_log->Price === '' ? '' : '\$' . number_format($ad_log->Price,2); ?>"/>
						<!--asp:RegularExpressionValidator id="RegularExpressionValidator2" ErrorMessage="Please enter valid price."
                            ControlToValidate="txtAdPrice" ValidationExpression="^\$?[0-9]+(,[0-9]{3})*(\.[0-9]{2})?$">Please enter valid price.</asp:RegularExpressionValidator-->
					</td>
					<td colspan="2">
                        <label id="Label11" style="width:89px">Expires Date  :</label>
						<input type="text" id="txtExpiry" name="txtExpiry" class="texta" style="width:70px" value="<?php echo $ad_log->DateExpires === '' ? '' : sprintf("l, F j, Y", $ad_log->DateExpires); ?>" /> &nbsp;
						<a href="javascript:OpenPopupPage('Calendar.aspx','<%= txtExpiry.ClientID %>','<%= Page.IsPostBack %>');"><img src="Images/Calendar_scheduleHS.png" border="0" align="absBottom" width="16" height="16"></a>
					</td>
                </tr>
                </table>
                <table style="background-color: lightsteelblue; width: 867px;">
                <tr>
                    <td style="width: 154px">
                        <label id="Label2">User Name :</label>
					</td>
                    <td style="width: 149px">
                        <input type="text" id="txtUserName" name="txtUserName" class="texta" value="<?php echo $ad_log->UserName; ?>"/>
					</td>
                    <td  align="left">
                        <label id="Label8">Password :</label>&nbsp;<input type="password" id="txtPassword" name="txtPassword" class="texta" value="<?php echo $ad_log->Password; ?>"/>
					</td>
                    <td align="right">&nbsp;
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; width: 154px; height: 40px;">
                        <label id="Label4" style="width:79px">Listing Type :</label>
					</td>
                    <td colspan="3" style="width: 314px; height: 40px">
                        <input type="text" id="txtListingType" name="txtListingType" class="texta" style="height:30px; width:400px" value="<?php echo $ad_log->ListingType; ?>" /></td>
                </tr>
                <tr>
                    <td style="width: 154px; height: 28px">
                        <label id="Label7" style="height:12px">Your Location on this site :</label>
					</td>
                    <td colspan="3" style="height: 28px">
                        <input type="text" id="txtSiteLocation" name="txtSiteLocation" class="texta" style="width:375px" value="<?php echo $ad_log->SiteLocation; ?>"/> 
                        <a id="hlSiteLocationURL" href="javascript:myHref('<?php echo $ad_log->SiteLocation; ?>')">Go</a>
					</td>
                </tr>
                <tr>
                    <td style="width: 154px; vertical-align: top;">
						Comments :
					</td>
                    <td colspan="3">
					<textarea id="txtComments" name="txtComments" style="height:75px; width:400px" class="texta"><?php echo $ad_log->Comments; ?></textarea>
                    </td>
                </tr>
                
            </table>
        </fieldset>
    </div>
  
    <div>
        <fieldset class="content">
            <legend>Contact Details</legend>
            <table style="width: 867px; background-color: #F7F6F3;">
                <tr>
                    <td style="width: 100px;">
                        <label id="lblCointact1">Contact 1 :</label>
					</td>
                    <td style="width: 243px; background-color: #FFFFFF;">
                        <label id="lblCointact1Value"><?php echo $bbdata->Contact; ?></label>
					</td>
                    <td style="width: 121px;">
                        <label id="lblContact2">Contact 2 :</label>
					</td>
                    <td style="width: 293px; background-color: #FFFFFF;">
                        <label id="lblContact2Value"><?php echo $bbdata->Contact2; ?></label>
					</td>
                </tr>
                <tr>
                    <td style="width: 100px;">
                        <label id="lblTitle1">Title :</label>
					</td>
                    <td style="width: 243px; background-color: #FFFFFF;">
                        <label id="lblTitle1Value"><?php echo $bbdata->Contact1Title; ?></label>
					</td>
                    <td style="width: 121px;">
                        <label id="lblTitle2">Title :</label>
					</td>
                    <td style="width: 293px; background-color: #FFFFFF;">
                        <label id="lblTitle2Value"><?php echo $bbdata->Contact2Title; ?></label>
					</td>
                </tr>
                <tr>
                    <td style="width: 100px;">
                        <label id="lblEmail1">Email Sales :</label>
					</td>
                    <td style="width: 243px; background-color: #FFFFFF;">
                        <a id="lblEmail1Value" href="mailto:<?php echo $bbdata->EmailSales; ?>"><?php echo $bbdata->EmailSales; ?></a>
					</td>
                    <td style="width: 121px;">
                        <label id="lblEmail2">Email Support :</label>
					</td>
                    <td style="width: 293px; background-color: #FFFFFF;">
                        <a id="lblEmail2Value" href="mailto:<?php echo $bbdata->EmailSupport; ?>"><?php echo $bbdata->EmailSupport; ?></a>
					</td>
                </tr>
                <tr>
                    <td style="width: 100px;">
                        <label id="lblPhone1">Phone :</label>
					</td>
                    <td style="width: 243px; background-color: #FFFFFF;">
                        <label id="lblPhone1Value"><?php echo $bbdata->RegularPhone; ?></label>
					</td>
                    <td style="width: 121px;">
                        <label id="lblPhone2">Phone :</label>
					</td>
                    <td style="width: 293px; background-color: #FFFFFF;">
                        <label id="lblPhone2Value"><?php echo $bbdata->Contact2RegularPhone; ?></label>
					</td>
                </tr>
                <tr>
                    <td style="width: 100px;">
                        <label id="lblTollFree1">Toll Free :</label></td>
                    <td style="width: 243px; background-color: #FFFFFF;">
                        <label id="lblTollFree1Value"><?php echo $bbdata->TollFreePhone; ?></label></td>
                    <td style="width: 121px;">
                        <label id="lblTollFree2">Toll Free :</label></td>
                    <td style="width: 293px; background-color: #FFFFFF;">
                        <label id="lblTollFree2Value"><?php echo $bbdata->Contact2TollFreePhone; ?></label></td>
                </tr>
            </table>
        </fieldset>
    </div>
<div>
        &nbsp;
        <button id="btnSaveReturnBottom" name="btnSaveReturnBottom" class="texta">Save &amp; Return to Search</button>&nbsp;
        <button id="btnCancel" class="texta">Return to Search</button></div>
    <script language="javascript">
  confApprove();
    </script>

