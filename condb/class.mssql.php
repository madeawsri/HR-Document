<?
/*
	เธ�เธทเน�เธญเน�เธ�เธฅเน�					class.mysql.php
	เธ�เธฒเธฃเน�เธ�เน�เธ�เธฒเธ�				    เน�เธ�เน�เน�เธ�เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ�เธฒเธ�เธ�เน�เธญเธกเธนเธฅ MySQL
	เธ�เธนเน�เน€เธ�เธตเธขเธ�					เธญเธฑเธฉเธ�เธฒ เธญเธดเธ�เธ•เน�เธฐ
	เธ•เธดเธ”เธ•เน�เธญ					webmaster@mocyc.com
*/


if (eregi("class.mssql.php",$_SERVER['PHP_SELF'])) {
    Header("Location: ../index.php");
    die();
}
class DBMS {
	//เธชเน�เธงเธ�เธ�เธญเธ�เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญ
	var $host = MS_HOST ;
	var $database ;
	var $connect_db ;
	var $selectdb ;
	var $db ;
	var $sql ;
	var $table ;
	var $where; 
////////////////////// เธ�เธฑเธ�เธ�เน�เธ�เธฑเน�เธ�เธ•เน�เธฒเธ�เน� //////////////////////
function __construct(){
		return($this->connectdb(MS_DBNAME,MS_USERNAME,MS_PASSWORD));
}	
	//เน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ”เธฒเธ•เน�เธฒเน€เธ�เธช
function connectdb($db_name="database",$user="username",$pwd="password"){
		$this->database = $db_name;
		$this->username = $user;
		$this->password = $pwd;
		$this->connect_db = mssql_connect( $this->host, $this->username, $this->password ) or $this->_error();
		//$this->connect_db = mysql_pconnect ( $this->host, $this->username, $this->password ) or $this->_error();
		$this->db = mssql_select_db ( $this->database, $this->connect_db) or $this->_error();
		//mssql_query("SET NAMES utf-8"); 
		//mssql_query("SET character_set_results=utf-8"); 
		return true; 
}
	//เธ�เธดเธ”เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ”เธฒเธ•เน�เธฒเน€เธ�เธช
function closedb( ){
		mssql_close ( $this->connect_db ) or $this->_error();
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
        mssql_query("BEGIN");
		if (mssql_query($sql)){ 
		  $strSql = 'select last_insert_id() as lastId';  
          $result = mssql_query($strSql);  
          while($row = @mssql_fetch_assoc($result)){ $lastId = $row['lastId']; }  
            mssql_query("COMMIT");
			return $lastId; 
        }else{ 
            $this->_error(); 
			mssql_query("ROLLBACK");
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
		if($q)  echo $sql;
		mssql_query("BEGIN TRAN");
        if (mssql_query($sql)){ 
			mssql_query("COMMIT");
            return true; 
        }else{ 
            $this->_error(); 
			mssql_query("ROLLBACK");
            return false; 
    } 
} 
	//เน�เธ�เน�เน�เธ�เธ�เน�เธญเธกเธนเธฅเน�เธ�เธ�เธ�เธดเธฅเธฅเน�เน€เธ”เธตเธขเธง
	//$db->update("table","set","where");
function update($table="table",$set="set",$where="where"){ 
        $sql="UPDATE ".$table." SET ".$set." WHERE ".$where; 
       // print $sql;
	   mssql_query("BEGIN");
				if (mssql_query($sql)){ 
					mssql_query("COMMIT");
            return true; 
        }else{ 
            $this->_error(); 
			mssql_query("ROLLBACK");
            return false; 
   } 
} 
	//เธฅเธ�เธ�เน�เธญเธกเธนเธฅ
	//$db->del("table","where"); 
function del($table="table",$where="where"){ 
        $sql="DELETE FROM ".$table." WHERE ".$where; 
        mssql_query("BEGIN");
		if (mssql_query($sql)){
			mssql_query("COMMIT");
            return true; 
        }else{ 
            $this->_error(); 
			mssql_query("ROLLBACK");
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
	if($res = mssql_query($sql)){ 
            return mssql_num_rows($res); 
        }else{ 
            $this->_error(); 
            return false; 
    } 
} 
	//Query เธ�เน�เธญเธกเธนเธฅ
	//$res = $db->select_query('SELECT field FROM table WHERE where'); 
function select_query($sql="sql"){ 
	//echo $sql;
        if ($res = mssql_query($sql)){ 
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
      if ($res = mssql_num_rows($sql)){ 
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
      if ($res = mssql_fetch_assoc($sql)){ 
            return $res; 
        }else{ 
            $this->_error(); 
            return false; 
   } 
} 
	//Class Fetch Row
function fetch_row($sql="sql"){ 
	 //print $sql;
      if ($res = mssql_fetch_row($sql)){ 
            return $res; 
        }else{ 
            $this->_error(); 
            return false; 
   } 
}

function exec($sql,$q=0){
    $data = array();
    $rs = $this->select_query($sql);
    while($ar = $this->fetch($rs)){
        $data[] = $ar;
    }
    if($q)
        return $sql;
    else
    return $data;
}
function execonly($sql){
    $data = array();
    $rs = $this->select_query($sql);
    return $data;
}


	//เน�เธชเธ”เธ�เธ�เน�เธญเธ�เธงเธฒเธกเธ�เธดเธ”เธ�เธฅเธฒเธ”
function _error(){ 
       // $this->error[]=mssql_errno(); 
   } 
}
function getMSSQLMax($a,$b='id',$c=" 1=1 "){
  global $dbms;
  $sql = "select max($b) as val from {$a} where {$c} ";
 // print $sql;
  $ar = $dbms->fetch($dbms->select_query($sql));
  return $ar[val];
}
  
function getMSSQLTopID($a,$c=" 1=1 "){
  global $dbms;
  $sql = "select max(id) as val from {$a} where {$c} ";
  $ar = $dbms->fetch($dbms->select_query($sql));
  return $ar[val];
}

function getMSSQLValue($a,$b,$c=" 1=1 ",$q=0){
  global $dbms;
  $sql = "select {$b} as val from {$a} where {$c} ";
    if($q) echo $sql;
  $ar = $dbms->fetch($dbms->select_query($sql));
  return $ar[val];
}

function insertMSID(){
	 global $dbms;
	 return mssql_insert_id($dbms);
}

function getMSSQLValues($a,$b,$c=" 1=1 ",$q=0){
  global $dbms;
  $sql = "select {$b}  from {$a} where {$c} ";

  $ar = $dbms->fetch($dbms->select_query($sql));

    if($q) return $sql;
    else
    return $ar;
}

function getMSSQLValueAll($a,$b="*",$c=" 1=1 ",$q=0){
  global $dbms;
  $sql = "select {$b}  from {$a} where {$c} ";
  if($q)  echo $sql;
  $data = array();
  $rs = $dbms->select_query($sql);
  while($ar = $dbms->fetch($rs)){
    $data[] = $ar;
  }
  return $data;
}
?>