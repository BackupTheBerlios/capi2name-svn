<?php
/*
    copyright            : (C) 2002-2005 by Jonas Genannt
    email                : jonas.genannt@capi2name.de
 ***************************************************************************/

/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   any later version.                                                    *
 *                                                                         *
 ***************************************************************************/
function check_exec_prog($prog_name)
{
	if (!is_executable($prog_name))
	{
		echo "Not Found: ". $prog_name;
		echo " ->> Check path to program!";
		die();
	}
}
function check_cs_username($cs_user)
{
	 $a = exec("id -g $cs_user",$a, $retval);
	 return $retval;
}
function strip_number($number) 
{
	$number=str_replace("/","",$number);
	$number=str_replace("-","",$number);
	$number=str_replace(" ","",$number);
	$number=trim($number);
	return $number;
}
function fill_sessions($row_userlist)
{
	
	$_SESSION['realname']=$row_userlist['name_first']." ".$row_userlist['name_last'];
	$_SESSION['username']=$row_userlist['username'];
	$_SESSION['password']=$row_userlist['passwd'];
	$_SESSION['userid']=$row_userlist['id'];
	$_SESSION['cs_user']=$row_userlist['cs_user'];
	$_SESSION['show_callback']=$row_userlist['show_callback'];
	$_SESSION['show_prefix']=$row_userlist['show_prefix'];
	$_SESSION['show_msn']=$row_userlist['show_msn'];
	$_SESSION['show_config']=$row_userlist['show_config'];
	$_SESSION['show_type']=$row_userlist['show_type'];
	$_SESSION['allow_delete']=$row_userlist['allow_delete'];
	$_SESSION['show_lines']=$row_userlist['show_lines'];
	$_SESSION['msn_listen']=$row_userlist['msn_listen'];
	$_SESSION['show_linktoam']=$row_userlist['show_linktoam'];
	$_SESSION['show_sfcallnr']=$row_userlist['show_sfcallnr'];
	$_SESSION['refresh_time']=$row_userlist['refresh_time'];
}

function split_number($tel_number,$prefix_nr) //split number in $prefix / $number
{
	if ($prefix_nr)
	{
		$len_prefix=strlen($prefix_nr);
		$teil_1=substr($tel_number,0,$len_prefix);
		$teil_2=substr($tel_number,$len_prefix,strlen($tel_number));
		return $teil_1. " / ".$teil_2;
	}
	else
	{
		return $tel_number;
	}
	
}

function split_cellphone($number)
{
	$teil_1=substr($number,0,4);
	$teil_2=substr($number,4,strlen($number));
	return $teil_1. " / ".$teil_2;
}

function fill_template_session($daten_config,$daten_config1,$u_template)
{
	if (!$daten_config['value'])
	{
		if (check_template($u_template))
		{
			$_SESSION['template']=$u_template;
		}
		else
		{
			$_SESSION['template']=$daten_config1['value'];
		}
	}
	else
	{
		$_SESSION['template']=$daten_config['value'];
	}
}
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
    if ($prefix==$cellphoneprefix) {
     $wert=true;
     break;
    }
    $cellphoneprefix++;
   }
  return $wert;
 }

