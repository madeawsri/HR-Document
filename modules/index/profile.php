<?php
include "../../conn.php";
include "../../libs/tabClass.php";
/**
 * Created by PhpStorm.
 * User: boonyadol
 * Date: 11/4/2560
 * Time: 9:27
 */
$tab = new tabClass();
$cid = $_REQUEST['id'];
if(strlen($cid) < 13){

   $sql = "
   select cid, CONCAT(pname,fname,' ',lname) as cname
     from hr_person where cid in (
                    select cid from hr_reg_position where regp = {$cid}
   )
   ";
   $dataCID = $dbmy->exec($sql);
    if($dataCID)
        foreach($dataCID as $k=>$v){
            //if($k <= 1) continue;
            $tab->tabData('tab' . $v['cid'], $v['cname'],ProfileRender($v['cid']));
        }
    echo $tab->render();
}else {
   echo ProfileRender($cid);
}

function ProfileRender($cid){
    global $_hr;
    $ps = getMYSQLValues('hr_person', '*', "cid =  '{$cid}'  ");
    $fname = $ps['pname'] . $ps['fname'] . " " . $ps['lname'];
    $cid = $ps['cid'];
    /* Education */
    $ed = $_hr->getEducation($cid);
    $edu = "<span class='bb'>{$ed['cer']}</span> {$ed['skk']} {$ed['edu']} จบปี {$ed['suc']} <p class='bb'>เกรดเฉลี่ย {$ed['gra']}</p>   ";
    /*  register position */
    $pt = $_hr->getRegPositions($cid);
    $ab = $_hr->getAbility($cid);
    $abx = array($ab['abname1'], $ab['abname2'], $ab['abname3']);
    $abb = implode(',', $abx);

    $path_doc = SERVER_NAME . "/../uploads/" . SITE_NAME . "/{$cid}/";
    $noimage = SERVER_NAME . "/../assets/images/no-image.png";
    $img = "{$path_doc}/{$cid}.jpg";
    if (!is_file("../../uploads/" . SITE_NAME . "/{$cid}/{$cid}.jpg")) {
        $img = $noimage;
    }
    /* other datas */
    $arOther = array("ตำแหน่งงานที่สมัคร", "ประวัติการทำงาน");

    $cm = $_hr->getCompanys($cid);
    $df = $_hr->getDocref($cid);
    $xx = $_hr->getInterview($cid);

    ob_start();
    ?>
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle"
                         src="<?= $img ?>" alt="User profile picture">
                    <h4 class=" text-center"><?= $fname ?></h4>

                    <p class="text-muted text-center"><?= $pt[0]['regp'] ?></p>

                    <ul class="list-group list-group-unbordered ">
                        <li class="list-group-item">
                            <i class="fa fa-phone"></i>
                            <small><?= $ps['tel'] ?></small>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-book"></i>
                            <small><?= $ps['lineid'] ?></small>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-envelope"></i>
                            <small><?= $ps['email'] ?></small>
                            </a>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-primary btn-block hide"><b>Follow</b></a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">ข้อมูลเบื้องต้น</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> ข้อมูลการศึกษา</strong>

                    <p class="text-muted">
                        <?= $edu ?>
                    </p>

                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> ที่อยู่</strong>

                    <p class="text-muted"><?= $ps['addr'] ?></p>

                    <hr>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> ความสามารถพิเศษ</strong>

                    <p class="text-muted"><?= $abb ?></p>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity<?=$cid?>" data-toggle="tab">ข้อมูลด้านอื่นๆ</a></li>
                    <li><a href="#timeline<?=$cid?>" data-toggle="tab">เอกสาร/หลักฐานการสมัคร</a></li>
                    <li class="hide"><a href="#settings<?=$cid?>" data-toggle="tab">ติดต่อผู้สมัคร</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity<?=$cid?>">
                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="<?= $img ?>"
                                     alt="user image">
                        <span class="username">
                          <a href="#">ตำแหน่งงานที่สมัคร</a>
                          <a href="#" class="pull-right btn-box-tool hide"><i class="fa fa-times"></i></a>
                        </span>
                                <span class="description"><?= $fname ?></span>
                            </div>
                            <!-- /.user-block -->

                            <!-- /.box-header -->
                            <p>
                            <table class="table table-hover" style="font-size: small">
                                <tr>
                                    <th>วันที่สมัคร</th>
                                    <th>แผนก/ ตำแหน่ง</th>
                                    <th>วันที่เปิดรับสมัคร</th>
                                </tr>
                                <?
                                if ($pt)
                                    foreach ($pt as $k => $v) {
                                        ?>
                                        <tr>
                                            <td><?= $v['rdate'] ?></td>
                                            <td><?= $v['regp'] ?></td>
                                            <td><?= $v['ddate'] ?></td>
                                        </tr>
                                    <? } ?>
                            </table>
                            </p>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="<?= $img ?>"
                                     alt="user image">
                        <span class="username">
                          <a href="#">ประวัติการทำงาน</a>
                          <a href="#" class="pull-right btn-box-tool hide"><i class="fa fa-times"></i></a>
                        </span>
                                <span class="description"><?= $fname ?></span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                            <table class="table table-hover" style="font-size: small">
                                <tr>
                                    <th>บริษัท</th>
                                    <th>แผนก/ ตำแหน่ง</th>
                                    <th>สถานะภาพ</th>
                                </tr>
                                <?
                                if ($cm)
                                    foreach ($cm as $k => $v) {
                                        ?>
                                        <tr>
                                            <td><?= $v['cname'] ?></td>
                                            <td><?= $v['cwork'] ?></td>
                                            <td><?= $v['ctype'] ?></td>
                                        </tr>
                                    <? } ?>
                            </table>
                            </p>
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="<?= $img ?>"
                                     alt="user image">
                        <span class="username">
                          <a href="#">ประวัติการนัดหมาย</a>
                          <a href="#" class="pull-right btn-box-tool hide"><i class="fa fa-times"></i></a>
                        </span>
                                <span class="description"><?= $fname ?></span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                            <table class="table table-hover" style="font-size: small">
                                <tr>
                                    <th>วันที่นัดสอบสัมภาษณ์</th>
                                    <th>แผนก/ ตำแหน่ง</th>
                                    <th>ผลสอบ</th>
                                    <th>หมายเหตุ</th>

                                </tr>
                                <?
                                if ($xx)
                                    foreach ($xx as $k => $v) {
                                        ?>
                                        <tr>
                                            <td><?= $v['ddate'] ?></td>
                                            <td><?= $v['rpname'] ?></td>
                                            <td><?= $v['rtype'] ?></td>
                                            <td><?= $v['note'] . " " . $v['note2'] ?></td>
                                        </tr>
                                    <? } ?>
                            </table>
                            </p>
                        </div>
                        <!-- /.post -->

                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline<?=$cid?>">
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="<?= $img ?>"
                                     alt="user image">
                        <span class="username">
                          <a href="#">เอกสารดาวน์โหลด</a>
                          <a href="#" class="pull-right btn-box-tool hide"><i class="fa fa-times"></i></a>
                        </span>
                                <span class="description"><?= $fname ?></span>
                            </div>
                            <!-- /.user-block -->

                            <!-- /.box-header -->
                            <p>
                            <table class="table table-hover" style="font-size: small">
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>รายละเอียดเอกสาร</th>
                                    <th>เอกสาร</th>
                                </tr>
                                <?
                                if ($df)
                                    foreach ($df as $k => $v) {
                                        ?>
                                        <tr>
                                            <td><?= ($k + 1) ?></td>
                                            <td><?= $v['detail'] ?></td>
                                            <td><a href="<?= "{$path_doc}{$v['filename']}" ?>"
                                                   download="<?= $v['filename'] ?>"> ดาวน์โหลด </a></td>
                                        </tr>
                                    <? } ?>
                            </table>
                            </p>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane hide" id="settings<?=$cid?>">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputName" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputExperience"
                                              placeholder="Experience"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <?
    $out = ob_get_contents();
    ob_end_clean();
    return $out;
}
?>