<script type="text/javascript">
function swapInputType()
	{
		if($("#rblGeo_0").attr('checked') == true)
			{
			$("#cbstates").hide();
			$("#rbstates").show();
			}
		else
			{
			$("#rbstates").hide();
			$("#cbstates").show();
			}
	}
</script>
	<div>
        <input type="submit" name="btnSaveTop" value="Save Record" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnSaveTop&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))" id="btnSaveTop" class="texta" style="width:107px;" />
        <input type="submit" name="btnSaveReturnTop" value="Save Return to Search" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnSaveReturnTop&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))" id="btnSaveReturnTop" class="texta" style="width:152px;" />
        <span id="lblLastUpdated">Last Updated :</span>
        <span id="lblLastUpdatedDate" style="display:inline-block;width:184px;">1/3/2010 12:00:49 PM</span>
        <span id="lblErrorMsg"></span>
	</div>
	
    <fieldset class="content">
        <legend>Website Details</legend>
        <table style="width: 750px; background-color: #F7F6F3;">
            <tr>
                <td>&nbsp;
                    
                </td>
                <td>&nbsp;
                    
                </td>
                <td style="text-align: right" colspan="6">
                    <span id="lblAdPackage" style="display:inline-block;width:76px;">Ad Package :</span>
                      <select name="ddlAdPackage" id="ddlAdPackage" class="texta">
						<option value=""></option>
						<?php foreach($adPackage as $row): ?>
						<option value="<?= $row['AdPackageId'] ?>" <?= $bbdata->AdPackage == $row['AdPackageId'] ? 'selected="selected"' : '' ?>><?= $row['AdPackageText'] ?></option>
						<?php endforeach; ?>
					</select>&nbsp; &nbsp;<span id="Label2">Score :</span>
                    <input name="txtScore" type="text" value="<?= $bbdata->Score ?>" id="txtScore" class="texta" style="width:60px;" />&nbsp;
                    &nbsp;<span id="lblRanking">Rating :</span>
                    <select name="ddlRank" id="ddlRank" class="texta">
						<option value="NR" <?= $bbdata->Rating === 'NR' ? 'selected="selected"' : '' ?>>NR</option>
						<option value="0" <?= $bbdata->Rating == '*' ? 'selected="selected"' : '' ?>>*</option>
						<option value="1" <?= $bbdata->Rating == 1 ? 'selected="selected"' : '' ?>>1</option>
						<option value="2" <?= $bbdata->Rating == 2 ? 'selected="selected"' : '' ?>>2</option>
						<option value="3" <?= $bbdata->Rating == 3 ? 'selected="selected"' : '' ?>>3</option>
						<option value="4" <?= $bbdata->Rating == 4 ? 'selected="selected"' : '' ?>>4</option>
					</select>&nbsp; &nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    <span id="lblWebsite">Website :</span></td>
                <td>
                    <a id="hlWebsiteURL" href="<?= $bbdata->WebsiteText ?>">
                        Go</a>
                </td>
                <td colspan="4">
                    <input name="txtWebsite" type="text" value="<?= $bbdata->WebsiteText ?>" id="txtWebsite" class="texta" style="width:230px;" />
					<span id="WebsiteRequired" style="color:Red;visibility:hidden;">*</span>
                    <span id="lblURL">URL :</span>&nbsp;
                    <input name="txtWebsiteURL" type="text" value="<?= $bbdata->Website ?>" id="txtWebsiteURL" class="texta" style="width:320px;" />
                </td>
            </tr>
            <tr>
                <td>
                    <span id="lblPricingURL">Pricing URL :</span></td>
                <td>
                    <a id="hlPricingURL" href="<?= $bbdata->PricingPageURL ?>">
                        Go</a></td>
                <td>
                    <input name="txtPricingURL" type="text" value="<?= $bbdata->PricingPageURL ?>" id="txtPricingURL" class="texta" style="width:300px;" />
                </td>
                <td colspan="2">
                    <span id="lblPrice">Price :</span></td>
                <td>
                    <input name="txtPrice" type="text" value="<?= $bbdata->Price ?>" id="txtPrice" class="texta" style="width:70px;" /></td>
            </tr>
            <tr>
                <td>
                    <span id="lblLogonURL">Logon URL :</span></td>
                <td>
                    <a id="hlLogonURL" href="<?= $bbdata->LogonPageURL ?>">
                        Go</a></td>
                <td>
                    <input name="txtLogonURL" type="text" value="<?= $bbdata->LogonPageURL ?>" id="txtLogonURL" class="texta" style="width:300px;" />
                </td>
                <td colspan="2">
                    <span id="lblEditMethod">Edit Method :</span></td>
                <td>
                    <select name="ddlEditMethod" id="ddlEditMethod" class="texta">
						<option value=""></option>
						<?php foreach($editMethod as $row): ?>
						<option value="<?= $row['MethodID'] ?>" <?= $bbdata->EditMethod == $row['MethodID'] ? 'selected="selected"' : '' ?>><?= $row['Method'] ?></option>
						<?php endforeach; ?>
					</select>
				</td>
            </tr>
            <tr>
                <td>
                    <span id="lblIndexURL">Index URL :</span></td>
                <td>
                    <a id="hlIndexURL" href="<?= $bbdata->IndexPageURL ?>">
                        Go</a></td>
                <td>
                    <input name="txtIndexURL" type="text" value="<?= $bbdata->IndexPageURL ?>" id="txtIndexURL" class="texta" style="width:300px;" />
                </td>
                <td colspan="2">
                    <span id="lblUserReview">User Review :</span></td>
                <td valign="middle">
                    <table id="rblUserReview" border="0">
						<tr>
							<td><input id="rblUserReview_0" type="radio" name="rblUserReview" value="Yes" <?= $bbdata->UserReview === 'Yes' ? 'selected="selected"' : '' ?> /><label for="rblUserReview_0">Yes</label></td>
							<td><input id="rblUserReview_1" type="radio" name="rblUserReview" value="No" <?= $bbdata->UserReview === 'No' ? 'selected="selected"' : '' ?> /><label for="rblUserReview_1">No</label></td>
						</tr>
					</table>
				</td>
            </tr>
            <tr>
                <td>
                    <span id="lblSpecialsURL" style="display:inline-block;width:94px;">Specials URL :</span></td>
                <td>
                    <a id="hlSpecialsURL" href="<?= $bbdata->SpecialPageURL ?>">
                        Go</a></td>
                <td>
                    <input name="txtSpecialsURL" type="text" value="<?= $bbdata->SpecialPageURL ?>" id="txtSpecialsURL" class="texta" style="width:300px;" />
                </td>
                <td colspan="2">
                    <span id="lblBBListSpecial" style="display:inline-block;width:141px;">B&B Can List Specials :</span></td>
                <td>
                    <table id="rblBBListSpecials" border="0">
						<tr>
							<td><input id="rblBBListSpecials_0" type="radio" name="rblBBListSpecials" value="Yes" <?= $bbdata->BBListSpecials === 'Yes' ? 'selected="selected"' : '' ?> /><label for="rblBBListSpecials_0">Yes</label></td>
							<td><input id="rblBBListSpecials_1" type="radio" name="rblBBListSpecials" value="No" <?= $bbdata->BBListSpecials === 'No' ? 'selected="selected"' : '' ?> /><label for="rblBBListSpecials_1">No</label></td>
						</tr>
					</table>
				</td>
            </tr>
            <tr>
                <td>
                    <span id="lblQuantURL">Quantcast URL :</span></td>
                <td>
                    <a id="hlQuantURL" href="<?= $bbdata->QuantPageURL ?>">
                        Go</a></td>
                <td>
                    <input name="txtQuantURL" type="text" value="<?= $bbdata->QuantPageURL ?>" id="txtQuantURL" class="texta" style="width:300px;" />
                </td>
                <td colspan="2">
                    <span id="lblQuantified">Quantified :</span></td>
                <td>
                    <table id="rblQuantified" border="0">
						<tr>
							<td><input id="rblQuantified_0" type="radio" name="rblQuantified" value="1" <?= $bbdata->Quantified == 1 ? 'selected="selected"' : '' ?> /><label for="rblQuantified_0">Yes</label></td>
							<td><input id="rblQuantified_1" type="radio" name="rblQuantified" value="0" <?= $bbdata->Quantified == 0 ? 'selected="selected"' : '' ?> /><label for="rblQuantified_1">No</label></td>
						</tr>
					</table>
				</td>
            </tr>
            <tr>
                <td>
                    <span id="lblCompeteURL">Compete URL :</span></td>
                <td>
                    <a id="hlCompeteURL" href="<?= $bbdata->CompetePageURL ?>">
                        Go</a></td>
                <td>
                    <input name="txtCompeteURL" type="text" value="<?= $bbdata->CompetePageURL ?>" id="txtCompeteURL" class="texta" style="width:300px;" />
                </td>
                <td colspan="2">
                    <span id="lblGeoSpecificity">GeoSpecificity :</span></td>
                <td>
                    <input name="txtGeoSpecificity" type="text" value="<?= $bbdata->GeoSpecificity ?>" id="txtGeoSpecificity" class="texta" /></td>
            </tr>
            <tr>
                <td colspan="3">
                    <table width="100%" cellspacing="0">
                        <tr>
                            <td>
                                <span id="lblMaxPr">Max PR :</span></td>
                            <td>
                                <select name="ddlMaxPr" id="ddlMaxPr" class="texta">
									<?php for($i=0; $i<10;$i++) { ?>
									<option value="<?= $i ?>" <?= $bbdata->MaxPR == $i ? 'selected="selected"' : '' ?>><?= $i ?></option>
									<?php } ?>
								</select>
							</td>
                            <td>
                                <span id="lblLinkPR">Link PR :</span></td>
                            <td>
                                <select name="ddlLinkPR" id="ddlLinkPR" class="texta">
									<?php for($i=0; $i<10;$i++) { ?>
									<option value="<?= $i ?>" <?= $bbdata->LinkPR == $i ? 'selected="selected"' : '' ?>><?= $i ?></option>
									<?php } ?>
								</select>
							</td>
                        </tr>
                    </table>
                </td>
                <td colspan="2">
                    <span id="lblAffiliation">Affiliation :</span></td>
                <td>
                    <input name="txtAffiliation" type="text" id="txtAffiliation" class="texta" value="<?= $bbdata->Affliation ?>" /></td>
            </tr>
        </table>
        <table style="width: 750px; background-color: #F7F6F3;">
            <tr>
                <td style="width: 120px;">
                    <span id="lblIndexGoogle">Index by Google :</span></td>
                <td style="width: 100px">
                    <table id="rblIndexGoogle" border="0">
						<tr>
							<td><input id="rblIndexGoogle_0" type="radio" name="rblIndexGoogle" value="Yes" <?= $bbdata->IndexByGoogle === 'Yes' ? 'checked="checked"' : '' ?> /><label for="rblIndexGoogle_0">Yes</label></td>
							<td><input id="rblIndexGoogle_1" type="radio" name="rblIndexGoogle" value="No" <?= $bbdata->IndexByGoogle === 'No' ? 'checked="checked"' : '' ?> /><label for="rblIndexGoogle_1">No</label></td>
						</tr>
					</table>
				</td>
                    <td> <span id="lblClassification">Classification :</span></td>
                <td colspan="3">
                   <select name="ddlClassification" id="ddlClassification" class="texta" style="width:150px;">
						<?php foreach($classification as $row): ?>
						<option value="<?= $row['ClassficationID'] ?>" <?= $bbdata->Classification == $row['ClassficationID'] ? 'selected="selected"' : '' ?>><?= $row['ClassficationText'] ?></option>
						<?php endforeach; ?>
					</select> &nbsp;&nbsp;<span id="lblBBCategory">B&B Category :</span><span id="rblBBCategory">
					<input id="rblBBCategory_0" type="radio" name="rblBBCategory" value="1" <?= $bbdata->BBCategory == 1 ? 'selected="selected"' : '' ?> /><label for="rblBBCategory_0">Yes</label>
					<input id="rblBBCategory_1" type="radio" name="rblBBCategory" value="0" <?= $bbdata->BBCategory == 0 ? 'selected="selected"' : '' ?> /><label for="rblBBCategory_1">No</label></span> 
				</td>
            </tr>
            
             <tr>
                <td style="width: 120px;">
                    <span id="Label1">SEO :</span></td>
                <td style="width: 100px">
                    <table id="rblSEO" border="0">
						<tr>
							<td><input id="rblSEO_0" type="radio" name="rblSEO" value="1" <?php $bbdata->SEO == 1 ? 'checked="checked"' : '' ?> /><label for="rblSEO_0">Yes</label></td>
							<td><input id="rblSEO_1" type="radio" name="rblSEO" value="0" <?php $bbdata->SEO == 0 ? 'checked="checked"' : '' ?> /><label for="rblSEO_1">No</label></td>
						</tr>
					</table>
				</td>
				<td> <span id="Label3">1PM :</span></td>
                <td colspan="3">
                   <span id="rbl1PM"><input id="rbl1PM_0" type="radio" name="rbl1PM" value="1" <?php $bbdata->PM == 1 ? 'checked="checked"' : '' ?> /><label for="rbl1PM_0">Yes</label>
				   <input id="rbl1PM_1" type="radio" name="rbl1PM" value="0" <?php $bbdata->PM == 0 ? 'checked="checked"' : '' ?> /><label for="rbl1PM_1">No</label></span> </td>
            </tr>
            
            <tr>
                <td>
                    <span id="lblIndexYahoo">Index by Yahoo :</span></td>
                <td>
                    <table id="rblIndexYahoo" border="0">
						<tr>
							<td><input id="rblIndexYahoo_0" type="radio" name="rblIndexYahoo" value="Yes" <?= $bbdata->IndexByYahoo === 'Yes' ? 'checked="checked"' : '' ?> /><label for="rblIndexYahoo_0">Yes</label></td>
							<td><input id="rblIndexYahoo_1" type="radio" name="rblIndexYahoo" value="No" <?= $bbdata->IndexByYahoo === 'No' ? 'checked="checked"' : '' ?> /><label for="rblIndexYahoo_1">No</label></td>
						</tr>
					</table>
				</td>
                <td>
                    <span id="lblPriceType">Price Type :</span></td>
                <td style="text-align: left">
                    <select name="ddlPriceType" id="ddlPriceType" class="texta" style="width:150px;">
						<option value=""></option>
						<?php foreach($price_type as $row): ?>
						<option value="<?= $row['PriceID'] ?>" <?= $bbdata->PriceType == $row['PriceID'] ? 'selected="selected"' : '' ?>><?= $row['PriceTypeText'] ?></option>
						<?php endforeach; ?>
					</select>&nbsp;&nbsp;
                    <span id="lblVacationRental">Vacation Rental Category:</span>&nbsp;<span id="rblVacationRental">
					<input id="rblVacationRental_0" type="radio" name="rblVacationRental" value="1" <?= $bbdata->VacationRental == 1 ? 'checked="checked"' : '' ?> /><label for="rblVacationRental_0">Yes</label>
					<input id="rblVacationRental_1" type="radio" name="rblVacationRental" value="0" <?= $bbdata->VacationRental == 0 ? 'checked="checked"' : '' ?> /><label for="rblVacationRental_1">No</label></span>
				</td>
            </tr>
            <tr>
                <td>
                    <span id="lblIndexMSN">Index by Bing :</span></td>
                <td>
                    <table id="rblIndexMSN" border="0">
						<tr>
							<td><input id="rblIndexMSN_0" type="radio" name="rblIndexMSN" value="Yes" <?= $bbdata->IndexByMSN === 'Yes' ? 'checked="checked"' : '' ?> /><label for="rblIndexMSN_0">Yes</label></td>
							<td><input id="rblIndexMSN_1" type="radio" name="rblIndexMSN" value="No" <?= $bbdata->IndexByMSN === 'No' ? 'checked="checked"' : '' ?> /><label for="rblIndexMSN_1">No</label></td>
						</tr>
					</table>
				</td>
                <td>
                    <span id="lblLinkType">Link Type :</span>
                </td>
                <td style="text-align: left">
                    <select name="ddlLinkType" id="ddlLinkType" class="texta" style="width:150px;">
						<option value=""></option>
						<?php foreach($link_type as $row): ?>
						<option value="<?= $row['LinkTypeID'] ?>" <?= $bbdata->PriceType == $row['LinkTypeID'] ? 'selected="selected"' : '' ?>><?= $row['LinkTypeText'] ?></option>
						<?php endforeach; ?>
					</select>
                </td>
            </tr>
        </table>
    </fieldset>
	
    <div>
        <fieldset class="content">
            <legend>Contacts Details</legend>
            <table style="width: 750px; background-color: #F7F6F3;">
                <tr>
                    <td style="width: 120px">
                        <span id="lblCointact1">Contact 1 :</span></td>
                    <td>
                        <input name="txtContact1" type="text" value="<?= $bbdata->Contact ?>" id="txtContact1" class="texta" style="width:210px;" /></td>
                    <td style="width: 120px">
                        <span id="lblContact2">Contact 2 :</span></td>
                    <td>
                        <input name="txtContact2" type="text" value="<?= $bbdata->Contact2 ?>" id="txtContact2" class="texta" style="width:210px;" /></td>
                </tr>
                <tr>
                    <td style="width: 120px">
                        <span id="lblTitle1">Title :</span></td>
                    <td>
                        <input name="txtTitle1" type="text" value="<?= $bbdata->Contact1Title ?>" id="txtTitle1" class="texta" style="width:210px;" /></td>
                    <td style="width: 120px">
                        <span id="lblTitle2">Title :</span></td>
                    <td>
                        <input name="txtTitle2" type="text" value="<?= $bbdata->Contact2Title ?>" id="txtTitle2" class="texta" style="width:210px;" /></td>
                </tr>
                <tr>
                    <td style="width: 120px">
                        <span id="lblEmail1">Email Sales :</span></td>
                    <td>
                        <input name="txtEmail1" type="text" value="<?= $bbdata->EmailSales ?>" id="txtEmail1" class="texta" style="width:210px;" />
                        <span id="RegularExpressionValidator1" style="color:Red;visibility:hidden;">*</span></td>
                    <td style="width: 120px">
                        <span id="lblEmail2">Email Support :</span></td>
                    <td>
                        <input name="txtEmail2" type="text" value="<?= $bbdata->EmailSupport ?>" id="txtEmail2" class="texta" style="width:210px;" />
                        <span id="RegularExpressionValidator2" style="color:Red;visibility:hidden;">*</span></td>
                </tr>
                <tr>
                    <td style="width: 120px">
                        <span id="lblPhone1">Phone :</span></td>
                    <td>
                        <input name="txtPhone1" type="text" value="<?= $bbdata->RegularPhone ?>" id="txtPhone1" class="texta" style="width:210px;" />
                    </td>
                    <td style="width: 120px">
                        <span id="lblPhone2">Phone :</span></td>
                    <td>
                        <input name="txtPhone2" type="text" value="<?= $bbdata->Contact2RegularPhone ?>" id="txtPhone2" class="texta" style="width:210px;" />
                    </td>
                </tr>
                <tr>
                    <td style="width: 120px">
                        <span id="lblTollFree1">Toll Free :</span></td>
                    <td>
                        <input name="txtTollFree1" type="text" value="<?= $bbdata->TollFreePhone ?>" id="txtTollFree1" class="texta" style="width:210px;" /></td>
                    <td style="width: 120px">
                        <span id="lblTollFree2">Toll Free :</span></td>
                    <td>
                        <input name="txtTollFree2" type="text" value="<?= $bbdata->Contact2TollFreePhone ?>" id="txtTollFree2" class="texta" style="width:210px;" /></td>
                </tr>
            </table>
        </fieldset>
    </div>
	
    <div>
    <fieldset class="content">
        <legend>Admin Notes (not for public viewing)</legend>
        <table style="width: 750px; background-color: lightsteelblue;">
            <tr>
                <td>
                    <textarea name="txtAdminNotes" rows="2" cols="20" id="txtAdminNotes" class="texta" style="height:100px;width:720px;"><?= $bbdata->AdminNote ?></textarea></td>
            </tr>
        </table>
    </fieldset>
    </div>
	
    <div>
        <fieldset class="content">
            <legend>Notes</legend>
            <table style="width: 750px; background-color: #F7F6F3;">
                <tr>
                    <td style="width: 100px">
                        <textarea name="txtNotes" rows="2" cols="20" id="txtNotes" class="texta" style="height:100px;width:720px;"><?= $bbdata->Notes ?></textarea></td>
                </tr>
            </table>
        </fieldset>
    </div>
	
    <div>
        <fieldset class="content">
            <legend>States</legend>
            <div id="MyStates_myStates">
				<table id="MyStates_tblStates" style="width: 750px; background-color: #F7F6F3;">
					<?php $clientState = $client_states->first_row(); ?>
					<?php $found_checked = false; ?>
					<?php for($r=0; $r<11; $r++) { ?>
						<tr>
						<?php for($j=0; $j<5; $j++) { ?>
							<?php if(($r == 0) && ($j == 0)) {
									$checked = '';
									if($clientState->StateServed === 'All') {
										$checked = 'checked = "checked"';
										$$found_checked = true;
										$clientState = $client_states->next_row();
									} ?>
									<td style="width: 150px;"><input name="MyStates_All" type="checkbox" id="MyStates_All" <?= $checked ?> value="All" />National</td>
							<?php } else { ?>
								<?php $state = $states->row_array((10*$j)+$r);
									  $checked = '';
									  if(($state['StatesCode'] === $clientState->StateServed) && !$found_checked) {
										$checked = 'checked = "checked"';
										$found_checked = true;
										$clientState = $client_states->next_row();
									  } ?>
									<td style="width: 150px;"><input name="MyStates_<?= $state['StatesCode'] ?>" type="checkbox" id="MyStates_<?= $state['StatesCode'] ?>" <?= $checked ?> value="<?= $state['StatesCode'] ?>" /><?= $state['StatesDescription'] ?></td>
								<?php } 
							} ?>
						</tr>
					<?php } ?>
					<tr>
					<?php $state = $states->row_array((10*$j)+1);
						  $checked = '';
						  if(($state['StatesCode'] === $clientState->StateServed) && !$found_checked) {
							$checked = 'checked = "checked"';
							$found_checked = true;
							$clientState = $client_states->next_row();
						  } ?>
						<td style="width: 150px;"><input name="MyStates_<?= $state['StatesCode'] ?>" type="checkbox" id="MyStates_<?= $state['StatesCode'] ?>" <?= $checked ?> value="<?= $state['StatesCode'] ?>" /><?= $state['StatesDescription'] ?></td>
					</tr>
				</table>
