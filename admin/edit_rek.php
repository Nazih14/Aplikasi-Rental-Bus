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
  $updateSQL = sprintf("UPDATE info_rekening SET nama=%s, bank=%s, no_rek=%s WHERE id=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['bank'], "text"),
                       GetSQLValueString($_POST['no_rek'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_database, $database);
  $Result1 = mysql_query($updateSQL, $database) or die(mysql_error());

  $updateGoTo = "berhasil4b.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_sql = "-1";
if (isset($_GET['id'])) {
  $colname_sql = $_GET['id'];
}
mysql_select_db($database_database, $database);
$query_sql = sprintf("SELECT * FROM info_rekening WHERE id = %s", GetSQLValueString($colname_sql, "int"));
$sql = mysql_query($query_sql, $database) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);
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
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#form1').validate({
        rules: {
          angka :{
            digits: true
          }
        },
        messages: {
          seat_a: {
            angka: "Harus diisi dengan angka"
          }
        }
      });
    });
    </script>
</head>

<body>
<div class="induk">
<div id="judul">
		Setting - Edit Rekening
  </div>
  <div id="konten">
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
      <table width="524" align="center">
        <tr valign="baseline">
          <td  class="td_judul" align="left" valign="top" nowrap="nowrap">Nama</td>
          <td>
          <div class="form-item">
          <input type="text" name="nama" value="<?php echo htmlentities($row_sql['nama'], ENT_COMPAT, 'utf-8'); ?>" size="32" required />
          </div>
          </td>
        </tr>
        <tr valign="baseline">
          <td  class="td_judul" align="left" valign="top" nowrap="nowrap">BANK</td>
          <td>
          <div class="form-item">
          <input type="text" name="bank" value="<?php echo htmlentities($row_sql['bank'], ENT_COMPAT, 'utf-8'); ?>" size="32" required />
          </div>
          </td>
        </tr>
        <tr valign="baseline">
          <td  class="td_judul" align="left" valign="top" nowrap="nowrap">No. Rek</td>
          <td>
          <div class="form-item">
          <input id="angka" type="text" name="no_rek" value="<?php echo htmlentities($row_sql['no_rek'], ENT_COMPAT, 'utf-8'); ?>" size="32" required />
          </div>
          </td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"></td>
          <td height="50" valign="middle">
          <input class="submit" type="submit" value="Tambah" />
          </td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="id" value="<?php echo $row_sql['id']; ?>" />
      <input type="hidden" name="MM_update" value="form1" />
    </form>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($sql);
?>
