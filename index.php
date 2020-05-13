<?PHP
  require "conn.php";
  $dsInfo = getMYSQLValues("tbinfo","*","loginid = ".$_SESSION[SS_USER][id]);
  $_SESSION["SS_USER_INFO"] = $dsInfo;
  $userIcon = "user".rand(1,5);
  $_html->renderIndex( strtoupper( $_REQUEST['site'] ) . ' - '.PROJECT_NAME.' '.date('Y'));
?>  