<!--
				<table id="MyStates_tblStates" style="width: 750px; background-color: #F7F6F3;">
						<tr>
							<td style="width: 150px;">
							<input name="All" type="checkbox" id="MyStates_All" checked="checked" value="441" />National</td>
							<td style="width: 150px;">
							<input name="HI" type="checkbox" id="MyStates_HI" />Hawaii</td>
							<td style="width: 150px;">
							<input name="MN" type="checkbox" id="MyStates_MN" />Minnesota</td>
							<td style="width: 150px;">
							<input name="OH" type="checkbox" id="MyStates_OH" />Ohio</td>
							<td style="width: 152px;">
							<input name="WA" type="checkbox" id="MyStates_WA" />Washington</td>
						</tr>
						<tr>
							<td style="width: 150px">
							<input name="AL" type="checkbox" id="MyStates_AL" />Alabama</td>
							<td style="width: 150px">
							<input name="ID" type="checkbox" id="MyStates_ID" />Idaho</td>
							<td style="width: 150px">
							<input name="MS" type="checkbox" id="MyStates_MS" />Mississippi</td>
							<td style="width: 150px">
							<input name="OK" type="checkbox" id="MyStates_OK" />Oklahoma</td>
							<td style="width: 152px">
							<input name="WV" type="checkbox" id="MyStates_WV" />West Virginia</td>
						</tr>
						<tr>
							<td style="width: 150px">
							<input name="AK" type="checkbox" id="MyStates_AK" />Alaska</td>
							<td style="width: 150px">
							<input name="IL" type="checkbox" id="MyStates_IL" />Illinois</td>
							<td style="width: 150px">
							<input name="MO" type="checkbox" id="MyStates_MO" />Missouri</td>
							<td style="width: 150px">
							<input name="OR2" type="checkbox" id="MyStates_OR2" />Oregon</td>
							<td style="width: 152px">
							<input name="WI" type="checkbox" id="MyStates_WI" />Wisconsin</td>
						</tr>
						<tr>
							<td style="width: 150px;">
							<input name="AZ" type="checkbox" id="MyStates_AZ" />Arizona</td>
							<td style="width: 150px;">
							<input name="IN2" type="checkbox" id="MyStates_IN2" />Indiana</td>
							<td style="width: 150px;">
							<input name="MT" type="checkbox" id="MyStates_MT" />Montana</td>
							<td style="width: 150px;">
							<input name="PA" type="checkbox" id="MyStates_PA" />Pennsylvania</td>
							<td style="width: 152px;">
							<input name="WY" type="checkbox" id="MyStates_WY" />Wyoming</td>
						</tr>
						<tr>
							<td style="width: 150px">
							<input name="AR" type="checkbox" id="MyStates_AR" />Arkansas</td>
							<td style="width: 150px">
							<input name="IA" type="checkbox" id="MyStates_IA" />Iowa</td>
							<td style="width: 150px">
							<input name="NE" type="checkbox" id="MyStates_NE" />Nebraska</td>
							<td style="width: 150px">
							<input name="RI" type="checkbox" id="MyStates_RI" />Rhode Island</td>
							<td style="width: 152px">
						</td>
						</tr>
						<tr>
							<td style="width: 150px">
							<input name="CA" type="checkbox" id="MyStates_CA" />California</td>
							<td style="width: 150px">
							<input name="KS" type="checkbox" id="MyStates_KS" />Kansas</td>
							<td style="width: 150px">
							<input name="NV" type="checkbox" id="MyStates_NV" />Nevada</td>
							<td style="width: 150px">
							<input name="SC" type="checkbox" id="MyStates_SC" />South Carolina</td>
							<td style="width: 152px">
						</td>
						</tr>
						<tr>
							<td style="width: 150px">
							<input name="CO" type="checkbox" id="MyStates_CO" />Colorado</td>
							<td style="width: 150px">
							<input name="KY" type="checkbox" id="MyStates_KY" />Kentucky</td>
							<td style="width: 150px">
							<input name="NH" type="checkbox" id="MyStates_NH" />New Hampshire</td>
							<td style="width: 150px">
							<input name="SD" type="checkbox" id="MyStates_SD" />South Dakota</td>
							<td style="width: 152px">
						</td>
						</tr>
						<tr>
							<td style="width: 150px">
							<input name="CT" type="checkbox" id="MyStates_CT" />Connecticut</td>
							<td style="width: 150px">
							<input name="LA" type="checkbox" id="MyStates_LA" />Louisiana</td>
							<td style="width: 150px">
							<input name="NJ" type="checkbox" id="MyStates_NJ" />New Jersey</td>
							<td style="width: 150px">
							<input name="TN" type="checkbox" id="MyStates_TN" />Tennessee</td>
							<td style="width: 152px">
						</td>
						</tr>
						<tr>
							<td style="width: 150px">
							<input name="DE" type="checkbox" id="MyStates_DE" />Delaware</td>
							<td style="width: 150px">
							<input name="ME2" type="checkbox" id="MyStates_ME2" />Maine</td>
							<td style="width: 150px">
							<input name="NM" type="checkbox" id="MyStates_NM" />New Mexico</td>
							<td style="width: 150px">
							<input name="TX" type="checkbox" id="MyStates_TX" />Texas</td>
							<td style="width: 152px">
						</td>
						</tr>
						<tr>
							<td style="width: 150px">
							<input name="DC" type="checkbox" id="MyStates_DC" />District of Columbia</td>
							<td style="width: 150px">
							<input name="MD" type="checkbox" id="MyStates_MD" />Maryland</td>
							<td style="width: 150px">
							<input name="NY" type="checkbox" id="MyStates_NY" />New York</td>
							<td style="width: 150px">
							<input name="UT" type="checkbox" id="MyStates_UT" />Utah</td>
							<td style="width: 152px">
						</td>
						</tr>
						<tr>
							<td style="width: 150px">
							<input name="FL" type="checkbox" id="MyStates_FL" />Florida</td>
							<td style="width: 150px">
							<input name="MA" type="checkbox" id="MyStates_MA" />Massachusetts</td>
							<td style="width: 150px">
							<input name="NC" type="checkbox" id="MyStates_NC" />North Carolina</td>
							<td style="width: 150px">
							<input name="VT" type="checkbox" id="MyStates_VT" />Vermont</td>
							<td style="width: 152px">
						</td>
						</tr>
						<tr>
							<td style="width: 150px; height: 24px;">
							<input name="GA" type="checkbox" id="MyStates_GA" />Georgia</td>
							<td style="width: 150px; height: 24px;">
							<input name="MI" type="checkbox" id="MyStates_MI" />Michigan</td>
							<td style="width: 150px; height: 24px;">
							<input name="ND" type="checkbox" id="MyStates_ND" />North Dakota</td>
							<td style="width: 150px; height: 24px;">
							<input name="VI" type="checkbox" id="MyStates_VI" />Virginia</td>
							<td style="height: 24px; width: 152px;">
						</td>
						</tr>
					</table>
