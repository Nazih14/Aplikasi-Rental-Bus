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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$cek_kode = mysql_num_rows(mysql_query("SELECT kode_order FROM `order` WHERE kode_order ='$_POST[kode_order]'"));

  mysql_select_db($database_database, $database);
  $query_sqlx = "SELECT total_biaya FROM `order` WHERE kode_order ='$_POST[kode_order]'";
  $sqlx = mysql_query($query_sqlx, $database) or die(mysql_error());
  $row_sqlx = mysql_fetch_assoc($sqlx);
  $totalRows_sqlx = mysql_num_rows($sqlx);
  $tot = $row_sqlx['total_biaya'];
  $dp = ($tot * 30)/100;

  $jtransfer = $_POST['jml_transfer'];
	if ((!$cek_kode == $_POST['kode_order']) or ($jtransfer < $dp)){
		header("Location: gagal2.php");die();
	}else{
	  $insertSQL = sprintf("INSERT INTO konfirmasi_order (id, kode_order, jml_transfer, bank, nama, no_rek, ke_rek) VALUES (%s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['id'], "int"),
						   GetSQLValueString($_POST['kode_order'], "text"),
						   GetSQLValueString($_POST['jml_transfer'], "int"),
						   GetSQLValueString($_POST['bank'], "text"),
						   GetSQLValueString($_POST['nama'], "text"),
						   GetSQLValueString($_POST['no_rek'], "int"),
						   GetSQLValueString($_POST['ke_rek'], "text"));
	
	  mysql_select_db($database_database, $database);
	  $Result1 = mysql_query($insertSQL, $database) or die(mysql_error());
	  $kode = $_POST['kode_order'];
	   
     $jml_transfer = $_POST['jml_transfer'];
	  $insertGoTo = "berhasil2.php?kode_order=$kode&&jml_transfer=$jml_transfer";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $insertGoTo));
	}
}

mysql_select_db($database_database, $database);
$query_sql = "SELECT * FROM konfirmasi_order";
$sql = mysql_query($query_sql, $database) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

mysql_select_db($database_database, $database);
$query_sql2 = "SELECT * FROM info_rekening";
$sql2 = mysql_query($query_sql2, $database) or die(mysql_error());
$row_sql2 = mysql_fetch_assoc($sql2);
$totalRows_sql2 = mysql_num_rows($sql2);

$query = "SELECT max(id) as idMaks FROM konfirmasi_order limit 1";
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$idorder = $data['idMaks'];
$idbaru = $idorder +1;
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
<link href="css/frame.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="js/validasiinput.js"></script>
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
<style>
.td_judul{
	font-weight: bold;
	padding: 5px;
}
</style>
</head>

<body>
<div class="induk">
<h2 style="font-size: 20px;">Formulir Konfirmasi Pembayaran </h2><br /><br />
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="634" align="left">
    <tr valign="baseline">
      <td width="145" align="left" valign="top" nowrap="nowrap" class="td_judul">Kode Order</td>
      <td width="477">
      <div class="form-item">
      <input type="text" name="kode_order" value="" size="32" required  onKeyPress="return goodchars(event,'0123456789',this)"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap" class="td_judul">Bank</td>
      <td>
        <div class="form-item">
          <input name="bank" value="" size="32" required />
        </div></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap" class="td_judul">Atas Nama</td>
      <td>
      <div class="form-item">
      <input name="nama" value="" size="32" required />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap" class="td_judul">No. Rekening</td>
      <td>
      <div class="form-item">
      <input type="text" name="no_rek" value="" size="32" required  onKeyPress="return goodchars(event,'0123456789',this)"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap" class="td_judul">Jumlah Transfer</td>
      <td>
        <div class="form-item">
          <input type="text" name="jml_transfer" value="" size="32" required  onKeyPress="return goodchars(event,'0123456789',this)"/>
        </div></td>
    </tr>
    <tr valign="baseline">
      <td align="left" valign="top" nowrap="nowrap" class="td_judul">Ke Rekening</td>
      <td>
      <div class="form-item">
        <select name="ke_rek">
          <?php
do {  
?>
          <option value="<?php echo $row_sql2['bank']?>"<?php if (!(strcmp($row_sql2['bank'], $row_sql2['bank']))) {echo "selected=\"selected\"";} ?>><?php echo $row_sql2['bank']?></option>
          <?php
} while ($row_sql2 = mysql_fetch_assoc($sql2));
  $rows = mysql_num_rows($sql2);
  if($rows > 0) {
      mysql_data_seek($sql2, 0);
	  $row_sql2 = mysql_fetch_assoc($sql2);
  }
?>
        </select>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"></td>
      <td height="50" valign="middle"><input class="submit" type="submit" value="Selesai" /></td>
    </tr>
  </table>
  <input type="hidden" name="id" value="<?php echo $idbarub; ?>" size="32" required />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</div>
</body>
</html>
<?php
mysql_free_result($sql);

mysql_free_result($sql2);
?>
