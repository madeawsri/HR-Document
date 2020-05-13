<?php

/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 15/01/2017
 * Time: 2:36 PM
 */
class libClass
{
    private $sqlCmd = '';

    function __construct()
    { /*@session_start();*/
    }

    function checkSession(){
        if( !isset($_SESSION['SS_USER']) ) {
            header( "location: ".SERVER_NAME."/" );
        }
    }

    function isMaster()
    {
        return $_SESSION[SS_USER][user] == 'boonyadol';
    }

    function isAdmin()
    {
        return $_SESSION[SS_USER][user] == HR_ADMIN;
    }

    function isUser()
    {
        return ($_SESSION[SS_USER]['pmtype'] != 0);
    }

    function isMenu($mode){ // open add edit del pdf
        $modes = array("open","add","edit","del","pdf","exp","ass");
        if ($_SESSION['SS_USER']['pmtype'] == 0  ) {  // admin
            return 1;
        } else { // user ohter
            if(in_array($mode,$modes)) {
                return (int)getMYSQLValue('gmenu g , menu m , tbinfo t',
                    ' g.' . $mode, ' t.loginid =  ' . $_SESSION['SS_USER']['id'] .
                    '  and m.fname = ' . "'{$_SESSION['M_FILE_NAME']}'" . ' and
                g.mid = m.id and g.pmid = ' . $_SESSION['SS_USER']['pmtype']);
            }else{
                return 0;
            }

        }
    }

    public function render($mode = 'my')
    {
        global $dbms, $dbmy;
        ${"db" . $mode}->select_query($this->sqlCmd);
    }

    public function MsExcute()
    {
        global $dbms;
        $dbms->select_query($this->sqlCmd);
    }

    public function MyExcute()
    {
        global $dbmy;
        $dbmy->select_query($this->sqlCmd);
    }


    function  arrayToSelect($data, $noDefaultValue = 0)
    {
        $ret = array();
        if ($noDefaultValue) $ret[] = " ";
        foreach ($data as $k => $v) {
            $ret[$v['id']] = $v['id'] . " - " . $v['name'];
        }
        return $ret;
    }

    function getDateTH($time,$g="-")
    {
        $d = date("d{$g}m{$g}", $time);
        $y = date('Y', $time) + 543;
        return $d . $y;
    }

    function JRender($str)
    {
        return "<script>{$str}</script>";
    }

    function getTable($tb, $f = '*', $w = '1=1')
    {
        return getMYSQLValueAll($tb, $f, $w);
    }

    function strCommar($str, $val, $mode = 'add', $g = ',')
    {
        $arr = explode($g, $str);
        $ret = null;
        switch (trim($mode)) {
            default:
            case "add":
                $arr[] = $val;
                $ret = implode($g, $arr);
                break;
            case "del":
                if ($arr)
                    foreach ($arr as $v)
                        if ($v != trim($val))
                            $ret[] = $v;
                break;
            case "ser":
                $ret = in_array(trim($val), $arr);
                break;
            case "edi":
                $val = explode($g, $val);
                $arr[array_search(trim($val[0]), $arr)] = $val[1];
                $ret = $arr;
                break;
        }
        return $ret;
    }

    function dbMGroup(){
        global $dbmy;
        return  $dbmy->exec("
        select g.id as gid ,
               g.name as gname,
               m.id as 'mid',
               m.name as mname,
               m.open,
               m.add,
               m.edit,
               m.del,
               m.pdf
          from menu as m , mgroup as g
         where m.gid = g.id
        ");
    }

    function dbMenu($key='1'){
        global $dbmy;
        if($key != '1')
            $key = " m.id in ({$key})  ";
        return  $dbmy->exec("
        select m.id,m.name
          from menu as m
         where {$key}
        ");
    }

    function dbGMenu(){
        global $dbmy;
        return  $dbmy->exec("
        select gm.id as gmid,
               (select pm.name from hr_pmtype as pm where pm.id = gm.pmid ) as gmname,
               gm.mid,
               gm.open,
               gm.add,
               gm.edit,
               gm.del,
               gm.pdf
          from gmenu as gm order by gm.pmid
        ");
    }

}