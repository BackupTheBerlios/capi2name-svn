<?
session_start();
?>
<html>
 <head>
   <title>Datenbank Update</title>
 </head>
<body>

<?php


if (!isset($_POST[absenden]) && !isset($_GET[update]))
 {

 echo "<br/><br/>please enter the connect informations for access the database.<br/><br/>";
  echo "<form action=\"$PHP_SELF\" method=\"post\">
   
  <table border=\"0\" style=\"margin-right:auto;margin-left:auto;text-align:left;\">
    <tr>
     <td style=\"text-align:left;\">database hostname:</td>
     <td style=\"width:10px;\"></td>
     <td ><input name=\"dbhost\" value=\"localhost\"/></td>
    </tr>
    <tr>
     <td style=\"text-align:left;\">database username:</td>
     <td style=\"width:10px;\"></td>
     <td><input name=\"dbuser\"/></td>
    </tr>
    <tr>
     <td style=\"text-align:left;\">database password:</td>
     <td style=\"width:10px;\"></td>
     <td><INPUT name=\"dbpasswd\" type=\"password\"/></td>
    </tr>
    <tr>
     <td style=\"text-align:left;\">database name:</td>
     <td style=\"width:10px;\"></td>
     <td><input name=\"dbname\"/></td>
    </tr>
    <tr>
     <td colspan=\"3\" style=\"text-align:center;\">
      <input name=\"absenden\" type=\"submit\" name=\"start update...\">
     </td>
    </tr>
   </table>
  
  </form>
  
  
  "; 
 }


