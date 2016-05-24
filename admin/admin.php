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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE `admin` SET nama_depan=%s, nama_belakang=%s, username=%s, password=%s WHERE id=%s",
                       GetSQLValueString($_POST['nama_depan'], "text"),
                       GetSQLValueString($_POST['nama_belakang'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_database, $database);
  $Result1 = mysql_query($updateSQL, $database) or die(mysql_error());

  $updateGoTo = "berhasil.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_database, $database);
$query_admin = "SELECT * FROM admin";
$admin = mysql_query($query_admin, $database) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);
$totalRows_admin = mysql_num_rows($admin);
$noUrut = 1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/frame_admin.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/assets/css/font-awesome.min.css">
</head>

<body>
<div class="induk">
	<div id="judul">
		Setting - Akun Admin
	</div>
	<div id="konten">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="396" align="center">
          <tr valign="baseline">
            <td class="td_judul" width="112" align="left" valign="top" nowrap="nowrap">Nama Depan</td>
            <td width="272">
            <div class="form-item">
            <input name="nama_depan" type="text" value="<?php echo htmlentities($row_admin['nama_depan'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="30" />
            </div></td>
          </tr>
          <tr valign="baseline">
            <td class="td_judul" align="left" valign="top" nowrap="nowrap">Nama Belakang</td>
            <td>
            <div class="form-item">
            <input name="nama_belakang" type="text" value="<?php echo htmlentities($row_admin['nama_belakang'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="30" />
            </div></td>
          </tr>
          <tr valign="baseline">
            <td class="td_judul" align="left" valign="top" nowrap="nowrap">Username</td>
            <td>
            <div class="form-item">
            <input name="username" type="text" value="<?php echo htmlentities($row_admin['username'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="10" />
            </div></td>
          </tr>
          <tr valign="baseline">
            <td class="td_judul" align="left" valign="top" nowrap="nowrap">Password</td>
            <td>
            <div class="form-item">
            <input type="text" name="password" value="<?php echo htmlentities($row_admin['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
            </div></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"></td>
            <td height="50" valign="middle"><input class="submit" type="submit" value="Perbarui" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="id" value="<?php echo $row_admin['id']; ?>" />
      </form>
      <p>&nbsp;</p>
	</div>
</div>
</body>
</html>
<?php
mysql_free_result($admin);
?>