	<form name="searchForm" method="post" id="searchForm" class="cmxform">
		<div id="search">
			<fieldset style="background-color:#f3f2ed;">
				<legend>Search</legend>
				<span id="lblSearchTitle" style="font-weight:bold; color:DimGray;">Property:</span>&nbsp;
				<input name="txtSearch" type="text" id="txtSearch" class="texta" style="width:243px;" value="<?php echo isset($_POST['txtSearch']) ? $_POST['txtSearch'] : '' ?>" />&nbsp;
				<input type="submit" name="btnSearch" value="Search" id="btnSearch" class="texta" />&nbsp;
				<input type="submit" name="btnReset" value="Reset" id="btnReset" class="texta" />&nbsp;
				<input type="submit" name="btnAddNew" value="Add New Record" id="btnAddNew" class="texta" style="width:118px;" />
				
				<table>
					<tr>
						<td nowrap="nowrap" style="color:DimGray;">
							<strong>Pay Type :</strong>&nbsp;
							<span id="rblPayType">
							<input id="rblPayType_1" type="radio" name="rblPayType" value="1" <?php echo (isset($_POST['rblPayType']) && ($_POST['rblPayType'] == '1')) ? 'checked="checked"' : '' ?> /><label for="rblPayType_1">Account</label>
							<input id="rblPayType_0" type="radio" name="rblPayType" value="0" <?php echo (isset($_POST['rblPayType']) && ($_POST['rblPayType'] == '0')) ? 'checked="checked"' : '' ?> /><label for="rblPayType_0">Cash</label></span>
						</td>
						<td width="20">&nbsp;</td>
						<td nowrap="nowrap" style="color:DimGray;">
							<strong>GEO :</strong>&nbsp;
							<span id="rblGeo">
							<input id="rblGeo_1" type="radio" name="rblGeo" value="1" <?php echo (isset($_POST['rblGeo']) && ($_POST['rblGeo'] == 1)) ? 'checked="checked"' : '' ?> /><label for="rblGeo_1">One</label></span>
							<input id="rblGeo_0" type="radio" name="rblGeo" value="0" <?php echo (isset($_POST['rblGeo']) && ($_POST['rblGeo'] == 0)) ? 'checked="checked"' : '' ?> /><label for="rblGeo_0">Many</label>
						</td>
						<td width="20">&nbsp;</td>
						<td nowrap="nowrap">
							<span id="lblProcessor" style="color:DimGray;">Processor :</span>
							<select name="ddProcessor" id="ddProcessor" class="texta">
								<option value="" <?= isset($_POST['ddProcessor']) && $_POST['ddProcessor'] === '' ? 'selected="selected"' : ''; ?>></option>
									<?php foreach($processor as $item):?>
										<option value="<?= $item['ProcessorID']; ?>" <?= set_select('ddProcessor', $item['ProcessorID'], isset($_POST['ddProcessor']) && $_POST['ddProcessor'] === $item['ProcessorID']); ?>><?= $item['Processor']; ?></option>
									<?php endforeach;?>
							</select>
						</td>
						<td width="20">&nbsp;</td>
						<td nowrap="nowrap">
							<span id="lblStates" style="color:DimGray;">State :</span>
							<select name="ddState" id="ddState" class="texta">
								<option value="" <?= isset($_POST['ddState']) && $_POST['ddState'] === '' ? 'selected="selected"' : ''; ?>></option>
									<?php foreach($states as $item):?>
										<option value="<?= $item['StatesCode']; ?>" <?= set_select('ddState', $item['StatesCode'], isset($_POST['ddState']) && $_POST['ddState'] === $item['StatesCode']); ?>><?= $item['StatesDescription']; ?></option>
									<?php endforeach;?>
							</select>
					</td>
					</tr>
				</table>
			</fieldset>
		</div>

    <div>
	<table cellspacing="0" cellpadding="4" border="0" id="gvResult" style="color:#333333;width:750px;border-collapse:collapse;">
		<tr style="color:White;background-color:#6D8497;font-weight:bold;"><input type="hidden" id="sort_column" name="sort_column" value="" /><input type="hidden" name="prev_sort_column" value="<?php echo $prev_sort_column ?>" /><input type="hidden" name="sort_direction" value="<?php echo $sort_direction ?>" />
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='PropertyName';document.forms[0].submit()">Property</a></th>
			<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='LastUpdateDate';document.forms[0].submit()">Last Updated</a></th>
			<th align="left" scope="col" nowrap="nowrap"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='PayType';document.forms[0].submit()">Pay Type</a></th>
			<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='SubscriptionEndDate';document.forms[0].submit()">Date Expires</a></th>
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Processor';document.forms[0].submit()">Processor</a></th>
			<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Geo';document.forms[0].submit()">Geo</a></th>
			<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='State';document.forms[0].submit()">State</a></th>
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='City';document.forms[0].submit()">City</a></th>
			<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='LastLogin';document.forms[0].submit()">Last Login Date</a></th>
		</tr>
		
		<?php $row_num = 0; ?>
		<?php foreach($client_profile as $row): ?>
		<tr style="color:#333333; background-color:#<?php echo (($row_num % 2) == 0) ? 'F7F6F3' : 'FFFFFF' ?>;">
			<td align="left" nowrap="nowrap"><a href="<?php echo base_url() ?>client_detail/<?php echo $row['UserID'] ?>"><?php echo $row['PropertyName'] ?></a></td>
			<td align="center"><?php echo $row['LastUpdateDate'] ?></td>
			<td align="left"><?php echo $row['PayType'] ?></td>
			<td align="center"><?php echo $row['SubscriptionEndDate'] ?></td>
			<td align="left"><?php echo $row['Processor'] ?></td>
			<td align="center"><?php echo $row['Geo'] ?></td>
			<td align="center"><?php echo $row['State'] ?></td>
			<td align="left"><?php echo $row['City'] ?></td>
			<td align="center"><?php echo $row['LastLogin'] ?></td>
		</tr>
		<?php ++$row_num; ?>
		<?php endforeach; unset($_POST); ?>
	</table>
</div>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>