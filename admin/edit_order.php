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
  $updateSQL = sprintf("UPDATE `order` SET kode_order=%s, tgl_order=%s, pemesan=%s, alamat=%s, tlp=%s, tujuan=%s, jml_bus_a=%s, jml_bus_b=%s, tgl_berangkat=%s, lama_pjln=%s, total_biaya=%s, konfirmasi=%s WHERE id=%s",
                       GetSQLValueString($_POST['kode_order'], "int"),
                       GetSQLValueString($_POST['tgl_order'], "date"),
                       GetSQLValueString($_POST['pemesan'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['tlp'], "text"),
                       GetSQLValueString($_POST['tujuan'], "text"),
                       GetSQLValueString($_POST['jml_bus_a'], "int"),
                       GetSQLValueString($_POST['jml_bus_b'], "int"),
                       GetSQLValueString($_POST['tgl_berangkat'], "date"),
                       GetSQLValueString($_POST['lama_pjln'], "int"),
                       GetSQLValueString($_POST['total_biaya'], "int"),
                       GetSQLValueString($_POST['konfirmasi'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_database, $database);
  $Result1 = mysql_query($updateSQL, $database) or die(mysql_error());

  $updateGoTo = "berhasil5.php";
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
$query_sql = sprintf("SELECT * FROM `order` WHERE id = %s", GetSQLValueString($colname_sql, "int"));
$sql = mysql_query($query_sql, $database) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

mysql_select_db($database_database, $database);
$query_sql2 = "SELECT * FROM harga_sewa WHERE kategori = 'paket'";
$sql2 = mysql_query($query_sql2, $database) or die(mysql_error());
$row_sql2 = mysql_fetch_assoc($sql2);
$totalRows_sql2 = mysql_num_rows($sql2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/frame_admin.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../js/datepicker/themes/smoothness/jquery.ui.all.css" type="text/css">
<script src="../js/datepicker/jquery-1.10.2.js"></script>
<script src="../js/datepicker/ui/jquery.ui.datepicker.js"></script>
<script src="../js/datepicker/ui/jquery.ui.core.js"></script>
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
          angka: {
            digits: "Harus diisi dengan angka"
          }
        }
      });
    });
    </script>
     <script type="text/javascript">
		$(function() {
		  $( "#datepicker" ).datepicker({
			  changeMonth : true,
			  changeYear : true,
				dateFormat: "yy-mm-dd"					  					  
			});
		});
		</script>
		<script type="text/javascript">
		$(document).ready(function() {
			  $('#form1').validate();
		  });
	</script>
</head>

<body>
<div class="induk">
	<div id="judul">
		Edit - Pemesanan Bus
	</div>
    <div id="konten">
      <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
            <table width="634" align="left">
        <tr valign="baseline">
          <td align="left" valign="top" nowrap="nowrap" class="td_judul">Tanggal Order</td>
          <td>
          <div class="form-item">
          <input type="text" name="tgl_order" value="<?php echo htmlentities($row_sql['tgl_order'], ENT_COMPAT, 'utf-8'); ?>" size="32" required />
          </div></td>
        </tr>
        <tr valign="baseline">
          <td width="145" align="left" valign="top" nowrap="nowrap" class="td_judul">Nama Lengkap</td>
          <td width="477">
          <div class="form-item">
          <input type="text" name="pemesan" value="<?php echo htmlentities($row_sql['pemesan'], ENT_COMPAT, 'utf-8'); ?>" size="32" required />
          </div></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left" valign="top" class="td_judul">Alamat</td>
          <td>
          <div class="form-item">
            <textarea name="alamat" cols="50" rows="5" ><?php echo htmlentities($row_sql['alamat'], ENT_COMPAT, 'utf-8'); ?></textarea>
          </div></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="top" nowrap="nowrap" class="td_judul">Telephone</td>
          <td>
          <div class="form-item">
          <input type="text" name="tlp" value="<?php echo htmlentities($row_sql['tlp'], ENT_COMPAT, 'utf-8'); ?>" size="32" required />
          </div></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="top" nowrap="nowrap" class="td_judul">Tujuan</td>
          <td>
          <div class="form-item">
          <select name="tujuan" size="1">
           <?php 
				do {  
				?>
          <option value="<?php echo $row_sql2['tujuan']?>" <?php if (!(strcmp($row_sql2['tujuan'], htmlentities($row_sql['tujuan'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_sql2['tujuan']?></option>
          <?php
			} while ($row_sql2 = mysql_fetch_assoc($sql2));
			?>
      </select>
          </div></td>
        </tr>
        <tr> </tr>
        <tr valign="baseline">
          <td align="left" valign="top" nowrap="nowrap" class="td_judul">Jumlah Bus 52 / 59 Seat</td>
          <td>
          <div class="form-item">
          <input id="angka" name="jml_bus_a" value="<?php echo htmlentities($row_sql['jml_bus_a'], ENT_COMPAT, 'utf-8'); ?>" size="32" required />
          </div></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="top" nowrap="nowrap" class="td_judul">Jumlah Bus 31 / 32 Seat</td>
          <td>
          <div class="form-item">
          <input id="angka"  name="jml_bus_b" value="<?php echo htmlentities($row_sql['jml_bus_b'], ENT_COMPAT, 'utf-8'); ?>" size="32" required />
          </div></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="top" nowrap="nowrap" class="td_judul">Tanggal Berangkat</td>
          <td>
          <div class="form-item">
          <input id="datepicker" type="text" name="tgl_berangkat" value="<?php echo htmlentities($row_sql['tgl_berangkat'], ENT_COMPAT, 'utf-8'); ?>" size="32" required />
          </div></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="top" nowrap="nowrap" class="td_judul">Lama Perjalanan</td>
          <td>
          <div class="form-item">
          <input id="angka" name="lama_pjln" value="<?php echo htmlentities($row_sql['lama_pjln'], ENT_COMPAT, 'utf-8'); ?>" size="20" required /> Hari
          </div></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="top" nowrap="nowrap" class="td_judul">Total Biaya</td>
          <td>
          <div class="form-item">
          <input id="angka" name="total_biaya" value="<?php echo htmlentities($row_sql['total_biaya'], ENT_COMPAT, 'utf-8'); ?>" size="20" required />
          </div></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="top" nowrap="nowrap" class="td_judul">Konfirmasi</td>
          <td><div class="form-item">
          <select name="konfirmasi">
            <option value="Sudah" <?php if (!(strcmp("Sudah", htmlentities($row_sql['konfirmasi'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Sudah</option>
          <option value="Belum" <?php if (!(strcmp("Belum", htmlentities($row_sql['konfirmasi'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Belum</option>
          </select>
          </div></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"></td>
          <td height="50" valign="middle"><input class="submit" type="submit" value="Perbarui" /></td>
        </tr>
      </table>
      <input type="hidden" name="kode_order" value="<?php echo htmlentities($row_sql['kode_order'], ENT_COMPAT, 'utf-8'); ?>" size="20"/>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="id" value="<?php echo $row_sql['id']; ?>" />
      </form>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($sql);

mysql_free_result($sql2);
?>
