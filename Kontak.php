<?php require_once('Connections/database.php'); ?>
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
$query_kontak = "SELECT * FROM kontak";
$kontak = mysql_query($query_kontak, $database) or die(mysql_error());
$row_kontak = mysql_fetch_assoc($kontak);
$totalRows_kontak = mysql_num_rows($kontak);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kontak</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/frame.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="induk">
  <h2 style="font-size: 20px;">Kontak Kami</h2><br />
  <p>Terima kasih atas kunjungan anda ke website PO. Arisa Pekalongan. Jika Anda mempunyai pertanyaan mengenai layanan PO. Arisa Pekalongan atau ingin menyampaikan informasi, saran dan keluhan yang dapat memperbaiki kinerja kami, silahkan menghubungi alamat di bawah ini.</p><br /><br />
    <table width="100%" border="0">
  <tr>
    <td width="13%" height="30" valign="middle">Alamat</td>
    <td width="2%" valign="middle">:</td>
    <td width="85%" valign="middle"><?php echo $row_kontak['alamat']; ?></td>
  </tr>
  <tr>
    <td height="30" valign="middle">Telephone</td>
    <td valign="middle">:</td>
    <td valign="middle"><?php echo $row_kontak['tlp']; ?></td>
  </tr>
  <tr>
    <td height="30" valign="middle">SMS</td>
    <td valign="middle">:</td>
    <td valign="middle"><?php echo $row_kontak['sms']; ?></td>
  </tr>
  <tr>
    <td height="30" valign="middle">eMail</td>
    <td valign="middle">:</td>
    <td valign="middle"><?php echo $row_kontak['email']; ?></td>
  </tr>
</table>

</div>
</body>
</html>
<?php
mysql_free_result($kontak);
?>
