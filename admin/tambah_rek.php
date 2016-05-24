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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO info_rekening (id, nama, bank, no_rek) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['bank'], "text"),
                       GetSQLValueString($_POST['no_rek'], "text"));

  mysql_select_db($database_database, $database);
  $Result1 = mysql_query($insertSQL, $database) or die(mysql_error());

  $insertGoTo = "berhasil4.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
		Setting - Tambah Rekening
  </div>
  <div id="konten">
    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
      <table width="524" align="center">
        <tr valign="baseline">
          <td  class="td_judul" align="left" valign="top" nowrap="nowrap">Nama</td>
          <td>
          <div class="form-item">
          <input type="text" name="nama" value="" size="32" required />
          </div>
          </td>
        </tr>
        <tr valign="baseline">
          <td  class="td_judul" align="left" valign="top" nowrap="nowrap">BANK</td>
          <td>
          <div class="form-item">
          <input type="text" name="bank" value="" size="32" required />
          </div>
          </td>
        </tr>
        <tr valign="baseline">
          <td  class="td_judul" align="left" valign="top" nowrap="nowrap">No. Rek</td>
          <td>
          <div class="form-item">
          <input id="angka" type="text" name="no_rek" value="" size="32" required />
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
      <input type="hidden" name="MM_insert" value="form1" />
      <input type="hidden" name="id" value="" />
    </form>
  </div>
</div>
</body>
</html>