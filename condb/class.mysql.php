<?
/*
	เธ�เธทเน�เธญเน�เธ�เธฅเน�					class.mysql.php
	เธ�เธฒเธฃเน�เธ�เน�เธ�เธฒเธ�				    เน�เธ�เน�เน�เธ�เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ�เธฒเธ�เธ�เน�เธญเธกเธนเธฅ MySQL
	เธ�เธนเน�เน€เธ�เธตเธขเธ�					เธญเธฑเธฉเธ�เธฒ เธญเธดเธ�เธ•เน�เธฐ
	เธ•เธดเธ”เธ•เน�เธญ					webmaster@mocyc.com
*/
if (eregi("class.mysql.php",$_SERVER['PHP_SELF'])) {
    Header("Location: ../index.php");
    die();
}
class DBMY{
	//เธชเน�เธงเธ�เธ�เธญเธ�เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญ
	var $host = MY_HOST ;
	var $database ;
	var $connect_db ;
	var $selectdb ;
	var $db ;
	var $sql ;
	var $table ;
	var $where; 
////////////////////// เธ�เธฑเธ�เธ�เน�เธ�เธฑเน�เธ�เธ•เน�เธฒเธ�เน� //////////////////////
function __construct(){
		return($this->connectdb(MY_DBNAME,MY_USERNAME,MY_PASSWORD));
}	
	//เน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ”เธฒเธ•เน�เธฒเน€เธ�เธช
function connectdb($db_name="database",$user="username",$pwd="password"){
		$this->database = $db_name;
		$this->username = $user;
		$this->password = $pwd;
		$this->connect_db = mysql_connect ( $this->host, $this->username, $this->password ) or $this->_error();
		//$this->connect_db = mysql_pconnect ( $this->host, $this->username, $this->password ) or $this->_error();
		$this->db = mysql_select_db ( $this->database, $this->connect_db) or $this->_error();
		mysql_query("SET NAMES utf8"); 
		mysql_query("SET character_set_results=utf8"); 
		return true; 
}
	//เธ�เธดเธ”เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ”เธฒเธ•เน�เธฒเน€เธ�เธช
function closedb( ){
		mysql_close ( $this->connect_db ) or $this->_error();
}
	//เน€เธ�เธดเน�เธกเธ�เน�เธญเธกเธนเธฅ
	//$db->add_db("table",array("field"=>"value")); 
function add_db($table="table", $data="data" , $q=0){
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
	if($q)
    return $sql;
        mysql_query("BEGIN");
		if (mysql_query($sql)){ 
		  $strSql = 'select last_insert_id() as lastId';  
          $result = mysql_query($strSql);  
          while($row = @mysql_fetch_assoc($result)){ $lastId = $row['lastId']; }  
            mysql_query("COMMIT");
			return $lastId; 
        }else{ 
            $this->_error(); 
			mysql_query("ROLLBACK");
            return false; 
    } 
}
	//เน�เธ�เน�เน�เธ�เธ�เน�เธญเธกเธนเธฅเน�เธ�เธ�เธซเธฅเธฒเธขเธ�เธดเธฅเธฅเน� 
	//$db->update_db("tabel",array("field"=>"value"),"where"); 
function update_db($table="table",$data="data",$where="where",$q = 0){
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
		if($q) return $sql;
		mysql_query("BEGIN");
        if (mysql_query($sql)){ 
			mysql_query("COMMIT");
            return true; 
        }else{ 
            $this->_error(); 
			mysql_query("ROLLBACK");
            return false; 
    } 
} 
	//เน�เธ�เน�เน�เธ�เธ�เน�เธญเธกเธนเธฅเน�เธ�เธ�เธ�เธดเธฅเธฅเน�เน€เธ”เธตเธขเธง
	//$db->update("table","set","where");
function update($table="table",$set="set",$where="where"){ 
        $sql="UPDATE ".$table." SET ".$set." WHERE ".$where; 
       // print $sql;
	   mysql_query("BEGIN");
				if (mysql_query($sql)){ 
					mysql_query("COMMIT");
            return true; 
        }else{ 
            $this->_error(); 
			mysql_query("ROLLBACK");
            return false; 
   } 
} 
	//เธฅเธ�เธ�เน�เธญเธกเธนเธฅ
	//$db->del("table","where"); 
function del($table="table",$where="where",$q=0){
        $sql="DELETE FROM ".$table." WHERE ".$where;
        if($q) return $sql;
        mysql_query("BEGIN");
		if (mysql_query($sql)){
			mysql_query("COMMIT");
            return true; 
        }else{ 
            $this->_error(); 
			mysql_query("ROLLBACK");
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
	if($res = mysql_query($sql)){ 
            return mysql_num_rows($res); 
        }else{ 
            $this->_error(); 
            return false; 
    } 
} 
	//Query เธ�เน�เธญเธกเธนเธฅ
	//$res = $db->select_query('SELECT field FROM table WHERE where'); 
function select_query($sql="sql"){ 
	//echo $sql;
        if ($res = mysql_query($sql)){ 
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
      if ($res = mysql_num_rows($sql)){ 
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
      if ($res = mysql_fetch_assoc($sql)){
            return $res; 
        }else{ 
            $this->_error(); 
            return false; 
   } 
} 
	//Class Fetch Row
function fetch_row($sql="sql"){ 
	 //print $sql;
      if ($res = mysql_fetch_row($sql)){ 
            return $res; 
        }else{ 
            $this->_error(); 
            return false; 
   } 
} 
	//เน�เธชเธ”เธ�เธ�เน�เธญเธ�เธงเธฒเธกเธ�เธดเธ”เธ�เธฅเธฒเธ”
function _error(){ 
        $this->error[]=mysql_errno(); 
   }

    function  exec($sql){
        $rs = $this->select_query($sql);
        while($ar = $this->fetch($rs)){
            $data[] = $ar;
        }
        return $data;
    }

}
function getMYSQLMax($a,$b='id',$c=" 1=1 "){
  global $dbmy;
  $sql = "select max($b) as val from {$a} where {$c} ";
 // print $sql;
  $ar = $dbmy->fetch($dbmy->select_query($sql));
  return $ar[val];
}
  
function getMYSQLTopID($a,$c=" 1=1 "){
  global $dbmy;
  $sql = "select max(id) as val from {$a} where {$c} ";
  $ar = $dbmy->fetch($dbmy->select_query($sql));
  return $ar[val];
}

function getMYSQLValue($a,$b,$c=" 1=1 ",$q=0){
  global $dbmy;
  $sql = "select {$b} as val from {$a} where {$c} ";
  if($q)print $sql;
  $ar = $dbmy->fetch($dbmy->select_query($sql));
  return $ar[val];
}

function insertMYID(){
	 global $dbmy;
	 return mysql_insert_id($dbmy);
}

function getMYSQLValues($a,$b,$c=" 1=1 ",$q=0){
  global $dbmy;
  $sql = "select {$b}  from {$a} where {$c} ";
  if($q) print $sql;
    $rs = $dbmy->select_query($sql);
    $ar = $dbmy->fetch($rs);
  return $ar;
}

function getMYSQLValueAll($a,$b="*",$c=" 1=1 ",$q=0){
  global $dbmy;
  $sql = "select {$b}  from {$a} where {$c} ";
    if($q) print $sql;
    $data = array();
  $rs = $dbmy->select_query($sql);
  while($ar = $dbmy->fetch($rs)){
    $data[] = $ar;
  }
  return $data;
}



?>