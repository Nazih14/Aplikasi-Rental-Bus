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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE konten SET judul=%s, isi=%s WHERE id=%s",
                       GetSQLValueString($_POST['judul'], "text"),
                       GetSQLValueString($_POST['isi'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_database, $database);
  $Result1 = mysql_query($updateSQL, $database) or die(mysql_error());

  $updateGoTo = "berhasil.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_database, $database);
$query_utama = "SELECT * FROM konten WHERE kategori = 'utama'";
$utama = mysql_query($query_utama, $database) or die(mysql_error());
$row_utama = mysql_fetch_assoc($utama);
$totalRows_utama = mysql_num_rows($utama);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/frame_admin.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<script src="../js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
</head>

<body>
<div class="induk">
	<div id="judul">
		Setting - Halaman Utama
	</div>
    <div id="konten">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td class="td_judul" width="52" align="left" valign="top" nowrap="nowrap">Judul</td>
            <td width="1187">
            <div class="form-item">
            <input type="text" name="judul" value="<?php echo htmlentities($row_utama['judul'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
            </div></td>
          </tr>
          <tr valign="baseline">
            <td class="td_judul" align="left" valign="top" nowrap="nowrap">Isi</td>
            <td>
            
            <textarea class="ckeditor" id="editor1" name="isi" style="height:500px; margin-bottom: 10px;" ><?php echo htmlentities($row_utama['isi'], ENT_COMPAT, 'utf-8'); ?></textarea>
            <script language="javascript" type="text/javascript">
				CKEDITOR.replace( 'editor1',
				{
					height: '400px',
					filebrowserBrowseUrl : '/poarisa/js/browser/browser.php',
					filebrowserImageBrowseUrl : '/poarisa/js/browser/browser.php?type=Images',
					filebrowserUploadUrl : '/poarisa/js/uploader/upload.php',
					filebrowserImageUploadUrl : '/poarisa/js/uploader/upload.php?type=Images',
					filebrowserWindowWidth : '900',
					filebrowserWindowHeight : '400',
					filebrowserBrowseUrl : '/poarisa/js/ckfinder/ckfinder.html',
					filebrowserImageBrowseUrl : '/poarisa/js/ckfinder/ckfinder.html?type=Images',
					filebrowserFlashBrowseUrl : '/poarisa/js/ckfinder/ckfinder.html?type=Flash',
					filebrowserUploadUrl : '/poarisa/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
					filebrowserImageUploadUrl : '/poarisa/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
					filebrowserFlashUploadUrl : '/poarisa/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
				});
			</script>
            </td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right"></td>
            <td height="50" valign="middle"><input class="submit" type="submit" value="Perbarui" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="id" value="<?php echo $row_utama['id']; ?>" />
      </form>
      <p></p>
    </div>
    
</div>
</body>
</html>
<?php
mysql_free_result($utama);
?>
