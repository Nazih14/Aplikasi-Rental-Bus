<?php require_once('Connections/database.php'); ?>
<?php
include('hapus_otomatis.php');
mysql_select_db($database_database, $database);
$query_harga_sewa = "SELECT * FROM daftar_bis ORDER BY nama_bus ASC";
$harga_sewa = mysql_query($query_harga_sewa, $database) or die(mysql_error());
$row_harga_sewa = mysql_fetch_assoc($harga_sewa);
$totalRows_harga_sewa = mysql_num_rows($harga_sewa);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar Ketersediaan Bus</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/frame.css" rel="stylesheet" type="text/css" />
<link href="css/tabel.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="induk">
  <h2 style="font-size: 20px;">Daftar Ketersediaan Bus</h2><br />
  <table width="100%" align="center" cellspacing="0">
    <tr>
      <td align="left" valign="baseline" style="font-weight:bold; font-size:14px; color:#de424f;">Nama Bus</td>
      <td align="left" valign="baseline" style="font-weight:bold; font-size:14px; color:#de424f;">Tipe</td>
      <td align="left" valign="baseline" style="font-weight:bold; font-size:14px; color:#de424f;">Status</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_harga_sewa['nama_bus']; ?></td>
        <td><?php echo $row_harga_sewa['tipe']; ?></td>
        <td><?php echo $row_harga_sewa['status']; ?></td>
      </tr>
      <?php } while ($row_harga_sewa = mysql_fetch_assoc($harga_sewa)); ?>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($harga_sewa);
?>
