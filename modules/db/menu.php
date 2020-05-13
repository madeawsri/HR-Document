<? include "../../conn.php"; ?>
<link href="<?=SERVER_NAME?>/../assets/plugins/dialog/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<script src="<?=SERVER_NAME?>/../assets/plugins/dialog/bootstrap-dialog.min.js"></script>

<div class="form-group">
  <button type="submit" id="addGname" class="btn btn-primary " >+ เพิ่มกลุ่มเมนู</button>
</div>
<script>
  $('#addGname').click(function(){
   BootstrapDialog.show({
            title: 'เพิ่มหมวดหมู่เมนู',
            message: $('<input type="type" id="gname" class="form-control" placeholder=" ชื่อหมวดหมู่ " >'),
			onshown: function(dialogRef){
               $('#gname').focus();
            },
			buttons: [{
                label: '(Enter) เพิ่ม',
                cssClass: 'btn-primary',
                hotkey: 13, // Enter.
                action: function(dialogRef) {
                    /* INSERT GROUP MENU */
					var gx = $('#gname').val();
					if(gx.trim()){
						$.post("<?=SERVER_NAME?>/../modules/db/insert.php",{'site':'<?=$_REQUEST[site]?>','m':'ins-mGroup','name':gx},function(data){ 
							 dialogRef.close();
							 loadGroupMenu();
							 BootstrapDialog.show({
									type : BootstrapDialog.TYPE_SUCCESS,
									title: 'เพิ่มหมวดหมู่เมนู',
									message: 'ระบบได้ดำเนินการ เพิ่มหมวดหมู่ "<font color=green><b>'+gx+'</b></font>" เรียบร้อยแล้ว.',
							});
							
						});
					}else{ 
					  $('#gname').focus();
					}
				}
            }]
        });
  });
  function JDelGroup(gid,name){
       BootstrapDialog.confirm('ยืนยันการลบ กลุ่มเมนู : "'+name+'" ?', function(result){
            if(result) {
               $.post("<?=SERVER_NAME?>/../modules/db/del.php",{'site':'<?=$_REQUEST[site]?>','m':'del-mGroup','gid':gid},function(){
			     loadGroupMenu();
							 BootstrapDialog.show({
									type : BootstrapDialog.TYPE_SUCCESS,
									title: 'ได้ดำเนินการลบ',
									message: 'ระบบได้ดำเนินการ ลบหมวดหมู่ "<font color=green><b>'+name+'</b></font>" เรียบร้อยแล้ว.',
							});
			   });  
            }
     });
  }
    function JDelMenu(gid,name,fname){
       BootstrapDialog.confirm('ยืนยันการลบ เมนู : "'+name+'" ?', function(result){
            if(result) {
               $.post("<?=SERVER_NAME?>/../modules/db/del.php",{'fname':fname,'site':'<?=$_REQUEST[site]?>','m':'del-sGroup','gid':gid},function(){
			     loadGroupMenu();
							 BootstrapDialog.show({
									type : BootstrapDialog.TYPE_SUCCESS,
									title: 'ได้ดำเนินการลบ',
									message: 'ระบบได้ดำเนินการ ลบเมนู "<font color=green><b>'+name+'</b></font>" เรียบร้อยแล้ว.',
							});
			   });  
            }
     });
  }
   function JEditMenu(gid,name,fname){
       BootstrapDialog.show({
            title: 'แก้ไขเมนู',
            message: $('<input type="type" id="gname" value="'+name+'" class="form-control" placeholder=" ชื่อเมนู " > - <input type="type" id="fname" class="form-control" placeholder=" ชื่อไฟล์ " value="'+fname+'">'),
			onshown: function(dialogRef){
               $('#gname').focus();
            },
			buttons: [{
                label: '(Enter) แก้ไข',
                cssClass: 'btn-primary',
                hotkey: 13, // Enter.
                action: function(dialogRef) {
                    /* INSERT GROUP MENU */
					var gx = $('#gname').val();
					var fx = $('#fname').val();
					if(gx.trim()){
						$.post("<?=SERVER_NAME?>/../modules/db/edit.php",{'site':'<?=$_REQUEST[site]?>','m':'edit-sGroup','fname':fx,'name':gx,'gid':gid},function(data){ 
							 dialogRef.close();
							 loadGroupMenu();
							 BootstrapDialog.show({
									type : BootstrapDialog.TYPE_SUCCESS,
									title: 'แก้ไขเมนู',
									message: 'ระบบได้ดำเนินการ แก้ไขเมนู "<font color=green><b>'+gx+'</b></font>" เรียบร้อยแล้ว.',
							});
							
						});
					}else{ 
					  $('#gname').focus();
					}
				}
            }]
        });
    }
    function JEditGroup(gid,name){
       BootstrapDialog.show({
            title: 'แก้ไขหมวดหมู่เมนู',
            message: $('<input type="type" id="gname" value="'+name+'" class="form-control" placeholder=" แก้ไขหมวดหมู่ " >'),
			onshown: function(dialogRef){
               $('#gname').focus();
            },
			buttons: [{
                label: '(Enter) แก้ไข',
                cssClass: 'btn-primary',
                hotkey: 13, // Enter.
                action: function(dialogRef) {
                    /* INSERT GROUP MENU */
					var gx = $('#gname').val();
					if(gx.trim()){
						$.post("<?=SERVER_NAME?>/../modules/db/edit.php",{'site':'<?=$_REQUEST[site]?>','m':'edit-mGroup','name':gx,'gid':gid},function(data){ 
							 dialogRef.close();
							 loadGroupMenu();
							 BootstrapDialog.show({
									type : BootstrapDialog.TYPE_SUCCESS,
									title: 'แก้ไขหมวดหมู่เมนู',
									message: 'ระบบได้ดำเนินการ แก้ไขหมวดหมู่ "<font color=green><b>'+gx+'</b></font>" เรียบร้อยแล้ว.',
							});
							
						});
					}else{ 
					  $('#gname').focus();
					}
				}
            }]
        });
    }
  
    function JAddSubGroup(gid,name){
       BootstrapDialog.show({
            title: 'เพิ่มเมนู : หมวดหมู่'+name,
            message: $('<input type="type" id="gname" class="form-control" placeholder=" ชื่อเมนู " > - <input type="type" id="fname" class="form-control" placeholder=" ชื่อไฟล์ " >'),
			onshown: function(dialogRef){
               $('#gname').focus();
            },
			buttons: [{
                label: '(Enter) เพิ่มเมนู',
                cssClass: 'btn-primary',
                hotkey: 13, // Enter.
                action: function(dialogRef) {
                    /* INSERT GROUP MENU */
					var gx = $('#gname').val();
					var fn = $('#fname').val();
					if(gx.trim()){
						
						$.post("<?=SERVER_NAME?>/../modules/db/insert.php",
						{'site':'<?=$_REQUEST[site]?>','m':'add-sGroup','name':gx,'fname':fn,'gid':gid},function(data){ 
							 dialogRef.close();
							 loadGroupMenu();
							 BootstrapDialog.show({
									type : BootstrapDialog.TYPE_SUCCESS,
									title: 'เพิ่มเมนู',
									message: 'ระบบได้ดำเนินการ เพิ่มเมนู "<font color=green><b>'+gx+'</b></font>" เรียบร้อยแล้ว.',
							});
							
						});
					}else{ 
					  $('#gname').focus();
					}
				}
            }]
        });
  }
  
  
  </script>
 
    <?
            $gdb = getMYSQLValueAll("mgroup","*","1=1");
			if($gdb)
			foreach($gdb as $v){
		  ?>
 <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title"><?=$v[name]?></h3>
                                    <div class="box-tools pull-right">
<a href="javascript:JEditGroup('<?=$v[id]?>','<?=$v[name]?>');" id="gid<?=$v[id]?>" title="แก้ไขหมวดหมู่"><span class="glyphicon glyphicon-edit "></span></a>
    <a href="javascript:JDelGroup('<?=$v[id]?>','<?=$v[name]?>');" id="gid<?=$v[id]?>" title="ลบหมวดหมู่"><span class="glyphicon glyphicon-remove cred"></span></a> | 
    <a href="javascript:JAddSubGroup('<?=$v[id]?>','<?=$v[name]?>');" id="gid<?=$v[id]?>" title="เพิ่มเมนูในหมวดหมู่"><span class="glyphicon glyphicon-list cgreen"></span></a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="todo-list">
									  <?
            $sdb = getMYSQLValueAll("menu","*","gid={$v[id]}");
			if($sdb)
			foreach($sdb as $vv){
			?>
                                        <li>
                                            <span class="handle hide">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>
                                            <input type="checkbox" value="" name=""/>
                                            <span class="text"><?=$vv[name]?> : Modules Name => <b><font color=green><?=$vv[fname]?></font></b></span>
                                            <small class="label label-default hide"><i class="fa fa-clock-o"></i> 1 month</small>
                                            <div class="tools">
                                               <a href="javascript:JEditMenu('<?=$vv[id]?>','<?=$vv[name]?>','<?=$vv[fname]?>');" title="แก้ไขเมนู<?=$vv[name]?>"><i class="fa fa-edit"></i></a>
                                               <a href="javascript:JDelMenu('<?=$vv[id]?>','<?=$vv[name]?>','<?=$vv[fname]?>');"><i class="fa fa-trash-o"></i></a>
                                            </div>
                                        </li>
										<?
			}	
			?>
                                    </ul>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix no-border">
                                    <button class="btn btn-default pull-right"  onclick="JAddSubGroup('<?=$v[id]?>','<?=$v[name]?>');"><i class="fa fa-plus"></i> Add item</button>
                                </div>
                            </div><!-- /.box -->
		   <?
			}   
		   ?>