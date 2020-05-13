<?php

/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 11/01/2017
 * Time: 9:43 AM
 */
abstract class __boxStyle
{
    const  __Default = 'box-default'
    , Primary = 'box-primary'
    , Info = 'box-info'
    , Warning = 'box-warning'
    , Success = 'box-success'
    , Danger = 'box-danger';
}

abstract class __labelStyle
{
    const  __Default = 'label-default'
    , Primary = 'label-primary'
    , Info = 'label-info'
    , Warning = 'label-warning'
    , Success = 'label-success'
    , Danger = 'label-danger';
}

class htmlClass
{
    public $boxTitle = "";
    public $labelText = "";
    public $boxBody = '';
    public $boxFooter = '';
    public $boxStyle = __boxStyle::__Default;
    public $labelStyle = __labelStyle::__Default;

    public $label = "";

    function __construct()
    {
        //echo ColorStyle::csPrimary;

    }

    function boxTag($title, $body, $footer, $style = __boxStyle::Primary)
    {
        $this->boxTitle = $title;
        $this->boxBody = $body;
        $this->boxFooter = $footer;
        $this->boxStyle = $style;
    }

    function boxRender()
    {
        $label = $this->labelTag('', $this->labelText);
        return '
        <div class="box ' . $this->boxStyle . '  ">
          <div class="box-header with-border">
            <h3 class="box-title">' . $this->boxTitle . '</h3>
            <div class="box-tools pull-right">
              <!-- Buttons, labels, and many other things can be placed here! -->
              <!-- Here is a label for example -->
              ' . $label . '
            </div><!-- /.box-tools -->
          </div><!-- /.box-header -->
          <div class="box-body">
            ' . $this->boxBody . '
          </div><!-- /.box-body -->
          <div class="box-footer">
            ' . $this->boxFooter . '
          </div><!-- box-footer -->
        </div><!-- /.box -->
        ';
    }

    public function labelTag($id, $labelText, $labelStyle = "")
    {
        $labelText = ($labelText) ? $labelText : $this->labelText;
        $labelStyle = ($labelStyle) ? $labelStyle : $this->labelStyle;
        return '<span id="' . $id . '" class="label ' . $labelStyle . ' ">' . $labelText . '</span>';
    }

    public function buTag($str)
    {
        return "<b class='uu'>{$str}</b>";
    }

    public function spanTag($str, $tag)
    {
        return "<span class='{$tag}'>{$str}</span>";
    }

    function txtColor($str, $color)
    {
        return "<span style='color:{$color};'>{$str}</span>";
    }

    private $formMethod = '';
    private $formID = '';
    private $formBody = '';
    private $formStyle = '';
    private $formOther = '';

    function formTag($id, $body, $met = 'post', $style = '', $other = '')
    {
        $this->formID = $id;
        $this->formMethod = $met;
        $this->formBody = $body;
        $this->formStyle = $style;
        $this->formOther = $other;
    }

    function formRender()
    {
        return '
        <form role="form" name="' . $this->formID . '" id="' . $this->formID . '" method="' . $this->formMethod . '"  style="' . $this->formStyle . '" ' . $this->formOther . '>' . $this->formBody . '</form>
        ';
    }

