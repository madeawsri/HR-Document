<?php

/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 16/01/2017
 * Time: 5:56 PM
 */
class billClass
{
    private  $fitemno = '';
    private  $dataBill = null;
    private  $fyear = '';
  function __construct($fyear='',$fitemno=''){
      if($fitemno)
          $this->fitemno = $fitemno;
      if($fyear)
          $this->fyear = $fyear;
      if($fitemno && $fyear)
         $this->dataBill = getMSSQLValues('DD11RRDT','*'," FITEMNO  = '{$this->fitemno}' AND FYEAR = '{$fyear}'  ");
      else
          $this->dataBill = getMSSQLValues('DD11RRDT','*'," FYEAR = '{$fyear}'  ");
  }




    function  render(){
        return $this->dataBill;
    }

}