-->					
				</div>
			</fieldset>
		</div>

    <div>
        <fieldset class="content">
            <legend>Quantcast</legend>
            <table style="width: 750px; background-color: #F7F6F3;">
                <tr>
                    <td style="width: 100px;">
                        <span id="lblQuantCurrent" style="display:inline-block;width:115px;">Quantcast Monthly</span></td>
                    <td style="width: 170px;">
                        <span id="lblQuantCurrentDate">Quantcast Current Data Date</span></td>
                    <td style="width: 100px;">
                        <span id="lblQuantPrevious" style="display:inline-block;width:115px;">Quantcast Previous</span></td>
                    <td style="width: 100px;">
                        <span id="lblQuantChange" style="display:inline-block;width:115px;">Quantcast Change</span></td>
                </tr>
                <tr>
                    <td style="width: 100px;">
                        <input name="txtQuantCurrent" type="text" value="<?= $bbdata->QuantcastCurrent ?>" id="txtQuantCurrent" class="texta" /></td>
                    <td style="width: 170px;">
                        <input name="txtQuantCurrentDate" type="text" value="<?= $bbdata->QuantcastCurrentDataDate ?>" id="txtQuantCurrentDate" class="texta" /></td>
                    <td style="width: 100px;">
                        <input name="txtQuantPrevious" type="text" value="<?= $bbdata->QuantcastPrevious ?>" id="txtQuantPrevious" class="texta" /></td>
                    <td style="width: 100px;">
                        <input name="txtQuantChange" type="text" value="<?= $bbdata->QuantcastChange ?>" id="txtQuantChange" class="texta" />%</td>
                </tr>
            </table>
        </fieldset>
		
        <fieldset class="content">
            <legend>Compete</legend>
            <table style="width: 750px; background-color: #F7F6F3;">
                <tr>
                    <td style="width: 100px;">
                        <span id="lblCompeteCurrent" style="display:inline-block;width:115px;">Compete Monthly</span></td>
                    <td style="width: 170px;">
                        <span id="lblCompeteCurrentDate">Compete Current Data Date</span></td>
                    <td style="width: 100px;">
                        <span id="lblCompetePrevious" style="display:inline-block;width:115px;">Compete Previous</span></td>
                    <td style="width: 100px;">
                        <span id="lblCompeteChange" style="display:inline-block;width:115px;">Compete Change</span></td>
                </tr>
                <tr>
                    <td style="width: 100px">
                        <input name="txtCompeteCurrent" type="text" value="<?= $bbdata->CompeteCurrent ?>" id="txtCompeteCurrent" class="texta" /></td>
                    <td style="width: 170px">
                        <input name="txtCompeteCurrentDate" type="text" value="<?= $bbdata->CompeteCurrentDataDate ?>" id="txtCompeteCurrentDate" class="texta" /></td>
                    <td style="width: 100px">
                        <input name="txtCompetePrevious" type="text" value="<?= $bbdata->CompetePrevious ?>" id="txtCompetePrevious" class="texta" /></td>
                    <td style="width: 100px">
                        <input name="txtCompeteChange" type="text" value="<?= $bbdata->CompeteChange ?>" id="txtCompeteChange" class="texta" />%</td>
                </tr>
            </table>
        </fieldset>  
		  
        <span id="lblRecNo" style="font-weight:bold;">Record No</span>
        <span id="lblBBDataIdNo" style="font-weight:bold;"><?= $this->uri->segment(2) ?></span></div>
    <br />
    <div>
        <input type="submit" name="btnSaveBottom" value="Save Record" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnSaveBottom&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))" id="btnSaveBottom" class="texta" style="width:107px;" />&nbsp;
          <input type="submit" name="btnRunScript" value="Run Script" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnRunScript&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))" id="btnRunScript" class="texta" style="width:107px;" />&nbsp;
        <input type="submit" name="btnSaveReturnBottom" value="Save Return to Search" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnSaveReturnBottom&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))" id="btnSaveReturnBottom" class="texta" style="width:152px;" />
        <input type="submit" name="btnDelete" value="Delete Record" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnDelete&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))" id="btnDelete" class="texta" style="width:107px;" />
        <input type="submit" name="btnCancel" value="Cancel" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnCancel&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, false))" id="btnCancel" class="texta" /></div>

	</div>
    <script language="javascript">
  confApprove();
    </script>

