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
$seite=base64_encode("kalender.php");
include("./login_check.inc.php");
include("./header.inc.php");
?>
<div class="ueberschrift_seite"><? echo "$textdata[header_inc_kalender]"; ?></div>


<?
//uebergabe kalender.php?datum=yes&monat=04&jahr=2004
//wenn nicht gesetzt, dann diesen Monat nehmen:
if  (!isset($_GET[datum]))
  {
   $cur_monat=date(n);
   $cur_jahr=date(Y);
  }
  else
  {
   $cur_monat=$_GET[monat];
   $cur_jahr=$_GET[jahr];
  }
  $tage_des_monats=date(t, mktime(0,0,0,$cur_monat,01, $cur_jahr));
  $erster_tag=date(D, mktime(0,0,0,$cur_monat,01,$cur_jahr));
  $monat_zeichen=date(M, mktime(0,0,0,$cur_monat,01,$cur_jahr));

if ($cur_monat != 10)  { $cur_monat = str_replace("0","",$cur_monat); }
if ( $cur_monat < 10) {  $cur_monat="0$cur_monat"; }

if ($cur_monat==01 OR $cur_monat==1)
 {
  $cur_monat_1=12;
  $cur_jahr_1=$cur_jahr-1;
 }
 else
  {
  $cur_monat_1=$cur_monat -1;
  $cur_jahr_1=$cur_jahr ;
  }
if ($cur_monat==12)
 {
  $cur_monat_2=01;
  $cur_jahr_2=$cur_jahr+1;
 }
 else
  {
  $cur_monat_2=$cur_monat +1;
  $cur_jahr_2=$cur_jahr ;
  }
$tage_vormonat=date(t,mktime(0,0,0,$cur_monat_1,01,$cur_jahr_1)); //FIX ME FIX ME was passier wenn aktuller Monat Januar ist, dann -1??? MÜSSTE PASSEN???? 
//passt :-) Denke ich! 
 if ( $cur_monat_1 < 10) {  $cur_monat_1="0$cur_monat_1"; } 
  if ( $cur_monat_2 < 10) {  $cur_monat_2="0$cur_monat_2"; } 
/*echo "<BR />Kalender sollte das anzeigen: $cur_monat - $cur_jahr<BR />";
echo "Tage des Monats: $tage_des_monats<BR />";
echo "Tage des Vormonats: $tage_vormonat<BR />";
echo "Erster Tag: $erster_tag<BR />";
echo "Monat: $monat_zeichen<BR />"; 
 */
?>


<center>
<table border="0" cellpadding="3" cellspacing="2">
  <tr>
    <td style="font-weight:bold;">
     <a href="<? echo "./kalender.php?datum=yes&amp;monat=$cur_monat_1&amp;jahr=$cur_jahr_1";?>">&laquo;</a></td>
    <td colspan="5" style="text-align:center;font-weight:bold; font-size:large;">
    <? echo "$monat_zeichen $cur_jahr"; ?></td>
    <td style="font-weight:bold;">
    <a href="<? echo "./kalender.php?datum=yes&amp;monat=$cur_monat_2&amp;jahr=$cur_jahr_2"; ?>">&raquo;</a></td>
   </tr>
  <?
  echo "<tr>
    <td style=\"font-weight:bold; font-size:large;\">$textdata[kalender_tag_mo]</td>
    <td style=\"font-weight:bold; font-size:large;\">$textdata[kalender_tag_di]</td>
    <td style=\"font-weight:bold; font-size:large;\">$textdata[kalender_tag_mi]</td>
    <td style=\"font-weight:bold; font-size:large;\">$textdata[kalender_tag_do]</td>
    <td style=\"font-weight:bold; font-size:large;\">$textdata[kalender_tag_fr]</td>
    <td style=\"font-weight:bold; font-size:large;\">$textdata[kalender_tag_sa]</td>
    <td style=\"font-weight:bold; font-size:large;\">$textdata[kalender_tag_so]</td>
  </tr>
  
  <tr>";
  
  

  
 
  if ($erster_tag=="Mo")    {  $index=0; }
  if ($erster_tag=="Tue")  {  $index=1; }
  if ($erster_tag=="Wed") {  $index=2; }
  if ($erster_tag=="Thu") {  $index=3; }
  if ($erster_tag=="Fri") {   $index=4; }
  if ($erster_tag=="Sat") {  $index=5; }
  if ($erster_tag=="Sun") {   $index=6; } 
  
  $tage_vormonat=$tage_vormonat-$index+1;
   for ($i=1; $i<=$index; $i++)
     {
        if($i%2==1)
      { $color="$c_color[11]"; }
    else
      { $color="$c_color[12]"; }
      echo "<td style=\"text-align:center;background-color:$color\"><a href=\"./showstatnew.php?sdatum=$tage_vormonat.$cur_monat_1.$cur_jahr_1\">$tage_vormonat</a></td>";
      $tage_vormonat++;
     }
  
   
  
  for ( $e=1;  $e<=$tage_des_monats;  $e++)
    {
         if($index%2==0)
      { $color="$c_color[11]"; }
    else
      { $color="$c_color[12]"; }
       if ( $e < 10) {  $tag_neu="0$e"; } else { $tag_neu=$e; }
      echo "<td style=\"text-align:center;background-color:$color\">
        <a href=\"./showstatnew.php?sdatum=$tag_neu.$cur_monat.$cur_jahr\">$e</a></td>";
      $index++;
      if ($index==7)
       {
        echo "</tr><tr>";
	$index=0;
       }
    
    }
   
    $tag=1;
    for ($r=$index; $r<7;$r++)
      {
      if($r%2==0)
      { $color="$c_color[11]"; }
    else
      { $color="$c_color[12]"; }
       echo "<td style=\"text-align:center;background-color:$color\">
        <a href=\"./showstatnew.php?sdatum=0$tag.$cur_monat_2.$cur_jahr_2\">$tag</a></td>";
       $tag++;
      }

  ?>
 </tr>
</table>
</center>
<br />
<?
echo "<form action=\"./kalender.php\"  method=\"get\">$textdata[kalender_schnellsprung]:";
echo "<select name=monat>";
  for ($i=1; $i<=12; $i++)
    {
     echo "<option>$i</option>";
    }
echo "</select>";
echo "<select name=jahr>";
  for ($i=1970;$i<=2010;$i++)
   {
    echo "<option>$i</option>";
   }
echo "</select>";
echo "<input type=\"submit\" name=datum value=\"$textdata[kalender_los]\"></form>";
?>
<?
include("footer.inc.php");
?>
