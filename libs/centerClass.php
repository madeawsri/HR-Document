<?php

/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 11/01/2017
 * Time: 6:51 PM
 */
class centerClass
{
    private  $dataCenter = null;
    private  $fyear = '';
    private  $fcode = '';
    public $centerInfo = null;
    public $sumCenterRqqty = 0;
    function __construct($pQuata='',$year=''){
        $this->fcode = $pQuata;
        $this->fyear = $year;
        if($year) {
            $data = getMYSQLValueAll('regcenter', '*', "fid = '{$pQuata}' and fyear = '{$year}' ");
            $this->sumCenterRqqty = (int)getMYSQLValue('regcenter','sum(svalue)',"fid = '{$pQuata}' and fyear = '{$year}' ");
        }else
            $data = getMYSQLValueAll('regcenter','*',"fid = '{$pQuata}' ");
        $this->dataCenter = $data;

        //***** Init Center Into
        $this->centerInfo = getMSSQLValueAll('[dbo].[RD01CXRF] as rc','[rc].[FCUXREF],[rc].[FDESC],[rc].[FDMARK]');

    }

    function getCode($code){
        foreach($this->centerInfo as $k=>$v){
            if(trim($v['FCUXREF'])==trim($code) || trim($v['FDMARK'])==trim($code)){
                return ConvertUTF8($v['FDMARK']);
            }
        }
    }

    function getName($code){
        foreach($this->centerInfo as $k=>$v){
            if(trim($v['FCUXREF'])==trim($code) || trim($v['FDMARK'])==trim($code)){
                return ConvertUTF8($v['FDESC']);
            }
        }
    }

    function checkRqqtyLessThenKSL($rn,$cn){
        $chkSum = $this->sumCenterRqqty + $cn;
        return  ($chkSum*1 <= $rn*1);
    }

    function render(){
        return $this->dataCenter;
    }
}