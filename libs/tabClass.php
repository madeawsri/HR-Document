<?php

/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 8/3/2560
 * Time: 9:25
 */
class tabClass
{
    private  $tabs = null;
    private  $id = '';
   function __construct($id='tabid'){
      $this->id = $id;
      $this->tabs  = array();
   }
    function tabData($id='',$name='',$content='',$title='',$icon=''){
        $ret = array('id'=>$id,'name'=>$name,'title'=>$title,'content'=>$content,'icon'=>$icon);
        $this->tabs[] = $ret;
        return $ret;
    }
    function render(){
        $ret= '
        <style type="text/css">
            .board {width: 100%;background: #fff;}
            .board .nav-tabs {position: relative; margin-bottom: 0px;box-sizing: border-box;}
            .board > div.board-inner {background-size: 30%;}
            .narrow{padding: 20px;}
        </style>';
        $ret .= '<div class="board"><div class="board-inner" style="zoom: 0.8;"> ';
        $ret .= '<ul class="nav nav-tabs" id="'.$this->id.'">';
        foreach($this->tabs as $hk=>$hv) {
            $active = (!$hk)?'active':'';
            $ret .= '<li class="'.$active.'">
                  <a href="#'.$hv['id'].'" data-toggle="tab" title="'.$hv['title'].'">
                  <span class="round-tabs" >
                     <i class="'.$hv['icon'].' bb " style="padding-top:10px"></i>
                      '.$hv['name'].'
                  </span>
                  </a></li>';
        }
        $ret  .= '</ul></div>';
        $ret  .= '<div class="tab-content" style="padding-top: 20px;">';
        foreach($this->tabs as $hk=>$hv) {
            $active = (!$hk)?'active':'';
            $ret .= '<div class="tab-pane fade in '.$active.'" id="'.$hv['id'].'">'.$hv['content'].'</div>';
        }
        $ret .='<div class="clearfix"></div></div></div>';
        $ret = "<div >{$ret}</div>";
    return   $ret;
    }
    function render2(){
        $ret= '
        <style type="text/css">
            .board {width: 100%;background: #fff;}
            .board .nav-tabs {position: relative; margin-bottom: 0px;box-sizing: border-box;}
            .board > div.board-inner {background-size: 30%;}
            .narrow{padding: 20px;}
        </style>';
        $ret .= '<div class="board"><div class="board-inner" style="zoom: 0.8;"> ';
        $ret .= '<ul class="nav nav-tabs" id="'.$this->id.'">';
        foreach($this->tabs as $hk=>$hv) {
            $active = (!$hk)?'active':'';
            $ret .= '<li class="'.$active.'">
                  <a href="#'.$hv['id'].'" data-toggle="tab" title="'.$hv['title'].'">
                  <span class="round-tabs" >
                     <i class="'.$hv['icon'].' bb " style="padding-top:10px"></i>
                      '.$hv['name'].'
                  </span>
                  </a></li>';
        }
        $ret  .= '</ul></div>';
        $ret  .= '<div class="tab-content" style="padding-top: 20px;">';
        foreach($this->tabs as $hk=>$hv) {
            $active = (!$hk)?'active':'';
            $ret .= '<div class="tab-pane fade in '.$active.'" id="'.$hv['id'].'">'.$hv['content'].'</div>';
        }
        $ret .='<div class="clearfix"></div></div></div>';
        $ret = "<div >{$ret}</div>";
        return   $ret;
    }

}
/*
<script type="text/javascript">
    $(function () {
        $('a[title]').tooltip();
    });
</script>
*/