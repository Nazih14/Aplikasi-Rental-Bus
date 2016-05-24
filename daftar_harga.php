<?php require_once('Connections/database.php'); ?>
<?php
include('hapus_otomatis.php');
mysql_select_db($database_database, $database);
$query_harga_sewa = "SELECT * FROM harga_sewa WHERE kategori = 'Paket' ORDER BY tujuan ASC";
$harga_sewa = mysql_query($query_harga_sewa, $database) or die(mysql_error());
$row_harga_sewa = mysql_fetch_assoc($harga_sewa);
$totalRows_harga_sewa = mysql_num_rows($harga_sewa);

mysql_select_db($database_database, $database);
$query_harga_sewa2 = "SELECT * FROM harga_sewa WHERE kategori = 'NB'";
$harga_sewa2 = mysql_query($query_harga_sewa2, $database) or die(mysql_error());
$row_harga_sewa2 = mysql_fetch_assoc($harga_sewa2);
$totalRows_harga_sewa2 = mysql_num_rows($harga_sewa2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar Harga</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/frame.css" rel="stylesheet" type="text/css" />
<link href="css/tabel.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="induk">
  <h2 style="font-size: 20px;">Daftar Harga Sewa</h2><br />
  <table width="100%" align="center" cellspacing="0">
    <tr>
      <td width="277" align="left" valign="baseline" style="font-weight:bold; font-size:14px; color:#de424f;">Tujuan</td>
      <td width="100" align="left" valign="baseline" style="font-weight:bold; font-size:14px; color:#de424f;">Lama</td>
      <td width="390" align="left" valign="baseline" style="font-weight:bold; font-size:14px; color:#de424f;">52 / 59 Seat</td>
      <td width="390" align="left" valign="baseline" style="font-weight:bold; font-size:14px; color:#de424f;">&nbsp;</td>
      <td width="378" align="left" valign="baseline" style="font-weight:bold; font-size:14px; color:#de424f;">31 / 32 Seat</td>
      <td width="378" align="left" valign="baseline" style="font-weight:bold; font-size:14px; color:#de424f;">&nbsp;</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_harga_sewa['tujuan']; ?></td>
        <td><?php echo $row_harga_sewa['lama']; ?> Hari</td>
        <td><?php $seat_a=number_format($row_harga_sewa['seat_a'],0,",",".");  echo 'Rp '. $seat_a ?></td>
        <td><a href="order52.php?tujuan=<?php echo $row_harga_sewa['tujuan']; ?>&&lama=<?php echo $row_harga_sewa['lama']; ?>" style="color: #de424f;">order</a></td>
        <td><?php $seat_b=number_format($row_harga_sewa['seat_b'],0,",","."); echo 'Rp '. $seat_b ?></td>
        <td><a href="order31.php?tujuan=<?php echo $row_harga_sewa['tujuan']; ?>&&lama=<?php echo $row_harga_sewa['lama']; ?>" style="color: #de424f;">order</a></td>
      </tr>
      <?php } while ($row_harga_sewa = mysql_fetch_assoc($harga_sewa)); ?>
    <tr>
      <td style="font-weight:bold; font-size:14px; color:#de424f;"><?php echo $row_harga_sewa2['tujuan']; ?></td>
      <td ></td>
      <td style="font-weight:bold; font-size:14px; color:#de424f;">
        <?php $seat_a=number_format($row_harga_sewa2['seat_a'],0,",",".");  echo 'Rp '. $seat_a .'/hari'?>
      </td>
      <td style="font-weight:bold; font-size:14px; color:#de424f;">&nbsp;</td>
      <td style="font-weight:bold; font-size:14px; color:#de424f;">
        <?php $seat_b=number_format($row_harga_sewa2['seat_b'],0,",",".");  echo 'Rp '. $seat_b .'/hari'?>
      </td>
      <td style="font-weight:bold; font-size:14px; color:#de424f;">&nbsp;</td>
    </tr>
  </table><br />
  <font style="font-size:12px; font-weight:bold; font-style:italic; color:#de424f;">NB. Harga sewaktu-waktu dapat berubah</font>
</div>
</body>
</html>
<?php
mysql_free_result($harga_sewa);
mysql_free_result($harga_sewa2);
?>
