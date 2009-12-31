<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $page_title; ?></title>
<?php echo link_tag('css/default.css');?>
<?php echo link_tag('favicon.ico', 'shortcut icon', 'image/ico'); ?>

<script src="<?php echo base_url(); ?>scripts/jquery-1.3.2.min.js" type="text/javascript"></script>

<?php if(strpos($_SERVER['PHP_SELF'],'detail') > -1):?>
<?php echo link_tag('css/ui-lightness/jquery-ui-1.7.2.custom.css');?>
<script src="<?php echo base_url(); ?>scripts/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
		$("#txtExpiry").datepicker();
	});
	</script>
<?php endif; ?>

<?php if(strpos($_SERVER['PHP_SELF'],'search') > -1):?>
<script type="text/javascript">
var theForm = document.forms['aspnetForm'];
if (!theForm) {
    theForm = document.aspnetForm;
}
function __doPostBack(eventTarget, eventArgument) {
    if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
        theForm.__EVENTTARGET.value = eventTarget;
        theForm.__EVENTARGUMENT.value = eventArgument;
        theForm.submit();
    }
}

function CheckboxTrigger(obj)
{
	// alert(obj.name);
	
	var chkval = 0;
	if (obj.name == "chkClass_0")
	{
	 var chkBoxList = document.getElementById("chkClass");
	 var chkBoxCount= chkBoxList.getElementsByTagName("input");
	   for(var i=0;i<chkBoxCount.length;i++)
		{ 
		if (chkBoxCount[i].name != "chkClass_0")  {
		chkBoxCount[i].checked = false;}
		
		   if (chkBoxCount[i].checked == true)  
				{
				chkval = 1;
				}
		 }
	}
	else if (obj.name == "chkClass_1")
	{
	 var chkBoxList = document.getElementById("chkClass");
	 var chkBoxCount= chkBoxList.getElementsByTagName("input");
	   for(var i=0;i<chkBoxCount.length;i++)
		{ 
		if (chkBoxCount[i].name != "chkClass_1")  {
		chkBoxCount[i].checked = false;}
		
		   if (chkBoxCount[i].checked == true)  
				{
				chkval = 1;
				}
		 }
	}
	else
	{
	 var chkBoxList = document.getElementById("chkClass");
	 var chkBoxCount= chkBoxList.getElementsByTagName("input");
	
	   for(var i=0;i<chkBoxCount.length;i++)
		{ 
			if (chkBoxCount[i].name == "chkClass_0" || chkBoxCount[i].name == "chkClass_1"  )  
				{
				chkBoxCount[i].checked = false;
				}
		
			if (chkBoxCount[i].checked == true)  
				{
				chkval = 1;
				}
		 }
	}
			
	if ( chkval == 0 ){
	chkBoxCount[0].checked = true;
	}
	
	return false; 
}
    
function mRating(id)
{
	var chkBox = document.getElementById(id);
	var chkAll = document.getElementById('chkAll');
	var chkOne = document.getElementById('chk1');
	var chkTwo = document.getElementById('chk2');
	var chkThree = document.getElementById('chk3');
	var chkFour = document.getElementById('chk4');
	var chkNR = document.getElementById('chk0');
	var chkNull = document.getElementById('chkNR');
	if (id == 'chkAll')
	{
	   chkOne.checked = false;
	   chkTwo.checked = false;
	   chkThree.checked = false;
	   chkFour.checked = false;
	   chkNR.checked = false;
	   chkNull.checked = false;
	}
	if (id != 'chkAll')
	{
	  chkAll.checked = false;
	}
}


