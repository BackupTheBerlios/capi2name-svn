<html>
 <head>
   <title>Capi2Name: Database installtion</title>
 </head>
<body>

<?php


if (!isset($_POST[absenden]))
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
      <input name=\"absenden\" type=\"submit\" value=\"start install...\">
     </td>
    </tr>
   </table>
  
  </form>
  
  
  "; 
 }


if (isset($_POST[absenden]))
 {
$dbuser=$_POST[dbuser];
$dbpasswd=$_POST[dbpasswd];
$dbname=$_POST[dbname];
$dbhost=$_POST[dbhost];


//Variablen:

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
  
 $file=fopen("database.sql", "rb");
 $inhalt= fread ($file, filesize("database.sql"));
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
  


$control=mysql_close();
  if ($control==FALSE)
   {
     echo "Verbingun (Close) fehlgeschlagen!\nMysql-Error: ". mysql_error();
	die();
   }

echo "<br>installtion has finished. Check your conf.inc.php and delete the up_inst folder.";
}//ende isset (absenden)

?>
</BODY>
</HTML>
