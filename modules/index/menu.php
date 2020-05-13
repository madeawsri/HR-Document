<?
include "../../conn.php";
$title = "จัดการเมนู";
?>
<link href="<?=SERVER_NAME?>/../assets/plugins/dialog/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<script src="<?=SERVER_NAME?>/../assets/plugins/dialog/bootstrap-dialog.min.js"></script>

<link rel="stylesheet" href="<?=SERVER_NAME?>/../assets/plugins/daterangepicker/daterangepicker-bs3.css">
<script src="<?=SERVER_NAME?>/../assets/plugins/daterangepicker/daterangepicker.js"></script>

<div class="box box-primary">
  <div class="box-header" >
    <center><h3 class="box-title-center">
      <?=$title?>
    </h3></center>
  </div>
  <div>
        <div class="form-group hide">
          <label>ที่ตั้งใช้ระบบ</label>
          <?  $dsSite = getMYSQLValueAll("setting","site,kks","1=1");   ?>
          <select class="form-control" id="selSite">
            <option value="" selected="selected" >  -  </option>
			<? 
			if($dsSite)
			foreach($dsSite as $v){ ?>
            <option value="<?=$v[site]?>">โรงงานน้ำตาลขอนแก่น สาขา<?=$v[kks]?> [ <?=$v[site]?> ]
            </option>
            <? } ?>
          </select>
        </div>
        <div  id="loading" style="display:none"><img src="<?=SERVER_NAME?>/../assets/images/ajax-loader.gif" border="0" /></div>
        <div id="load_data"></div>
        <script>
		function loadGroupMenu(){
		  $('#loading').show();
		  var d1 = $('#startDate').val();
		  var d2 = $('#endDate').val();
		  $.post("<?=SERVER_NAME?>/../modules/db/<?=$_REQUEST[m]?>.php",{'site':'<?=$_REQUEST[site]?>'},function(data){ 
			$('#load_data').html(data.trim());
		    $('#loading').hide();
		  });	
		}
		loadGroupMenu();
		$('#selSite').change(function(){
		  loadGroupMenu();
		});
	   </script> 
      </div>
  <!-- /.form group --> 
</div>
  <div id="load_p0"></div>
<script>

               
    //Date range picker
  //$('#reservation').daterangepicker({format: 'YYYY/MM/DD'});
  
  $('#btnSubmit').click(function(){
		  $('#loading').show();
		  $('#btnSubmit').hide();
		  var d = $('#reservation').val().split("-");
		  var d1 = d[0].trim();
		  var d2 = d[1].trim();
		  $.post("<?=SERVER_NAME?>/../modules/db/<?=$_REQUEST[m]?>.php",{'site':'<?=$_REQUEST[site]?>','d1':d1,'d2':d2},function(data){ 
			$('#load_p0').html(data.trim());
		    $('#loading').hide();
		    $('#btnSubmit').show();
		  });
		});
  
</script>