    function elementFormTag($mode, $id, $name, $title, $value = '', $class = '', $other = '', $jother = '')
    { //-- placeholder="โควต้า 01XXXXX" required="required"
        $hide = (strpos($class, 'hide') !== false) ? 'hide' : '';
        $isModal = (strpos($class, 'modal') !== false) ? true : false;

        $ret = '';
        switch (trim($mode)) {
            case "textarea":
                $ret = '
          <div class="form-group element ' . $hide . '">
               <label for="' . $name . '"> ' . $title . ' <span id="lable-' . $id . '"></span></label>
               <textarea  rows="10"  class=" form-control ' . $class . ' " name="' . $name . '"  id="' . $id . '" ' . $other . '>' . $value . '</textarea>
               <p class="help-' . $id . '"></p>
          </div>
        ';
                break;
            case "mask":  //data-inputmask=\'"mask": "0199999"\'
                $ret = '
                    <div class="form-group">
                        <label for="' . $name . '"> ' . $title . ' <span id="lable-' . $id . '"></span></label>
                        <input type="textbox" class=" form-control ' . $class . ' "
                               name="' . $name . '" value="' . $value . '"
                               id="' . $id . '" ' . $other . ' data-mask>
                    </div><script>$("#' . $id . '").inputmask();</script>
                ';
                break;
            case "hidden":
            case "file":
            case "submit":
            case "date":
            case "textbox":
                $ret = '
          <div class="form-group element ' . $hide . '">
               <label for="' . $name . '"> ' . $title . ' <span id="lable-' . $id . '"></span></label>
               <input type="' . $mode . '" class=" form-control ' . $class . ' " name="' . $name . '" value="' . $value . '" id="' . $id . '" ' . $other . '>
               <p class="help-' . $id . '"></p>
          </div>
        ';
                break;
            case "radio":

                $ret = '
          <div class="form-group element ' . $hide . '">
               <label for="' . $name . '"> ' . $title . ' <span id="lable-' . $id . '"></span></label>
               <input type="' . $mode . '" class=" form-control ' . $class . ' " name="' . $name . '" value="' . $value . '" id="' . $id . '" ' . $other . '>
               <p class="help-' . $id . '"></p>
          </div>
        ';
                break;
            case "number":
                $ret = '
          <div class="form-group element ' . $hide . '">
               <label for="' . $name . '"> ' . $title . ' <span id="lable-' . $id . '"></span></label>
               <input type="number" class=" form-control ' . $class . ' " name="' . $name . '" value="' . $value . '"     id="' . $id . '" ' . $other . '>
               <p class="help-' . $id . '"></p>
          </div>
        ';
                break;

            case "checkbox":
                $ret = '
        <div class="form-group element ' . $hide . '">
            <label for="' . $name . '"> ' . $title . ' <span id="lable-' . $id . '"></span></label>
            <input type="checkbox" class=" form-control probeProbe ' . $class . ' " name="' . $name . '" value="' . $value . '"   id="' . $id . '" ' . $other . '>
            <p class="help-' . $id . '"></p>
        </div>
        ';
                $ret .= "<script>  $('#{$id}').bootstrapSwitch('state', false); </script>";
                break;

            case "button":
            case "reset":
                $ret = '<label for="' . $name . '"> ' . $title . ' <span id="lable-' . $id . '"></span> </label>
               <input type="' . $mode . '" class="form-control ' . $class . ' " name="' . $name . '" value="' . $value . '" id="' . $id . '" ' . $other . '>
               <p class="help-' . $id . '"></p>';
                break;
            case "datepicker":
                $ret = '
                  <div class="form-group element ' . $hide . '">
                       <label for="' . $name . '"> ' . $title . ' <span id="lable-' . $id . '"></span></label>
                       <div class="input-group">
                         <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                         <input type="text" class="form-control pull-right" id="' . $id . '"  value="' . $value . '" >
                       </div>
                       <p class="help-' . $id . '"></p>
                  </div>
                ';
                $ret .= " <script> $('#{$id}').daterangepicker({format: 'YYYY/MM/DD'}); </script> ";
                break;
            case "select":
                $ret = '<div class="form-group element ' . $hide . '">
                         <label for="' . $name . '"> ' . $title . ' <span id="lable-' . $id . '"></span></label>
                       ';
                $ret .= "<select class=\"form-control \"  style='width: 98%;' id='{$id}' name=\"{$name}\" {$other}>";
                if (is_array($value))
                    foreach ($value as $k => $v) {
                        $ret .= " <option  value='{$k}' > {$v} </option> ";
                    }
                $ret .= "</select>";
                $ret .= '</div>';
                if (!$isModal)
                    $ret .= " <script> $('#{$id}').select2({{$jother}}); </script>";
                break;
        }
        return $ret;
    }

