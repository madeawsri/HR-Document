<?php

/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 28/01/2017
 * Time: 11:44 AM
 */
class tableClass
{
    public $header = '';
    private $ret = '';

    private $id = '';
    public $rows = '';
    public $ishow = '10';
    public $showFooter = 'hide';
    public $search = 'true';
    public $paging = 'true';
    public $info = 'true';
    function __construct($id,$headers=null,$rows=null,$ishow='9',$showFooter='hide',$search='true',$paging = 'true',$info='true'){
        $this->id = $id;
        $this->rows = $rows;
        $this->ishow = $ishow;
        $this->showFooter = $showFooter;
        $this->search = $search;
        $this->paging = $paging;
        $this->info = $info;
        if($headers)
          $this->header = $this->tbHeader($headers);
        else $this->header = "<tr></tr>";
        return 0;
    }
    function tbHeader($headers){
        $hs = '<tr>';
        if($headers)
        foreach($headers as $k=> $v){
            $hs .=  "<th width=''>{$v}</th>";
        }
        return $hs.'</tr>';
    }
    function tbHeaderFix($headers,$cr){
        $hs = '<tr>';
        if($headers)
            foreach($headers as $k=> $v){
                $c = explode(',',$cr[$k]);
                $r = $c[1]; $c= $c[0];
                $hs .=  "<th colspan='{$c}' rowspan='{$r}' >{$v}</th>";
            }
        return $hs.'</tr>';
    }
    function tbRows($rows){
        $bd = '';
        $bd .=  '<tbody>';
        $trPattern = "<tr>%s</tr>";
        $rs = '';
        if($rows){
            foreach($rows as $k=>$v) {
                $kid = ($k+1);
                foreach ($v as $kk=>$vv) {
                    $rs .= "<td id='{$this->id}{$kk}{$kid}'>{$vv}</td>";
                }
                $bd .= sprintf($trPattern,$rs);
                $rs = '';
            }
        }
        $bd .='</tbody>';
        return $bd;
    }
    function tbFooter($showFooter,$hs){
        $ft = '';
        $ft .= "<tfoot class='{$showFooter}'>";
        $ft .= $this->header;
        $ft .= '</tfoot>';
        $ft .= '</table>';
        return $ft;
    }
    function render(){
        $this->ret .=  ' <table id="'.$this->id.'" class="table table-bordered table-striped" style="width:98%" ><thead>';
        $this->ret .= $this->header;
        $this->ret .= '</thead>';
        $this->ret .= $this->tbRows($this->rows);
        $this->ret .= $this->tbFooter($this->showFooter,$this->header);
        $this->ret .= '
        <script>
           $("#'.$this->id.'").DataTable({
            "pageLength": '.$this->ishow.',
            "paging": '.$this->paging.',
            "lengthChange": false,
            "searching":  '.$this->search.',  //false,
            "ordering": true,
            "info": '.$this->info.',
            "autoWidth": false,
            "aaSorting": [],
           });
        </script>
        ';
        return $this->ret;
    }

    //function (){ }





}