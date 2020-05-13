<?php

/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 15/01/2017
 * Time: 4:23 PM
 */
class MsSQL {
    //เธชเน�เธงเธ�เธ�เธญเธ�เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญ
    var $host = MS_HOST ;
    var $database ;
    var $connect_db ;
    var $selectdb ;
    var $db ;
    var $sql ;
    var $table ;
    var $where;

    public $isConnect = false;
    public $errMsg = '';

////////////////////// เธ�เธฑเธ�เธ�เน�เธ�เธฑเน�เธ�เธ•เน�เธฒเธ�เน� //////////////////////
    function __construct($ip,$us,$ps,$dbn){
        return $this->connectdb($ip,$us,$ps,$dbn);
    }
    //เน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ”เธฒเธ•เน�เธฒเน€เธ�เธช
    function connectdb($ip,$us,$ps,$dbn){
        $this->database = $dbn;
        $this->username = $us;
        $this->password = $ps;
        $this->host = $ip;

         $this->connect_db = mssql_connect( $this->host, $this->username, $this->password ) or die(mssql_get_last_message());
       // $this->connect_db = mssql_connect( 'CENTER11', 'sa', 'C@neCenTer' ) or die(mssql_get_last_message());
          if($this->connect_db)
             $this->db = mssql_select_db ($this->database, $this->connect_db) or die(mssql_get_last_message());
        $this->isConnect =$this->connect_db;

        return $this->isConnect;

    }
    //เธ�เธดเธ”เธ�เธฒเธฃเน€เธ�เธทเน�เธญเธกเธ•เน�เธญเธ”เธฒเธ•เน�เธฒเน€เธ�เธช
    function closedb( ){
        mssql_close ( $this->connect_db ) or $this->_error();
    }
    function __destruct(){
        return $this->closedb();
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
    //เน�เธชเธ”เธ�เธ�เน�เธญเธ�เธงเธฒเธกเธ�เธดเธ”เธ�เธฅเธฒเธ”
    function _error(){
        // $this->error[]=mssql_errno();
        return mssql_get_last_message();
    }
    function _getError(){
        return mssql_get_last_message();
    }

    function exec($sql){
        $data = array();
        $rs = $this->select_query($sql);
        while($ar = $this->fetch($rs)){
            $data[] = $ar;
        }
        return $data;
    }
    function execonly($sql){
        $rs = $this->select_query($sql);
        return $rs;
    }

    function ExecuteSQL($sql,$mode="",$q=""){
        $data = array();
        if(strtolower($q) == "debug") echo $sql;
        $rs = $this->select_query($sql);
        if(strtolower($mode)=="data"){
            while($ar = $this->fetch($rs)){
                $data[] = $ar;
            }
            return $data;
        }else{
            return $rs;
        }

    }

    function getMSSQLValues($a,$b,$c=" 1=1 ",$q=0){
        $sql = "select {$b}  from {$a} where {$c} ";
        if($q) echo $sql;
        $ar = $this->fetch($this->select_query($sql));
        return $ar;
    }


}