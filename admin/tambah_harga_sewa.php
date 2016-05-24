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
  $insertSQL = sprintf("INSERT INTO harga_sewa (tujuan, seat_a, seat_b) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['tujuan'], "text"),
                       GetSQLValueString($_POST['seat_a'], "int"),
                       GetSQLValueString($_POST['seat_b'], "int"));

  mysql_select_db($database_database, $database);
  $Result1 = mysql_query($insertSQL, $database) or die(mysql_error());

  $insertGoTo = "berhasil3.php";
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
          seat_a :{
            digits: true
          },
           seat_b: {
              digits: true
            }
        },
        messages: {
          seat_a: {
            digits: "Harus diisi dengan angka"
          },
          seat_b: {
              digits: "Harus diisi dengan angka"
            }
        }
      });
    });
    </script>
</head>

<body>
<div class="induk">
	<div id="judul">
		Tambah Harga Sewa
	</div>
    <div id="konten">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
          <tr valign="baseline">
            <td width="82" align="left" valign="top" nowrap="nowrap" class="td_judul">Tujuan</td>
            <td width="278">
            <div class="form-item">
            <input type="text" name="tujuan" value="" size="32" required />
            </div></td>
          </tr>
          <tr valign="baseline">
            <td align="left" valign="top" nowrap="nowrap" class="td_judul">52 / 59 Seat</td>
            <td>
            <div class="form-item">
            <input id="seat_a" type="text" name="seat_a" value="" size="32" required />
            </div></td>
          </tr>
          <tr valign="baseline">
            <td align="left" valign="top" nowrap="nowrap" class="td_judul">31 / 32 Seat</td>
            <td>
            <div class="form-item">
            <input id="seat_b" type="text" name="seat_b" value="" size="32" required />
            </div></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"></td>
            <td height="50" valign="middle"><input class="submit" type="submit" value="Tambah" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
      <p></p>
    </div>
    
</div>
</body>
</html>