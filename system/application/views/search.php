	<form name="searchForm" method="post" id="searchForm" class="cmxform">
		<div id="search">
			<fieldset>
				<legend>Search</legend>
				<span id="lblSearchTitle" style="font-weight:bold;">Search:</span>&nbsp;
				<input name="txtSearch" type="text" id="txtSearch" class="texta" style="width:243px;" value="<?php echo isset($_POST['txtSearch']) ? $_POST['txtSearch'] : '' ?>" />&nbsp;
				<input type="submit" name="btnSearch" value="Search" id="btnSearch" class="texta" />&nbsp;
				<input type="submit" name="btnReset" value="Reset" id="btnReset" class="texta" />&nbsp;<br />
				
				<table>
					<tr>
						<td>
							<strong>Classification :</strong>
						</td>
					</tr>
					<tr>
						<td>
							<table id="chkClass" border="0">
								<?php $row = 0; ?>
								<?php do { ?>
								<tr>
									<?php for($col = 0; $col <= 5; $col++) { 
									$offset = ($row*6)+$col; 
									if($offset < $class_count) { 
									$class_id = $classification[$offset]['ClassficationID'];
									$is_checked = $classification[$offset]['UserDefault'];
									if(isset($_POST) && !empty($_POST)) {
										$is_checked = isset($_POST["chkClass_$class_id"]); 
									}
									$is_checked = $is_checked ? 'checked="checked"' : ''; ?>
									<td><input id="chkClass" type="checkbox" name="chkClass_<?php echo $class_id; ?>" onclick="CheckboxTrigger(this);" <?php echo $is_checked; ?> /><label for="chkClass_<?php echo $class_id; ?>"><?php echo $classification[$offset]['ClassficationText']; ?></label></td>
									<?php } else { ?>
									<td></td>
									<?php } } ?>
								</tr>
								<?php $row++; ?>
								<?php } while(($offset+1) < $class_count) ?>
							</table>
						</td>
					</tr>
				</table>
				
				<table>
					<tr>
						<td>
							<strong>Rating&nbsp;: &nbsp;&nbsp; </strong>
							<input id="chkAll" type="checkbox" name="chkAll" onclick="javascript:mRating('chkAll');" <?php echo !(isset($_POST['chk1']) || isset($_POST['chk2']) || isset($_POST['chk3']) || isset($_POST['chk4']) || isset($_POST['chk0']) || isset($_POST['chkNR'])) ? 'checked="checked"' : '' ?>/><label for="chkAll">All</label>&nbsp;
							<input id="chk1" type="checkbox" name="chk1" onclick="javascript:mRating('chk1');" <?php echo (isset($_POST['chk1'])) ? 'checked="checked"' : '' ?> /><label for="chk1">1</label>&nbsp;
							<input id="chk2" type="checkbox" name="chk2" onclick="javascript:mRating('chk2');" <?php echo (isset($_POST['chk2'])) ? 'checked="checked"' : '' ?> /><label for="chk2">2</label>&nbsp;
							<input id="chk3" type="checkbox" name="chk3" onclick="javascript:mRating('chk3');" <?php echo (isset($_POST['chk3'])) ? 'checked="checked"' : '' ?> /><label for="chk3">3</label>&nbsp;
							<input id="chk4" type="checkbox" name="chk4" onclick="javascript:mRating('chk4');" <?php echo (isset($_POST['chk4'])) ? 'checked="checked"' : '' ?> /><label for="chk4">4</label>&nbsp;
							<input id="chk0" type="checkbox" name="chk0" onclick="javascript:mRating('chk0');" <?php echo (isset($_POST['chk0'])) ? 'checked="checked"' : '' ?> /><label for="chk0">*</label>&nbsp;
							<input id="chkNR" type="checkbox" name="chkNR" onclick="javascript:mRating('chkNR');" <?php echo (isset($_POST['chkNR'])) ? 'checked="checked"' : '' ?> /><label for="chkNR">NR</label>&nbsp;
						</td>
						<td>
							<strong>Price Type&nbsp;: </strong>
							<select name="ddPriceType" id="ddPriceType" class="texta">
								<option selected="selected" value="All">All</option>
								<?php foreach($price_type as $item): ?>
								<option value="<?php echo $item['PriceID']; ?>"><?php echo $item['PriceTypeText']; ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td>
							<strong>&nbsp;&nbsp; &nbsp;</strong>
						</td>
					</tr>
				</table>
				
				<table style="width: 750px">
					<tr>
						<td width="160">
							<strong>B&amp;B&nbsp;Specials :</strong>&nbsp;
							<span id="rblBBSpecials"><input id="rblBBSpecials_0" type="radio" name="rblBBSpecials" value="Y" <?php echo (isset($_POST['rblBBSpecials']) && ($_POST['rblBBSpecials'] === 'Y')) ? 'checked="checked"' : '' ?> /><label for="rblBBSpecials_0">Yes</label>
							<input id="rblBBSpecials_1" type="radio" name="rblBBSpecials" value="N" <?php echo (isset($_POST['rblBBSpecials']) && ($_POST['rblBBSpecials'] === 'N')) ? 'checked="checked"' : '' ?> /><label for="rblBBSpecials_1">No</label></span>
						</td>
						<td width="160">
							<strong>User&nbsp;Review&nbsp; :</strong>
							<span id="rblUserReview"><input id="rblUserReview_0" type="radio" name="rblUserReview" value="Y" <?php echo (isset($_POST['rblUserReview']) && ($_POST['rblUserReview'] === 'Y')) ? 'checked="checked"' : '' ?> /><label for="rblUserReview_0">Yes</label>
							<input id="rblUserReview_1" type="radio" name="rblUserReview" value="N" <?php echo (isset($_POST['rblUserReview']) && ($_POST['rblUserReview'] === 'N')) ? 'checked="checked"' : '' ?> /><label for="rblUserReview_1">No</label></span>
						</td>
						<td width="160" >
							<strong>B&amp;B Category :</strong>
							<span id="rblBBCategory"><input id="rblBBCategory_0" type="radio" name="rblBBCategory" value="1" <?php echo (isset($_POST['rblBBCategory']) && ($_POST['rblBBCategory'] == 1)) ? 'checked="checked"' : '' ?> /><label for="rblBBCategory_0">Yes</label>
							<input id="rblBBCategory_1" type="radio" name="rblBBCategory" value="0" <?php echo (isset($_POST['rblBBCategory']) && ($_POST['rblBBCategory'] == 0)) ? 'checked="checked"' : '' ?> /><label for="rblBBCategory_1">No</label></span>
						</td>
					  <td width="160" >
							<strong>Vacation Rental :</strong>
							<span id="rblVacationRental"><input id="rblVacationRental_0" type="radio" name="rblVacationRental" value="1" <?php echo (isset($_POST['rblVacationRental']) && ($_POST['rblVacationRental'] == 1)) ? 'checked="checked"' : '' ?> /><label for="rblVacationRental_0">Yes</label>
							<input id="rblVacationRental_1" type="radio" name="rblVacationRental" value="0" <?php echo (isset($_POST['rblVacationRental']) && ($_POST['rblVacationRental'] == 0)) ? 'checked="checked"' : '' ?> /><label for="rblVacationRental_1">No</label></span>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
	
    <div>
	<table cellspacing="0" cellpadding="4" border="0" id="gvResult" style="color:#333333;width:1000px;border-collapse:collapse;">
		<tr style="color:White;background-color:#6D8497;font-weight:bold;"><input type="hidden" id="sort_column" name="sort_column" value="" /><input type="hidden" name="prev_sort_column" value="<?php echo $prev_sort_column ?>" /><input type="hidden" name="sort_direction" value="<?php echo $sort_direction ?>" />
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='WebSiteText';document.forms[0].submit()">Websites</a></th>
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Rating';document.forms[0].submit()">Rating</a></th>
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='ClassficationText';document.forms[0].submit()">Classification</a></th>
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Price';document.forms[0].submit()">Price</a></th>
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='PriceType';document.forms[0].submit()">Price Type</a></th>
			<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='BBListSpecials';document.forms[0].submit()">Specials</a></th>
			<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='UserReview';document.forms[0].submit()">User Review</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='VacationRental';document.forms[0].submit()">Vacation Rental</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Checked';document.forms[0].submit()">Add?</a></th>
		</tr>
		
		<?php $row_num = 0; ?>
		<?php foreach($bbdata as $row): ?>
		<tr style="color:#333333; background-color:#<?php echo (($row_num % 2) == 0) ? 'F7F6F3' : 'FFFFFF' ?>;">
			<td align="left" style="width:140px;"><a href="DetailPage/<?php echo $row['BBDataID'] ?>"><?php echo $row['WebSiteText'] ?></a></td>
			<td align="left" style="width:80px;"><span id="gvResult_ctl02_imgButton"><?php for($i=0; $i<$row['Rating']; $i++) { echo "<IMG src='". base_url() ."images/star_active.gif'>"; } ?></span></td>
			<td align="left"><?php echo $row['ClassficationText'] ?></td>
			<td align="left" style="width:80px;"><?php echo $row['Price'] ?></td>
			<td align="left" style="width:100px;"><?php echo $row['PriceType'] ?></td>
			<td align="center" style="width:120px;"><?php echo $row['BBListSpecials'] ?></td>
			<td align="center" style="width:120px;"><?php echo $row['UserReview'] ?></td>
			<td align="center"><?php echo $row['VacationRental'] == 0 ? 'No' : 'Yes' ?></td>
			<td align="center">
				<?php if($row['Checked'] == 1) { ?>
					<a onclick="return confirm('Are you sure you want to remove this item?');" id="ctl00_ContentPlaceHolder1_gvResult_ctl10_LnkButton" class="YesNo" BBDataID="<?php echo $row['BBDataID'] ?>" BBDataUID="312" State="CANCEL" href="javascript:__doPostBack('ctl00$ContentPlaceHolder1$gvResult$ctl10$LnkButton','')" style="color:Black;">Done</a>
				<?php } else { ?>
					<a id="gvResult_ctl02_LnkButton" class="YesNo" BBDataID="<?php echo $row['BBDataID'] ?>" State="ADD" href="javascript:__doPostBack('gvResult$ctl02$LnkButton','')" style="color:Green;">Yes</a>
				<?php } ?>
			</td>
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