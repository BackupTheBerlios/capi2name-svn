<?


$login_name =$_COOKIE[ck_ausername];
$login_passwd =$_COOKIE[ck_apasswd];
$loginok="0";
mysql_connect($host, $dbuser, $dbpasswd);
$result=mysql_db_query($db, "SELECT username, passwd FROM userliste WHERE username=\"admin\"");
$daten=mysql_fetch_array($result);
mysql_close();

if ($login_name==md5($daten[username]))
 {
  if ($login_passwd==md5($daten[passwd]))
   {
  //  echo "LOGIN OK";
    $loginok="1";
   }
   else
    {
 //   echo "LOGIN Failed! 1";
    $loginok="0";
    }
 }
 else
 {
// echo "LOGIN Failed! username";
 $loginok="0";
 }


 if ($loginok!=1)
  {
  echo "
  <br><br><br><br>
   <FORM action=\"./login.php?seite=$seite\" method=\"post\">
<center>
<table border=\"0\">
 <tr>
  <td>Username:</td>
  <td width=\"5\"></td>
  <td><INPUT name=\"login\" type=\"hidden\" value=\"admin\">admin</td>
 </tr>
 <tr>
  <td>Password:</td>
  <td width=\"5\"></td>
  <td><INPUT name=\"login_passwd\" type=\"password\"></td>
 </tr>

  <tr>
  <td colspan=\"3\"><center><INPUT name=\"absenden\" value=\"Login\" type=\"submit\"></center></td>
 </tr>

</FORM>
</table>
</center>";

exit();

  }
