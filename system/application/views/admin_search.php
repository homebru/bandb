	<form name="searchForm" method="post" id="searchForm" class="cmxform">	
    <div id="search">
        <fieldset style="background-color:#f3f2ed;">
            <legend>Search</legend>
            <table style="width: 850px">
                <tr>
                    <td>
                        <strong>Search :</strong>&nbsp;
                        <input name="txtSearch" type="text" id="txtSearch" class="texta" style="width:243px;" />&nbsp;&nbsp;&nbsp;&nbsp;<strong>Ad Package :</strong>&nbsp;
						<select name="ddAdPackage" id="ddAdPackage" class="texta">
							<option selected="selected" value="All">All</option>
							<?php foreach($ad_package as $item) {
								$is_selected = (isset($_POST["ddAdPackage"]) && ($_POST["ddAdPackage"] == $item['AdPackageId'])) ? ' selected="selected"' : ''; ?>
								<option value="<?= $item['AdPackageId'] ?>" <?= $is_selected ?> ><?= $item['AdPackageText'] ?></option>
							 <?php } ?>
						</select>&nbsp;
                        <input type="submit" name="btnSearch" value="Search" id="btnSearch" class="texta" />&nbsp;
                        <input type="submit" name="btnReset" value="Reset" id="btnReset" class="texta" />&nbsp;
						<input type="submit" name="btnAddNew" value="Add New Record" id="btnAddNew" class="texta" style="width:118px;" />
					</td>
                </tr>
            </table>
			
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
								$is_checked = '';	//$classification[$offset]['UserDefault'];
								if(isset($_POST) && !empty($_POST)) {
									$is_checked = isset($_POST["chkClass_$class_id"]); 
								}
								else {
									if($classification[$offset]['ClassficationText'] === 'All')
										$is_checked = true;
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
            <table style="width: 750px">
                <tr>
                    <td style="width: 399px;">
                        <strong>Rating : &nbsp;</strong>
						<input id="chkAll" type="checkbox" name="chkAll" onclick="javascript:mRating('chkAll');" <?php echo !(isset($_POST['chk1']) || isset($_POST['chk2']) || isset($_POST['chk3']) || isset($_POST['chk4']) || isset($_POST['chk0']) || isset($_POST['chkNR'])) ? 'checked="checked"' : '' ?> /><label for="chkAll">All</label>
                        <input id="chk1" type="checkbox" name="chk1" onclick="javascript:mRating('chk1');" <?php echo (isset($_POST['chk1'])) ? 'checked="checked"' : '' ?> /><label for="chk1">1</label>
                        <input id="chk2" type="checkbox" name="chk2" onclick="javascript:mRating('chk2');" <?php echo (isset($_POST['chk2'])) ? 'checked="checked"' : '' ?> /><label for="chk2">2</label>
                        <input id="chk3" type="checkbox" name="chk3" onclick="javascript:mRating('chk3');" <?php echo (isset($_POST['chk3'])) ? 'checked="checked"' : '' ?> /><label for="chk3">3</label>
                        <input id="chk4" type="checkbox" name="chk4" onclick="javascript:mRating('chk4');" <?php echo (isset($_POST['chk4'])) ? 'checked="checked"' : '' ?> /><label for="chk4">4</label>
                        <input id="chk0" type="checkbox" name="chk0" onclick="javascript:mRating('chk0');" <?php echo (isset($_POST['chk0'])) ? 'checked="checked"' : '' ?> /><label for="chk0">*</label>
                        <input id="chkNR" type="checkbox" name="chkNR" onclick="javascript:mRating('chkNR');" <?php echo (isset($_POST['chkNR'])) ? 'checked="checked"' : '' ?> /><label for="chkNR">NR</label></td>
                    <td style="width: 90px">
                        <strong>Link Type :&nbsp;</strong>
                    </td>
                    <td>
						<select name="ddLinkType" id="ddLinkType" class="texta" style="width:150px;">
							<option selected="selected" value="All">All</option>
							<?php foreach($link_type as $item) {
								$is_selected = (isset($_POST["ddLinkType"]) && ($_POST["ddLinkType"] == $item['LinkTypeId'])) ? ' selected="selected"' : ''; ?>
								<option value="<?= $item['LinkTypeId'] ?>" <?= $is_selected ?>><?= $item['LinkTypeText'] ?></option>
							 <?php } ?>
						</select>
					</td>
                </tr>
                <tr>
                    <td style="width: 399px">
                        <strong>Max&nbsp;PR&nbsp;:&nbsp; </strong>
						<?php for($i=0; $i<10; $i++) {
							$is_checked = ($is_checked || isset($_POST["chkMaxPR$i"])); 
						} $is_checked = (!$is_checked || isset($_POST['chkMaxPRAll'])) ? 'checked="checked"' : ''; ?>
                        <input id="chkMaxPRAll" type="checkbox" name="chkMaxPRAll" onclick="javascript:mMaxPR('chkMaxPRAll');" <?= $is_checked ?> /><label for="chkMaxPRAll">All</label>
						<?php for($i=0; $i<10; $i++) {
							$is_checked = (isset($_POST["chkMaxPR$i"])) ? 'checked="checked"' : '';
							echo "<input id='chkMaxPR$i' type='checkbox' name='chkMaxPR$i' onclick='javascript:mMaxPR(\'chkMaxPR$i\');' $is_checked /><label for='chkMaxPR$i'>$i</label>";
						} ?>
                    </td>
                    <td style="width: 90px">
                        <strong>Price Type :&nbsp;</strong>
                    </td>
                    <td>
						<select name="ddPriceType" id="ddPriceType" class="texta" style="width:150px;">
							<option selected="selected" value="All">All</option>
							<option value="Blank" <?php echo isset($_POST['ddPriceType']) && $_POST['ddPriceType'] === 'Blank' ? 'selected="selected"' : '' ?> >Blank</option>
							<?php foreach($price_type as $item) {
								$is_selected = (isset($_POST["ddPriceType"]) && ($_POST["ddPriceType"] == $item['PriceID'])) ? ' selected="selected"' : ''; ?>
								<option value="<?= $item['PriceID'] ?>" <?= $is_selected ?>><?= $item['PriceTypeText'] ?></option>
							<?php }?>
						</select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 399px">
                        <strong>Link&nbsp;PR&nbsp;:&nbsp; </strong>
						<?php for($i=0; $i<10; $i++) {
							$is_checked = ($is_checked || isset($_POST["chkLinkPR$i"])); 
						} $is_checked = (!$is_checked || isset($_POST['chkLinkPRALL'])) ? 'checked="checked"' : ''; ?>
                        <input id="chkLinkPRAll" type="checkbox" name="chkLinkPRAll" onclick="javascript:mLinkPR('chkLinkPRAll');" <?= $is_checked ?> /><label for="chkLinkPRAll">All</label>
						<?php for($i=0; $i<10; $i++) {
							$is_checked = (isset($_POST["chkLinkPR$i"])) ? 'checked="checked"' : '';
							echo "<input id='chkLinkPR$i' type='checkbox' name='chkLinkPR$i' onclick='javascript:mMaxPR(\'chkLinkPR$i\');' $is_checked /><label for='chkLinkPR$i'>$i</label>";
						} ?>
                    </td>
                    <td style="width: 90px">
                        <strong>State :&nbsp;</strong>
                    </td>
                    <td>
                        <select name="ddStates" id="ddStates" class="texta" style="width:150px;">
							<option selected="selected" value="All">National</option>
							<option value="Everything">All</option>
							<option value="Blank">Blank</option>
							<?php foreach($states as $item):?>
								<option value="<?= $item['StatesCode']; ?>" <?= set_select('ddState', $item['StatesCode'], $_POST['ddStates'] === $item['StatesCode']); ?>><?= $item['StatesDescription']; ?></option>
							<?php endforeach;?>
						</select>
                    </td>
                </tr>
            </table>
            <table style="width: 850px">
                <tr>
                    <td>
                        <strong>B&amp;B&nbsp;Specials :</strong>&nbsp;</td>
                    <td style="width: 90px">
                        <span id="rblBBSpecials">
						<input id="rblBBSpecials_0" type="radio" name="rblBBSpecials" value="Y" <?php echo (isset($_POST['rblBBSpecials']) && ($_POST['rblBBSpecials'] === 'Y')) ? 'checked="checked"' : '' ?> /><label for="rblBBSpecials_0">Yes</label>
						<input id="rblBBSpecials_1" type="radio" name="rblBBSpecials" value="N" <?php echo (isset($_POST['rblBBSpecials']) && ($_POST['rblBBSpecials'] === 'N')) ? 'checked="checked"' : '' ?> /><label for="rblBBSpecials_1">No</label></span>
					</td>
                    <td>
                        <strong>User&nbsp;Review&nbsp; :</strong></td>
                    <td style="width: 90px">
                        <span id="rblUserReview">
						<input id="rblUserReview_0" type="radio" name="rblUserReview" value="Y" <?php echo (isset($_POST['rblUserReview']) && ($_POST['rblUserReview'] === 'Y')) ? 'checked="checked"' : '' ?> /><label for="rblUserReview_0">Yes</label>
						<input id="rblUserReview_1" type="radio" name="rblUserReview" value="N" <?php echo (isset($_POST['rblUserReview']) && ($_POST['rblUserReview'] === 'N')) ? 'checked="checked"' : '' ?> /><label for="rblUserReview_1">No</label></span>
					</td>
                    <td>
                        <strong>Quantified :</strong></td>
                    <td style="width: 90px">
                        <span id="rblQuantified">
						<input id="rblQuantified_0" type="radio" name="rblQuantified" value="Y" <?php echo (isset($_POST['rblQuantified']) && ($_POST['rblQuantified'] === 'Y')) ? 'checked="checked"' : '' ?> /><label for="rblQuantified_0">Yes</label>
						<input id="rblQuantified_1" type="radio" name="rblQuantified" value="N" <?php echo (isset($_POST['rblQuantified']) && ($_POST['rblQuantified'] === 'N')) ? 'checked="checked"' : '' ?> /><label for="rblQuantified_1">No</label></span>
					</td>
                    <td style="width: 171px">
                        <strong>B&amp;B Category :</strong></td>
                    <td>
                        <span id="rblBBCategory">
						<input id="rblBBCategory_0" type="radio" name="rblBBCategory" value="1" <?php echo (isset($_POST['rblBBCategory']) && ($_POST['rblBBCategory'] == 1)) ? 'checked="checked"' : '' ?> /><label for="rblBBCategory_0">Yes</label>
						<input id="rblBBCategory_1" type="radio" name="rblBBCategory" value="0" <?php echo (isset($_POST['rblBBCategory']) && ($_POST['rblBBCategory'] == 0)) ? 'checked="checked"' : '' ?> /><label for="rblBBCategory_1">No</label></span>
					</td>
                </tr>
                <tr>
                    <td style="height: 22px">
                        <strong>Google :</strong></td>
                    <td style="width: 90px; height: 22px;">
                        <span id="rblGoogle">
						<input id="rblGoogle_0" type="radio" name="rblGoogle" value="Y" <?php echo (isset($_POST['rblGoogle']) && ($_POST['rblGoogle'] === 'Y')) ? 'checked="checked"' : '' ?> /><label for="rblGoogle_0">Yes</label>
						<input id="rblGoogle_1" type="radio" name="rblGoogle" value="N" <?php echo (isset($_POST['rblGoogle']) && ($_POST['rblGoogle'] === 'N')) ? 'checked="checked"' : '' ?> /><label for="rblGoogle_1">No</label></span>
					</td>
                    <td style="height: 22px">
                        <strong>Yahoo :</strong></td>
                    <td style="width: 90px; height: 22px;">
                        <span id="rblYahoo">
						<input id="rblYahoo_0" type="radio" name="rblYahoo" value="Y" <?php echo (isset($_POST['rblYahoo']) && ($_POST['rblYahoo'] === 'Y')) ? 'checked="checked"' : '' ?> /><label for="rblYahoo_0">Yes</label>
						<input id="rblYahoo_1" type="radio" name="rblYahoo" value="N" <?php echo (isset($_POST['rblYahoo']) && ($_POST['rblYahoo'] === 'N')) ? 'checked="checked"' : '' ?> /><label for="rblYahoo_1">No</label></span>
					</td>
                    <td style="height: 22px">
                        <strong>Bing:</strong></td>
                    <td style="width: 90px; height: 22px;">
                        <span id="rblMSN">
						<input id="rblMSN_0" type="radio" name="rblMSN" value="Y" <?php echo (isset($_POST['rblMSN']) && ($_POST['rblMSN'] === 'Y')) ? 'checked="checked"' : '' ?> /><label for="rblMSN_0">Yes</label>
						<input id="rblMSN_1" type="radio" name="rblMSN" value="N" <?php echo (isset($_POST['rblMSN']) && ($_POST['rblMSN'] === 'N')) ? 'checked="checked"' : '' ?> /><label for="rblMSN_1">No</label></span>
					</td>
                    <td style="height: 22px; width: 171px;">
                        &nbsp;<strong>Vacation Rental Category :</strong></td>
                    <td>
                        <span id="rblVacationRental">
						<input id="rblVacationRental_0" type="radio" name="rblVacationRental" value="1" <?php echo (isset($_POST['rblVacationRental']) && ($_POST['rblVacationRental'] == 1)) ? 'checked="checked"' : '' ?> /><label for="rblVacationRental_0">Yes</label>
						<input id="rblVacationRental_1" type="radio" name="rblVacationRental" value="0" <?php echo (isset($_POST['rblVacationRental']) && ($_POST['rblVacationRental'] == 0)) ? 'checked="checked"' : '' ?> /><label for="rblVacationRental_1">No</label></span>
					</td>
                </tr>
            </table>
            <span id="lblCount" style="color:Firebrick;"><?= $row_count ?> Rows Returned</span>
		</fieldset>
    </div>
    




    <div>
	<table cellspacing="0" cellpadding="4" border="0" id="gvResult" style="color:#333333;border-collapse:collapse;">
		<tr style="color:White;background-color:#6D8497;font-weight:bold;"><input type="hidden" id="sort_column" name="sort_column" value="" /><input type="hidden" name="prev_sort_column" value="<?php echo $prev_sort_column ?>" /><input type="hidden" name="sort_direction" value="<?php echo $sort_direction ?>" />
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='WebSiteText';document.forms[0].submit()">Websites</a></th>
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Rating';document.forms[0].submit()">Rating</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Score';document.forms[0].submit()">Score</a></th>
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Price';document.forms[0].submit()">Price</a></th>
			<th align="left" scope="col" nowrap="nowrap"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='PriceType';document.forms[0].submit()">Price Type</a></th>
			<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='ClassficationText';document.forms[0].submit()">Classification</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='BBCategory';document.forms[0].submit()">BB</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='VacationRental';document.forms[0].submit()">VR</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='MaxPR';document.forms[0].submit()">MPR</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='LinkPR';document.forms[0].submit()">LPR</a></th>
			<th align="left" scope="col" nowrap="nowrap"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='LinkType';document.forms[0].submit()">Link Type</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='IndexByGoogle';document.forms[0].submit()">G</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='IndexByYahoo';document.forms[0].submit()">Y</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='IndexByMSN';document.forms[0].submit()">B</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Quantified';document.forms[0].submit()">Q</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='PM';document.forms[0].submit()">PM</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='SEO';document.forms[0].submit()">SEO</a></th>
			<th scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='AdPackage';document.forms[0].submit()">Ad Package</a></th>
			<th align="right" scope="col" nowrap="nowrap"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='QuantcastCurrent';document.forms[0].submit()">Q Monthly</a></th>
			<th align="right" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='QuantcastChange';document.forms[0].submit()">Q%</a></th>
			<th align="right" scope="col" nowrap="nowrap"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='CompeteCurrent';document.forms[0].submit()">C Monthly</a></th>
			<th align="right" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='CompeteChange';document.forms[0].submit()">C%</a></th>
			<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='LastUpdated';document.forms[0].submit()">Updated</a></th>
		</tr>
		
		<?php $row_num = 0; ?>
		<?php foreach($bbdata as $row): ?>
		<tr style="color:#333333; background-color:#<?php echo (($row_num % 2) == 0) ? 'F7F6F3' : 'FFFFFF' ?>;">
			<td align="left"><a href="<?php echo base_url() ?><? echo (user_group('admin') === TRUE) ? 'admin_' : '' ?>detail/<?= $row['BBDataID'] ?>"><?php echo $row['WebSiteText'] ?></a></td>
			<td align="left" nowrap="nowrap">
				<?php if($row['Rating'] == 0) { ?>
					NR
				<?php } else { ?>
					<span id="gvResult_ctl02_imgButton"><?php for($i=0; $i<$row['Rating']; $i++) { echo "<IMG src='". base_url() ."images/star_active.gif'>"; } ?></span>
				<?php } ?>
			</td>
			<td align="right"><?php echo number_format($row['Score']) ?></td>
			<td align="right"><?php echo $row['Price'] ?></td>
			<td align="left" nowrap="nowrap"><?php echo $row['PriceType'] ?></td>
			<td align="left" nowrap="nowrap"><?php echo $row['ClassficationText'] ?></td>
			<td align="center"><?php echo $row['BBCategory'] == 0 ? 'N' : 'Y' ?></td>
			<td align="center"><?php echo $row['VacationRental'] == 0 ? 'N' : 'Y' ?></td>
			<td align="center"><?php echo $row['MaxPR'] ?></td>
			<td align="center"><?php echo $row['LinkPR'] ?></td>
			<td align="left" nowrap="nowrap"><?php echo $row['LinkType'] ?></td>
			<td align="center"><?php echo $row['IndexByGoogle'] === '' ? 'N' : $row['IndexByGoogle'][0] ?></td>
			<td align="center"><?php echo $row['IndexByYahoo'] === '' ? 'N' : $row['IndexByYahoo'][0] ?></td>
			<td align="center"><?php echo $row['IndexByMSN'] === '' ? 'N' : $row['IndexByMSN'][0] ?></td>
			<td align="center"><?php echo $row['Quantified'] == 0 ? 'N' : 'Y' ?></td>
			<td align="center"><?php echo $row['PM'] == 0 ? 'N' : 'Y' ?></td>
			<td align="center"><?php echo $row['SEO'] == 0 ? 'N' : 'Y' ?></td>
			<td align="left" nowrap="nowrap"><?php echo $row['AdPackage'] ?></td>
			<td align="right"><?php echo number_format($row['QuantcastCurrent']) ?></td>
			<td align="right" <?= $row['QuantcastChange'] < 0 ? 'style="color:#990000;"' : '' ?>><?php echo $row['QuantcastChange'] ?>%</td>
			<td align="right"><?php echo number_format($row['CompeteCurrent']) ?></td>
			<td align="right" <?= $row['CompeteChange'] < 0 ? 'style="color:#990000;"' : '' ?>><?php echo $row['CompeteChange'] ?>%</td>
			<td align="center"><?php echo $row['LastUpdated'] ?></td>
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