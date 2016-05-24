<?php require_once('Connections/database.php'); ?>
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

$kode = "-1";
if (isset($_GET['kode_order'])) {
  $kode = $_GET['kode_order'];
}
mysql_select_db($database_database, $database);
$query_sql = sprintf("SELECT a.*, b.* FROM `order` as a, konfirmasi_order as b WHERE b.kode_order = a.kode_order AND a.kode_order = %s", GetSQLValueString($kode, "int"));
$sql = mysql_query($query_sql, $database) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

$query2 = "SELECT SUM(jml_transfer) AS tot_transfer FROM konfirmasi_order WHERE kode_order = '$kode'";
$hasil2 = mysql_query($query2);
$data2  = mysql_fetch_array($hasil2);
$tot_transfer = $data2['tot_transfer'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/frame.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/assets/css/font-awesome.min.css">
</head>

<body>
<div class="induk">
    <div id="konten">
        <div style="text-align:center; font-size: 24px; font-weight: bold; color: #1d9d74; margin-top: 50px;">
            PO. Arisa Pekalongan
        </div>
        <div style="text-align:center; font-size: 14px; font-weight: bold; margin-top: 20px;">
            Nota pesanan anda :
        </div>
        <div style="text-align:center; font-size: 14px; margin: 10px auto;">
<table width="470" border="0" align="center">
              <tr>
                <td height="20" align="left" valign="middle">Kode Order</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php echo $row_sql['kode_order']; ?></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Tanggal Pemesanan</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php 
                $tanggalbaru = date('d-m-Y', strtotime($row_sql['tgl_order'] ));
                echo $tanggalbaru;
                ?></td>
              </tr>
              <tr>
                <td width="231" height="20" align="left" valign="middle">Nama</td>
                <td width="10" height="20" align="left" valign="middle">:</td>
                <td width="215" height="20" align="left" valign="middle"><?php echo $row_sql['pemesan']; ?></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Alamat</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php echo $row_sql['alamat']; ?></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Telephone</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php echo $row_sql['tlp']; ?></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Tujuan</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php echo $row_sql['tujuan']; ?></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Jumlah Bus 52 / 59 Seat</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php echo $row_sql['jml_bus_a']; ?> Unit</td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Jumlah Bus 31 / 32 Seat</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php echo $row_sql['jml_bus_b']; ?> Unit</td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Tanggal Berangkat</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php 
                $tanggalbaru2 = date('d-m-Y', strtotime($row_sql['tgl_berangkat'] ));
                echo $tanggalbaru2;
                ?></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Lama Perjalanan</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php echo $row_sql['lama_pjln']; ?> hari</td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Total Biaya</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle">
                <?php $tampil=number_format($row_sql['total_biaya'],0,",",".");  echo 'Rp '. $tampil ?>
                </td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Jumlah Transfer</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php $tampil2=number_format($row_sql['jml_transfer'],0,",",".");  echo 'Rp '. $tampil2 ?></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle">Kekurangan Yang Belum Dibayar</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php

                  if($tot_transfer < $row_sql['total_biaya']){
                    $kurang =  $row_sql['total_biaya'] - $row_sql['jml_transfer'];
                    $tampil3=number_format($kurang,0,",",".");  echo 'Rp '. $tampil3;
                  }else{
                    echo "Rp. 0";
                  }
                 
                  
                  ?></td>
              </tr>
            </table>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($sql);
?>