function get_id_from_prefix($number)
 {
      $tab_vorwahl=mysql_query("SELECT * FROM vorwahl");
      $typ=0;
      $prefix=0;
       while($vorwahl_row=mysql_fetch_assoc($tab_vorwahl))
        {
          $laenge=strlen($vorwahl_row['vorwahlnr']);
          $vorwahl_nr=substr($number,0,$laenge);
          if($vorwahl_row['vorwahlnr']==$vorwahl_nr)
	   { 
	    $typ=$vorwahl_row['id'];
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
		if ($teilvondata1==$handyvorwahl) {
		  $handynummer="1";
		  break;
		}
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

function anzeige_datum($wert, $today,$yesterday)
 {
  if ($wert==date("d.m.Y"))
  {
   $anz_datum=$today;
  }
else if ($wert== date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")-1, date("Y"))))
  {
   $anz_datum=$yesterday;
  }
else
  {
   $anz_datum=$wert;
  }
  return $anz_datum;
 }


 
 
 
/*-------------------------------------------------------------------------------
                      MYSQL-CONNECTION CLASS
--------------------------------------------------------------------------------*/
class c_mysql
 {
   var $dbconnect_id;
   var $query_result;
   var $fetch_result;
   var $num_rows_result;
    
    function sql_connect($dbhost,$dbuser,$dbpasswd,$db)
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
   
   function sql_close()
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
   
  function sql_check($value)
    {
     if (get_magic_quotes_gpc()) {
     	$value=stripslashes($value);
	}
     $value = strip_tags($value);
     $value = "'" . mysql_real_escape_string($value) . "'";
     return $value;
    }
   function sql_checkn($value)
    {
     if (is_numeric($value))
     {
      if (get_magic_quotes_gpc()) {
     	$value=stripslashes($value);
	 }
      $value = strip_tags($value);
      $value = "'" . mysql_real_escape_string($value) . "'";
      return $value;
     }
    else
     {
      return -1;
     }
    }
  function sql_query($sql_query)
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
   
  function sql_fetch_assoc($data)
   {
    if($data!=NULL)
     {
      $this->fetch_result=@mysql_fetch_assoc($data);
      return $this->fetch_result;
     }
    else
     {
      return false;
     }
   }
  function sql_return_last_id($result)
   {
    return mysql_insert_id();
   } 
   function sql_num_rows($res)
   {
    $this->num_rows_result=@mysql_num_rows($res);
    return $this->num_rows_result;
   }
   
 }
/*----------------------------------------------------------------------------
                  MYSQL CONNECTION CLASS END
----------------------------------------------------------------------------*/ 
 




/*-------------------------------------------------------------------------------
                      POSTGRE-CONNECTION CLASS
--------------------------------------------------------------------------------*/
class c_postgre
 {
   var $dbconnect_id;
   var $query_result;
   var $fetch_result;
   var $num_rows_result;
    
    function sql_connect($dbhost,$dbuser,$dbpasswd,$db)
     { 
      $this->sql_host=$dbhost;
      $this->sql_user=$dbuser;
      $this->sql_passwd=$dbpasswd;
      $this->sql_db=$db;
   
       $this->dbconnect_id=@pg_connect("host=$this->sql_host port=5432 dbname=$this->sql_db user=$this->sql_user password=$this->sql_passwd");
      if($this->sql_db=="")
	   {
       echo "<br>Postgre-Database Field is emty. Please check conf.inc.php!";
	die();
	   }
       if(!$this->dbconnect_id)
        {
	 echo "<br>Connection to Postgres fails...<br>Postgre-Says: ". pg_last_error();
	 die();
	}
     } //function connect_mysql ENDE
   
   function sql_close()
    {
     if (@pg_close($this->dbconnect_id))
       {
        return true;
       }
      else
       {
        echo "<br>Close to Postgre fails.<br>Postgre-Says: ".pg_last_error();
       }
    }//function close_mysql ENDE
   
  function sql_query($sql_query)
    {
     if($sql_query!="")
      {
        $this->query_result=@pg_query($sql_query);
	return $this->query_result;
      }
     else
      {
       echo "Postgre-Query is emty! If you are not an developer, you have found a bug. Please report it.";
       die();
      }
    }
   
  function sql_fetch_assoc($data)
   {
    if($data!=NULL)
     {
      $this->fetch_result=@pg_fetch_assoc($data);
      return $this->fetch_result;
     }
    else
     {
      return false;
     }
   }
 function sql_return_last_id($result)
   {
    return pg_last_oid($result);
   } 
 function sql_num_rows($res)
   {
    $this->num_rows_result=@pg_num_rows($res);
    return $this->num_rows_result;
   }
   
 }
/*----------------------------------------------------------------------------
                 POSTGRE CONNECTION CLASS END
----------------------------------------------------------------------------*/ 
 






//class sql_zugriff ENDE
//funktions............ENDE	
//class enable:
//$dbuse='c_postgre';
$dbuse='c_mysql';
$dataB=new $dbuse;


?>