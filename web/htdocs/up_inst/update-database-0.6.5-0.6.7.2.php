<?php
session_start();
$host=$_SESSION['dbhost'];
$db=$_SESSION['dbname'];
$username=$_SESSION['dbuser'];
$passwd=$_SESSION['dbpasswd'];


echo "<br>Seite laed sich oefters neu bitte warten bis FERTIG da steht!!! danke....<br><br>";

if (!isset($_GET[start_id]))
 {
  
mysql_connect($host, $username, $passwd);
$result=mysql_db_query($db, "CREATE TABLE angerufene_ (
`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`rufnummer` varchar( 100 ) default NULL ,
`datum` varchar( 10 ) default NULL ,
`uhrzeit` time NOT NULL default '00:00:00',
`aktive` char( 1 ) default NULL ,
`name` text,
`msn` varchar( 100 ) default NULL ,
`vorwahl` varchar( 100 ) default NULL ,
`dienst` int( 11 ) default NULL ,
PRIMARY KEY ( `id` )
) TYPE = MYISAM");
if ($result==false)
  {
   echo "Error: ". mysql_error() . "<br>";
   exit("ERROR MYSQL");
  }
$result=mysql_db_query($db, "INSERT INTO `angerufene_`
SELECT * FROM `angerufene`");
if ($result==false)
   {
    echo "Error: ". mysql_error() . "<br>";
    exit("ERROR MYSQL");
   }
$result=mysql_db_query($db, "ALTER TABLE `angerufene` ADD `datum_` DATE AFTER `datum`");
if ($result==false)
   {
    echo "Error: " . mysql_error() . "<br>";
    exit("ERROR MYSQL");
   }
   mysql_close();
 

echo "<meta http-equiv=\"refresh\" content=\"3; URL=./update-database-0.6.5-0.6.7.2.php?start_id=0\">";
} //!isset  ENDE
else
 {
  $start_id=$_GET[start_id];
 
mysql_connect($host,$username, $passwd);
mysql_select_db($db);
$rows_anzahl=0;
$res_anzahl=mysql_query("SELECT * FROM angerufene");
$rows_anzahl=mysql_num_rows($res_anzahl);
 if ($rows_anzahl==false)
   {
    echo "ERROR: " . mysql_error();
    exit();
   }
$result=mysql_db_query($db, "SELECT * FROM angerufene LIMIT $start_id, 50");
 while($daten=mysql_fetch_array($result))
  {
    $teil=explode('.', $daten['datum']);
    $new_date="$teil[2]-$teil[1]-$teil[0]";
    $res=mysql_db_query($db, "UPDATE angerufene SET datum_='$new_date' WHERE id='$daten[id]'");
     if ($res==true) { echo "Eintrag $daten[id] neu geschrieben...<br>"; }
     else { echo "Eintrag FALSCH!!!$daten[id]::$daten[datum]<br>"; exit();  }
  }
$wert=$start_id+50;  
if ($wert <= $rows_anzahl)
  {
  
  echo "<meta http-equiv=\"refresh\" content=\"3; URL=./update-database-0.6.5-0.6.7.2.php?start_id=$wert\">";
  }
else
{
 

 $result=mysql_db_query($db, "ALTER TABLE `angerufene` DROP `datum` ");
 if ($result==false)
    {
        echo "Error: " . mysql_error() . "<br>";
        exit("ERROR MYSQL");
    }
 $result=mysql_db_query($db, "ALTER TABLE `angerufene` CHANGE `datum_` `datum` DATE DEFAULT NULL");
 if ($result==false)
    {
      echo "Error: " . mysql_error() . "<br>";
      exit("ERROR MYSQL");
    }
 echo "<font color=red><b>FERTIG</b></font>";
 echo "<br>Going to the update.php script now...... (10sec) please wait<br>";       
 echo "<meta http-equiv=\"refresh\" content=\"10; URL=./update.php?update=yes\">";
}
mysql_close();
}
?>
