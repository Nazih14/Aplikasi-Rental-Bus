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
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link href="../css/tabel_admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/assets/css/font-awesome.min.css">
</head>

<body>
<div class="induk">
	<div id="judul">
		Daftar Pemasukan
	</div>
    <div id="tambah">
    
    </div>
  <div id="tambah">
   	<div style="margin: 20px 20px 0 21px">
    	<form method="POST" action="print.php" target="_blank">
        <table>
        <tr>
        <td width="159" height="30" valign="middle" style="font-weight:bold;">
        Cetak Berdasarkan Bulan : 
        </td>
        <td width="116" height="30" valign="middle"></td>
        </tr>
        <tr>
          <td height="30" valign="bottom"><div class="form-item" >
            <select name="bulan">
              <option value="01">Januari</option>
              <option value="02">Februari</option>
              <option value="03">Maret</option>
              <option value="04">April</option>
              <option value="05">Mei</option>
              <option value="06">Juni</option>
              <option value="07">Juli</option>
              <option value="08">Agustus</option>
              <option value="09">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desembar</option>
            </select>
          </div></td>
          <td height="30" align="center" valign="top">
            <input class="submit" type="submit" name="button"  value="Lihat" />
            </td>
        </tr>
        </table>
        </form>
      </div>
    </div>
    <div id="konten" style="font-size:11px; line-height: 12px;">
      <table id="table" cellspacing="0">
        <tr>
          <td width="1%" id="td_judul">No.</td>
          <td width="4%" id="td_judul">K. Order</td>
          <td width="3%" id="td_judul">TgL Order</td>
          <td width="7%" id="td_judul">Pemesan</td>
          <td width="8%" id="td_judul">Tujuan</td>
          <td width="3%" id="td_judul">52/59</td>
          <td width="3%" id="td_judul">31/32</td>
          <td width="6%" id="td_judul">brangkat</td>
          <td width="3%" id="td_judul">lama</td>
          <td width="8%" id="td_judul">T. Biaya</td>
          <td width="10%" id="td_judul">Jml. Transfer</td>
          <td width="6%" id="td_judul">Tgl. Konfirm</td>
          <td width="8%" id="td_judul">Kekurangan</td>
          <td width="3%" id="td_judul">Status</td>
        </tr>
        <?php do {

          $kode = $row_sql['kode_order'];
          $query2 = "SELECT SUM(jml_transfer) AS tot_transfer FROM konfirmasi_order WHERE kode_order = '$kode'";
          $hasil2 = mysql_query($query2);
          $data2  = mysql_fetch_array($hasil2);
          $tot_transfer = $data2['tot_transfer'];

          ?>
          <tr id="show">
            <td align="center"id="td_isi"><?php echo $noUrut++; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['kode_order']; ?></td>
            <td align="center" id="td_isi"><?php $tanggalbaru = date('d-m-Y', strtotime($row_sql['tgl_order'] ));
            echo $tanggalbaru; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['pemesan']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['tujuan']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['jml_bus_a']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['jml_bus_b']; ?></td>
            <td align="center" id="td_isi"><?php $tanggalbaru2 = date('d-m-Y', strtotime($row_sql['tgl_berangkat'] ));
            echo $tanggalbaru2;  ?></td>
            <td align="center" id="td_isi"><?php echo $row_sql['lama_pjln']; ?></td>
            <td align="center" id="td_isi"><?php $biaya=number_format($row_sql['total_biaya'],0,",",".");  echo 'Rp '. $biaya ?></td>
            <td align="center" id="td_isi"><?php $biaya2=number_format($tot_transfer,0,",",".");  echo 'Rp '. $biaya2 ?></td>
            <td align="center" id="td_isi"><?php $tanggalbaru3 = date('d-m-Y', strtotime($row_sql['tgl_konfirmasi'] ));
            echo $tanggalbaru3;  ?></td>
            <td align="center" id="td_isi"><?php

                  if($tot_transfer < $row_sql['total_biaya']){
                    $kurang =  $row_sql['total_biaya'] - $row_sql['jml_transfer'];
                    $tampil3=number_format($kurang,0,",",".");  echo 'Rp '. $tampil3;
                  }else{
                    echo "Rp. 0";
                  }
                 
                  
                  ?></td>
            <td align="center" id="td_isi"><?php

                  if($tot_transfer < $row_sql['total_biaya']){
                    echo "DP";
                  }else{
                    echo "Lunas";
                  }
                 
                  
                  ?></td>
          </tr>
          <?php }while ($row_sql = mysql_fetch_assoc($sql)); ?>
      </table>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($sql);
?>