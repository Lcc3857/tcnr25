<?php require_once('Connections/tcnr25.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_indexCord = 3;
$pageNum_indexCord = 0;
if (isset($_GET['pageNum_indexCord'])) {
  $pageNum_indexCord = $_GET['pageNum_indexCord'];
}
$startRow_indexCord = $pageNum_indexCord * $maxRows_indexCord;

mysql_select_db($database_tcnr25, $tcnr25);
$query_indexCord = "SELECT * FROM profiles";
$query_limit_indexCord = sprintf("%s LIMIT %d, %d", $query_indexCord, $startRow_indexCord, $maxRows_indexCord);
$indexCord = mysql_query($query_limit_indexCord, $tcnr25) or die(mysql_error());
$row_indexCord = mysql_fetch_assoc($indexCord);

if (isset($_GET['totalRows_indexCord'])) {
  $totalRows_indexCord = $_GET['totalRows_indexCord'];
} else {
  $all_indexCord = mysql_query($query_indexCord);
  $totalRows_indexCord = mysql_num_rows($all_indexCord);
}
$totalPages_indexCord = ceil($totalRows_indexCord/$maxRows_indexCord)-1;

$queryString_indexCord = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_indexCord") == false && 
        stristr($param, "totalRows_indexCord") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_indexCord = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_indexCord = sprintf("&totalRows_indexCord=%d%s", $totalRows_indexCord, $queryString_indexCord);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>home</title>
</head>

<body>
<table width="100" border="1" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td>ID</td>
    <td>Name</td>
    <td>Old</td>
    <td>Addr</td>
  </tr>
  
  <?php do { ?>
  <tr>
    <td><?php echo $row_indexCord['id']; ?></td>
    <td><a href="detail.php?id=<?php echo $row_indexCord['id']; ?>"><?php echo $row_indexCord['Name']; ?></a></td>
    <td><?php echo $row_indexCord['Old']; ?></td>
    <td><?php echo $row_indexCord['Addr']; ?></td>
  </tr>
  <?php } while ($row_indexCord = mysql_fetch_assoc($indexCord)); ?>
  
</table>




<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_indexCord > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_indexCord=%d%s", $currentPage, 0, $queryString_indexCord); ?>">第一頁</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_indexCord > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_indexCord=%d%s", $currentPage, max(0, $pageNum_indexCord - 1), $queryString_indexCord); ?>">上一頁</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_indexCord < $totalPages_indexCord) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_indexCord=%d%s", $currentPage, min($totalPages_indexCord, $pageNum_indexCord + 1), $queryString_indexCord); ?>">下一頁</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_indexCord < $totalPages_indexCord) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_indexCord=%d%s", $currentPage, $totalPages_indexCord, $queryString_indexCord); ?>">最後頁</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($indexCord);
?>
