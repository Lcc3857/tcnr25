<?php require_once('Connections/tcnr25.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE profiles SET Name=%s, `Old`=%s, Addr=%s WHERE id=%s",
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Old'], "int"),
                       GetSQLValueString($_POST['Addr'], "text"),
                       GetSQLValueString($_POST['ID'], "int"));

  mysql_select_db($database_tcnr25, $tcnr25);
  $Result1 = mysql_query($updateSQL, $tcnr25) or die(mysql_error());

  $updateGoTo = "detail.php?id=" . $row_dateailCord['id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_dateailCord = "-1";
if (isset($_GET['id'])) {
  $colname_dateailCord = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_tcnr25, $tcnr25);
$query_dateailCord = sprintf("SELECT * FROM profiles WHERE id = %s", $colname_dateailCord);
$dateailCord = mysql_query($query_dateailCord, $tcnr25) or die(mysql_error());
$row_dateailCord = mysql_fetch_assoc($dateailCord);
$totalRows_dateailCord = mysql_num_rows($dateailCord);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>update</title>
</head>

<body>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
<table width="100" border="1" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td>ID</td>
    <td>姓名</td>
    <td>年齡</td>
    <td>居住縣市</td>
  </tr>
  <tr>
    <td><input type="text" value="<?php echo $row_dateailCord['id']; ?>" readonly="true" name="ID" /></td>
    <td><input type="text" value="<?php echo $row_dateailCord['Name']; ?>" name="Name" /></td>
    <td><input type="text" value="<?php echo $row_dateailCord['Old']; ?>" name="Old" /></td>
	<td><input type="text" value="<?php echo $row_dateailCord['Addr']; ?>" name="Addr" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" value="送出" /></td>
    <td colspan="2"><a href="del.php?id=<?php echo $row_dateailCord['id']; ?>">刪除</a></td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($dateailCord);
?>