    function divTag($id, $content = '', $class = '', $other = '')
    {
        return '
          <div id="' . $id . '" class="' . $class . '" ' . $other . ' >' . $content . '</div>
        ';
    }

    function alertTag($id, $title)
    {
        return '
           <div id="' . $id . '" class="bb-alert alert alert-info " style="display: none" >
             <span>' . $title . '</span>
           </div>
        ';
    }

    function boxTable($id, $headers, $rows = null, $ishow = '10', $showFooter = 'hide', $search = true, $paging = true)
    {
        /*
          <!-- DataTables -->
               <link rel="stylesheet" href="<?=SERVER_NAME?>/../assets/plugins/datatables/dataTables.bootstrap.css">
               <script src="<?=SERVER_NAME?>/../assets/plugins/datatables/jquery.dataTables.min.js"></script>
               <script src="<?=SERVER_NAME?>/../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
        */
        $hs = '';
        $ret = ' <table id="' . $id . '" class="table table-bordered table-striped" ><thead><tr> ';
        if ($headers)
            foreach ($headers as $v) {
                $hs .= '<th>' . $v . '</th>';
            }
        $ret .= $hs;
        $ret .= '</tr></thead>';
        $ret .= '<tbody>';
        $trPattern = "<tr>%s</tr>";
        $rs = '';
        if ($rows) {
            foreach ($rows as $k => $v) {
                foreach ($v as $vv)
                    $rs .= "<td>{$vv}</td>";
                $ret .= sprintf($trPattern, $rs);
                $rs = '';
            }
        }
        $ret .= '</tbody>';
        $ret .= '<tfoot class="' . $showFooter . '">';
        $ret .= '<tr>' . $hs . '</tr>';
        $ret .= '</tfoot>';
        $ret .= '</table>';

        $ret .= '
        <script>
           $("#' . $id . '").DataTable({
            "pageLength": ' . $ishow . ',
            "paging": ' . $paging . ',
            "lengthChange": false,
            "searching":  ' . $search . ',  //false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "aaSorting": []
           });
        </script>
        ';
        return $ret;
    }

    function boxTableFormDB($id, $datas)
    {
        $hs = '';
        $ret = ' <table id="' . $id . '" class="table table-bordered table-striped" ><thead><tr> ';
        if ($datas)
            foreach ($datas[0] as $k => $v) {
                //foreach($v as $vv)
                $hs .= '<th>' . $k . '</th>';
            }
        $ret .= $hs;
        $ret .= '</tr></thead>';
        $ret .= '<tbody>';
        $trPattern = "<tr>%s</tr>";
        $rs = '';
        if ($datas) {
            foreach ($datas as $k => $v) {
                foreach ($v as $vv)
                    $rs .= "<td x:str>{$vv}</td>";
                $ret .= sprintf($trPattern, $rs);
                $rs = '';
            }
        }
        $ret .= '</tbody></table>';
        return $ret;

    }

    function boxLoading($id)
    {
        return '<div id="' . $id . '" style="display:none"><img src="' . SERVER_NAME . '/../assets/images/ajax-loader.gif" border=0 /></div>';
    }

    function includeAll($_PageName)
    {
        $serv = SERVER_NAME;
        $time = TIMESTAMP;
        $ret = "
        <link rel='stylesheet' href='{$serv}/../modules/css/loader.css?v={$time}'>
        <script>var jFileName = '{$_PageName}'; </script>
        <script src='{$serv}/../modules/js/{$_PageName}.js?v={$time}'></script>
        ";
        return $ret;
    }

