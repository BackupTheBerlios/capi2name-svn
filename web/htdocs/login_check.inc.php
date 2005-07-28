<?php
include("./includes/conf.inc.php");
include("./language/".$config['language'].".inc.php");
include("./includes/functions.php");
session_start(); 
$realname=$_SESSION['realname'];
$username=$_SESSION['username']; 
$password=$_SESSION['password'];
$user_id=$_SESSION['user_id'];
$cs_user=$_SESSION['cs_user']; 
$login_ok=0;

if ($_SESSION['remember_login'])
 {
  setcookie("ck_username",$username, time()+172800000 );  
  setcookie("ck_passwd",$password, time()+172800000 );  
  setcookie("ck_realname",$realname, time()+172800000 );  
  setcookie("ck_user_id",$user_id, time()+172800000 );
  setcookie("ck_cs_user",$cs_user, time()+172800000 );
  $_SESSION['remember_login']=false;
 }

if ($_COOKIE['ck_username']!="" && $_COOKIE['ck_passwd']!="" && $_COOKIE['ck_realname']!="")
 {
  $_SESSION['realname']=$_COOKIE['ck_realname'];
  $_SESSION['username']=$_COOKIE['ck_username']; 
  $_SESSION['password']=$_COOKIE['ck_passwd'];
  $_SESSION['user_id'] =$_COOKIE['ck_user_id'];
  $_SESSION['cs_user']=$_COOKIE['ck_cs_user'];
  $realname=$_SESSION['realname'];
  $username=$_SESSION['username']; 
  $password=$_SESSION['password'];
  $user_id =$_SESSION['user_id'];
  $cs_user=$_SESSION['cs_user'];
 }

$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
if (is_numeric($user_id))
 {
  $query=sprintf("SELECT * FROM users WHERE id=%s", $dataB->sql_checkn($user_id));
 }
else
 {
  $query=sprintf("SELECT * FROM users WHERE username=%s",$dataB->sql_check($username));
 }
$result_userlist=$dataB->sql_query($query);
 if ($result_userlist && $username!="" && $password!="")
  {
  $row_userlist=$dataB->sql_fetch_assoc($result_userlist);
    if ($password==$row_userlist['passwd'])
    {
    // echo "PASSWD Richtig...";
     //DB-Version auslesen:
     $result_db_version=$dataB->sql_query("SELECT value FROM config WHERE conf='db_version'");
     $db_version=$dataB->sql_fetch_assoc($result_db_version);
     $login_ok=1;
     //Usersettings auslesen und in $userconfig[] schreiben...
     $userconfig['anzahl']=$row_userlist['show_lines'];
     $userconfig['msns']=$row_userlist['msn_listen'];
     if ($row_userlist['show_callback'])
      {
       $userconfig['showrueckruf']=true;
      }
     else
      {
       $userconfig['showrueckruf']=false;
      }
     if ($row_userlist['show_prefix'])
      {
       $userconfig['showvorwahl']=true;
      }
     else
      {
       $userconfig['showvorwahl']=false;
      }
     if ($row_userlist['show_msn'])
      {
       $userconfig['showmsn']=true;
      }
     else
      {
       $userconfig['showmsn']=false;
      }
     if ($row_userlist['show_config'])
      {
       $userconfig['showconfig']=true;
      }
     else
      {
       $userconfig['showconfig']=false;
      }
     if ($row_userlist['show_type'])
      {
       $userconfig['showtyp']=true;
      }
     else
      {
       $userconfig['showtyp']=false;
      }
     if ($row_userlist['allow_delete'])
      {
       $userconfig['loeschen']=true;
      }
     else
      {
       $userconfig['loeschen']=false;
      }
      if ($row_userlist['cs_user']!="")
      {
       $userconfig['cs_user']=$row_userlist['cs_user'];
      }
      //template suchen und schauen wegen global oder nicht ;)
      $result_config=$dataB->sql_query("SELECT * FROM config WHERE conf='template'");
      $daten_config=$dataB->sql_fetch_assoc($result_config);
      if (!$daten_config[value])
        {
	 if (check_template($row_userlist[template]))
	  {
	   $userconfig['template']=$row_userlist[template];
	  }
	 else
	  {
	   $result_config1=$dataB->sql_query("SELECT * FROM config WHERE conf='default_template'");
	   $daten_config1=$dataB->sql_fetch_assoc($result_config1);
	   $userconfig['template']=$daten_config1[value];
	  }
	}
      else
        {
	 $userconfig['template']=$daten_config['value'];
	}
      //update lastlogin_d and lastlogin_t
      //UPDATE capi_version SET version='0.6.7.2' WHERE id='1'
      $datum=$dataB->sql_fetch_assoc($dataB->sql_query("SELECT lastlogin_d FROM users WHERE username='$username'"));
     if ($datum[lastlogin_d]!=date("Y-m-d"))
       {
      $dataB->sql_query("UPDATE users SET lastlogin_t=NOW(),lastlogin_d=NOW() WHERE username='$username'");
       }
     $result_callback=$dataB->sql_query("SELECT user_id,notify FROM callback WHERE user_id='$row_userlist[id]' AND notify='1'");
     $daten_callback=$dataB->sql_fetch_assoc($result_callback);
     if ($daten_callback)
     {
      $_SESSION['show_callback_notify']=true;
     }  
    }//if passwd OK
   else
    {
     $login_ok=0;
    }
  }//if username es gibt
 else
  {
   $login_ok=0;
  }
  
$dataB->sql_close();
if ($login_ok == 0)
 {
$dataB->sql_connect($sql["host"],$sql["dbuser"],$sql["dbpasswd"],$sql["db"] );
$result=$dataB->sql_query("SELECT conf,value FROM config WHERE conf='default_template'");
$daten=$dataB->sql_fetch_assoc($result); 
$dataB->sql_close();
$userconfig['template']=$daten[value];
include("./header.inc.php");
$template->set_filenames(array('overall_body' => 'templates/'.$userconfig['template'].'/login_site.tpl'));
$template->assign_vars(array(
	'L_USERNAME' => $textdata[configpage_username],
	'L_PASSWD' => $textdata[passwd],
	'DATA_TO_SITE' => $seite,
	'L_STAY_LOGIN' => $textdata[stay_login],
	'L_LOGIN' => $textdata[login]));
$template->pparse('overall_body');
include("./footer.inc.php");
exit();
 }

?>
