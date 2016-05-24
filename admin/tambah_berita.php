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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO berita (judul, isi, penulis) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['judul'], "text"),
                       GetSQLValueString($_POST['isi'], "text"),
                       GetSQLValueString($_POST['penulis'], "text"));

  mysql_select_db($database_database, $database);
  $Result1 = mysql_query($insertSQL, $database) or die(mysql_error());

  $insertGoTo = "berhasil2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/frame_admin.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/assets/css/font-awesome.min.css">
<script src="../js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#form1').validate({
        rules: {
           judul: {
              required: true
            },
            editor1:{
              required: true
            }
        }
      });
    });
    </script>
</head>

<body>
<div class="induk">
	<div id="judul">
		Tambah Konten Berita
	</div>
    <div id="konten">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline">
            <td width="52" align="left" valign="top" nowrap="nowrap" class="td_judul">Judul</td>
            <td width="1180">
            <div class="form-item">
            <input type="text" name="judul" value="" size="32" required />
            </div></td>
          </tr>
          <tr valign="baseline">
            <td class="td_judul" nowrap="nowrap" align="left" valign="top">Isi</td>
            <td>
            <textarea class="ckeditor" id="editor1" name="isi" style="height:500px; margin-bottom: 10px;" required ></textarea>
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
            <td height="50" valign="middle"><input class="submit" type="submit" value="Tambah" /></td>
          </tr>
        </table>
        <input type="hidden" name="penulis" value="<?php echo $_SESSION['nama_depan'];?>" size="32" />
        <input type="hidden" name="MM_insert" value="form1" />
      </form>
    </div>
    
</div>
</body>
</html>