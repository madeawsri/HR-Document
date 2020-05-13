<?
include "../../conn.php";
$m = trim($_REQUEST[m]);
switch($m){
case "select-users": 
  echo "
  <div class=\"form-group\">
                    <select class=\"form-control select2\" style=\"width: 100%;\" id='sl_users' name=\"sl_users\">";
                    /*
					   SELECT x.id,x.user , y.name FROM tblogin x, tbinfo y WHERE x.id = y.loginid
					*/
					$dsUsers = getMYSQLValueAll("tblogin x, tbinfo y"," x.site, x.id,x.user , y.name , y.work ","x.id = y.loginid order by x.id desc ");
					if($dsUsers)
					foreach($dsUsers as $k=>$v){
  				       print " <option  value='{$v[id]}' > {$v[site]} : {$v[user]} : {$v[name]} : {$v[work]} </option> ";
					}
 echo "
                    </select>
                  </div>
				  <div class=\"form-group\">
				     <div id='list_menu' ></div>
				  </div>
  ";
  echo "<script>";
  echo "  function loadmenu(uid){
			  $.post('".SERVER_NAME."/../modules/db/permision.php',{'site':'".$site."','m':'list-menu','userid':uid},function(data){
				  $('#list_menu').html(data.trim());
			  });
          } 
       ";      
  echo " $(\".select2\").select2();";
  echo " loadmenu($('#sl_users').val()); ";
  echo " $('#sl_users').change(function(){  loadmenu($(this).val()); });";
  echo "</script>";  
break;
case "list-menu":
  $userid = $_REQUEST[userid];
  $acc = getMYSQLValue("tblogin","access","id={$userid}");
  ?>


  <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">กำหนกสิทธิ์การใช้งาน</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                เปิดใช้งานระบบ <input type="checkbox"  onchange="chkBox($(this),'99','<?=$userid?>','access')" class="probeProbe on<?=(int)$acc?> "  style="width: 50px; height: 20px; " />
                  <table class="table table-bordered">
                    <tbody><tr>
                      <th>รายการเมนู</th>
                      <th>เปิดสิทธิใช้งาน</th>
                    </tr>
                    <?
                    $dsMenu = getMYSQLValueAll("menu","*"," enable = 0");
					if($dsMenu)
					foreach($dsMenu as $k=>$v){		
					  $ins = getPermision($userid,$v[id],'ins');
					  $upd = getPermision($userid,$v[id],'upd');
					  $del = getPermision($userid,$v[id],'del');
					  $vie = getPermision($userid,$v[id],'vie');
					  
					?>
<tr>
  <td><?=$v[name]?></td>
   <td  >  <input type="checkbox" id="d<?=$v[id]?>" onchange="chkBox($(this),'<?=$v[id]?>','<?=$userid?>','vie')"  class="probeProbe on<?=(int)$vie?> " /> </td>
</tr>
<?
					}
					?>
                  </tbody></table>
                  <script>
				    $('.on0').bootstrapSwitch('state', false);
					$('.on1').bootstrapSwitch('state', true);
                    function chkBox(obj,id,userid,type){					
						obj.on('switchChange.bootstrapSwitch', function (event, state) {
						  $.post("<?=SERVER_NAME?>/../modules/db/permision.php",
                              {'site':'<?=$site?>','m':'edit-permision','v':+state,'id':id,'userid':userid,'type':type},
                              function(data){  });
						});
					}
				  </script>

                </div><!-- /.box-body -->
                <div class="box-footer clearfix hide">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">«</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">»</a></li>
                  </ul>
                </div>
              </div>


    <?
break;
case "edit-permision":
  $userid = $_REQUEST[userid];
  $id = $_REQUEST[id];
  $v = $_REQUEST[v];
  $type = $_REQUEST[type];
  $filename = getMYSQLValue("menu","fname","id={$id}");

  if($id == 99){
	$dbmy->update_db("tblogin",array($type=>$v)," id = '{$userid}'  ");
  }else{
    $chk = getMYSQLValue("tbpermision","count(*)","uid = '{$userid}' and mid = '{$id}' ");
      if(!$chk){
         $dbmy->add_db("tbpermision",array("uid"=>$userid,"mid"=>$id,$type=>$v,"filename"=>$filename));
      }else{
         $dbmy->update_db("tbpermision",array($type=>$v)," uid = '{$userid}' and mid = '{$id}' ");
      }
  }

break;
}

?>

