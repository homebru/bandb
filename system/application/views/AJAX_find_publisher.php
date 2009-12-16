<?php
if (isset($record))
{
	foreach($record as $id=>$value) { ?>
		<br />
		Yes, <strong><?=$value?></strong> is in our system.
		<br />
		<br />
<?php } 
}
else
	0
?>