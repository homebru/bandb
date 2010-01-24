<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.blockUI.js?v2.29"></script>
<script type="text/javascript">
	/* Disable buttons while processing request */
	$(document).ready(function() {
		$.unblockUI;
		
		$("input[type='submit']").click(function(){
			var btnText = $(this).attr("value").replace('Update ','').replace('Validate ', '');
			$.blockUI({ message: '<h1 style="padding-top:6px;"><img src="images/ajax-loader.gif" /> Processing '+btnText+'...</h1>' });
			//$('#script').submit();
		});
		
		$("input[name=ProcType]:radio").change(function(){
			if($(this).val() == 'G')
			{
				$('#Group').show();
				$('#Single').hide();
			}
			else
			{
				$('#Group').hide();
				$('#Single').show();
			}
		});
	 });
</script>
<form id='script' method='post'>
	<div>
		<fieldset>
			<legend>Admin Scripts</legend>
			<div style="margin-top:10px;">
				<?php echo validation_errors(); ?>
			<fieldset class="content">
				<legend>Processing Type</legend>
				<div style="float:left; margin-left:40px; margin-right:20px;">
					<input type="radio" name="ProcType" id="ProcType" value="G" <? echo (!isset($_POST['ProcType']) || ($_POST['ProcType'] === 'G')) ? 'checked="checked"' : '' ?> />Record Groups
				</div>
				<div style="float:left; margin-right:20px;">
					<input type="radio" name="ProcType" id="ProcType" value="S" <? echo (isset($_POST['ProcType']) && ($_POST['ProcType'] === 'S')) ? 'checked="checked"' : '' ?> />Single Record
				</div>

			<div id="Group" style="clear:both; margin-left:40px; display:<? echo (!isset($_POST['ProcType']) || ($_POST['ProcType'] === 'G')) ? 'block' : 'none' ?>;">
				<div style="float:left; margin:3px 20px 0 40px;">
					<label><strong><? echo $rec_count; ?> Total Records</strong></label>
				</div>
				<div style="float:left; margin-right:20px;">
					<label for="txtFirst">First Record ID: </label>
					<input name="txtFirst" type="text" id="txtFirst" style="width:50px" value="<?php echo set_value('txtFirst'); ?>" />
				</div>
				<div style="float:left; margin-right:20px;">
					<label for="txtLast">Last Record ID: </label>
					<input name="txtLast" type="text" id="txtLast" style="width:50px" value="<?php echo set_value('txtLast'); ?>" />
					<span style="margin-left:20px; font-size:.8em; font-style:italic">(Record IDs are inclusive)</span>
				</div>
			</div>
			
			<div id="Single" style="clear:both; margin-left:40px; display:<? echo (isset($_POST['ProcType']) && ($_POST['ProcType'] === 'S')) ? 'block' : 'none' ?>;">
				<div style="float:left; margin:3px 20px 0 40px;">
					<label for="txtID">Single Record ID: </label>
					<input name="txtID" type="text" id="txtID" style="width:50px" value="<?php echo set_value('txtID'); ?>" />
				</div>
			</div>
			</fieldset>
		</div>

    <div style="margin-top:20px;">
        <fieldset class="content">
            <legend>Processes</legend>
			<div style="float:left; margin-left:40px; margin-right:20px;">
				<input type="submit" name="btnQuantcast" value="Update Quantcast" id="btnQuantcast" style="width:200px; margin-bottom:5px;" /><br />
				<input type="submit" name="btnQuantified" value="Update Quantified" id="btnQuantified" style="width:200px; margin-bottom:5px;" /><br />
				<input type="submit" name="btnCompete" value="Update Compete" id="btnCompete" style="width:200px;" />
			</div>
			<div style="float:left; margin-right:20px;">
				<input type="submit" name="btnMSN" value="Update Index by MSN" id="btnMSN" style="width:200px; margin-bottom:5px;" /><br />
				<input type="submit" name="btnGoogle" value="Update Index by Google" id="btnGoogle" style="width:200px; margin-bottom:5px;" /><br />
				<input type="submit" name="btnYahoo" value="Update Index by Yahoo" id="btnYahoo" style="width:200px;" />
			</div>
			<div style="float:left;">
				<div>
				<input disabled="disabled" type="submit" name="btnPageRank" value="Update Max Page Rank" id="btnPageRank" style="width:200px; margin-bottom:5px;" /><br />
				<input disabled="disabled" type="submit" name="btnPageRankLink" value="Update Link Page Rank" id="btnPageRankLink" style="width:200px; margin-bottom:10px;" />
				</div>
				<div style="margin-top:10px;">
				<input type="submit" name="btnScore" value="Update Score" id="btnScore" style="width:200px; margin-bottom:5px;" /><br />
				<input type="submit" name="btnNoFollow" value="Validate NoFollow" id="btnNoFollow" style="width:200px;" /><br />
				</div>
			</div>
			<div style="clear:both; padding-top:20px;">
				<div style="float: left; width:50%; text-align:left; margin-left:40px;">
				<!--input type="submit" name="btnUpdate" value="Update by Record Id" id="btnUpdate" style="width:200px; color:#990000;" /--><br />
				</div>
				<div style="float:right;">
					<input type="submit" name="btnClearLog" value="Clear Log File" id="btnClearLog" style="width:200px; color:#cd6700;" />
				</div>
				<br class="clear" />
			</div>
        </fieldset>
    </div>
	</form>
	</fieldset>
</div>
<div>

<!--
    Protected Sub btnScore_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnScore.Click
        Dim mngt As New ManagementTool.Service
        Call mngt.GetScore()
    End Sub

    Protected Sub btnQuantcast_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnQuantcast.Click
        Dim mngt As New ManagementTool.Service
        Call mngt.GetQuantCasT()

    End Sub

    Protected Sub btnCompete_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnCompete.Click
        Dim mngt As New ManagementTool.Service
        Call mngt.GetCompete()

    End Sub

    Protected Sub btnMSN_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnMSN.Click
        Dim mngt As New ManagementTool.Service
        Call mngt.GetIndexed("http://search.msn.com.ph/results.aspx?q=")
    End Sub

    Protected Sub btnGoogle_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnGoogle.Click
        Dim mngt As New ManagementTool.Service
        Call mngt.GetIndexed("http://www.google.com/search?hl=en&q=")
    End Sub

    Protected Sub btnYahoo_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnYahoo.Click
        Dim mngt As New ManagementTool.Service
        Call mngt.GetIndexed("http://search.yahoo.com/search?p=")
    End Sub

    Protected Sub btnPageRank_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnPageRank.Click
        Dim mngt As New ManagementTool.Service
        Call mngt.GetMaxPageRank()

    End Sub

    Protected Sub btnNoFollow_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnNoFollow.Click
        Dim mngt As New ManagementTool.Service
        Call mngt.GetNoFollow()
    End Sub

    Protected Sub btnUpdate_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnUpdate.Click
        Dim intId As String = txtID.Text
        If intId.Trim <> "" Then
            Dim mngt As New ManagementTool.Service
            Call mngt.RunUpdate(intId)
        End If
    End Sub

    Protected Sub btnPageRankLink_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnPageRankLink.Click
        Dim mngt As New ManagementTool.Service
        Call mngt.GetLinkPageRank()
    End Sub
-->