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
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
//check if template is avaiable in the template-Directory
function check_template($check)
{
 $is_template=false; 
 $dir= "templates";
 $dh=opendir($dir);
 while (false!== ($filename=readdir($dh)))
   {
    if ($filename!="." AND $filename!=".." AND $filename!="index.html")
     {
      $files[] =$filename;
     }
   }
 foreach ($files as $value)
  {
   if ($value==$check)
    {
     $is_template=true;
    }
  }
  return $is_template;  
}

//funktions......
function mysql_datum($old) //wandle mysql datum in deutsch datum um
{
	$teil=explode("-", $old);
	$neu="$teil[2].$teil[1].$teil[0]";
	return $neu;
}

function datum_mysql($old) //wandle deutsch datum in mysql datum um
{
	$teil=explode('.', $old);
	$neu="$teil[2]-$teil[1]-$teil[0]";
	return $neu;
}

function msns_ueberpruefen($msns,$msn) {
	$wert=false;
	if($msns!="") {
		$array=explode(",", $msns);
		for($x=0;$x<count($array);$x++) {
			if($msn==$array[$x]) { $wert=true; }
		}
	}
	else { $wert=true; }
	return $wert;
}
function cellphone_number($number)
 {
  $cellphoneprefix=160;
  $wert=false;
  $prefix=substr($number,1,3);
  while($cellphoneprefix<180)
   {
    if ($prefix==$cellphoneprefix) $wert=true;
    $cellphoneprefix++;
   }
  return $wert;
 }

function get_id_from_prefix($number)
 {
      $tab_vorwahl=mysql_query("SELECT * FROM vorwahl");
      $prefix=0;
       while($vorwahl_row=mysql_fetch_assoc($tab_vorwahl))
        {
          $laenge=strlen($vorwahl_row[vorwahlnr]);
          $vorwahl_nr=substr($number,0,$laenge);
          if($vorwahl_row[vorwahlnr]==$vorwahl_nr)
	   { 
	    $typ=$vorwahl_row[id];
	    break;
	   }
      }//while vorwahl END
   return $typ;
 }
 

function handynr_vorhanden($nummer) //pruefe ob Handy Nr vorhanden, wegen add adressbuch
{
	$handyvorwahl=160;
	$handynummer="0";
	$teilvondata1=substr($nummer, 1,3);
	while ($handyvorwahl<180) {
		if ($teilvondata1==$handyvorwahl) { $handynummer="1"; }
		$handyvorwahl++;
	}
	if ($handynummer=="1") $wert="handy=$nummer";
	else $wert="rufnr=$nummer";
	return $wert;
}

function msnzuname($msn) {
	$result_msn=@mysql_query("SELECT name FROM msnzuname WHERE msn='$msn'") or die ("<br>ERROR: msnzuname-Query<br>".mysql_error());
	$data_msn=@mysql_fetch_array($result_msn);
	if ($data_msn==true)
	{
		$wert=$data_msn[name];
	}
	else
	{
		$wert=$msn;
	}
	return $wert;
}

function ermittle_typ_anruf($nummer) {
	$wert="";
	if ($nummer=="1" || $nummer=="2" || $nummer=="3" || $nummer=="4" || $nummer=="5")
		{
		$wert="Telefon";
		}
	if ($nummer=="6" || $nummer=="7")
		{
		$wert="Daten/Fax";
		} 
	return $wert;
}

function anzeige_datum($wert)
 {
  if ($wert==date("d.m.Y"))
  {
   $anz_datum="Heute";
  }
else if ($wert== date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")-1, date("Y"))))
  {
   $anz_datum="Gestern";
  }
else
  {
   $anz_datum=$wert;
  }
  return $anz_datum;
 }

class sql_zugriff
 {
   var $dbconnect_id;
   var $query_result;
    
    function connect_mysql($dbhost,$dbuser,$dbpasswd,$db)
     { 
      $this->sql_host=$dbhost;
      $this->sql_user=$dbuser;
      $this->sql_passwd=$dbpasswd;
      $this->sql_db=$db;
      
       $this->dbconnect_id=@mysql_connect($this->sql_host,
       					 $this->sql_user,
					 $this->sql_passwd);
       if($this->dbconnect_id)
        {
	  if($this->sql_db!="")
	   {
	     if(@mysql_select_db($this->sql_db))
	      {
	       return $this->dbconnect_id;
	      }
	     else
	      {
	       echo "<br>Mysql-Database Select faild.<br>Mysql-Says: ".mysql_error();
	      }
	   }
	  else
	   {
	    echo "<br>Mysql-Database Field is emty. Please check conf.inc.php!";
	    die();
	   }
	}
       else
        {
	 echo "<br>Connection to Mysql fails...<br>Mysql-Says: ". mysql_error();
	 die();
	}
     } //function connect_mysql ENDE
   
   function close_mysql()
    {
     if (@mysql_close($this->dbconnect_id))
       {
        return true;
       }
      else
       {
        echo "<br>Close to Mysql fails.<br>Mysql-Says: ".mysql_error();
       }
    }//function close_mysql ENDE
   
  function sql_abfrage($sql_query)
    {
     if($sql_query!="")
      {
        $this->query_result=@mysql_query($sql_query, $this->dbconnect_id);
	return $this->query_result;
      }
     else
      {
       echo "Mysql-Query is emty! If you are not an developer, you have found a bug. Please report it.";
       die();
      }
    }
   
  
   
 }//class sql_zugriff ENDE
//funktions............ENDE	
//class enable:
$zugriff_mysql=new sql_zugriff;


?>