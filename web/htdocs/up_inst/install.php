<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
 <head>
  <title>Capi2Name: database installation</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" /> 
 </head>
 <body bgcolor="Gray">
<br/>
<div style="text-align:center;color:blue;font-size:2em;font-weight:bold;">Capi2Name Database installation</div>
<br/>
<br/>

<?php
error_reporting(E_ALL);
if (!isset($_POST['install']))
{
	$c2n_passwd="";
	for ($i=0;$i<8;$i++)
	{
		$num = rand(48,120);
		while (($num >= 59 && $num <= 67) || ($num >= 80 && $num <= 99))
			$num = rand(48,120);
			$c2n_passwd .= chr($num);
	}
	echo "please enter <b>root password</b> and <b>hostname</b> of the database.<br/>
	The script creates a <b>new database and user with password for capi2name</b>.<br/>
	Please notice the capi2name username, password and the database name!
	<br/><br/>
	<form action=\"install.php\" method=\"post\">
	<table border=\"0\" style=\"margin-right:auto;margin-left:auto;text-align:left;\">
	<tr style=\"background-color:#124567;height:30px\">
	 <td style=\"width:250px;text-align:left;\">Database Hostname:</td>
	 <td style=\"width:10px;\"></td>
	 <td style=\"width:250px;text-align:left;\"><input name=\"dbhostname\" value=\"localhost\"/></td>
	</tr>
	<tr style=\"background-color:#124567;height:30px\">
	 <td style=\"width:250px;text-align:left;\">Database Admin:</td>
	 <td style=\"width:10px;\"></td>
	 <td style=\"width:250px;text-align:left;\"><input name=\"dbuadmin\" value=\"root\"/></td>
	</tr>
	<tr style=\"background-color:#124567;height:30px\">
	 <td style=\"width:250px;text-align:left;\">Database Admin password:</td>
	 <td style=\"width:10px;\"></td>
	 <td style=\"width:250px;text-align:left;\"><input name=\"dbpadmin\"  type=\"password\" value=\"\"/></td>
	</tr>
	<tr style=\"height:40px\">
	</tr>
	
	<tr style=\"background-color:#124567;height:30px\">
	 <td style=\"width:250px;text-align:left;\">Capi2Name user:</td>
	 <td style=\"width:10px;\"></td>
	 <td style=\"width:250px;text-align:left;\"><input name=\"dbucapi\" value=\"capi\"/></td>
	</tr>
	<tr style=\"background-color:#124567;height:30px\">
	 <td style=\"width:250px;text-align:left;\">Capi2Name user password:</td>
	 <td style=\"width:10px;\"></td>
	 <td style=\"width:250px;text-align:left;\"><input name=\"dbpcapi\" value=\"$c2n_passwd\"/></td>
	</tr>
	<tr style=\"background-color:#124567;height:30px\">
	 <td style=\"width:250px;text-align:left;\">Capi2Name database name:</td>
	 <td style=\"width:10px;\"></td>
	 <td style=\"width:250px;text-align:left;\"><input name=\"dbcapidb\" value=\"capidb\"/></td>
	</tr>
	
	<tr style=\"background-color:#124567;height:30px\">
	 <td colspan=\"3\" style=\"text-align:center;\">
	   <input type=\"submit\" value=\"start installation\" name=\"install\" /></td>
	</tr>
	</table>
	</form>
	"; //ende echo
}



if (isset($_POST['install']))
{
	if (!isset($_POST['dbhostname']) || empty($_POST['dbhostname']))
	{
		echo "<span style=\"text-weight:bold;color:red;\">No hostname entered!</span>";
		exit();
	}
	if (!isset($_POST['dbpcapi']) || empty($_POST['dbpcapi']))
	{
		echo "<span style=\"text-weight:bold;color:red;\">No capi2name user password entered!</span>";
		exit();
	}
	if (!isset($_POST['dbucapi']) || empty($_POST['dbucapi']))
	{
		echo "<span style=\"text-weight:bold;color:red;\">No capi2name user entered!</span>";
		exit();
	}
	if (!isset($_POST['dbcapidb']) || empty($_POST['dbcapidb']))
	{
		echo "<span style=\"text-weight:bold;color:red;\">No capi2name database name entered!</span>";
		exit();
	}
	if (!isset($_POST['dbuadmin']) || empty($_POST['dbuadmin']))
	{
		echo "<span style=\"text-weight:bold;color:red;\">No admin user entered!</span>";
		exit();
	}
	require("../includes/functions.php");
	
	$dataB->sql_connect($_POST['dbhostname'],$_POST['dbuadmin'],$_POST['dbpadmin'], "mysql");
	$dbcapidb=strip_tags($_POST['dbcapidb']);
	$dbucapi=strip_tags($_POST['dbucapi']);
	$dbpcapi=strip_tags($_POST['dbpcapi']);
	$sql_query=sprintf("CREATE DATABASE %s", $dbcapidb);
	$result=$dataB->sql_query($sql_query);
	if (!$result)
	{
		echo "<span style=\"text-weight:bold;color:red;\">ERROR: On creating database!<br>Mysql Says: </span>". mysql_error();
		exit();
	}
	
	$sql_query=sprintf("GRANT SELECT,UPDATE,ALTER,CREATE,DROP,INSERT,DELETE,INDEX ON %s.* TO '%s'@'localhost' IDENTIFIED BY '%s'",	$dbcapidb,$dbucapi,$dbpcapi);
	$result=$dataB->sql_query($sql_query);
	if (!$result)
	{
		echo "<span style=\"text-weight:bold;color:red;\">ERROR: On creating user!<br>Mysql Says: </span>". mysql_error();
		exit();
	}
	$result=$dataB->sql_query("flush privileges");
	if (!$result)
	{
		echo "<span style=\"text-weight:bold;color:red;\">ERROR: On flushing privileges!<br>Mysql Says: </span>". mysql_error();
		exit();
	}
	$dataB->sql_close();
	
	//login with new user:
	$dataB->sql_connect($_POST['dbhostname'],$dbucapi,$dbpcapi, $dbcapidb);
	$file=fopen("database.sql", "rb");
	$inhalt=fread($file, filesize("database.sql"));
	$array_inhalt=split("(;\n|;\r)",$inhalt);
	for($i=0;$i<sizeof($array_inhalt)-1; $i++)
	{
		$array_inhalt[$i]=trim($array_inhalt[$i]);
		$control=$dataB->sql_query($array_inhalt[$i]);
		if (!$control)
		{
			echo "<span style=\"text-weight:bold;color:red;\">ERROR: On creating database layout!<br>Mysql Says: </span>". mysql_error();
			exit();
		}
	}
	fclose($file);
	$dataB->sql_close();
	
	echo "<br/>installtion has finished. Check your conf.inc.php and delete the up_inst folder.";
	echo "
	<br/>
	Your <i>includes/conf.inc.php</i> should look like this:<br/>
<textarea cols=\"35\" rows=\"10\">


\$sql[\"host\"]          = \"$_POST[dbhostname]\";
\$sql[\"dbuser\"]        = \"$dbucapi\";
\$sql[\"dbpasswd\"]      = \"$dbpcapi\";
\$sql[\"db\"]            = \"$dbcapidb\";
</textarea><br/>
Dont' forget to update <i>/etc/capi2name.conf</i> with this user and password informations!!<br/>
	"; //echo ende
	
}//ende isset (absenden)

?>
</body>
</html>
