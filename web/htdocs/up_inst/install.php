<HTML>
 <HEAD>
   <TITLE>Datenbank Installation</TITLE>
 </HEAD>
<BODY>

<?php


if (!isset($_POST[absenden]))
 {
 echo "Bitte die Daten für die Installation eintragen!<br>";
  echo "<FORM action=\"$PHP_SELF\" method=\"POST\">
  <CENTER> 
  <TABLE border=\"1\">
    <TR>
     <TD>DB-Hostname:</TD>
     <TD> </TD>
     <TD><INPUT NAME=\"dbhost\"></TD>
    </TR>
    <TR>
     <TD>DB-User:</TD>
     <TD> </TD>
     <TD><INPUT NAME=\"dbuser\"></TD>
    </TR>
    <TR>
     <TD>DB-Passwort:</TD>
     <TD> </TD>
     <TD><INPUT NAME=\"dbpasswd\" TYPE=\"password\"></TD>
    </TR>
    <TR>
     <TD>DB-Name:</TD>
     <TD> </TD>
     <TD><INPUT NAME=\"dbname\"></TD>
    </TR>
   </TABLE><br>
   <INPUT NAME=\"absenden\" TYPE=\"submit\" name=\"Update..\"></CENTER>
  </FORM>
  
  
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

echo "<br>Datenbank installation abgeschlossen.....";
}//ende isset (absenden)

?>
</BODY>
</HTML>
