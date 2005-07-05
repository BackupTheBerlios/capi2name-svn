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
 *   any later version.                                   *
 *                                                                         *
 ***************************************************************************/
$seite=base64_encode("calendar.php");
include("./login_check.inc.php");
include("./header.inc.php");

$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/calendar.tpl'));
$template->assign_vars(array('L_SITE_TITLE' => $textdata[header_inc_kalender]));




//uebergabe kalender.php?datum=yes&monat=04&jahr=2004
//wenn nicht gesetzt, dann diesen Monat nehmen:
if  (   !isset($_POST[monat]) OR 
	!isset($_POST[jahr]) OR 
	!is_numeric($_POST[jahr]) OR 
	!is_numeric($_POST[monat]))
  {
   $cur_monat=date(n);
   $cur_jahr=date(Y);
  }
  else
  {
   $cur_monat=$_POST[monat];
   $cur_jahr=$_POST[jahr];
  }
  $tage_des_monats=date(t, mktime(0,0,0,$cur_monat,01, $cur_jahr));
  $erster_tag=date(D, mktime(0,0,0,$cur_monat,01,$cur_jahr));
  $monat_zeichen=date(M, mktime(0,0,0,$cur_monat,01,$cur_jahr));

if ($cur_monat != 10)  { $cur_monat = str_replace("0","",$cur_monat); }
if ( $cur_monat < 10)  {  $cur_monat="0$cur_monat"; }

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
$tage_vormonat=date(t,mktime(0,0,0,$cur_monat_1,01,$cur_jahr_1)); 
if ( $cur_monat_1 < 10) {  $cur_monat_1="0$cur_monat_1"; } 
if ( $cur_monat_2 < 10) {  $cur_monat_2="0$cur_monat_2"; } 


 $template->assign_vars(array(
 		'DATA_CUR_MONTH1' => $cur_monat_1,
		'DATA_CUR_YEAR1'  => $cur_jahr_1,
		'DATA_CUR_MONTH2' => $cur_monat_2,
		'DATA_CUR_YEAR2'  => $cur_jahr_2,
		'DATA_TITLE_YEAR' => $monat_zeichen ." ". $cur_jahr,
		'L_DAY_MO'  => $textdata[kalender_tag_mo],
		'L_DAY_TUE' => $textdata[kalender_tag_di],
		'L_DAY_WED' => $textdata[kalender_tag_mi],
		'L_DAY_THU' => $textdata[kalender_tag_do],
		'L_DAY_FRI' => $textdata[kalender_tag_fr],
		'L_DAY_SAT' => $textdata[kalender_tag_sa],
		'L_DAY_SUN' => $textdata[kalender_tag_so]));


if ($erster_tag=="Mo")  {  $index=0; }
if ($erster_tag=="Tue") {  $index=1; }
if ($erster_tag=="Wed") {  $index=2; }
if ($erster_tag=="Thu") {  $index=3; }
if ($erster_tag=="Fri") {  $index=4; }
if ($erster_tag=="Sat") {  $index=5; }
if ($erster_tag=="Sun") {  $index=6; } 
$tage_vormonat=$tage_vormonat-$index+1;
for ($i=1; $i<=$index; $i++)
  {
   if($i%2==1)
     { $color=$row_color_1; }
   else
     { $color=$row_color_2; }
   if ($tage_vormonat==date(d) && $cur_monat_1==date(m) && $cur_jahr_1==date(Y))
       $color=$hightlight_color; 
   $template->assign_block_vars('tab1',array(
   		'DATA_COLOR' => $color,
		'DATA_DAY_BEFOR' =>$tage_vormonat,
		'DATA_MONTH' => $cur_monat_1,
		'DATA_YEAR' => $cur_jahr_1));  

      $tage_vormonat++;
     }
  
   
  
  for ( $e=1;  $e<=$tage_des_monats;  $e++)
    {
    if($index%2==0)
      { $color=$row_color_1; }
    else
      { $color=$row_color_2; 
      }
    if ($e==date(d) && $cur_monat==date(m) && $cur_jahr==date(Y)) 
    	{ $color=$hightlight_color; }
       if ( $e < 10) {  $tag_neu="0$e"; } else { $tag_neu=$e; }
       $template->assign_block_vars('tab2',array(
       		'DATA_COLOR' => $color,
		'DATA_DAY' => $tag_neu,
		'DATA_MONTH' => $cur_monat,
		'DATA_YEAR' => $cur_jahr,
		'DATA_E' => $e));
      ++$index;
      if ($index==7)
       {
        $template->assign_block_vars('tab2.tab3', array());
	$index=0;
       }
    
    }
    $tag=1;
    for ($r=$index; $r<7;$r++)
      {
      if($r%2==0)
      { $color=$row_color_1; }
    else
      { $color=$row_color_2; }
    if ($tag==date(d) && $cur_monat_2==date(m)&& $cur_jahr_2==date(Y)) 
    		{ $color=$hightlight_color; }
       $template->assign_block_vars('tab4',array(
       		'DATA_COLOR' => $color,
		'DATA_DAY' => $tag,
		'DATA_MONTH' => $cur_monat_2,
		'DATA_YEAR' => $cur_jahr_2));
       $tag++;
      }


$template->assign_vars(array(
		'L_MSG_GO_TO' => $textdata[kalender_schnellsprung],
		'L_MSG_GO' => $textdata[kalender_los]));
for ($i=1; $i<=12; $i++)
 {
  if ($cur_monat==$i)
   {
   $template->assign_block_vars('month_data',array(
   		'DATA_MONTH' => $i,
		'SELECTED' => "selected=\"selected\"")); 
   }
  else
   {
    $template->assign_block_vars('month_data',array('DATA_MONTH' => $i));
   }
 }
for ($i=1970;$i<=2010;$i++)
 {
  if ($cur_jahr==$i)
   {
    $template->assign_block_vars('year_data',array(
    		'DATA_YEAR' => $i,
		'SELECTED' => "selected=\"selected\""));
   }
  else
   {
    $template->assign_block_vars('year_data',array('DATA_YEAR' => $i));
   }
 }

$template->pparse('overall_body');
include("footer.inc.php");
?>
