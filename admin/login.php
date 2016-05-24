<?php require_once('../Connections/database.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}
$pesan = "";
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_database, $database);
  
  $LoginRS__query=sprintf("SELECT * FROM `admin` WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $database) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	 
	$tb_stt = mysql_fetch_assoc($LoginRS);
	$_SESSION['nama_depan'] = $tb_stt['nama_depan'];

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    
	$pesan = "Username atau Password yang anda masukkan salah !";
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login - Admin PO. Arisa Pekalongan</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/style_admin.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="box_login">
	<div class="head_login">Silahkan Login Dulu</div>
    <div class="form_login">
    <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" name="login">
        <table width="100%" border="0" align="center" cellspacing="0">
          <tr>
            <td width="22%" height="40" align="left" valign="baseline">Username</td>
            <td width="78%" height="40" align="right" valign="middle">
                <div class="form-item">
                <input style="text-align:center;" name="username" type="text" maxlength="10"/>
                </div>
            </td>
          </tr>
          <tr>
            <td height="40" align="left" valign="baseline">Password</td>
            <td height="40" align="right" valign="middle">
                <div class="form-item">
                <input style="text-align:center;" name="password" type="password" maxlength="10"/>
                </div>
            </td>
            </tr>
          <tr>
            <td height="40" colspan="2" align="right" valign="middle">
                <input class="submit" type="submit" name="button" value="Login" /></td>
            </tr>
        </table>
    </form>
    </div>
</div>
<div class="peringatan">
	<?php echo $pesan ?>
</div>
</body>
</html>