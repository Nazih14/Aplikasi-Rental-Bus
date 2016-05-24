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

mysql_select_db($database_database, $database);
$query_info_rekening = "SELECT * FROM info_rekening";
$info_rekening = mysql_query($query_info_rekening, $database) or die(mysql_error());
$row_info_rekening = mysql_fetch_assoc($info_rekening);
$totalRows_info_rekening = mysql_num_rows($info_rekening);

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
		Setting - Rekening Anda
	</div>
	<div id="konten">
    <div id="tambah"><a id="a_tambah" href="tambah_rek.php"><span class="fa fa-plus-square fa-fw"></span> Tambah&nbsp;</a></div>
      <table id="table" cellspacing="0">
        <tr>
          <td width="5%" id="td_judul">No.</td>
          <td width="25%" id="td_judul">Atas Nama</td>
          <td width="15%" id="td_judul">BANK</td>
          <td width="35%" id="td_judul">Nomor rekening</td>
          <td colspan="2" id="td_judul">Proses</td>
        </tr>
        <?php do { ?>
          <tr id="show">
            <td align="center"id="td_isi"><?php echo $noUrut++; ?></td>
            <td id="td_isi" style="padding-left:10px"><?php echo $row_info_rekening['nama']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_info_rekening['bank']; ?></td>
            <td align="center" id="td_isi"><?php echo $row_info_rekening['no_rek']; ?></td>
            <td width="4%" align="center" id="td_isi"><a href="edit_rek.php?id=<?php echo $row_info_rekening['id']; ?>" id="a_aksi"><span class="fa fa-edit fa-lg fa-fw"></span> </a></td>
            <td width="4%" align="center" id="td_isi"><a  onclick="return confirm('Anda Yakin Akan Menghapus')" href="hapus_rekening.php?id=<?php echo $row_info_rekening['id']; ?>" id="a_aksi"><span class="fa fa-trash-o fa-lg fa-fw"></span></a></td>
          </tr>
          <?php } while ($row_info_rekening = mysql_fetch_assoc($info_rekening)); ?>
      </table>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($info_rekening);
?>