function mMaxPR(id)
{
	var chkMaxPR = document.getElementById(id);
	var chkMaxPRAll = document.getElementById('chkMaxPRAll');
	var chkMaxPRZero = document.getElementById('chkMaxPR0');
	var chkMaxPROne = document.getElementById('chkMaxPR1');
	var chkMaxPRTwo = document.getElementById('chkMaxPR2');
	var chkMaxPRThree = document.getElementById('chkMaxPR3');
	var chkMaxPRFour = document.getElementById('chkMaxPR4');
	var chkMaxPRFive = document.getElementById('chkMaxPR5');
	var chkMaxPRSix = document.getElementById('chkMaxPR6');
	var chkMaxPRSeven = document.getElementById('chkMaxPR7');
	var chkMaxPREight = document.getElementById('chkMaxPR8');
	var chkMaxPRNine = document.getElementById('chkMaxPR9');
	
	if (id == 'chkMaxPRAll')
	{
	chkMaxPRZero.checked = false;
	chkMaxPROne.checked = false;
	chkMaxPRTwo.checked = false;
	chkMaxPRThree.checked = false;
	chkMaxPRFour.checked = false;
	chkMaxPRFive.checked = false;
	chkMaxPRSix.checked = false;
	chkMaxPRSeven.checked = false;
	chkMaxPREight.checked = false;
	chkMaxPRNine.checked = false; 
	
	}
	if (id != 'chkMaxPRAll')
	{
	chkMaxPRAll.checked = false;
	
	}
}




function mLinkPR(id)
{
	var chkLinkPR = document.getElementById(id);
	var chkLinkPRAll = document.getElementById('chkLinkPRAll');
	var chkLinkPRZero = document.getElementById('chkLinkPR0');
	var chkLinkPROne = document.getElementById('chkLinkPR1');
	var chkLinkPRTwo = document.getElementById('chkLinkPR2');
	var chkLinkPRThree = document.getElementById('chkLinkPR3');
	var chkLinkPRFour = document.getElementById('chkLinkPR4');
	var chkLinkPRFive = document.getElementById('chkLinkPR5');
	var chkLinkPRSix = document.getElementById('chkLinkPR6');
	var chkLinkPRSeven = document.getElementById('chkLinkPR7');
	var chkLinkPREight = document.getElementById('chkLinkPR8');
	var chkLinkPRNine = document.getElementById('chkLinkPR9');
	
	if (id == 'chkLinkPRAll')
	{
	chkLinkPRZero.checked = false;
	chkLinkPROne.checked = false;
	chkLinkPRTwo.checked = false;
	chkLinkPRThree.checked = false;
	chkLinkPRFour.checked = false;
	chkLinkPRFive.checked = false;
	chkLinkPRSix.checked = false;
	chkLinkPRSeven.checked = false;
	chkLinkPREight.checked = false;
	chkLinkPRNine.checked = false; 
	
	}
	if (id != 'chkLinkPRAll')
	{
	chkLinkPRAll.checked = false;
	
	}
}

</script>
		
<?php endif; ?>
	
</head>

<body>
	<div class="holder2" style="font-size: 8pt; font-family: Tahoma">
		<div class="top" style="width:100%; margin-bottom:10px;">
			<div style="text-align: right; padding-right: 30px; padding-top:15px;">
				<span id="lblDateStamp" class="TopLabel" style="color:LightGrey;"><?php echo date("l, F j, Y"); ?></span>
			</div>
		</div>
		<br style="clear:both;" />
	   
			
		<div class="main">
			<div>
			<table><tr><td>
				<table>
					<tr>
						<td>
							<div id="user_menu" class="menuGeneric">
								<ul>
									<li class="archive">
										<a id="MyMenu_HyperLink5" class="archive" href="<?php echo base_url(); ?>search">Travel Directory</a></li>
									<li class="contact">
										<a id="MyMenu_HyperLink2" class="archive" href="<?php echo base_url(); ?>users">User Accounts</a></li>
									<li class="archive">
										<a id="MyMenu_HyperLink6" class="archive" href="<?php echo base_url(); ?>maintenance">Maintenance</a></li>
									<li class="user">
									
									 <a id="MyMenu_LoginStatus3" class="archive" href="<?php echo base_url(); ?>logout">Logout</a>
										
									</li>
								</ul>
							</div>
						</td>
					</tr>
				</table>
			<!--/div-->
