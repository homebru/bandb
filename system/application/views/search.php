	<form name="searchForm" method="post" action="Search.aspx" id="searchForm" class="cmxform">
		<div id="search">
			<fieldset>
				<legend>Search</legend>
				<span id="lblSearchTitle" style="font-weight:bold;">Search:</span>&nbsp;
				<input name="txtSearch" type="text" id="txtSearch" class="texta" style="width:243px;" />&nbsp;
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
									$class_id = $classification[$offset]['ClassficationID']; ?>
									<td><input id="chkClass_<?php echo $class_id; ?>" type="checkbox" name="chkClass_<?php echo $class_id; ?>" onclick="CheckboxTrigger(this);" <?php echo ($classification[$offset]['UserDefault'] == 0) ? '' : 'checked="checked"'; ?> /><label for="chkClass_<?php echo $class_id; ?>"><?php echo $classification[$offset]['ClassficationText']; ?></label></td>
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
							<input id="chkAll" type="checkbox" name="chkAll" checked="checked" onclick="javascript:mRating('chkAll');" /><label for="chkAll">All</label>&nbsp;
							<input id="chk1" type="checkbox" name="chk1" onclick="javascript:mRating('chk1');" /><label for="chk1">1</label>&nbsp;
							<input id="chk2" type="checkbox" name="chk2" onclick="javascript:mRating('chk2');" /><label for="chk2">2</label>&nbsp;
							<input id="chk3" type="checkbox" name="chk3" onclick="javascript:mRating('chk3');" /><label for="chk3">3</label>&nbsp;
							<input id="chk4" type="checkbox" name="chk4" onclick="javascript:mRating('chk4');" /><label for="chk4">4</label>&nbsp;
							<input id="chk0" type="checkbox" name="chk0" onclick="javascript:mRating('chk0');" /><label for="chk0">*</label>&nbsp;
							<input id="chkNR" type="checkbox" name="chkNR" onclick="javascript:mRating('chkNR');" /><label for="chkNR">NR</label>&nbsp;
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
							<span id="rblBBSpecials"><input id="rblBBSpecials_0" type="radio" name="rblBBSpecials" value="Y" /><label for="rblBBSpecials_0">Yes</label><input id="rblBBSpecials_1" type="radio" name="rblBBSpecials" value="N" /><label for="rblBBSpecials_1">No</label></span>
						</td>
						<td width="160">
							<strong>User&nbsp;Review&nbsp; :</strong>
							<span id="rblUserReview"><input id="rblUserReview_0" type="radio" name="rblUserReview" value="Y" /><label for="rblUserReview_0">Yes</label><input id="rblUserReview_1" type="radio" name="rblUserReview" value="N" /><label for="rblUserReview_1">No</label></span>
						</td>
						<td width="160" >
							<strong>B&amp;B Category :</strong>
							<span id="rblBBCategory"><input id="rblBBCategory_0" type="radio" name="rblBBCategory" value="1" /><label for="rblBBCategory_0">Yes</label><input id="rblBBCategory_1" type="radio" name="rblBBCategory" value="0" /><label for="rblBBCategory_1">No</label></span>
						</td>
					  <td width="160" >
							<strong>Vacation Rental :</strong>
							<span id="rblVacationRental"><input id="rblVacationRental_0" type="radio" name="rblVacationRental" value="1" /><label for="rblVacationRental_0">Yes</label><input id="rblVacationRental_1" type="radio" name="rblVacationRental" value="0" /><label for="rblVacationRental_1">No</label></span>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
	
    <div>
	<table cellspacing="0" cellpadding="4" border="0" id="gvResult" style="color:#333333;width:1000px;border-collapse:collapse;">
		<tr style="color:White;background-color:#6D8497;font-weight:bold;">
			<th align="left" scope="col"><a href="javascript:__doPostBack('gvResult','Sort$WebSiteText')" style="color:White;">Websites</a></th>
			<th align="left" scope="col"><a href="javascript:__doPostBack('gvResult','Sort$Rating')" style="color:White;">Rating</a></th>
			<th align="left" scope="col"><a href="javascript:__doPostBack('gvResult','Sort$ClassficationText')" style="color:White;">Classification</a></th>
			<th align="left" scope="col"><a href="javascript:__doPostBack('gvResult','Sort$Price')" style="color:White;">Price</a></th>
			<th align="left" scope="col"><a href="javascript:__doPostBack('gvResult','Sort$PriceType')" style="color:White;">Price Type</a></th>
			<th align="center" scope="col"><a href="javascript:__doPostBack('gvResult','Sort$BBListSpecials')" style="color:White;">Specials</a></th>
			<th align="center" scope="col"><a href="javascript:__doPostBack('gvResult','Sort$UserReview')" style="color:White;">User Review</a></th>
			<th scope="col"><a href="javascript:__doPostBack('gvResult','Sort$VacationRental')" style="color:White;">Vacation Rental</a></th>
			<th scope="col"><a href="javascript:__doPostBack('gvResult','Sort$Checked')" style="color:White;">Add?</a></th>
		</tr>
		<tr style="color:#333333;background-color:#F7F6F3;">
			<td align="left" style="width:140px;"><a href="DetailPage.aspx?ID=1339">10000vacations.com</a></td><td align="left" style="width:80px;">
                    <span id="gvResult_ctl02_imgButton"><IMG src='../images/star_active.gif'><IMG src='../images/star_active.gif'><IMG src='../images/star_active.gif'><IMG src='../images/star_active.gif'></span>
                </td><td align="left">Vacation Rentals</td><td align="left" style="width:80px;">$1.00</td><td align="left" style="width:100px;">Free</td><td align="center" style="width:120px;">No</td><td align="center" style="width:120px;">No</td><td align="center">
                    <span id="gvResult_ctl02_lblVacationRental">Yes</span>
                </td><td align="center">
                    <a id="gvResult_ctl02_LnkButton" class="YesNo" BBDataID="1339" State="ADD" href="javascript:__doPostBack('gvResult$ctl02$LnkButton','')" style="color:Green;">Yes</a>
                </td>
		</tr>
	</table>
</div>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>