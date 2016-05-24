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
$query_sql = "SELECT aa.*, bb.* FROM `order` as aa, konfirmasi_order as bb WHERE aa.kode_order = bb.kode_order GROUP BY bb.kode_order ORDER BY bb.tgl_konfirmasi";
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
		Daftar Konfirmasi Pembayaran
	</div>
    <div id="konten">
      <table id="table" cellspacing="0">
        <tr>
          <td width="1%" id="td_judul">No.</td>
          <td width="3%" id="td_judul">K. Odr</td>
          <td width="7%" id="td_judul">Jml. Transfer</td>
          <td width="3%" id="td_judul">Bank</td>
          <td width="10%" id="td_judul">Nama</td>
          <td width="10%" id="td_judul">No. Rek</td>
          <td width="3%" id="td_judul">Ke Rek</td>
          <td width="10%" id="td_judul">Tgl. Konfirmasi</td>
          <td width="10%" id="td_judul">Kekurangan</td>
          <td width="5%" id="td_judul">Status</td>
          <td id="td_judul">Proses</td>
        </tr>
        <?php do {

          $kode = $row_sql['kode_order'];
          $query2 = "SELECT SUM(jml_transfer) AS tot_transfer FROM konfirmasi_order WHERE kode_order = '$kode'";
          $hasil2 = mysql_query($query2);
          $data2  = mysql_fetch_array($hasil2);
          $tot_transfer = $data2['tot_transfer'];

          mysql_select_db($database_database, $database);
          $query_sql2 = "SELECT * FROM `order` WHERE kode_order = '$kode'";
          $sql2 = mysql_query($query_sql2, $database) or die(mysql_error());
          $row_sql2 = mysql_fetch_assoc($sql2);
          $totalRows_sql2 = mysql_num_rows($sql2);

          ?>
          <tr id="show">
            <td align="center"id="td_isi"><?php echo $noUrut++; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['kode_order']; ?></td>
            <td align="center" id="td_isi"><?php $biaya=number_format($tot_transfer,0,",",".");  echo 'Rp '. $biaya ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['bank']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['nama']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['no_rek']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['ke_rek']; ?></td>
            <td align="center" id="td_isi"><?php 
              $tanggalbaru = date('d-m-Y', strtotime($row_sql['tgl_konfirmasi'] ));
            echo $tanggalbaru;

             ?></td>
             <td align="center" id="td_isi"><?php

                  if($tot_transfer < $row_sql['total_biaya']){
                    $kurang =  $row_sql['total_biaya'] - $row_sql['jml_transfer'];
                    $tampil3=number_format($kurang,0,",",".");  echo 'Rp '. $tampil3;
                  }else{
                    echo "Rp. 0";
                  }
                 
                  
                  ?></td>
            <td align="center" id="td_isi"><?php

                  if($tot_transfer < $row_sql2['total_biaya']){
                    echo "DP";
                  }else{
                    echo "Lunas";
                  }
                 
                  
                  ?></td>
            <td width="1%" align="center" id="td_isi"><a  onclick="return confirm('Anda Yakin Akan Menghapus')" href="hapus_kon.php?kode_order=<?php echo $row_sql['kode_order']; ?>" id="a_aksi"><span class="fa fa-trash-o fa-lg fa-fw"></span></a></td>
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