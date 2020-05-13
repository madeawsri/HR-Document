<?
/*
	เธ�เธทเน�เธญเน�เธ�เธฅเน�					class.mysql.php
	เธ�เธฒเธฃเน�เธ�เน�เธ�เธฒเธ�				    เน�เธ�เน�เน�เธ�เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ�เธฒเธ�เธ�เน�เธญเธกเธนเธฅ MySQL
	เธ�เธนเน�เน€เธ�เธตเธขเธ�					เธญเธฑเธฉเธ�เธฒ เธญเธดเธ�เธ•เน�เธฐ
	เธ•เธดเธ”เธ•เน�เธญ					webmaster@mocyc.com
*/


if (eregi("class.odbc.php",$_SERVER['PHP_SELF'])) {
    Header("Location: ../index.php");
    die();
}
class DBOD {
	//เธชเน�เธงเธ�เธ�เธญเธ�เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญ
	var $host = OD_HOST;
	var $database ;
	var $connect_db ;
	var $selectdb ;
	var $db ;
	var $sql ;
	var $table ;
	var $where;
////////////////////// เธ�เธฑเธ�เธ�เน�เธ�เธฑเน�เธ�เธ•เน�เธฒเธ�เน� //////////////////////
function __construct(){
		return($this->connectdb(OD_DBNAME,OD_USERNAME,OD_PASSWORD));
}
	//เน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ”เธฒเธ•เน�เธฒเน€เธ�เธช
function connectdb($db_name="database",$user="username",$pwd="password"){
global $dsnPort ;
  	$this->database = $db_name;
		$this->username = $user;
		$this->password = $pwd;

       $this->connect_db = @odbc_connect( $this->host, $this->username, $this->password ,'TH8TISASCII' ) or $this->_error();

      // $this->connect_db = odbc_connect( "dsnCCSNo", $this->username, $this->password  ) or $this->_error();

        //$dsn = "Driver={Microsoft Visual FoxPro Driver};SourceType=DBF;SourceDB=c:\\shortcut;Exclusive=NO;collate=Machine;NULL=NO;DELETED=NO;BACKGROUNDFETCH=NO;";

         //$connection_string = 'DRIVER={Microsoft dBase Driver (*.dbf)};'.
           //                   'datasource=C:\\AppServ\\www\\ccp\\ccs.dbf';
         //$this->connect_db = odbc_connect("dsnCCS",$user,$pwd);

         //if($this->connect_db){

         //}

		return true;
}
	//เธ�เธดเธ”เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ”เธฒเธ•เน�เธฒเน€เธ�เธช
function closedb( ){
		odbc_close ( $this->connect_db ) or $this->_error();
}
	//เน€เธ�เธดเน�เธกเธ�เน�เธญเธกเธนเธฅ
	//$db->add_db("table",array("field"=>"value"));
function add_db($table="table", $data="data"){
		$key = array_keys($data);
        $value = array_values($data);
		$sumdata = count($key);
		for ($i=0;$i<$sumdata;$i++)
        {
            if (empty($add)){
                $add="(";
            }else{
                $add=$add.",";
            }
            if (empty($val)){
                $val="(";
            }else{
                $val=$val.",";
            }
            $add=$add.$key[$i];
            $val=$val."'".$value[$i]."'";
        }
        $add=$add.")";
        $val=$val.")";
        $sql="INSERT INTO ".$table." ".$add." VALUES ".$val;
		//echo $sql;
        odbc_exec($this->connect_db,"BEGIN");
		if (odbc_exec($this->connect_db,$sql)){
		  $strSql = 'select last_insert_id() as lastId';
          $result = odbc_exec($this->connect_db,$strSql);
          while($row = @odbc_fetch_assoc($result)){ $lastId = $row['lastId']; }
            odbc_exec($this->connect_db,"COMMIT");
			return $lastId;
        }else{
            $this->_error();
			odbc_exec($this->connect_db,"ROLLBACK");
            return false;
    }
}
	//เน�เธ�เน�เน�เธ�เธ�เน�เธญเธกเธนเธฅเน�เธ�เธ�เธซเธฅเธฒเธขเธ�เธดเธฅเธฅเน�
	//$db->update_db("tabel",array("field"=>"value"),"where");
function update_db($table="table",$data="data",$where="where",$q=0){
        $key = array_keys($data);
        $value = array_values($data);
        $sumdata = count($key);
        $set="";
        for ($i=0;$i<$sumdata;$i++)
        {
            if (!empty($set)){
                $set=$set.",";
            }
            $set=$set.$key[$i]."='".$value[$i]."'";
        }
        $sql="UPDATE ".$table." SET ".$set." WHERE ".$where;
		if($q)
          echo $sql;
		odbc_exec($this->connect_db,"BEGIN");
        if (odbc_exec($this->connect_db,$sql)){
			odbc_exec($this->connect_db,"COMMIT");
            return true;
        }else{
            $this->_error();
			odbc_exec($this->connect_db,"ROLLBACK");
            return false;
    }
}
	//เน�เธ�เน�เน�เธ�เธ�เน�เธญเธกเธนเธฅเน�เธ�เธ�เธ�เธดเธฅเธฅเน�เน€เธ”เธตเธขเธง
	//$db->update("table","set","where");
function update($table="table",$set="set",$where="where",$q=0){
        $sql="UPDATE ".$table." SET ".$set." WHERE ".$where;
       if($q)
        print $sql;
	   odbc_exec($this->connect_db,"BEGIN");
				if (odbc_exec($this->connect_db,$sql)){
					odbc_exec($this->connect_db,"COMMIT");
            return true;
        }else{
            $this->_error();
			odbc_exec($this->connect_db,"ROLLBACK");
            return false;
   }
}
	//เธฅเธ�เธ�เน�เธญเธกเธนเธฅ
	//$db->del("table","where");
function del($table="table",$where="where"){
        $sql="DELETE FROM ".$table." WHERE ".$where;
        odbc_exec($this->connect_db,"BEGIN");
		if (odbc_exec($this->connect_db,$sql)){
			odbc_exec($this->connect_db,"COMMIT");
            return true;
        }else{
            $this->_error();
			odbc_exec($this->connect_db,"ROLLBACK");
            return false;
   }
}
	//เธ�เธฑเธ�เธ�เธณเธ�เธงเธ�เน�เธ–เธงเธ�เน�เธญเธกเธนเธฅ
	//$db->num_rows("table","field","where");
function num_rows($table="table",$field="field",$where="where") {
        if ($where=="") {
            $where = "";
        } else {
            $where = " WHERE ".$where;
        }
        $sql = "SELECT ".$field." FROM ".$table.$where;
	if($res = odbc_exec($this->connect_db,$sql)){
            return odbc_num_rows($res);
        }else{
            $this->_error();
            return false;
    }
}
	//Query เธ�เน�เธญเธกเธนเธฅ
	//$res = $db->select_query('SELECT field FROM table WHERE where');
function select_query($sql="sql",$q=0){
	if($q)
    echo $sql;
        if ($res = odbc_exec($this->connect_db, $sql)){
            return $res;
        }else{
            $this->_error();
            return false;
    }
}
	//เธ�เธฑเธ�เธ�เธณเธ�เธงเธ�เน�เธ–เธงเธ�เน�เธญเธกเธนเธฅ
	//$res = $db->select_query('SELECT field FROM table WHERE where');
	//$rows = $db->rows($res);
function rows($sql="sql"){
      if ($res = odbc_num_rows($sql)){
            return $res;
        }else{
            $this->_error();
            return false;
    }
}
	//เธ”เธถเธ�เธ�เน�เธฒ array
	//$res = $db->select_query('SELECT field FROM table WHERE where');
	//while ($arr = $db->fetch($res)) {
	//		echo $arr['a']." - ".$arr['c']."<br>\n";
	//}
function fetch($sql="sql"){

      if ($res = odbc_fetch_array($sql)){
            return $res;
        }else{
            $this->_error();
            return false;
   }
}
	//Class Fetch Row
function fetch_row($sql="sql"){
	 //print $sql;
      if ($res = odbc_fetch_row($sql)){
            return $res;
        }else{
            $this->_error();
            return false;
   }
}
	//เน�เธชเธ”เธ�เธ�เน�เธญเธ�เธงเธฒเธกเธ�เธดเธ”เธ�เธฅเธฒเธ”
function _error(){
       // $this->error[]=odbc_errno();
   }
}
function getODSQLMax($a,$b='id',$c=" 1=1 "){
  global $dbod;
  $sql = "select max($b) as val from {$a} where {$c} ";
 // print $sql;
  $ar = $dbod->fetch($dbod->select_query($sql));
  return $ar[val];
}

function getODSQLTopID($a,$c=" 1=1 "){
  global $dbod;
  $sql = "select max(id) as val from {$a} where {$c} ";
  $ar = $dbod->fetch($dbod->select_query($sql));
  return $ar[val];
}

function getODSQLValue($a,$b,$c=" 1=1 ",$q=0){
  global $dbod;
  $sql = "select {$b} as val from {$a} where {$c} ";
 if($q) print $sql;
  $ar = $dbod->fetch($dbod->select_query($sql));
  return $ar[val];
}

function insertODID(){
	 global $dbod;
	 return odbc_insert_id($dbod);
}

function getODSQLValues($a,$b,$c=" 1=1 ",$q=0){
  global $dbod;
  $sql = "select {$b}  from {$a} where {$c} ";
 if($q) print $sql;
  $ar = $dbod->fetch($dbod->select_query($sql));
  return $ar;
}

function getODSQLValueAll($a,$b="*",$c=" 1=1 ",$q=0){
  global $dbod;
  $sql = "select {$b}  from {$a} where {$c} ";
if($q)  echo $sql;
  $data = array();
  $rs = $dbod->select_query($sql);
  while($ar = $dbod->fetch($rs)){
    $data[] = $ar;
  }
  return $data;
}
?>
