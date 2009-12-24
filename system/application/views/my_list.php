    <form name="mylistForm" method="post" action="search/my" id="mylistForm" class="cmxform">
		<div>

		<div style="height: 30px; padding-top: 15px;">
			&nbsp;&nbsp; <strong>Hi</strong>&nbsp;<span id="LoginName" style="font-weight:bold;"><?php echo username(); ?></span>
		</div>
		<fieldset>
			<legend>My Advertising Sites</legend>
			<div>
				<table>
					<tr>
						<td>
							<div>
								<table cellspacing="0" cellpadding="4" border="0" id="MyAdLog" style="color:#333333;width:900px;border-collapse:collapse;">
									<tr style="color:White;background-color:#6D8497;font-weight:bold;">
										<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='WebSiteText';document.forms[0].submit()">Websites</a></th>
										<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Rating';document.forms[0].submit()">Rating</a></th>
										<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='Price';document.forms[0].submit()">Price</a></th>
										<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='DateExpires';document.forms[0].submit()">Expires Date</a></th>
										<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='PriceType';document.forms[0].submit()">Price Type</a></th>
										<th align="left" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='ClassficationText';document.forms[0].submit()">Classification</a></th>
										<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='BBListSpecials';document.forms[0].submit()">Specials</a></th>
										<th align="center" scope="col"><a href="#" style="color:White;" onclick="javascript:document.getElementById('sort_column').value='UserReview';document.forms[0].submit()">User Review</a></th>
									</tr>
		
									<?php $row_num = 0; ?>
									<?php foreach($bbdata as $row): ?>
										<?php if($row['Checked'] != 0): ?>
										<tr style="color:#333333; background-color:#<?php echo (($row_num % 2) == 0) ? 'F7F6F3' : 'FFFFFF' ?>;">
											<td align="left" style="width:190px;"><a href="<?php echo base_url() ?>detail/<?php echo $row['BBDataID'] ?>"><?php echo $row['WebSiteText'] ?></a></td>
											<td align="left" style="width:100px;"><span id="gvResult_ctl02_imgButton"><?php for($i=0; $i<$row['Rating']; $i++) { echo "<IMG src='". base_url() ."images/star_active.gif'>"; } ?></span></td>
											<td align="left" style="width:80px;"><?php echo $row['Price'] ?></td>
											<td align="center" style="width:110px;"><?php //echo $row['DateExpires'] ?></td>
											<td align="left" style="width:120px;"><?php echo $row['PriceType'] ?></td>
											<td align="left" style="width:150px;"><?php echo $row['ClassficationText'] ?></td>
											<td align="center" style="width:120px;"><?php echo $row['BBListSpecials'] ?></td>
											<td align="center" style="width:120px;"><?php echo $row['UserReview'] ?></td>
										</tr>
										<?php ++$row_num; ?>
										<?php endif; ?>
									<?php endforeach; unset($_POST); ?>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</fieldset>
	</div>
    </form>
</body>
</html>