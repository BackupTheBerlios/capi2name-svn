<?
include("./includes/conf.inc.php");
include("./includes/functions.php");
include("./includes/template.php");
$template = new Template("./templates/blueingrey");
$template->set_filenames(array('overall_body' => 'templates/blueingrey/callback_notify.tpl'));
session_start(); 
if ($_SESSION['show_callback_notify'])
 {
  $zugriff_mysql->connect_mysql($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
  $result_callback=$zugriff_mysql->sql_abfrage("SELECT t1.*,t2.nachname,t2.vorname,t2.tele1,t2.handy FROM callback AS t1 LEFT JOIN adressbuch AS t2 ON t1.addr_id=t2.id WHERE t1.user_id=".$_SESSION['user_id']  ." AND t1.notify=1;");
  $zugriff_mysql->sql_abfrage("UPDATE callback SET notify=0 WHERE user_id=".$_SESSION['user_id']);
  $_SESSION['show_callback_notify']=false;
  while($daten_callback=mysql_fetch_assoc($result_callback))
   {
    if ($daten_callback[tele1]=="99")
     {
      $number=$daten_callback[handy];
     }
    else
     {
      $number=$daten_callback[tele1];
     }
    switch ($daten_callback[callback_time])
     {
      case 0:
      	$callback_time="So bald wie moeglich";
	break;
      case 1:
      	$callback_time="Morgens";
	break;
      case 2:
      	$callback_time="Mittags";
	break;
      case 3:
      	$callback_time="Abends";
	break;
     
     };
    $template->assign_block_vars('tab1',array(
    		'L_DATA_NAME' => $daten_callback[vorname]." ".$daten_callback[nachname],
		'L_DATA_NUMBER' => $number,
		'L_DATA_CREATED_ON' => $daten_callback[en_time]." / ". mysql_datum($daten_callback[en_date]),
		'L_DATA_CALLBACK_TIME' => $callback_time,
		'L_DATA_MESSAGE' => $daten_callback[message]));
   }
  $zugriff_mysql->close_mysql();
 }
else
 {
  $template->assign_block_vars('not_found',array('L_MSG_NOT_FOUND' => 'Nicht erlebt/keine Callback entries found'));

 }
$template->pparse('overall_body');
?>