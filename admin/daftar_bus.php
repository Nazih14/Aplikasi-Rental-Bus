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
$query_sql = "SELECT * FROM daftar_bis ORDER BY nama_bus ASC";
$sql = mysql_query($query_sql, $database) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

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
		Daftar Ketersediaan Bus
	</div>
	<div id="konten">
    <div id="tambah"><a id="a_tambah" href="tambah_daftar_bus.php"><span class="fa fa-plus-square fa-fw"></span> Tambah&nbsp;</a></div>
      <table id="table" cellspacing="0">
        <tr>
          <td width="5%" id="td_judul">No.</td>
          <td width="35%" id="td_judul">Nama Bus</td>
          <td width="10%" id="td_judul">Tipe</td>
          <td width="15%" id="td_judul">Status</td>
          <td colspan="2" id="td_judul">Proses</td>
        </tr>
        <?php do { ?>
          <tr id="show">
            <td align="center"id="td_isi"><?php echo $noUrut++; ?></td>
            <td id="td_isi" style="padding-left:10px"><?php echo $row_sql['nama_bus']; ?></td>
            <td align="center" id="td_isi" style="padding-left:10px"><?php echo $row_sql['tipe']; ?></td>
            <td align="center" id="td_isi" style="padding-left:10px"><?php echo $row_sql['status']; ?></td>
            <td width="4%" align="center" id="td_isi"><a href="edit_daftar_bus.php?id=<?php echo $row_sql['id']; ?>" id="a_aksi"><span class="fa fa-edit fa-lg fa-fw"></span> </a></td>
            <td width="4%" align="center" id="td_isi"><a  onclick="return confirm('Anda Yakin Akan Menghapus')" href="hapus_daftar_bus.php?id=<?php echo $row_sql['id']; ?>" id="a_aksi"><span class="fa fa-trash-o fa-lg fa-fw"></span></a></td>
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
