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
  $updateSQL = sprintf("UPDATE kontak SET alamat=%s, tlp=%s, sms=%s, email=%s WHERE id=%s",
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['tlp'], "text"),
                       GetSQLValueString($_POST['sms'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
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
$query_kontak = "SELECT * FROM kontak WHERE id = 1";
$kontak = mysql_query($query_kontak, $database) or die(mysql_error());
$row_kontak = mysql_fetch_assoc($kontak);
$totalRows_kontak = mysql_num_rows($kontak);
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
		Setting - Info Kontak
  </div>
  <div id="konten">
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table width="524" align="center">
        <tr valign="baseline">
          <td  class="td_judul" width="80" align="left" valign="top" nowrap="nowrap">Alamat</td>
          <td width="438">
          <div class="form-item">
          <textarea name="alamat" cols="50" rows="5"><?php echo htmlentities($row_kontak['alamat'], ENT_COMPAT, 'utf-8'); ?></textarea>
          </div>
          </td>
        </tr>
        <tr valign="baseline">
          <td  class="td_judul" align="left" valign="top" nowrap="nowrap">Telephone</td>
          <td>
          <div class="form-item">
          <input type="text" name="tlp" value="<?php echo htmlentities($row_kontak['tlp'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
          </div>
          </td>
        </tr>
        <tr valign="baseline">
          <td  class="td_judul" align="left" valign="top" nowrap="nowrap">Sms</td>
          <td>
          <div class="form-item">
          <input type="text" name="sms" value="<?php echo htmlentities($row_kontak['sms'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
          </div>
          </td>
        </tr>
        <tr valign="baseline">
          <td  class="td_judul" align="left" valign="top" nowrap="nowrap">Email</td>
          <td>
          <div class="form-item">
          <input type="text" name="email" value="<?php echo htmlentities($row_kontak['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
          </div>
          </td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"></td>
          <td height="50" valign="middle">
          <input class="submit" type="submit" value="Perbarui" />
          </td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="id" value="<?php echo $row_kontak['id']; ?>" />
    </form>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($kontak);
?>