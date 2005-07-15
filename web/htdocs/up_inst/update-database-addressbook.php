<?php
session_start();
$host=$_SESSION['dbhost'];
$db=$_SESSION['dbname'];
$username=$_SESSION['dbuser'];
$passwd=$_SESSION['dbpasswd'];


echo "<br>Please wait! This site will automaticly load hisself.<br>Please wait until at the button stands 'READY' --- Thank you.";

if (isset($_GET[start]))
{
	$start_id=$_GET[start];
}
else
{
	$start_id=0;
}
mysql_connect($host,$username, $passwd);
mysql_select_db($db);
$res_anzahl=mysql_query("SELECT id FROM adressbuch");
$rows_anzahl=mysql_num_rows($res_anzahl);
echo "Rows Anzahl: $rows_anzahl<br>";
$result=mysql_query("SELECT * FROM adressbuch LIMIT $start_id, 10");
while($daten=mysql_fetch_assoc($result))
 {
  $sql_query_addr="INSERT INTO addressbook VALUES('',
  	'$daten[vorname]', '$daten[nachname]',
	'$daten[strasse]', '$daten[hausnr]',
	'$daten[plz]', '$daten[ort]', '$daten[email]')";
  $res=mysql_query($sql_query_addr);
   if (!$res)
    {
     echo "<br>Error in Insert new data to the new addressbook table.<br>";
     echo "Mysql-Says: <br> ". mysql_error();
    }
  $last_id=mysql_insert_id();
  $tele_array=array("tele1", "tele2", "tele3");
  for ($i=0;$i<=2;$i++)
  { //FOR
  $tele=$tele_array[$i];
  if ($daten[$tele]!= "99")
   {
    echo "<br>Adding $tele to new phonenumbers table...<br>";
     $tab_vorwahl=mysql_query("SELECT * FROM vorwahl");
     $prefix=0;
     while($vorwahl_row=mysql_fetch_assoc($tab_vorwahl))
      {
       $laenge=strlen($vorwahl_row[vorwahlnr]);
       $vorwahl_nr=substr($daten[$tele],0,$laenge);
         if($vorwahl_row[vorwahlnr]==$vorwahl_nr)
	  { 
	   echo "found prefix in prefix table, addin prefix-gr.id to phonenumbers";
	   $prefix=$vorwahl_row[id];
	   break;
	  }
      }//while vorwahl END
    $sql_query_phonenumber="INSERT INTO phonenumbers VALUES('','$last_id',
    	'$daten[$tele]', '1', '$prefix')";
    $res=mysql_query($sql_query_phonenumber);
     if (!$res)
      {
       echo "<br>Error in Insert new data to the phonenumber table<br>";
       echo "Mysql-Says: <br>". mysql_error();
      }
   }
  } // FOR END
  //CELL PHONE BEGIN:
    if ($daten[handy]!= "99")
   {
    echo "<br>Adding cell phone to new phonenumbers table...<br>";
    $sql_query_phonenumber="INSERT INTO phonenumbers VALUES('','$last_id',
    	'$daten[handy]', '2', '2')";
    $res=mysql_query($sql_query_phonenumber);
     if (!$res)
      {
       echo "<br>Error in Insert new data to the phonenumber table<br>";
       echo "Mysql-Says: <br>". mysql_error();
      }
   }
   //CELL PHONE END
   //FAX NUMBER BEGIN
   if ($daten[fax]!= "99" && $daten[fax]!="")
   {
    echo "<br>Adding fax to new phonenumbers table...<br>";
     $tab_vorwahl=mysql_query("SELECT * FROM vorwahl");
     $prefix=0;
     while($vorwahl_row=mysql_fetch_assoc($tab_vorwahl))
      {
       $laenge=strlen($vorwahl_row[vorwahlnr]);
       $vorwahl_nr=substr($daten[fax],0,$laenge);
         if($vorwahl_row[vorwahlnr]==$vorwahl_nr)
	  { 
	   echo "found prefix in prefix table, addin prefix-gr.id to phonenumbers";
	   $prefix=$vorwahl_row[id];
	  }
      }//while vorwahl END
    $sql_query_phonenumber="INSERT INTO phonenumbers VALUES('','$last_id',
    	'$daten[fax]', '3', '$prefix')";
    $res=mysql_query($sql_query_phonenumber);
     if (!$res)
      {
       echo "<br>Error in Insert new data to the phonenumber table<br>";
       echo "Mysql-Says: <br>". mysql_error();
      }
   }
   //FAX NUMBER END
   
   
   
 }//ende while
$wert=$start_id+10;
echo "<br>Wert: $wert<br>Rows: $rows_anzahl";
if ($wert <= $rows_anzahl)
 {
	mysql_close();
	echo "<meta http-equiv=\"refresh\" content=\"1; URL=./update-database-addressbook.php?start=$wert\">";
 }
 else
 {
  //adressbuch muss umbenannt werden!!!!!!!!!!!!!!!!!
  mysql_query("ALTER TABLE `adressbuch` RENAME `adressbuchOLD`");
  mysql_close();
  echo "<font color=\"red\"><b><br>READY</b></font><br/>Wait 10 secundes.br/> You will be forwarded to update.php";
  echo "<meta http-equiv=\"refresh\" content=\"10; URL=./update.php\">";
 }
?>