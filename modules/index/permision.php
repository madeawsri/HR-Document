<?
include "../../conn.php";
?>
<div class="row">
<section class="content" style="display: block;">

<div class="row">
  <div class="col-md-12">
    <div class="box box-danger">
      <div class="box-header">
        <h3 class="box-title">
          กำหนดสิทธ์การใช้งาน</h3>
      </div>
      <div class="box-body">
        <form action="" method="post" id="frmteam">
          <input type="hidden" name="site" value="master">
          <input type="hidden" name="m" value="add">
          <div class="form-group">
            <label>ชื่อผู้ใช้งานระบบ</label>
            <div id="select-users"></div>
		  </div>
        </form>
        <script>
		$.post("./../modules/db/permision.php",{'site':'<?=$site?>','m':'select-users'},function(data){
               $('#select-users').html(data.trim());
        });
        </script>
              </div>
    </div>
  </div>
</div>