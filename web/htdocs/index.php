<?php
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                : jonasge@gmx.net
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                   *
 *                                                                         *
 ***************************************************************************/
 ?>
<?php
	$seite=base64_encode("index.php");
	include("./login_check.inc.php");
	include("./header.inc.php");
	
?>	
	<h2 style="text-align:center"><?php echo $textdata[index_willkommen]; ?></h2><br />
	<div style="text-align:right;"><?php echo $textdata[index_zu];?> <i>Capi2Name</i>
	 <?php echo $textdata[index_Version];?> <b><?php echo $codenamen;?></b> 
	 (<?php echo $version;?>)</div>
	<br />
	
<?php
	if ($config['capi2name_status']=="yes" && $config['capisuite'] != "yes") {
		if (exec("ps -A | grep capi2name")!="") {
			$status_capi2name="<span style=\"color:blue\">$textdata[index_status_laeuft]</span>";
		} else {
			$status_capi2name="<span style=\"color:red\">$textdata[index_status_laeft_nicht]</span>";
		}
		echo "<br /><br /><div style=\"text-align:left\">$textdata[index_status_capi2name]: &nbsp; $status_capi2name</div>";
	}
	else if($config['capi2name_status']=="yes" && $config['capisuite'] == "yes") {
		if (exec("ps -A | grep capisuite")!="") {
			$status_capi2name="<span style=\"color:blue\">$textdata[index_status_laeuft]</span>";
		} else {
			$status_capi2name="<span style=\"color:red\">$textdata[index_status_laeft_nicht]</span>";
		}
		echo "<br /><br /><div style=\"text-align:left\">$textdata[index_status_capisuite]: &nbsp; $status_capi2name</div>";
	}
?>

<?php
	include("footer.inc.php");
?>
