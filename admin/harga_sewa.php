<?php require_once('../Connections/database.php'); ?>
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

mysql_select_db($database_database, $database);
$query_paket = "SELECT * FROM harga_sewa WHERE kategori = 'PAKET'";
$paket = mysql_query($query_paket, $database) or die(mysql_error());
$row_paket = mysql_fetch_assoc($paket);
$totalRows_paket = mysql_num_rows($paket);

mysql_select_db($database_database, $database);
$query_nb = "SELECT * FROM harga_sewa WHERE kategori = 'nb'";
$nb = mysql_query($query_nb, $database) or die(mysql_error());
$row_nb = mysql_fetch_assoc($nb);
$totalRows_nb = mysql_num_rows($nb);

$noUrut = 1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/frame_admin.css" rel="stylesheet" type="text/css" />
<link href="../css/tabel_admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/assets/css/font-awesome.min.css">
<script type="text/javascript" src="../js/jquery.min.js"/></script>
</head>
<body>
<div class="induk">
	<div id="judul">
		Daftar Harga Sewa
	</div>
	<div id="konten">
    <div id="tambah"><a id="a_tambah" href="tambah_harga_sewa.php"><span class="fa fa-plus-square fa-fw"></span> Tambah&nbsp;</a></div>
      <table id="table" cellspacing="0">
        <tr>
          <td width="5%" id="td_judul">No.</td>
          <td width="35%" id="td_judul">Tujuan</td>
          <td width="10%" id="td_judul">Lama</td>
          <td width="15%" id="td_judul">52 / 59 Seat</td>
          <td width="15%" id="td_judul">31 / 32 Seat</td>
          <td colspan="2" id="td_judul">Proses</td>
        </tr>
        <?php do { ?>
          <tr id="show">
            <td align="center"id="td_isi"><?php echo $noUrut++; ?></td>
            <td id="td_isi" style="padding-left:10px"><?php echo $row_paket['tujuan']; ?></td>
            <td align="center" id="td_isi" style="padding-left:10px"><?php echo $row_paket['lama']; ?> Hari</td>
            <td align="center" id="td_isi"><?php $seat_a=number_format($row_paket['seat_a'],0,",",".");  echo 'Rp '. $seat_a ?></td>
            <td align="center" id="td_isi"><?php $seat_b=number_format($row_paket['seat_b'],0,",",".");  echo 'Rp '. $seat_b ?></td>
            <td width="4%" align="center" id="td_isi"><a href="edit_harga_sewa.php?id=<?php echo $row_paket['id']; ?>" id="a_aksi"><span class="fa fa-edit fa-lg fa-fw"></span> </a></td>
            <td width="4%" align="center" id="td_isi"><a  onclick="return confirm('Anda Yakin Akan Menghapus')" href="hapus_harga_sewa.php?id=<?php echo $row_paket['id']; ?>" id="a_aksi"><span class="fa fa-trash-o fa-lg fa-fw"></span></a></td>
          </tr>
          <?php } while ($row_paket = mysql_fetch_assoc($paket)); ?>
      </table>
  </div>
  <div id="judul">
		Overtime Saat Ini
  </div>
    <div id="konten">
    <div id="tambah"><a id="a_tambah" href="edit_overtime.php?id=<?php echo $row_nb['id']; ?>"><span class="fa fa-edit fa-fw"></span> Edit&nbsp;</a></div>
      <table id="untable" width="500px">
          <tr>
            <td width="112">52 / 59 Seat</td>
            <td width="22">:</td>
            <td width="350"><?php $seat_a=number_format($row_nb['seat_a'],0,",",".");  echo 'Rp '. $seat_a  .'/hari'?></td>
          </tr>
          <tr>
            <td>31 / 32 Seat</td>
            <td>:</td>
            <td><?php $seat_b=number_format($row_nb['seat_b'],0,",",".");  echo 'Rp '. $seat_b .'/hari' ?></td>
          </tr>
		</table>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($paket);
mysql_free_result($nb);
?>
