<?php
require_once('Connections/database.php');

$kode = "-1";
if (isset($_GET['kode_order'])) {
  $kode = $_GET['kode_order'];
}
$jml_transfer = "-1";
if (isset($_GET['jml_transfer'])) {
  $jml_transfer = $_GET['jml_transfer'];
}
$konfirmasi = "Sudah";
if (isset($_POST)) {
	$updateSQL = "UPDATE `order` SET konfirmasi = '$konfirmasi' WHERE kode_order = '$kode'";
    mysql_select_db($database_database, $database);
  	$Result1 = mysql_query($updateSQL, $database) or die(mysql_error());
	
	exit("<script>window.location='cetak_nota.php?kode_order=$kode&&jml_transfer=$jml_transfer';</script>");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/frame_admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/assets/css/font-awesome.min.css">
</head>

<body>
<div class="induk">
    <div id="konten">
        <div style="text-align:center; font-size: 24px; font-weight: bold; color: #1d9d74; margin-top: 50px;">
            <span class="fa fa-check fa-lg"></span> Formulir Berhasil Dikirim
        </div>
    </div>
</div>
</body>
</html>