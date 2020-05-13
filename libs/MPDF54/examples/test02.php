<?php
ini_set("memory_limit","128M");
ob_start();
?>

<table class="tablex">
<thead>
    <tr  >
	  <th class="xxx" style="color:black;background-color:#fff;border:0px;" colspan="18">
         <img src="tiger.png" width="100px" height="100px" ></img>
		 <h3>ทดสอบการสร้างไฟล์ PDF</h3>
         <h5>Periodic Table <?=date("d/m/Y H:i:s")?></h5>
	  </th>
	</tr>
	<tr>
		<th ><p>Element type 1A</p><p>Second line</p>
		<th text-rotate="90"><p>Element type longer 2A</p></th>
		<th text-rotate="90">ประเภทอ้อย</th>
		<th text-rotate="90">ประเภททะเบียนรถ</th>
		<th text-rotate="90">Element type 5B</th>
		<th text-rotate="90">Element type 6B</th>
		<th text-rotate="90">7B</th>
		<th text-rotate="90">8B</th>
		<th text-rotate="90">Element type 8B R</th>
		<th text-rotate="90">8B</th>
		<th text-rotate="90">Element <span>type</span> 1B</th>
		<th text-rotate="90">2B</th>
		<th text-rotate="90">Element type 3A</th>
		<th text-rotate="90">Element type 4A</th>
		<th text-rotate="90">Element type 5A</th>
		<th text-rotate="90">Element type 6A</th>
		<th text-rotate="90">7A</th>
		<th >Element type 8A</th>
	</tr>
</thead>
<tbody>
<? for($i=1;$i<=50; $i++){?>
	<tr>
		<td><?=$i?>ทดสอบความเป็นได้ </td>
		<td>กด </td>
		<td>ฟห </td>
		<td>ดก </td>
		<td>ทำ </td>
		<td>ให้</td>
		<td>สัต</td>
		<td>สร่</td>
		<td>นัส</td>
		<td>สไห</td>
		<td>ทส</td>
		<td>หห</td>
		<td>กำ</td>
		<td>พะ</td>
		<td>กัว</td>
		<td>รส</td>
		<td>นส</td>
		<td>25,500,000.00</td>
	</tr>
<? } ?>
</tbody></table>
<p>&nbsp;</p>
<?
$html = ob_get_contents();
ob_end_clean();
//==============================================================
//==============================================================
//==============================================================
include("../mpdf.php");

//$mpdf=new mPDF('','A4',14,'thsarabunnew',32,25,27,25,16,13); 
$mpdf=new mPDF('','A4',14,'thsarabunnew',10,5,10); 
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet

//$stylesheet = file_get_contents('w3.css');
$stylesheet .= "
  .tablex  th { vertical-align:bottom; color:#fff!important;background-color:#f44336!important}
  .tablex  th { vertical-align:bottom; background-color:#f44336!important}

  .tablex tr:nth-child(odd){background-color:#fff}
  .tablex  tr:nth-child(even){background-color:#f1f1f1}

.tablex {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  
}
.tablex th,td { border: 1px solid #CCC; padding:5px;}

";
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html,2);
$mpdf->Output('mpdf.pdf','I');
exit;



?>