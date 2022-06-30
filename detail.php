<?php require_once('Connections/tcnr25.php'); ?>
<?php
$colname_detailCord = "-1";
if (isset($_GET['id'])) {
  $colname_detailCord = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_tcnr25, $tcnr25);
$query_detailCord = sprintf("SELECT * FROM profiles WHERE id = %s", $colname_detailCord);
$detailCord = mysql_query($query_detailCord, $tcnr25) or die(mysql_error());
$row_detailCord = mysql_fetch_assoc($detailCord);
$totalRows_detailCord = mysql_num_rows($detailCord);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>設定</title>
</head>

<body>
<table width="100" border="1" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td>ID</td>
    <td>姓名</td>
    <td>年齡</td>
    <td>居住縣市</td>
  </tr>
  <tr>
    <td><input type="text" value="<?php echo $row_detailCord['id']; ?>" readonly="true" /></td>
    <td><input type="text" value="<?php echo $row_detailCord['Name']; ?>" readonly="true" /></td>
    <td><input type="text" value="<?php echo $row_detailCord['Old']; ?>" readonly="true" /></td>
	<td><input type="text" value="<?php echo $row_detailCord['Addr']; ?>" readonly="true" /></td>
  </tr>
  <tr>
    <td colspan="2"><a href="update.php?id=<?php echo $row_detailCord['id']; ?>">更新</a></td>
    <td colspan="2"><a href="del.php?id=<?php echo $row_detailCord['id']; ?>">刪除</a></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($detailCord);
?>
