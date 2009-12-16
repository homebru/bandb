<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$page_title?></title>
<?php echo link_tag('css/style.css');?>
<?php echo link_tag('favicon.ico', 'shortcut icon', 'image/ico'); ?>
</head>

<body>
	<div>
		<?php
		echo $header.$content.$footer;
		?>
	</div>
</body>
</html>