    /*
             <!-- DATE PICKER -->
        <link rel='stylesheet' href='{$serv}/../assets/plugins/daterangepicker/daterangepicker-bs3.css?v={$time}'>
        <script src='{$serv}/../assets/plugins/daterangepicker/daterangepicker.js?v={$time}'></script>
        <!-- Notiny Alert Mssage-->
        <link href='{$serv}/../assets/plugins/notiny/dist/styles/metro/notify-metro.css?v={$time}' rel='stylesheet' />
        <script src='{$serv}/../assets/plugins/notiny/dist/notify.js?v={$time}'></script>
        <script src='{$serv}/../assets/plugins/notiny/dist/styles/metro/notify-metro.js?v={$time}'></script>
     * */
    function boxMenu($title, $link, $icon = 'ion-ios-list-outline', $bg = 'bg-light-blue')
    {
        $ret = "
            <div class=\"col-lg-3 col-xs-6\">
              <div class=\"small-box {$bg} \">
                  <div class=\"inner\">
                     <i class=\"icon ion {$icon} \"></i> <p>{$title}</p>
                  </div>
                   <a href=\"{$link}\" class=\" small-box-footer text-right \">
                   read more <i class=\" fa fa-arrow-circle-right \"></i></a>
              </div>
           </div>
        ";
        return $ret;
    }

