<?
/*
    copyright            : (C) 2002-2004 by Jonas Genannt
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
<?
$seite=base64_encode("adressbuch.php");
include("./login_check.inc.php");
include("./header.inc.php");
?>

<? echo "<div class=\"ueberschrift_seite\">$textdata[header_inc_adressbuch]</div>"; ?>
<br />

<table border="0" style="margin-right:auto;margin-left:auto;">
 <tr>
  <td style="width:150px;font-weight:bold;text-align:left;">
   <a href="./adressbuch.php?order=nachname" title="<? echo "$textdata[adressbuch_sortiere_nachname]"; ?>">
       <? echo "$textdata[addadress_nachname]"; ?></a></td>
  <td style="width:100px; font-weight:bold;text-align:left;">
   <a href="./adressbuch.php?order=vorname" title="<? echo "$textdata[adressbuch_sortiere_vorname]"; ?>">
     <? echo "$textdata[addadress_vorname]"; ?></a></td>
  <td style="width:150px; text-align:center; font-weight:bold;">
        <? echo "$textdata[adressbuch_telefonNR]"; ?></td>
  <td style="width:150px; text-align:center; font-weight:bold;">
             <? echo "$textdata[addadress_handy]"; ?></td>
  <td></td>
  <td></td>
  <td></td>
  <td style="width:10px;"></td>
  <td></td>
 </tr>

<?
$i=0;
// Auslesen:
if (isset($_GET[order]))
 {
  $sqlabfrage="SELECT * FROM adressbuch ORDER BY $_GET[order]";
 }
else
 {
 $sqlabfrage="SELECT * FROM adressbuch ORDER BY nachname";
 }
$zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] ); 
$result=$zugriff_mysql->sql_abfrage($sqlabfrage);
$zugriff_mysql->close_mysql();
while($row=mysql_fetch_row($result))
 {
   if($i%2==0)
   { $color="$c_color[11]";
     $i=1; }
  else
   { $color="$c_color[12]";
     $i=0; }
  if ($row[10]== 99) { $row[10]=""; }
  if ($row[7]== 99) { $row[7]=""; }
  if (isset($_GET[findnr]) )
   {
    $findnr=$_GET[findnr];
    if($row[7]== $findnr or $row[8]== $findnr or $row[9]== $findnr or $row[10]== $findnr  )
     {
      $color="yellow";
      $row[7]="<a name=\"find\">$row[7]</a>";
     }
   } 

     if (isset($_GET[id]) )
   {
    $findid=$_GET[id];
    if($findid==$row[0] )
     {
      $color="yellow";
      $row[7]="<a name=\"find\">$row[7]</a>";
     }
      
        
    }

  echo "
  <tr style=\"background-color:$color\">
   <td style=\"text-align:left;\"><a href=\"./showaddress.php?show=$row[0]\" >$row[2]</a></td>
   <td style=\"text-align:left;\"><a href=\"./showaddress.php?show=$row[0]\">$row[1]</a></td>
   <td style=\"text-align:center;\">$row[7]</td>
   <td style=\"text-align:center;\">$row[10]</td>
   <td style=\"text-align:center;\">
     <a href=\"./editadress.php?bearbeiten=$row[0]\" title=\"$textdata[adressbuch_eintrag_bearbeiten]\">
     <img src=\"./bilder/edit.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
   <td style=\"width:10px;\"></td>
   <td style=\"text-align:center;\">
    <a href=\"./editadress.php?bearbeiten=$row[0]&amp;loeschen=1\" title=\"$textdata[adressbuch_eintrag_loeschen]\">
   <img src=\"./bilder/edittrash.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
   <td style=\"width:10px;\">&nbsp;</td>
   <td style=\"text-align:center;\">
   <a href=\"./stat_anrufer.php?id=$row[0]\" title=\"$textdata[adressbuch_suche_eintraege]\">
   <img src=\"./bilder/search.png\" style=\"border-width:0px;vertical-align:middle;\" alt=\"\"/></a></td>
  </tr>
  ";
 }
// Auslesen ENde

?>
</table>
<br />
<?
include("./footer.inc.php");
?>
