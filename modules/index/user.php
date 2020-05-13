<?
$title = "สิทธิการเข้าใช้งานเมนู CWCReport ";
?>
<div class="box box-primary">
  <div class="box-header" >
    <center><h3 class="box-title-center">
      <?=$title?>
    </h3></center>
  </div>
  <div>
        <div class="form-group">
          <label>ที่ตั้งใช้ระบบ</label>
          <?  $dsSite = getSQLValueAll("setting","site,kks","1=1");   ?>
          <select class="form-control" id="selSite">
            <option value="" selected="selected" >  -  </option>
			<? 
			if($dsSite)
			foreach($dsSite as $v){ ?>
            <option value="<?=$v[site]?>">โรงงานน้ำตาลขอนแก่น สาขา
            <?=$v[kks]?> [ <?=$v[site]?> ]
            </option>
            <? } ?>
          </select>
        </div>
        <div  id="loading" style="display:none"><img src="<?=SERVER_NAME?>/../images/ajax-loader.gif" border="0" /></div>
        <div id="load_data"></div>
        <script>
		function loadGroupMenu(){
		  $('#loading').show();
		  var d1 = $('#startDate').val();
		  var d2 = $('#endDate').val();
		  $.post("<?=SERVER_NAME?>/../modules/db/setting.php",{'site':'<?=$_GET[site]?>'},function(data){ 
		    $('#load_data').html(data.trim());
		    $('#loading').hide();
		  });	
		}
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
  $('#reservation').daterangepicker({format: 'YYYY/MM/DD'});
  
  $('#btnSubmit').click(function(){
		  $('#loading').show();
		  $('#btnSubmit').hide();
		  var d = $('#reservation').val().split("-");
		  var d1 = d[0].trim();
		  var d2 = d[1].trim();
		  $.post("<?=SERVER_NAME?>/../modules/db/p0.php",{'site':'<?=$_GET[site]?>','d1':d1,'d2':d2},function(data){ 
			$('#load_p0').html(data.trim());
		    $('#loading').hide();
		    $('#btnSubmit').show();
		  });
		});
  
</script>