    /* HOME PAGE INDEX  ************************************/
    function html_header()
    {
        global $site, $userIcon;
        ?>
        <header class="main-header">
            <!-- Logo -->
            <a href="<?= SERVER_NAME ?>/" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b><?= PROJECT_NAME ?></b><?= strtoupper($site) ?></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b><?= PROJECT_NAME ?></b> <?= strtoupper($site) ?></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle hide" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success"><? $objInitClass = new htmlClass(); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img
                                                        src="<?= SERVER_NAME ?>/../assets/dist/img/<?= $userIcon ?>.png"
                                                        class="img-circle" alt="User Image">
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle hide" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu ">
                            <a href="#" class="dropdown-toggle hide" data-toggle="dropdown">
                                <i class="fa fa-flag-o"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                         role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                         aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= SERVER_NAME ?>/../assets/dist/img/<?= $userIcon ?>.png" class="user-image"
                                     alt="User Image">
                                <span class="hidden-xs"><?= $_SESSION[SS_USER_INFO][name] ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?= SERVER_NAME ?>/../assets/dist/img/<?= $userIcon ?>.png"
                                         class="img-circle" alt="User Image">

                                    <p>
                                        <?= $_SESSION[SS_USER_INFO][job] ?>
                                        <small><?= $_SESSION[SS_USER_INFO][work] ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body hide">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <button id="btnLogout" class="btn btn-danger">Sign out</button>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <?
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    function html_slide()
    {
        global $userIcon, $_hr,$_lib;
        ob_start();
        ?>
        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?= SERVER_NAME ?>/../assets/dist/img/<?= $userIcon ?>.png" class="img-circle"
                             alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?= $_SESSION[SS_USER_INFO][name] ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- search form -->
                <form id="frmSearch" class="sidebar-form">
                    <input type="hidden" name="site" value="<?= SITE_NAME ?>">

                    <div class="input-group">
                        <input type="mask" name="cardid" id="cardid"
                               data-inputmask='"mask": "9999999999999"'
                               class="form-control" placeholder=" บัตรประชาชนผู้สมัคร ">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                    </div>
                </form>
                540
                <script>
                    $('#frmSearch').find('#cardid').inputmask();
                    $('#frmSearch').on('submit', function (event) {
                        var objFrm = $(this).find('#cardid');
                        var cardid = objFrm.val();
                        console.log("Search+++" + cardid);
                        $.ajax({
                            url: jServerName + '/../modules/db/profile.php?cid=' + cardid + '&site=' + jSite,
                            type: 'POST',
                            dataType: 'json',
                            success: function (obj) {
                                jLog(obj);
                                if (obj.DATA == 1)
                                    JLoadMainParam('profile', cardid);
                                else {
                                    bootbox.alert(" ไม่พบข้อมูล!! ", function (ret) {
                                        setTimeout(function () {
                                            objFrm.val('').focus();
                                        }, 300);
                                    });
                                }
                            }
                        });
                        event.preventDefault();
                    });
                </script>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="active"><a href="javascript:JLoadMain('index');"> <i class="fa fa-dashboard"></i> <span>หน้าแรก</span>
                        </a></li>
                    <?

                    if ($_SESSION['SS_USER']['pmtype'] == 0) {  // admin
                        $menuData = getMYSQLValueAll('menu m',' m.id as mid,m.gid ');
                    } else { // user ohter
                        $menuData = getMYSQLValueAll('gmenu g , menu m',
                            ' g.mid,m.gid ', 'g.open = 1 and  g.mid = m.id and g.pmid = ' . $_SESSION['SS_USER']['pmtype']);
                    }

                    $arGroup = array();
                    foreach ($menuData as $mk => $mv) {
                        $arGroup[$mv['gid']][] = $mv['mid'];
                    }
                    $gGroup = "'" . implode("','", array_keys($arGroup)) . "'";

                    $gm = getMYSQLValueAll("mgroup", "*", " id in ({$gGroup}) order by id ");
                   // vvArray($gm);
                    if ($gm)
                        foreach ($gm as $v) {
                            $gMenu = "'" . implode("','", $arGroup[$v[id]]) . "'";
                            ?>
                            <li class="treeview"><a href="#"> <i class="fa fa-folder"></i> <span><?= $v[name] ?></span>
                                    <i class="fa fa-angle-left pull-right"></i> </a>
                                <ul class="treeview-menu">
                                    <?
                                    $mm = getMYSQLValueAll("menu", "*", " gid={$v[id]} and id <> 56 and id in ({$gMenu}) ");
                                    if ($mm)
                                        foreach ($mm as $vv) {
                                            ?>
                                            <li><a href="javascript:JLoadMain('<?= $vv[fname] ?>');"><i
                                                        class="fa fa-angle-double-right"></i> <font
                                                        size="-1"><?= $vv[name] ?></font></a></li>
                                        <? } ?>
                                </ul>
                            </li>
                            <?
                        }
                    //vvArray($_lib->isMenu('add'));
                    ?>
                    <li class="active hide"><a href="<?= SERVER_NAME ?>/../assets/doc/fprinter.pdf" target="_blank"> <i
                                class="fa fa-briefcase"></i> <span>คู่มือตั้งค่าสั่งพิมพ์</span> </a></li>
                    <li class="active hide"><a href="<?= SERVER_NAME ?>/../assets/doc/form.pdf" target="_blank"> <i
                                class="fa fa-briefcase"></i> <span>โหลดแบบฟร์อมเงินยืม</span> </a></li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
        <?
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    function html_body()
    {
        global $kks_name, $kks, $_isOpenCane, $_html;
        ob_start();
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1> <?= $kks_name ?>
                    <small><?= $kks ?></small>
                </h1>
                <div id="main-loading" style="display:none"><img
                        src="<?= SERVER_NAME ?>/../assets/images/ajax-loader.gif" border=0/>
                </div>
                <ol class="breadcrumb ">
                    <li><a href="?"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                    <li class="active"> ระบบ <?= PROJECT_NAME ?> <?= date('Y') ?>
                        <? //= ($_isOpenCane) ? $_html->labelTag('', "กำลังเปิดหีบ", __labelStyle::Success) : $_html->labelTag('', "ปิดหีบ", __labelStyle::Danger)
                        ?>
                    </li>
                </ol>
            </section>
            <section class="content"></section>
        </div>
        <?
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    function html_footer()
    {
        ob_start();
        ?>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Database : </b> <? echo MS_DBNAME ?> <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2016-<?= date('Y') ?> <a href="mailto:boonyadol@kslgroup.com">IT technical support.
                    <span class="text-red bb">[ KKS ]</span></a>.</strong> All rights reserved.
        </footer>
        <?
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    function renderIndex($title)
    {
        global $_PageName, $_isOpenCane, $_html;
        ob_start();
        ?>
        <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title><?= $title ?></title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <!-- Bootstrap 3.3.5 -->
            <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/bootstrap/css/bootstrap.min.css?v=<?= time() ?>">
            <!-- Font Awesome -->
            <link rel="stylesheet"
                  href="<?= SERVER_NAME ?>/../assets/font-awesome/css/font-awesome.min.css?v=<?= time() ?>">
            <!-- Ionicons -->
            <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/ionicons/css/ionicons.min.css?v=<?= time() ?>">
            <!-- Theme style -->
            <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/dist/css/AdminLTE.css?v=<?= time() ?>">
            <!-- AdminLTE Skins. Choose a skin from the css/skins
                 folder instead of downloading all of them to reduce the load. -->
            <link rel="stylesheet"
                  href="<?= SERVER_NAME ?>/../assets/dist/css/skins/_all-skins.min.css?v=<?= time() ?>">
            <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/fonts/font.css?v=<?= time() ?>">

            <!-- jQuery 2.1.4 -->
            <script src="<?= SERVER_NAME ?>/../assets/plugins/jQuery/jQuery-2.1.4.min.js?v=<?= time() ?>"></script>
            <!-- Bootstrap 3.3.5 -->
            <script src="<?= SERVER_NAME ?>/../assets/bootstrap/js/bootstrap.min.js?v=<?= time() ?>"></script>
            <!-- SlimScroll -->
            <script
                src="<?= SERVER_NAME ?>/../assets/plugins/slimScroll/jquery.slimscroll.min.js?v=<?= time() ?>"></script>

            <!-- AdminLTE App -->
            <script src="<?= SERVER_NAME ?>/../assets/dist/js/app.min.js?v=<?= time() ?>"></script>
            <!-- AdminLTE for demo purposes <script src="<?= SERVER_NAME ?>/../assets/dist/js/demo.js"></script>-->

            <script src="<?= SERVER_NAME ?>/../assets/plugins/bootbox.min.js?v=<?= time() ?>"></script>
            <script
                src="<?= SERVER_NAME ?>/../assets/plugins/datepicker/bootstrap-datepicker.js?v=<?= time() ?>"></script>
            <script
                src="<?= SERVER_NAME ?>/../assets/plugins/daterangepicker/daterangepicker.js?v=<?= time() ?>"></script>
            <script src="<?= SERVER_NAME ?>/../assets/plugins/notiny/dist/notify.js?v=<?= time() ?>"></script>
            <script
                src="<?= SERVER_NAME ?>/../assets/plugins/notiny/dist/styles/metro/notify-metro.js?v=<?= time() ?>"></script>


            <link rel="stylesheet"
                  href="<?= SERVER_NAME ?>/../assets/plugins/datatables/jquery.dataTables.min.css?v=<?= time() ?>">
            <link rel="stylesheet"
                  href="<?= SERVER_NAME ?>/../assets/plugins/datatables/dataTables.tableTools.css?v=<?= time() ?>">
            <script
                src="<?= SERVER_NAME ?>/../assets/plugins/datatables/jquery.dataTables.min.js?v=<?= time() ?>"></script>
            <script
                src="<?= SERVER_NAME ?>/../assets/plugins/datatables/dataTables.tableTools.js?v=<?= time() ?>"></script>

            <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/plugins/select2/select2.min.css?v=<?= time() ?>">
            <script src="<?= SERVER_NAME ?>/../assets/plugins/select2/select2.full.min.js?v=<?= time() ?>"></script>

            <link rel="stylesheet"
                  href="<?= SERVER_NAME ?>/../assets/plugins/checkbox/bootstrap-checkbox.css?v=<?= time() ?>">
            <script src="<?= SERVER_NAME ?>/../assets/plugins/checkbox/bootstrap-checkbox.js?v=<?= time() ?>"></script>

            <script src="<?= SERVER_NAME ?>/../assets/plugins/imgZoom/jquery.elevatezoom.js?v=<?= time() ?>"></script>

            <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/plugins/iCheck/all.css?v=<?= time() ?>">
            <script src="<?= SERVER_NAME ?>/../assets/plugins/iCheck/icheck.js?v=<?= time() ?>"></script>

            <!-- InputMask -->
            <script src="<?= SERVER_NAME ?>/../assets/plugins/input-mask/jquery.inputmask.js?v=<?= time() ?>"></script>
            <script
                src="<?= SERVER_NAME ?>/../assets/plugins/input-mask/jquery.inputmask.date.extensions.js?v=<?= time() ?>"></script>
            <script
                src="<?= SERVER_NAME ?>/../assets/plugins/input-mask/jquery.inputmask.extensions.js?v=<?= time() ?>"></script>
            <!--<script src="<?= SERVER_NAME ?>/../assets/plugins/jQuery/jquery.validate.js?v=<?= time() ?>"></script>-->
            <script src="<?= SERVER_NAME ?>/../assets/plugins/jQuery/jquery.validate.x.js?v=<?= time() ?>"></script>
            <script src="<?= SERVER_NAME ?>/../assets/plugins/jQuery/additional-methods.x.js?v=<?= time() ?>"></script>

            <script>
                var jServerName = '<?=SERVER_NAME?>';
                var jSite = '<?=SITE_NAME?>';
                var jFileName = '<?=$_PageName?>';
            </script>
            <script src="<?= SERVER_NAME ?>/../assets/plugins/lib.js?v=<?= time() ?>"></script>
        </head>
        <!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
        <!-- the fixed layout is not compatible with sidebar-mini -->
        <body class="hold-transition skin-blue fixed sidebar-mini" style="zoom:93%">
        <!--<img src="<?= SERVER_NAME ?>/../assets/images/black_ribbon_top_left.png" class="black-ribbon stick-top stick-left" />-->
        <!-- Site wrapper -->
        <div class="wrapper">
            <? echo $_html->html_header(); ?>
            <? echo $_html->html_slide(); ?>
            <? echo $_html->html_body(); ?>
            <? echo $_html->html_footer(); ?>
        </div>

        <!-- ./wrapper -->
        </body>
        </html>
        <?
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }
    /********************************* END HOME PAGE INDEX  */
}
/*
 <!-- phone mask -->
<div class="form-group">
    <label>US phone mask:</label>
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-phone"></i>
        </div>
        <input type="text" class="form-control" data-inputmask='"mask": "0199999"' data-mask>
    </div><!-- /.input group -->
</div><!-- /.form group -->

<script>
    //Money Euro
    $("[data-mask]").inputmask();
</script>
 * */

/**
 * <!-- The form which is used to populate the item data -->
 * <form id="userForm" method="post" class="form-horizontal" style="">
 * <div class="form-group">
 * <label class="col-xs-3 control-label">ID</label>
 * <div class="col-xs-3">
 * <input type="text" class="form-control" name="id" disabled="disabled" />
 * </div>
 * </div>
 *
 * <div class="form-group">
 * <label class="col-xs-3 control-label">Full name</label>
 * <div class="col-xs-5">
 * <input type="text" class="form-control" name="name" />
 * </div>
 * </div>
 *
 * <div class="form-group">
 * <label class="col-xs-3 control-label">Email</label>
 * <div class="col-xs-5">
 * <input type="text" class="form-control" name="email" />
 * </div>
 * </div>
 *
 * <div class="form-group">
 * <label class="col-xs-3 control-label">Website</label>
 * <div class="col-xs-5">
 * <input type="text" class="form-control" name="website" />
 * </div>
 * </div>
 *
 * <div class="form-group">
 * <div class="col-xs-5 col-xs-offset-3">
 * <button type="submit" class="btn btn-default">Save</button>
 * </div>
 * </div>
 * </form>
 */


