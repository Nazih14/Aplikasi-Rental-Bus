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
$noUrut = 1;
mysql_select_db($database_database, $database);
$query_sql = "SELECT * FROM `order`";
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
<link href="../css/tabel_admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/assets/css/font-awesome.min.css">
</head>

<body>
<div class="induk">
	<div id="judul">
		Daftar Pemesanan Bus
	</div>
    <div id="konten" style="font-size:11px; line-height: 12px;">
      <table id="table" cellspacing="0">
        <tr>
          <td width="1%" id="td_judul">No.</td>
          <td width="4%" id="td_judul">K. Ord</td>
          <td width="3%" id="td_judul">TgL Order</td>
          <td width="7%" id="td_judul">Pemesan</td>
          <td width="10%" id="td_judul">Alamat</td>
          <td width="7%" id="td_judul">TLP</td>
          <td width="8%" id="td_judul">Tujuan</td>
          <td width="3%" id="td_judul">52/59</td>
          <td width="3%" id="td_judul">31/32</td>
          <td width="6%" id="td_judul">brangkat</td>
          <td width="3%" id="td_judul">lama</td>
          <td width="10%" id="td_judul">T. Biaya</td>
          <td width="6%" id="td_judul">Konfirmasi</td>
          <td colspan="2" id="td_judul">Proses</td>
        </tr>
        <?php do { ?>
          <tr id="show">
            <td align="center"id="td_isi"><?php echo $noUrut++; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['kode_order']; ?></td>
            <td align="center" id="td_isi"><?php
              $tanggalbaru = date('d-m-Y', strtotime($row_sql['tgl_order'] ));
            echo $tanggalbaru; 

              ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['pemesan']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['alamat']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['tlp']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['tujuan']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['jml_bus_a']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['jml_bus_b']; ?></td>
            <td align="center" id="td_isi"><?php
              $tanggalbaru2 = date('d-m-Y', strtotime($row_sql['tgl_berangkat'] ));
            echo $tanggalbaru2; 

              ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['lama_pjln']; ?></td>
            <td align="center" id="td_isi"><?php $biaya=number_format($row_sql['total_biaya'],0,",",".");  echo 'Rp '. $biaya ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['konfirmasi']; ?></td>
            <td width="1%" align="center" id="td_isi"><a href="edit_order.php?id=<?php echo $row_sql['id']; ?>" id="a_aksi"><span class="fa fa-edit fa-lg fa-fw"></span> </a></td>
            <td width="1%" align="center" id="td_isi"><a  onclick="return confirm('Anda Yakin Akan Menghapus')" href="hapus_order.php?kode_order=<?php echo $row_sql['kode_order']; ?>" id="a_aksi"><span class="fa fa-trash-o fa-lg fa-fw"></span></a></td>
          </tr>
          <?php } while ($row_sql = mysql_fetch_assoc($sql)); ?>
      </table>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($sql);
?>