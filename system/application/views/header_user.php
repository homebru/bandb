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
<!--
var theForm = document.forms['searchForm'];
if (!theForm) {
    theForm = document.searchForm;
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
       
        if (obj.name == "chkClass$0")
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
            if (chkBoxCount[i].name != "chkClass$1")  {
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
            if (chkBoxCount[i].name == "chkClass_0" || chkBoxCount[i].name == "chkClass_1"  )  {
            chkBoxCount[i].checked = false;}
            
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

 
function confApprove(id, imageButton)
{

  var ok = confirm('Are you sure you want to remove this?');    
    if (ok)                        
    {   
        //change the trashcan icon into an animated  ajax loading icon     
        imageButton.src = 'Images/icon-save.gif';
        //call the webservice execute the delete action
    }
    else
    {
        imageButton.src = 'Images/icon-cancel.gif';
    }            


}

//-->
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
										<a id="MyMenu_HyperLink1" class="archive" href="<?php echo base_url(); ?>search/my">My List</a></li>
									<li class="archive">
										<a id="MyMenu_HyperLink5" class="archive" href="<?php echo base_url(); ?>search">Travel Database</a></li>
								 	<li class="archive">
										<a id="MyMenu_HyperLink6" class="archive" href="<?php echo base_url(); ?>profile">My Account</a></li>        
									<li class="archive">
										<a id="MyMenu_HyperLink2" class="archive" href="<?php echo base_url(); ?>glossary">Intro</a></li>
									<li class="archive">
										<a id="MyMenu_HyperLink3" class="archive" href="<?php echo base_url(); ?>about_us">About Us</a></li>
									<li class="archive">
										<a id="MyMenu_HlArchive" class="archive" href="<?php echo base_url(); ?>contact_us">Contact Us</a></li>
									<li class="archive">
										<a id="MyMenu_HyperLink7" class="archive" href="<?php echo base_url(); ?>gds">GDS</a></li>
									<li class="archive">
										<a id="MyMenu_HyperLink4" class="archive" href="<?php echo base_url(); ?>blog">Blog</a></li>
									<li class="archive">
										<a id="MyMenu_LoginStatus3" class="archive" href="<?php echo base_url(); ?>logout">Logout</a></li>
								</ul>
							</div>
						</td>
					</tr>
				</table>
			<!--/div-->
