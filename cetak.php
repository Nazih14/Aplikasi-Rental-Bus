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
$query_sql = sprintf("SELECT * FROM `order` WHERE kode_order = %s", GetSQLValueString($kode, "int"));
$sql = mysql_query($query_sql, $database) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

$colname_sql2 = "-1";
if (isset($_GET['tujuan'])) {
  $colname_sql2 = $_GET['tujuan'];
}
mysql_select_db($database_database, $database);
$query_sql2 = sprintf("SELECT * FROM harga_sewa WHERE tujuan = %s", GetSQLValueString($colname_sql2, "text"));
$sql2 = mysql_query($query_sql2, $database) or die(mysql_error());
$row_sql2 = mysql_fetch_assoc($sql2);
$totalRows_sql2 = mysql_num_rows($sql2);
$lamatujuan = $row_sql2['lama'];

$jml_a = "-1";
if (isset($_GET['jml_bus_a'])) {
  $jml_a = $_GET['jml_bus_a'];
}
$jml_b = "-1";
if (isset($_GET['jml_bus_b'])) {
  $jml_b = $_GET['jml_bus_b'];
}
$lama = "-1";
if (isset($_GET['lama_pjln'])) {
  $lama = $_GET['lama_pjln'];
}

if($lama > $lamatujuan){
  $tlama = $lama + $lamatujuan;
  $total = (($jml_a * $row_sql2['seat_a'])+($jml_b * $row_sql2['seat_b']) +( $tlama * 250000));
  $overtime = ($lama - $lamatujuan) * 250000;
}else{
  $tlama = $lama;
  $total = (($jml_a * $row_sql2['seat_a'])+($jml_b * $row_sql2['seat_b']));
  $overtime = ($lama - $lamatujuan) * 250000;
}

$dp = ($total * 30)/100;

if (isset($_POST)) {
	$updateSQL = "UPDATE `order` SET total_biaya = '$total' WHERE kode_order = '$kode'";
    mysql_select_db($database_database, $database);
  	$Result1 = mysql_query($updateSQL, $database) or die(mysql_error());
}
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
            Rincian pengajuan pesanan anda :
        </div>
        <div style="text-align:center; font-size: 14px; margin: 10px auto;">
<table width="470" border="0" align="center">
              <tr>
                <td height="20" align="left" valign="middle">Kode Order</td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><?php echo $kode ?></td>
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
                <td height="20" align="left" valign="middle"><font style="font-weight: bold;">Total Biaya</font></td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><font style="font-weight: bold;">
                <?php $tampil=number_format($total,0,",",".");  echo 'Rp '. $tampil ?>
                </font></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle"><font style="font-weight: bold;">Biaya Overtime</font></td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><font style="font-weight: bold;">
                <?php $tampil3=number_format($overtime,0,",",".");  echo 'Rp '. $tampil3 ?>
                </font></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="middle"><font style="font-weight: bold;">Minimal DP</font></td>
                <td height="20" align="left" valign="middle">:</td>
                <td height="20" align="left" valign="middle"><font style="font-weight: bold;">
                <?php $tampil2=number_format($dp,0,",",".");  echo 'Rp '. $tampil2 ?>
                </font></td>
              </tr>
            </table>

    </div>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($sql);

mysql_free_result($sql2);
?>