<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $page_title; ?></title>
<?php if($this->uri->total_segments() == 0): ?>
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
<?php else :?>
<link href="<?php echo base_url(); ?>css/default.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

<link href="<?php echo base_url(); ?>favicon.ico" rel="shortcut icon" type="image/ico" />

<script src="<?php echo base_url(); ?>scripts/jquery-1.3.2.min.js" type="text/javascript"></script>

<?php if(strpos($_SERVER['PHP_SELF'],'search') > -1):?>
<script src="<?php echo base_url(); ?>scripts/search_scripts.js" type="text/javascript"></script>
<?php endif; ?>

<?php if(strpos($_SERVER['PHP_SELF'],'publishers') > -1):?>
	<script src="<?php echo base_url(); ?>scripts/publishers.js" type="text/javascript"></script>
<?php endif; ?>

<?php if(strpos($_SERVER['PHP_SELF'],'detail') > -1):?>
	<link href="<?php echo base_url(); ?>css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url(); ?>scripts/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {
			$("#txtExpiry").datepicker();
		});
	</script>
<?php endif; ?>

</head>

<body>
	<div style="background-color:#ffffff;">
		<div id="Header">
			<div class="holder">
				<h1 class="logo">
					<a href="#">Inn Strategy</a></h1>
				<div class="headImg">
				</div>
				<div class="leftTxt">
					Online Advertising Intelligence</div>
			</div>
		</div>
		<div id="Nav">
			<div class="holder">
				<ul>
					<li><a <?php echo $this->uri->segment(1) === 'login' ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?><?php echo logged_in() ? 'logout">Logout' : 'login">Login'; ?></a></li>
					<li><a <?php echo $this->uri->segment(1) === 'contact_us' ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>contact_us">Contact Us</a></li>
					<li><a <?php echo $this->uri->segment(1) === 'blog' ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>blog">Blog</a></li>
					<?php if($this->auth->logged_in()) { ?>
						<li><a <?php echo $this->uri->segment(1) === 'gds' ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>gds">GDS</a></li>
						<li><a <?php echo $this->uri->segment(1) === 'profile' ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>profile<?php echo ($this->uri->segment(2) === 'demo') ? '/demo' : ''; ?>">My Account</a></li>        
						<li><a <?php echo (($this->uri->segment(1) === 'search') && ($this->uri->segment(2) !== 'my')) ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>search<?php echo ($this->uri->segment(2) === 'demo') ? '/demo' : ''; ?>">Travel Database</a></li>
						<li><a <?php echo (($this->uri->segment(2) === 'my') || ($this->uri->segment(3) === 'my')) ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>search<?php echo ($this->uri->segment(2) === 'demo') ? '/demo' : ''; ?>/my">My List</a></li>
					<?php } else { ?>
						<li><a <?php echo $this->uri->segment(1) === 'publishers' ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>publishers">Publishers</a></li>
						<li><a <?php echo $this->uri->segment(1) === 'pricing' ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>pricing">Our Services</a></li>
					<?php } ?>
					<li><a <?php echo $this->uri->segment(1) === 'glossary' ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>glossary">Glossary</a></li>
					<li><a <?php echo $this->uri->segment(1) === 'about_us' ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>about_us">About Us</a></li>
					<li><a <?php echo $this->uri->total_segments() == 0 ? 'class="on"' : ''; ?> href="<?php echo base_url(); ?>">Home</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div style="background-color:#ffffff; <?php echo $this->uri->total_segments() == 0 ? '' : 'padding:8px;'; ?>">
	<!--div class="holder2">	   
			
		<!--div class="gds"-->
