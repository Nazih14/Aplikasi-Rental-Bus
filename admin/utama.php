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
if (!isset($_SESSION)) {
  session_start();
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
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/frame_admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"/></script>
</head>
<body>
<div class="induk">
	<div class="sub_induk">
	<h2 style="font-size: 20px;">Hello <?php echo $_SESSION['nama_depan']; ?>, Selamat Datang di Admin Area</h2><br />
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae, ullam, aperiam dignissimos accusantium autem numquam velit iste veritatis obcaecati et architecto reprehenderit quidem eos iure cumque ducimus animi doloremque error ipsam nulla expedita illum inventore voluptas atque ab quos labore eius tempore rem sit consequatur fuga incidunt sed voluptatum neque.</p>
	</div>
	
</div>
</body>
</html>
<?php
mysql_free_result($admin);
?>
