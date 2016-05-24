<?php require_once('../Connections/database.php'); ?>
<?php
include('hapus_otomatis.php');
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
$query_admin = "SELECT * FROM admin";
$admin = mysql_query($query_admin, $database) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);
$totalRows_admin = mysql_num_rows($admin);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin - PO. Arisa Pekalongan</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/style_admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/assets/css/font-awesome.min.css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type='text/javascript'>
function calcHeight()
{
var the_height=document.getElementById('id').contentWindow.document.body.scrollHeight;
document.getElementById('id').height=the_height;
}
</script>
</head>

<body>
<div class="header">
	<div class="g_admin"><a id="a_gadmin" href="index.php">ADMINpanel</a></div>
    <div class="box_logout">
       <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['nama_depan'];?> | <a href="<?php echo $logoutAction ?>" id="a_logout">Logout</a>
    </div>
</div>
<div class="menu_nav">
<ul class="ul_nav">
    <li><a href="berita.php" style="text-decoration:none" target="frame"><div class="tb_nav">
    		<span class="fa fa-bullhorn fa-lg fa-fw"></span> Konten Berita
    	</div></a></li>
  	   <li><a href="harga_sewa.php" style="text-decoration:none" target="frame"><div class="tb_nav">
    		<span class="fa fa-table fa-lg fa-fw"></span> Harga Sewa
    	</div></a></li>
      <li><a href="daftar_bus.php" style="text-decoration:none" target="frame"><div class="tb_nav">
        <span class="fa fa-table fa-lg fa-fw"></span> Daftar Ketersediaan Bus
      </div></a></li>
   	  <li><a href="pemesanan.php" style="text-decoration:none" target="frame"><div class="tb_nav">
    		<span class="fa fa-ticket fa-lg fa-fw"></span> Pemesanan
    	</div></a></li>
      <li><a href="konfirm_pesan.php" style="text-decoration:none" target="frame"><div class="tb_nav">
    		<span class="fa fa-gavel fa-lg fa-fw"></span> Konfirmasi Pesanan
    	</div></a></li>
      <li><a href="cetak.php" style="text-decoration:none" target="frame"><div class="tb_nav">
        <span class="fa fa-file-text-o fa-lg fa-fw"></span> Laporan
      </div></a></li>
      <li><a href="setting.php" style="text-decoration:none" target="frame"><div class="tb_nav">
        <span class="fa fa-wrench fa-lg fa-fw"></span> Setting
      </div></a></li>
</ul>	
</div>

<div class="container">
    <iframe width="100%" id="id" onLoad="calcHeight();" src="utama.php" scrolling="NO" frameborder="0" height="1" name="frame">
    </iframe>
</div>

<div class="footer">
	© 2014 PO. Arisa Pekalongan | Created by Kuni STMIK WP Pekalongan
</div>
</body>
</html>
<?php
mysql_free_result($admin);
?>
