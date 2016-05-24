<?php
include('../Connections/database.php');

$waktu=1;
$deleteSQL="DELETE  FROM `order` WHERE konfirmasi = 'Belum' AND DATEDIFF(CURDATE(),tgl_order) > $waktu";
mysql_select_db($database_database, $database);
$Result1 = mysql_query($deleteSQL, $database) or die(mysql_error());
?>