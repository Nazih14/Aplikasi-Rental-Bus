<?php require_once('Connections/database.php'); ?>
<?php
include'hapus_otomatis.php';
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

mysql_select_db($database_database, $database);
$query_rek = "SELECT * FROM info_rekening";
$rek = mysql_query($query_rek, $database) or die(mysql_error());
$row_rek = mysql_fetch_assoc($rek);
$totalRows_rek = mysql_num_rows($rek);

$maxRows_berita = 3;
$pageNum_berita = 0;
if (isset($_GET['pageNum_berita'])) {
  $pageNum_berita = $_GET['pageNum_berita'];
}
$startRow_berita = $pageNum_berita * $maxRows_berita;

mysql_select_db($database_database, $database);
$query_berita = "SELECT * FROM berita ORDER BY tgl_terbit DESC";
$query_limit_berita = sprintf("%s LIMIT %d, %d", $query_berita, $startRow_berita, $maxRows_berita);
$berita = mysql_query($query_limit_berita, $database) or die(mysql_error());
$row_berita = mysql_fetch_assoc($berita);

if (isset($_GET['totalRows_berita'])) {
  $totalRows_berita = $_GET['totalRows_berita'];
} else {
  $all_berita = mysql_query($query_berita);
  $totalRows_berita = mysql_num_rows($all_berita);
}
$totalPages_berita = ceil($totalRows_berita/$maxRows_berita)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PO. Arisa Pekalongan</title>
<link href="css/style_user.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type='text/javascript'>
$(function() { $(window).scroll(function() { if($(this).scrollTop()>100) { $('.keatas').fadeIn()} else { $('.keatas').fadeOut();}});
$('.keatas').click(function(){$('html,body').animate({scrollTop:0},1000);return false})});
</script>

<script type="text/javascript">
$(function() {
	$('.tb-header li').hover(function() {
		$(this).children('ul').slideDown('fast');
		}, function() {
		$(this).children('ul').slideUp('fast');
	});
});
</script>

<script type="text/javascript">
	$(function() {
		$('#nav li').hover(function() {
			$(this).children('ul').slideDown('fast');
		}, function() {
			$(this).children('ul').slideUp('fast');
		});
	});
</script>

<script type='text/javascript'>
function calcHeight()
{
var the_height=
document.getElementById('id').contentWindow.document.body.scrollHeight;
document.getElementById('id').height=the_height;
}
</script>
</head>

<body>
<div class='keatas'>
<img alt='Back to top' src='gambar/kembali_keatas.png'/>
</div>

<div class="container">

	<div class="g_utama">
    </div>
    
    <div class="navigasi">
    	<nav id="nav">
            <ul>
            	<li><a href='index.php'>Home</a></li>
                <li><a href='tampil_berita.php' target="frame">Berita</a></li>
                <li><a href='tentang.php' target="frame">Tentang</a></li>
                <li><a href='daftar_harga.php' target="frame">Harga Sewa</a>
                <ul>
                  <li><a href='daftar_bus.php' target="frame">Ketersediaan Bis</a></li>
                </ul>
                </li>
                <li><a href='order.php' target="frame">Pemesanan</a>
                	<ul>
                    	<li><a href='cara_pesan.php' target="frame">Cara Pesan</a></li>
                        <li><a href='konfirmasi.php' target="frame">Konfirmasi Pembayaran</a></li>
                  </ul>
              </li>
                <li><a href='kontak.php' target="frame">Kontak</a></li>
          </ul>
        </nav>
</div>
    
    <div class="konten">
    	<div class="ifkonten">
            <iframe width="100%" id="id" onLoad="calcHeight();" src="utama.php" scrolling="NO" frameborder="0" height="1" name="frame">
			</iframe>
        </div>
        
  </div>
  
    <div class="footer">
        <div class="link_footer">
            <font style="font-weight:bold;">Navigasi</font><br />
            <a class="main_navigasi" href='index.php'>Home</a><br />
            <a class="main_navigasi" href="tampil_berita.php" target="frame">Berita</a><br />
            <a class="main_navigasi" href="tentang.php" target="frame">Tentang</a><br />
            <a class="main_navigasi" href="daftar_harga.php" target="frame">Harga Sewa</a><br />
            <a class="main_navigasi" href="order.php" target="frame">Pemesanan</a><br />
            <a class="main_navigasi" href="konfirmasi.php" target="frame">Konfirmasi Pembayaran</a><br />
            <a class="main_navigasi" href="kontak.php" target="frame">Kontak</a>
        </div>
        
        <div class="link_footer">
            <font style="font-weight:bold;">Rekening</font><br />
            <font style="font-size: 11px;">
            	<?php do { ?>
                <?php echo $row_rek['bank']; ?><br />
                Nama: <?php echo $row_rek['nama']; ?><br />
                No. Rek: <?php echo $row_rek['no_rek']; ?><br /><br />
                <?php } while ($row_rek = mysql_fetch_assoc($rek)); ?>
                </font>
        </div>
        
        <div class="link_footer_2">
        <font style="font-weight:bold;">Hubungi Kami</font><br />
            <font style="font-size: 11px;">
            Alamat: <?php echo $row_kontak['alamat']; ?> <br />
            Tlp: <?php echo $row_kontak['tlp']; ?> <br />
            SMS: <?php echo $row_kontak['sms']; ?> <br />
            eMail: <?php echo $row_kontak['email']; ?> <br />
          	</font>
        </div>
    </div>
    
</div>

<div class="copyright">
	© 2014 PO. Arisa Pekalongan | Created by Kuni STMIK WP Pekalongan
</div>
</body>
</html>
<?php
mysql_free_result($kontak);
mysql_free_result($berita);
mysql_free_result($rek);
?>
