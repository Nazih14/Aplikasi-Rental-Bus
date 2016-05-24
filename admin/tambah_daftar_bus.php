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
  $insertSQL = sprintf("INSERT INTO daftar_bis (nama_bus, tipe, status) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nama_bus'], "text"),
                       GetSQLValueString($_POST['tipe'], "text"),
                       GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_database, $database);
  $Result1 = mysql_query($insertSQL, $database) or die(mysql_error());

  $insertGoTo = "berhasil3c.php";
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
		Tambah Ketersediaan Bus
	</div>
    <div id="konten">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
          <tr valign="baseline">
            <td width="82" align="left" valign="top" nowrap="nowrap" class="td_judul">Nama Bus</td>
            <td width="278">
            <div class="form-item">
            <input type="text" name="nama_bus" value="" size="32" required />
            </div></td>
          </tr>
          <tr valign="baseline">
            <td align="left" valign="top" nowrap="nowrap" class="td_judul">Tipe</td>
            <td>
            <div class="form-item">
            <select name="tipe">
            <option value="Seat A">Seat A</option>
            <option value="Seat B">Seat B</option>
            </select>
            </div></td>
          </tr>
          <tr valign="baseline">
            <td align="left" valign="top" nowrap="nowrap" class="td_judul">Status</td>
            <td>
            <div class="form-item">
            <select name="status">
            <option value="Ada">Ada</option>
            <option value="Berangkat">Berangkat</option>
            </select>
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