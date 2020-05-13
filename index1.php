<? 
@session_start();
if($_SESSION['SS_USER']['access'] && $_SESSION['SS_USER']['status_info']){
  include "index.php";
}else{
  include "login.php"; 
}
?>
<script>
$('#btnLogout').click(function(){
		  $.post('<?=SERVER_NAME?>/../modules/index/logout.php',{'site':'<?=$site?>'},function(data){
			 window.location =  window.location;
		  });
	    });
</script>
 <? if(strtolower($_SESSION[SS_USER][site]) <> strtolower($site)){ ?>
   <script> $('#btnLogout').click();  </script> 
 <? } ?>
