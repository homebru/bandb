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
<form method="post">
	<input type="hidden" name="BBDataID" value="<?= $client->BBDataID ?>" />
    <div>
        <input type="submit" name="btnSaveTop" value="Save Record" id="btnSaveTop" class="texta" style="width:107px;" />
        <input type="submit" name="btnSaveReturnTop" value="Save Return to Search" id="btnSaveReturnTop" class="texta" style="width:152px;" />&nbsp;
    </div>
    <div>
        <fieldset style="width:758px;">
            <legend>Client Detail Page</legend>
            <table style="width: 750px; background-color: #F7F6F3;">
                <tr>
                    <td style="width: 102px">
                        <span id="lblProperty">Property :</span></td>
                    <td colspan="3">
                        <span id="lblPropertyName" style="color:DimGray;"><?= $client->PropertyName ?></span>
                    </td>
                    <td colspan="3" nowrap="nowrap">
                        <span id="lblPayType" style="font-weight:normal;">Pay Type :</span></td>
                    <td style="width: 235px" colspan="3">
                        <span id="rblPayType">
						<input id="rblPayType_0" type="radio" name="rblPayType" value="1" <?php echo $client->PayType == 1 ? 'checked="checked"' : '' ?> /><label for="rblPayType_0">Account</label>
						<input id="rblPayType_1" type="radio" name="rblPayType" value="0" <?php echo $client->PayType == 0 ? 'checked="checked"' : '' ?> /><label for="rblPayType_1">Cash</label></span>
					</td>
                    <td style="width: 100px">
                       <span id="lblPrice" style="font-weight:normal;">Price :</span></td>
                    <td><input name="txtPrice" type="text" id="txtPrice" class="texta" style="width:70px;" value="<?= set_value('Price', $client->Price); ?>" /></td>
                </tr>
                <tr>
                    <td style="height: 18px; width: 102px;">
                        <span id="lblAddress">Address :</span></td>
                    <td colspan="3" style="height: 18px; width: 250px;">
                        <span id="lblAddressValue" style="color:DimGray;"><?= $client->Address ?></span>
                    </td>
                    <td colspan="3" style="height: 18px" nowrap="nowrap">
                        <span id="lblProcessor">Processor : </span></td>
                    <td style="height: 18px" colspan="3">
                        <select name="ddProcessor" id="ddProcessor" class="texta">
							<option value="" <?php echo $client->Processor === '' ? 'checked="checked"' : '' ?>></option>
							<option value="1" <?php echo $client->Processor == 1 ? 'checked="checked"' : '' ?>>Capital Bankcard</option>
						</select>
					</td>
                    <td style="height: 18px; width: 78px;">
                        </td>
                    <td style="height: 18px; width: 120px;">
                        </td>
                </tr>
                <tr>
                    <td style="width: 102px">
                        <span id="lblCity">City :</span></td>
                    <td colspan="3">
                        <span id="lblCityValue" class="texta" style="color:DimGray;"><?= $client->City ?></span>&nbsp;
                        <span id="lblState">State :</span>
                        <span id="lblStateValue" style="color:DimGray;"><?= $client->State ?></span>&nbsp;
                        <span id="lblZip">Zip :</span>
                        <span id="lblZipValue" class="texta" style="display:inline-block;color:DimGray;width:50px;"><?= $client->Zip ?></span>
                    </td>
                    <td colspan="7">
                        <span id="lblExpires">Date Expires :</span>&nbsp;&nbsp;
                        <input name="txtSubscriptionEndDate" type="text" id="txtSubscriptionEndDate" class="texta" value="<?= set_value('SubscriptionEndDate', $client->SubscriptionEndDate); ?>" />
					</td>
                    <td style="height: 18px; width: 120px;">&nbsp;
                        </td>
                </tr>
                <tr>
                    <td style="width: 102px">
                        <span id="lblGeo">Geo :</span></td>
                    <td colspan="3">
                        <span id="rblGeo"><input id="rblGeo_0" type="radio" name="rblGeo" value="1" onchange="swapInputType();" <?php echo $client->Geo == 1 ? 'checked="checked"' : '' ?> /><label for="rblGeo_0">One</label>
						<input id="rblGeo_1" type="radio" name="rblGeo" value="0" onchange="swapInputType();" <?php echo $client->Geo == 0 ? 'checked="checked"' : '' ?> /><label for="rblGeo_1">Many</label></span>
					</td>
                    <td colspan="7">
                        <span id="lblEnabled">Account Enabled :</span>
                        &nbsp;<span id="rblEnabled"><input id="rblEnabled_0" type="radio" name="rblEnabled" value="1" <?php echo $client->Enabled == 1 ? 'checked="checked"' : '' ?> /><label for="rblEnabled_0">Yes</label>
						<input id="rblEnabled_1" type="radio" name="rblEnabled" value="0" <?php echo $client->Enabled == 0 ? 'checked="checked"' : '' ?> /><label for="rblEnabled_1">No</label></span></td>
                    <td>&nbsp;
                        </td>
                </tr>
                <tr>
                    <td style="width: 102px">
                    </td>
                    <td>
                    </td>
                    <td style="width: 7px">
                    </td>
                    <td style="width: 2348px">
                    </td>
                    <td colspan="7">
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td style="width: 102px">
                        <span id="lblURL">URL</span></td>
                    <td colspan="3">
                        <a href="#" onclick="javascript:window.open('<?= $client->URL ?>');" id="hlURL">
						<span id="lblURLValue" style="color:DimGray;"><?= $client->URL ?></span></a>
                        </td>
                    <td colspan="7">
                        <span id="Label1" style="display:inline-block;width:111px;">Advertised Sites :</span>
                        <a id="hlAdSites" href="<?= base_url() ?>search/my/<?= $client->UserID ?>">Go</a></td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td style="width: 102px; height: 15px" nowrap="nowrap">
                        <span id="lblWebEmail" style="display:inline-block;width:69px;">Prim. Email :</span></td>
                    <td colspan="3" style="height: 15px">
                        <span id="lblWebEmailValue" style="color:DimGray;"><?= $client->Email1 ?></span></td>
                    <td colspan="7" style="height: 15px">
                    </td>
                    <td style="height: 15px">
                    </td>
                </tr>
                <tr>
                    <td style="width: 102px">
                    </td>
                    <td>
                    </td>
                    <td style="width: 7px">
                    </td>
                    <td style="width: 2348px">
                    </td>
                    <td colspan="7">
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>

    <div>
        <fieldset style="width:758px;">
            <legend>Contacts Details</legend>
            <table style="width: 750px; background-color: #F7F6F3;">
                <tr>
                    <td style="width: 147px">
                        <span id="lblCointact1">Contact 1 :</span></td>
                    <td style="width: 223px">
                        
                        <span id="lblContact1Value" style="color:DimGray;"><?= $client->Contact1 ?></span>
                        </td>
                    <td>
                        <span id="lblContact2">Contact 2 :</span></td>
                    <td>
                        
                           <span id="lblContact2Value" style="color:DimGray;"><?= $client->Contact2 ?></span>
                        </td>
                </tr>
                <tr>
                    <td style="width: 147px">
                        <span id="lblTitle1">Title :</span></td>
                    <td style="width: 223px">
                     <span id="lblTitle1Value" style="color:DimGray;"><?= $client->Title1 ?></span>
                        </td>
                    <td>
                        <span id="lblTitle2">Title :</span></td>
                    <td>
                    <span id="lblTitle2Value" style="color:DimGray;"><?= $client->Title2 ?></span>
                        </td>
                </tr>
                <tr>
                    <td style="width: 147px">
                        <span id="lblEmail1">User Name :</span></td>
                    <td style="width: 223px">
                    <span id="lblEmail1Value" style="color:DimGray;"><?= username() ?></span>
                       </td>
                    <td>
                        <span id="lblEmail2">Email :</span></td>
                    <td>
                     <span id="lblEmail2Value" style="color:DimGray;"><?= $client->Email2 ?></span>
                      </td>
                </tr>
                <tr>
                    <td style="width: 147px">
                        <span id="lblPhone1">Phone :</span></td>
                    <td style="width: 223px">
                     <span id="lblPhone1Value" style="color:DimGray;"><?= $client->Phone1 ?></span>
                       </td>
                    <td>
                        <span id="lblPhone2">Phone :</span></td>
                    <td>
                    <span id="lblPhone2Value" style="color:DimGray;"><?= $client->Phone2 ?></span>
                        </td>
                </tr>
            </table>
        </fieldset>
    </div>

    <div>
        <fieldset style="width:758px;">
            <legend>Admin Notes</legend>
            <table style="width: 750px; background-color: #F7F6F3;">
                <tr>
                    <td style="width: 100px">
                        <textarea name="txtAdminNotes" rows="2" cols="20" id="txtAdminNotes" class="texta" style="height:50px;width:700px;"><?= $client->AdminNote ?></textarea></td>
                </tr>
            </table>
        </fieldset>
    </div>

    <div id="cbstates" style="display:<?= $client->Geo == 0 ? 'block' : 'none' ?>;">
        <fieldset style="width:758px;">
            <legend>States</legend>
            <div id="MyStates_myStates">
				<table id="MyStates_tblStates" style="width: 750px; background-color: #F7F6F3;">
					<?php $clientState = $client_states->first_row(); ?>
					<?php for($r=0; $r<11; $r++) { ?>
						<tr>
						<?php for($j=0; $j<5; $j++) { ?>
							<?php if(($r == 0) && ($j == 0)) {
									$checked = '';
									if($clientState->StateCode === 'All') {
										$checked = 'checked = "checked"'; 
										$clientState = $client_states->next_row();
									} ?>
									<td style="width: 150px;"><input name="MyStates_All" type="checkbox" id="MyStates_All" <?= $checked ?> value="All" />National</td>
							<?php } else { ?>
								<?php $state = $states->row_array((10*$j)+$r);
									  $checked = '';
									  if($state['StatesCode'] === $clientState->StateCode) {
										$checked = 'checked = "checked"';
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
						  if(($state['StatesCode'] === $clientState->StateCode) && !$found_checked) {
							$checked = 'checked = "checked"';
							$found_checked = true;
							$clientState = $client_states->next_row();
						  } ?>
						<td style="width: 150px;"><input name="MyStates_<?= $state['StatesCode'] ?>" type="checkbox" id="MyStates_<?= $state['StatesCode'] ?>" <?= $checked ?> value="<?= $state['StatesCode'] ?>" /><?= $state['StatesDescription'] ?></td>
					</tr>
				</table>
			</div>
		</fieldset>
	</div>

    <div id="rbstates" style="display:<?= $client->Geo == 1 ? 'block' : 'none' ?>;">
        <fieldset style="width:758px;">
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
									if($clientState->StateCode === 'All') {
										$checked = 'checked = "checked"';
										$$found_checked = true;
										$clientState = $client_states->next_row();
									} ?>
									<td style="width: 150px;"><input name="MyStates" type="radio" id="MyStates_All" <?= $checked ?> value="All" />National</td>
							<?php } else { ?>
								<?php $state = $states->row_array((10*$j)+$r);
									  $checked = '';
									  if(($state['StatesCode'] === $clientState->StateCode) && !$found_checked) {
										$checked = 'checked = "checked"';
										$found_checked = true;
										$clientState = $client_states->next_row();
									  } ?>
									<td style="width: 150px;"><input name="MyStates" type="radio" id="MyStates_<?= $state['StatesCode'] ?>" <?= $checked ?> value="<?= $state['StatesCode'] ?>" /><?= $state['StatesDescription'] ?></td>
								<?php } 
							} ?>
						</tr>
					<?php } ?>
					<tr>
					<?php $state = $states->row_array((10*$j)+1);
						  $checked = '';
						  if(($state['StatesCode'] === $clientState->StateCode) && !$found_checked) {
							$checked = 'checked = "checked"';
							$found_checked = true;
							$clientState = $client_states->next_row();
						  } ?>
						<td style="width: 150px;"><input name="MyStates" type="radio" id="MyStates_<?= $state['StatesCode'] ?>" <?= $checked ?> value="<?= $state['StatesCode'] ?>" /><?= $state['StatesDescription'] ?></td>
					</tr>
				</table>
			</div>
		</fieldset>
	</div>

    <br />
    <div>
        <input type="submit" name="btnSaveBottom" value="Save Record" id="btnSaveBottom" class="texta" style="width:107px;" />&nbsp;
        <input type="submit" name="btnSaveReturnBottom" value="Save Return to Search" id="btnSaveReturnBottom" class="texta" style="width:152px;" />&nbsp;<input type="submit" name="btnDelete" value="Delete Account" onclick="return confirm('Are you sure you want to delete this account?');" id="btnDelete" class="texta" style="width:107px;" />
        <input type="submit" name="btnCancel" value="Cancel" id="btnCancel" class="texta" />
	</div>
</form>