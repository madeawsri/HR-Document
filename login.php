<!doctype html>
<?
@session_start();
include "conn.php";
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HR KSL > ระบบจัดการข้อมูลสมัครงาน</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/plugins/iCheck/square/blue.css">
    <script src="<?= SERVER_NAME ?>/../assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?= SERVER_NAME ?>/../assets/bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/plugins/select2/select2.min.css?v=<?= time() ?>">
    <script src="<?= SERVER_NAME ?>/../assets/plugins/select2/select2.full.min.js?v=<?= time() ?>"></script>
    <link rel="stylesheet" href="<?= SERVER_NAME ?>/../assets/fonts/font.css?v=<?= time() ?>">

    <!-- iCheck -->
    <script src="<?= SERVER_NAME ?>/../assets/plugins/iCheck/icheck.min.js"></script>
    <script src="<?= SERVER_NAME ?>/../assets/plugins/jQuery/jquery.form.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box" style="zoom:0.9">
    <div class="login-logo" style="zoom:0.9">
        <h2>ระบบจัดการข้อมูลสมัครงาน</h2>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?
        if (isset($_SESSION["SS_USER"]) && $_SESSION['SS_USER'][status_info] == 0) {
            //FnADLogin('boonyadol', 'bm@2560');
            ?>
            <p> แบบฟอร์มขออนุมัติการใช้งาน </p>
            <form action="db.php" method="post" id="frmInfo">
                <input type="hidden" name="site" value="<?= $site ?>"/>
                <input type="hidden" name="m" value="add-info"/>

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder=" ชื่อ-สกุล " name="a[]" autofocus required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback" >
                    <?
                    $pptype = $_lib->getTable('hr_pptype', 'id,name');
                    ?>
                    <select class="form-control select2" data-tags="true" data-placeholder="Select an option" id="spptype" name="a[]" required>
                        <?
                        if ($pptype)
                            foreach ($pptype as $k => $v) {
                              print '<option value="'.$v['id'].'"> '.$v['name'].' </option>';
                            }
                        ?>
                    </select>
                    <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback" >
                    <?
                    $pptype = $_lib->getTable('hr_ptype', 'id,name');
                    ?>
                    <select class="form-control select2" data-tags="true" data-placeholder="Select an option" id="sptype" name="a[]" required>
                        <?
                        if ($pptype)
                            foreach ($pptype as $k => $v) {
                                print '<option value="'.$v['id'].'"> '.$v['name'].' </option>';
                            }
                        ?>
                    </select>
                    <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder=" งานที่รับผิดชอบ " name="a[]" required>
                    <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
                </div>


                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder=" รหัสโรงงาน " name="a[]"
                           value="<?= $kks_code ?>">
                    <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
                </div>


                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder=" ชื่อโรงงาน " name="a[]"
                           value="<?= $kks_name . $kks ?>">
                    <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
                </div>
                <div class="row" align="center">
                    <!-- /.col -->
                    <div>
                        <button type="submit" class="btn btn-primary "> ส่งแบบฟอร์มเพิ่มเปิดสิทธ์การใช้งาน</button>
                        <input type="button" value=" Logout " id="btnLogout" class="btn btn-danger"/>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <script>
                $('#spptype').select2({ dropdownParent: $('#frmInfo'),});
                $('#sptype').select2({ dropdownParent: $('#frmInfo'),});

            </script>
        <?
        }else if (isset($_SESSION[SS_USER]) && $_SESSION[SS_USER][status_info] == 1){
        ?>
            <h3> รอการเปิดสิทธิ์ในการใช้งาน </h3>
            <p><u> รายเอียดข้อมล </u></p>
            <?
            $dbInfo = getMySQLValues("tbinfo", "name,job,work,rcode,rname", "loginid=" . $_SESSION[SS_USER][id]);
            foreach ($dbInfo as $k => $v) {
                ?>
                <?= " " . $v ?>
            <? } ?>

            <p></p>
        <input type="button" value=" Logout " id="btnLogout" class="btn btn-danger"/>
            <?
        }else {
            ?>
            <div class="login-box-msg"></div>
            <form action="db.php" method="post" id="frmLogin1">
                <input type="hidden" name="site" value="<?= $site ?>"/>
                <input type="hidden" name="m" value="add-login"/>

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Email Name " name="user" autofocus>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <small class="text-color-green"> <font class="text-color-red">***</font> ชื่อผู้ใช้ (User) ไม่ต้องใช่ @kslgroup.com</small>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="pass">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck hide">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <?
        }
        ?>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script>
    $('#frmInfo').submit(function () {
        // $(this).ajaxForm(options);
        $.post('<?=SERVER_NAME?>/../modules/db/insert.php', $('#frmInfo').serialize(), function (data) {
            if (data.trim() == "OK")
                window.location = window.location;
        });
//		  alert(data.trim());
        return false;
    });
    $('#frmLogin1').submit(function () {
        // $(this).ajaxForm(options);
        $.post('<?=SERVER_NAME?>/../modules/db/insert.php', $('#frmLogin1').serialize(), function (data) {
            if (data.trim() == "OK")
                window.location = window.location;
            else
                alert(data.trim());
        });
        return false;
    });
</script>
</body>
</html>
