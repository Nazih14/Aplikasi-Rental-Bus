<?php require_once('Connections/database.php'); ?>
<?php
include('hapus_otomatis.php');
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
$colname_sql = "-1";
if (isset($_GET['tujuan'])) {
  $colname_sql = $_GET['tujuan'];
}

$colname_sql2 = "-1";
if (isset($_GET['lama'])) {
  $colname_sql2 = $_GET['lama'];
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$result = mysql_query("SELECT * FROM daftar_bis WHERE tipe = 'Seat A' AND status = 'Ada'");
$num_rows = mysql_num_rows($result);

$result2 = mysql_query("SELECT * FROM daftar_bis WHERE tipe = 'Seat B' AND status = 'Ada'");
$num_rows2 = mysql_num_rows($result2);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if (($num_rows < $_POST['jml_bus_a']) or ($num_rows2 < $_POST['jml_bus_b'])){
		header("Location: gagal.php");die();
	} else{
  $insertSQL = sprintf("INSERT INTO `order` (id, kode_order, pemesan, alamat, tlp, tujuan, jml_bus_a, jml_bus_b, tgl_berangkat, lama_pjln) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "text"),
					   GetSQLValueString($_POST['kode_order'], "text"),
					   GetSQLValueString($_POST['pemesan'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['tlp'], "text"),
                       GetSQLValueString($_POST['tujuan'], "text"),
                       GetSQLValueString($_POST['jml_bus_a'], "int"),
                       GetSQLValueString($_POST['jml_bus_b'], "int"),
                       GetSQLValueString($_POST['tgl_berangkat'], "date"),
                       GetSQLValueString($_POST['lama_pjln'], "int"));

  mysql_select_db($database_database, $database);
  $Result1 = mysql_query($insertSQL, $database) or die(mysql_error());
  $kode = $_POST['kode_order'];
  $colname_sql2 = $_POST['tujuan'];
  $jml_a = $_POST['jml_bus_a'];
  $jml_b = $_POST['jml_bus_b'];
  $lama = $_POST['lama_pjln'];
  $kota = $_POST['kota'];
  $insertGoTo = "berhasil.php?kode_order=$kode&&tujuan=$colname_sql2&&jml_bus_a=$jml_a&&jml_bus_b=$jml_b&&lama_pjln=$lama&&kota=$kota";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
}

mysql_select_db($database_database, $database);
$query_sql = "SELECT * FROM `order`";
$sql = mysql_query($query_sql, $database) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

mysql_select_db($database_database, $database);
$query_sql2 = "SELECT * FROM harga_sewa WHERE kategori = 'paket' ORDER BY tujuan ASC";
$sql2 = mysql_query($query_sql2, $database) or die(mysql_error());
$row_sql2 = mysql_fetch_assoc($sql2);
$totalRows_sql2 = mysql_num_rows($sql2);

$query = "SELECT max(kode_order) as idMaks FROM `order` limit 1";
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$idorder = $data['idMaks'];
$idbaru = $idorder +1;

$queryb = "SELECT max(id) as idMaks FROM `order` limit 1";
$hasilb = mysql_query($queryb);
$datab  = mysql_fetch_array($hasilb);
$idorderb = $datab['idMaks'];
$idbarub = $idorderb +1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/tabel_admin.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form.css" rel="stylesheet" type="text/css" />
<link href="css/tabel_admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="js/datepicker/themes/smoothness/jquery.ui.all.css" type="text/css">
<script src="js/datepicker/jquery-1.10.2.js"></script>
<script src="js/datepicker/ui/jquery.ui.datepicker.js"></script>
<script src="js/datepicker/ui/jquery.ui.core.js"></script>
<link href="css/frame.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="js/validasiinput.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#form1').validate({
        rules: {
          tlp : {
            digits: true,
            minlength:10,
            maxlength:12
          },
          lama_pjln: {
            digits: true
          },
          jml_bus_a: {
            digits: true
          },
          jml_bus_b: {
            digits: true
          }
        },
        messages: {
          tlp : {
            minlength: "Coba periksa nomor telepon anda"
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
<style>
.td_judul{
	font-weight: bold;
	padding: 5px;
}
</style>
</head>

<body>
<div class="induk">
<h2 style="font-size: 20px;">Formulir Pemesanan  </h2><br />
  <p style="font-size: 14px;"> Sebelum melakukan pemesanan, harap tanyakan dulu <a href="daftar_bus.php" style="color: #de424f;">ketersediaan bus</a> pada operator kami melalui kontak yang telah kami informasikan.</p><br /><br />
      
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="634" align="left">
    <tr valign="baseline">
      <td width="145" align="left" valign="top" nowrap="nowrap" class="td_judul">Nama Lengkap</td>
      <td width="477">
      <div class="form-item">
      <input type="text" name="pemesan" value="" size="32" required />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left" valign="top" class="td_judul">Alamat</td>
      <td>
      <div class="form-item">
        <textarea name="alamat" cols="50" rows="5"></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap" class="td_judul">Telephone</td>
      <td>
      <div class="form-item">
      <input type="text" name="tlp" value="" size="32" required  onKeyPress="return goodchars(event,'0123456789',this)"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap" class="td_judul">Tujuan</td>
      <td>
      <div class="form-item">
       <input type="text" name="tujuan" value="<?php echo $colname_sql; ?>" size="32" required readonly="readonly" />
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap" class="td_judul">Jumlah Bus 52 / 59 Seat</td>
      <td>
      <div class="form-item">
      <input id="angka" name="jml_bus_a" value="0" size="32" required  onKeyPress="return goodchars(event,'0123456789',this)"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap" class="td_judul">Tanggal Berangkat</td>
      <td>
      <div class="form-item">
      <input id="datepicker" type="text" name="tgl_berangkat" value="" size="32" required />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap" class="td_judul">Lama Perjalanan</td>
      <td>
      <div class="form-item">
      <input id="angka" name="lama_pjln" value="<?php echo $colname_sql2; ?>" size="20" required readonly="readonly" /> Hari
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"></td>
      <td height="50" valign="middle"><input class="submit" type="submit" value="Selesai" /></td>
    </tr>
  </table>
  <input type="hidden" id="angka"  name="jml_bus_b" value="0" size="32" required />
  <input type="hidden" name="id" value="<?php echo $idbarub; ?>" size="32" required />
  <input type="hidden" name="kode_order" value="<?php echo $idbaru; ?>" size="32" required />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</div>
</body>
</html>
<?php
mysql_free_result($sql);

mysql_free_result($sql2);
?>
