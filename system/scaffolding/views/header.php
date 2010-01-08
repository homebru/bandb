<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title><?php echo $title; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />

<!--link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/default.css" /-->
<link rel="shortcut icon" href="<?php echo $image_url; ?>favicon.ico" />
<?php //echo link_tag('favicon.ico', 'shortcut icon', 'image/ico'); ?>

<style type='text/css'>
<?php $this->file(BASEPATH.'scaffolding/views/stylesheet.css'); ?>
</style>

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

<div id="header">
<div id="header_left">
<h3><?php echo $this->uri->rsegment(1) ?>:&nbsp; <?php echo $title; ?></h3>
</div>
<div id="header_right">
<?php echo anchor(array($this->uri->rsegment(1), 'maintain/view'), $scaff_view_records); ?> &nbsp;&nbsp;|&nbsp;&nbsp;
<?php echo anchor(array($this->uri->rsegment(1),'maintain/add'),  $scaff_create_record); ?>
</div>
</div>

<br clear="all">
<div id="outer">