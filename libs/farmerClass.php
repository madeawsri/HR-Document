<?php

/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 11/01/2017
 * Time: 5:37 PM
 */
class farmerClass
{
    private $dataFarmer = null;
    private $wonoFarmer = null;
    private $rqqtFarmer = null;
    private $orgFarm = null;
    private $smnameFarmer = null;
    private $fyear = '';
    private $fcode = '';

    public $hasFarmer = false;
    public $hasFwono = false;

    function __construct($cota,$year=''){
        $this->fyear = $year;
        $this->fcode = $cota;
        // SELECT * FROM   [dbo].[DD02FRMN] WHERE [FFARMERCD] = '0131285'
        $this->orgFarm = getMSSQLValueAll('DD02FRMN','FFARMNO'," FFARMERCD = '{$this->fcode}' ");

        $data = getMSSQLValues('RD01CUST as rd','[rd].[FCUCODE],[rd].[FCUNAME],[rd].[FSMCODE] , rd.FSLROUTE',"rd.FCUCODE = '{$this->fcode}' ");
        // SELECT [ld].[FSMNAME] FROM [dbo].[LD01SMAN] AS ld WHERE [ld].[FSMCODE] =
        $this->smnameFarmer = getMSSQLValue('[dbo].[LD01SMAN] AS ld','ld.FSMNAME',"[ld].[FSMCODE] = '{$data['FSMCODE']}' ");
        $this->hasFarmer = ($data)?true:false;
        if(!$this->hasFarmer) return false;

        $wono = getMSSQLValues(' [dbo].[PD20WOI1] as pd ',' pd.[FYEAR], [pd].[FWONO], [pd].[FRQQTY]'," pd.FCUCODE = '{$this->fcode}' and pd.FYEAR = '{$this->fyear}'  ");
        $this->hasFwono = ($wono)?true:false;
        if($wono){
                //------ Add in to DATA FARMER
                $data['FWONO'] = $wono['FWONO'];
                $data['FRQQTY'] = $wono['FRQQTY'];
        }
        $this->wonoFarmer = $data['FWONO'];
        $this->rqqtFarmer =  $data['FRQQTY'];
        $this->dataFarmer = MSSQLEncodeTH($data);
        return $this->hasFarmer;
    }

    function checkFarmno($frmno){
        return in_array($frmno, array_column($this->orgFarm, 'FFARMNO'));
    }

    function getSlroute(){return $this->dataFarmer['FSLROUTE'];}
    function getSmcode(){return $this->dataFarmer['FSMCODE'];}
    function getSmname(){return ConvertUTF8( $this->smnameFarmer);}
    function getQuata(){return $this->fcode;}
    function getName(){return $this->dataFarmer['FCUNAME'];}
    function getFwono(){
        return $this->wonoFarmer;
    }
    function getFrqqty(){
        return $this->rqqtFarmer;
    }
    function getValue($key=""){
        return ($key)?$this->dataFarmer[$key]:$this->dataFarmer;
    }
    function getFwonoAll(){
        $wono = getMSSQLValues('[dbo].[PD20WOI1] pd',' pd.[FYEAR], [pd].[FWONO], [pd].[FRQQTY]'," concat(pd.FCUCODE,pd.FYEAR) like '{$this->fcode}{$this->fyear}' ");
        return $wono;
    }
    function render(){
        return $this->dataFarmer;
    }


    // SELECT TOP 1000 FCUNAME,FCUNAMET,FAPPFLAG FROM [dbo].[RD01CUST]
    //SELECT [FWONO],[FRQQTY],[FUPDFLAG],[FUPDDATE] FROM Pd20woi1 WHERE [FYEAR] = '5960'


}

/*
 * SELECT fyear,fid
FROM `regcenter`
WHERE fyear = '5960'
group by fyear,fid
having count(fid)  >= 4

 * */