if (isset($_POST[absenden]) or isset($_GET[update]))
 {
if (isset($_POST[absenden]))
{ 
$dbuser=$_POST[dbuser];
$dbpasswd=$_POST[dbpasswd];
$dbname=$_POST[dbname];
$dbhost=$_POST[dbhost];
$_SESSION['dbuser']=$dbuser;
$_SESSION['dbpasswd']=$dbpasswd;
$_SESSION['dbname']=$dbname;
$_SESSION['dbhost']=$dbhost;
}
else
{
$dbuser=$_SESSION['dbuser'];
$dbpasswd=$_SESSION['dbpasswd'];
$dbname=$_SESSION['dbname'];
$dbhost=$_SESSION['dbhost'];

}


//Variablen:
$capi_version_tabelle=false;
$db_layout_version="";
$db_layout_neue_version="0.6.7.2";

echo "<br><b>Warten bis unten in Grün OK
steht<br></b><br>";


do{

$control=mysql_connect($dbhost,$dbuser,$dbpasswd);
  if ($control==FALSE)
      {
       echo "Verbindung (Connect) fehlgeschlagen!\nMysql-Error: ". mysql_error() ;
       die();
      }

$control=mysql_select_db($dbname);
  if ($control==FALSE)
   {
    echo "Verbindung (Select_DB) fehlgeschlagen!\nMysql-Error: ". mysql_error();
    die();
   }

$result=mysql_list_tables($dbname);
   if ($result==FALSE)
     {
      echo "Fehler: (mysql_list_tables)!\nMysql-Error: ". mysql_error();
      die();
     }

while ($row=mysql_fetch_row($result))
  {
   //echo "Tabelle: $row[0]<br>";
     if ($row[0]=="capi_version")
      {
       echo "Tabelle capi_version gefunden! - DB-Layout: < 0.6<br><br>";
       $capi_version_tabelle=true;
      }
  }






/******************************************************************
   CAPI2NAME DB-Layout ueber 0.6 ANFANG
*******************************************************************/
if ($capi_version_tabelle==true)
{
$result=mysql_query("SELECT version FROM capi_version WHERE id=1");
 if($result==false)
  {
   echo "Mysql-Query fehlgeschlagen!<br>Mysql-Error: ". mysql_error();
   die();
  }
$row=mysql_fetch_row($result);
$db_layout_version=$row[0];

 
}
/********************************************************************
  CAPI2NAME DB-Layout ueber 0.6 ENDE
********************************************************************/





/*********************************************************************
   CAPI2NAME DB-Layout unter 0.6 ANFANG
*********************************************************************/
if($capi_version_tabelle==false)
 {
  echo "Capi2Name DB-Layout unter 0.6 gefunden! Erkennung wird gestartet............<br><br>"; 
  
  $result=mysql_list_fields($dbname, "userliste");
   if($result==FALSE)
    {
     echo "Fields Error!<br>Mysql-Error: ". mysql_error();
     die();
    }
  $columns=mysql_num_fields($result); 
  $felder=$columns;    
  //echo "Felder in der Tabelle userliste: $felder<br>";
  if ($felder==6) $db_layout_version="0.1";
  if ($felder==9) $db_layout_version="0.2";
  if ($felder==10) $db_layout_version="0.3"; 
  if ($felder==12) $db_layout_version="0.5";
  
 }
/*********************************************************************
   CAPI2NAME DB-Layout unter 0.6 ENDE
**********************************************************************/






/****************************************
****************************************/
echo "<br><b>DB-Version gefunden: $db_layout_version</b><br>";


/***************************************** Version 0.1 auf 0.2
********************************************************************/
if ($db_layout_version=="0.1")
 {
  echo "Found Version 0.1 updating now to 0.2.........<br>";
  
 $control=mysql_select_db($dbname);
  if ($control==FALSE)
   {
    echo "Verbindung (Select_DB) fehlgeschlagen!\nMysql-Error: ". mysql_error();
    die();
   }
 
 $file=fopen("update-database-0.1-0.2.sql", "rb");
 $inhalt= fread ($file, filesize("update-database-0.1-0.2.sql"));
  $array_inhalt=split("(;\n|;\r)",$inhalt);

   for($i=0;$i<sizeof($array_inhalt)-1; $i++)
     {
      $array_inhalt[$i]=trim($array_inhalt[$i]);
      $control=mysql_query($array_inhalt[$i]);
       if ($control==FALSE)
        {
          echo "Insert fehlgeschlagen: $array_inhalt[$i]<br>Mysql-Error: ". mysql_error();
          die();
         }
     }

fclose($file);

   
   
   
    
 }
/************************ENDE Version 0.1 auf 0.2****************
*************************************************************/


/***********************ANFANG Version 0.2 auf 0.3 ****************
*******************************************************************/
if ($db_layout_version=="0.2")
 {
  echo "Found Version 0.2 updating to 0.3............<br>";
  $control=mysql_select_db($dbname);
  if ($control==FALSE)
   {
    echo "Verbindung (Select_DB) fehlgeschlagen!\nMysql-Error: ". mysql_error();
    die();
   }
  $file=fopen("update-database-0.2-0.3.sql", "rb");
 $inhalt= fread ($file, filesize("update-database-0.2-0.3.sql"));
  $array_inhalt=split("(;\n|;\r)",$inhalt);

   for($i=0;$i<sizeof($array_inhalt)-1; $i++)
     {
      $array_inhalt[$i]=trim($array_inhalt[$i]);
      $control=mysql_query($array_inhalt[$i]);
       if ($control==FALSE)
        {
          echo "Insert fehlgeschlagen: $array_inhalt[$i]<br>Mysql-Error: ". mysql_error();
          die();
         }
     }

fclose($file);
   
 }
/**********************ENDE Version 0.2 auf 0.3********************
******************************************************************/




/***********************ANFANG Version 0.3-0.4 auf 0.5 ****************
*******************************************************************/
if ($db_layout_version=="0.3")
 {
  echo "Found Version 0.3 or 0.4  updating to 0.5...........<br>";
  $control=mysql_select_db($dbname);
  if ($control==FALSE)
   {
    echo "Verbindung (Select_DB) fehlgeschlagen!\nMysql-Error: ". mysql_error();
    die();
   }
    $file=fopen("update-database-0.4-0.5.sql", "rb");
 $inhalt= fread ($file, filesize("update-database-0.4-0.5.sql"));
  $array_inhalt=split("(;\n|;\r)",$inhalt);

   for($i=0;$i<sizeof($array_inhalt)-1; $i++)
     {
      $array_inhalt[$i]=trim($array_inhalt[$i]);
      $control=mysql_query($array_inhalt[$i]);
       if ($control==FALSE)
        {
          echo "Insert fehlgeschlagen: $array_inhalt[$i]<br>Mysql-Error: ". mysql_error();
          die();
         }
     }

fclose($file);
   
 }
/**********************ENDE Version 0.3-0.4 auf 0.5********************
******************************************************************/



/********************ANFANG Version 0.5 auf 0.6**********************
*********************************************************************/
if ($db_layout_version==0.5)
{
  echo "Found Version 0.5 updating to 0.6...........<br>";
  $control=mysql_select_db($dbname);
  if ($control==FALSE)
   {
    echo "Verbindung (Select_DB) fehlgeschlagen!\nMysql-Error: ". mysql_error();
    die();
   }
  
    $file=fopen("update-database-0.5.2-0.6.sql", "rb");
 $inhalt= fread ($file, filesize("update-database-0.5.2-0.6.sql"));
  $array_inhalt=split("(;\n|;\r)",$inhalt);

   for($i=0;$i<sizeof($array_inhalt)-1; $i++)
     {
      $array_inhalt[$i]=trim($array_inhalt[$i]);
      $control=mysql_query($array_inhalt[$i]);
       if ($control==FALSE)
        {
          echo "Insert fehlgeschlagen: $array_inhalt[$i]<br>Mysql-Error: ". mysql_error();
          die();
         }
     }

fclose($file);

  
}
/*********************ENDE Version 0.5 auf 0.6***********************
********************************************************************/




/********************ANFANG Version 0.6 auf 0.6.5**********************
*********************************************************************/
if ($db_layout_version=="0.6")
{
  echo "Found Version 0.6 updating to 0.6.5...........<br>";
  $control=mysql_select_db($dbname);
  if ($control==FALSE)
   {
    echo "Verbindung (Select_DB) fehlgeschlagen!\nMysql-Error: ". mysql_error();
    die();
   }
  
      $file=fopen("update-database-0.6-0.6.5.sql", "rb");
 $inhalt= fread ($file, filesize("update-database-0.6-0.6.5.sql"));
  $array_inhalt=split("(;\n|;\r)",$inhalt);

   for($i=0;$i<sizeof($array_inhalt)-1; $i++)
     {
      $array_inhalt[$i]=trim($array_inhalt[$i]);
      $control=mysql_query($array_inhalt[$i]);
       if ($control==FALSE)
        {
          echo "Insert fehlgeschlagen: $array_inhalt[$i]<br>Mysql-Error: ". mysql_error();
          die();
         }
     }

fclose($file);
  
}
/***************************ENDE Version 0.6 auf 0.6.5*******************
**********************************************************************/


/****************************Version 0.6.5 auf 0.6.7.2*********************
***************************************************************************/
if ($db_layout_version=="0.6.5")
 {
  echo "Found Version 0.6.5 updating to 0.6.7.2...........<br>";
  $control=mysql_select_db($dbname);
  if ($control==FALSE)
   {
    echo "Verbindung (Select_DB) fehlgeschlagen!\nMysql-Error: ". mysql_error();
    die();
   }
 $control=mysql_query("UPDATE capi_version SET version='0.6.7.2' WHERE id='1'");
if ($control==FALSE)
        {
          echo "Insert fehlgeschlagen: <br>Mysql-Error: ". mysql_error();
          die();
         } 
  echo "<br>Big database update. Starting his own script. Please wait........"; 
  echo "<meta http-equiv=\"refresh\" content=\"0; URL=./update-database-0.6.5-0.6.7.2.php\">";
  sleep(5);

 }
/*************************ENDE Version 0.6.5 auf 0.6.7.2 ************************
***************************************************************************/


$control=mysql_close();
  if ($control==FALSE)
   {
     echo "Verbingun (Close) fehlgeschlagen!\nMysql-Error: ". mysql_error();
	die();
   }
}

while($db_layout_version!=$db_layout_neue_version);
if ($db_layout_version==$db_layout_neue_version)
 {
 echo "<br><br><font color=green>OK! DB-Layout update fertig!</font><br>";
 }

}//ende isset (absenden)

?>
</BODY>
</HTML>
