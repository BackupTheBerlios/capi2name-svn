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
 *   any later version.                                  		   *
 *                                                                         *
 ***************************************************************************/
session_start();
session_destroy();
setcookie("ck_userid","", time()-172800000 );  
setcookie("ck_passwd","", time()-172800000 );  
include("./includes/conf.inc.php");
include("./language/".$config['language'].".inc.php");
include("./includes/functions.php");  
include("./includes/template.php");
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$dataB->sql_query("SELECT conf,value FROM config WHERE conf='default_template'");

$daten=$dataB->sql_fetch_assoc($result); 
$dataB->sql_close();
$L_template=$daten[value];
$template = new Template("./templates/".$L_template);
$template->set_filenames(array('overall_body' => 'templates/'.$L_template.'/logout.tpl'));
$template->assign_vars(array('L_LOGOUT' => $textdata['logoff']));
$template->assign_vars(array('L_MSG_FORWARD' => $textdata['msg_logoff_forward']));
$template->pparse('overall_body');
?>

