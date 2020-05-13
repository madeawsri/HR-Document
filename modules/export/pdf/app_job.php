<?php
include "../../../conn.php";
ini_set("memory_limit","128M");

$datadb = $dbmy->exec("
        select x.datein,
               (select pp.name from hr_grtype as pp where pp.id = x.grtype) as grtype,
               (select pp.name from hr_sutype as pp where pp.id = x.sutype) as sutype,
               (select pp.name from hr_pptype as pp where pp.id = x.grtype) as pptype,
               (select pp.name from hr_ptype as pp where pp.id = x.ptype) as ptype,
                x.ndate,x.ns,
                x.sxtype,
               (select pp.name from hr_agtype as pp where pp.id = x.agtype) as agtype,
               (select pp.name from hr_satype as pp where pp.id = x.satype) as satype,
                x.etypes, x.aptype1, x.aptype2,
               (select pp.name from hr_pptype as pp where pp.id = x.grtype) as pptype,
               (select pp.name from tbinfo as pp where pp.loginid = x.uid) as uname,
               x.status,x.note,
               x.id
        from hr_appjob as x
        where  x.kslid = '" . SITE_NAME . "' and x.id = {$_GET['url']}
        order by datein desc ");
$ds = $datadb[0];

$age =  trim(str_replace('ปี','', $ds['agtype'] ));
$age = explode('-',$age);

$edus = array(0,0,0,0,);
$edu = explode(',',$ds['etypes']);
foreach($edu as $k=>$v){
    $edus[$v-1] = 1;
}

$checkbox = '<img src="'.SERVER_NAME.'/../assets/images/uncheck.png"  width="12px" height="12px" />';
$checked = '<img src="'.SERVER_NAME.'/../assets/images/checked.png"  width="12px" height="12px" />';

ob_start();
?>
    <table class="tablex" align="center">
        <thead>
        <tr  >
            <th class="xxx" style="color:black;background-color:#fff;border:0px;" colspan="18" align="left">
                <table width="800px"   border="1" cellpadding="0" cellspacing="0" >
                    <tr>
                        <td width="25%" align="center">
                            <img src="<?=SERVER_NAME?>/../assets/images/LogoKSL.jpg"  width="150px" height="60px" />
                            <p style=" border: solid; border-width: thin" > <small> บริษัท น้ำตาลขอนแก่น จำกัด (มหาชน)&nbsp;</small></p>
                        </td>
                        <td width="75%">

                            <table width="800px"   border="0" cellpadding="0" cellspacing="0" >
                                <tr>
                                    <td width="80%" align="center"> <span class="font-b">แบบฟอร์ม ใบขออนุมัติอัตรากำลัง</span> </td>
                                    <td width="20%" valign="top" >
                                        <p> No. KKS-FW-PN01-33 </p>
                                        <p> Dev. 3A-16/12/59 </p>
                                        <p> Page 1/1 </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </th></tr>
        </thead>
        <tbody>
        <tr><td valign="top"><p>&nbsp;</p>
                <span class="font-b"> วันที่  </span>
                <span class="font-n u"> <?=getDateTH($ds['datein'])?> </span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <span class="font-b">เลขที่ใบขอ </span>
                <span class="font-n u">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                </span>
<p>&nbsp;</p>
            </td></tr>

        <tr><td valign="top">
                <span class="font-b"> ฝ่าย </span>
                <span class="font-n u" > <?=$ds['grtype']?> </span>
                <span class="font-b"> ส่วน </span>
                <span class="font-n u"> <?=$ds['sutype']?> </span>
                <span class="font-b"> เผนก </span>
                <span class="font-n u"> <?=$ds['pptype']?> </span>
                <span class="font-b"> ผู้ขอ </span>
                <span class="font-n u"> <?=$ds['uname']?> </span>

            </td></tr>

        <tr><td><br>

                <table width="800px"   border="1" cellpadding="5" cellspacing="0" >
                  <tr>
                      <td align="center" width="30%"> <span class="font-b"> วันที่ต้องการ </span> </td>
                      <td align="center" width="5%"> <span class="font-b"> จำนวน </span> </td>
                      <td align="center" width="40%"> <span class="font-b"> ตำแหน่ง </span> </td>
                      <td align="center" width="5%"> <span class="font-b"> เลขที่ </span> </td>
                      <td align="center" width="40%"> <span class="font-b"> อัตรา </span> </td>
                  </tr>
                  <tr>
                     <td align="center" valign="top" width="30%"  >
                         <p class="font-n u"><?=getDateTH($ds['ndate'])?></p>
                         <p>&nbsp;</p>
                     </td>
                     <td align="center" valign="top" width="5%" class="font-n u">
                         <p class="font-n u"><?=$ds['ns']?></p>
                     </td>
                     <td align="center" valign="top" width="40%" class="font-n u">
                         <p class="font-n u"><?=$ds['ptype']?></p>
                     </td>
                     <td align="center" valign="top" width="5%" class="font-n u">
                         <p class="font-n u">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                     </td>
                     <td align="center" valign="top" width="40%" class="font-n u">
                         <p class="font-n u"><?=$ds['satype']?></p>
                     </td>
                  </tr>

                    <tr>
                        <td align="" colspan="2" valign="top" class="font-n">

                                เพิ่ม &nbsp;&nbsp;<?=($ds['aptype1']==1)?$checked:$checkbox?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                ถาวร &nbsp;&nbsp;<?=($ds['aptype2']==1)?$checked:$checkbox?><br>

                                ทดแทน &nbsp;&nbsp;<?=($ds['aptype1']==2)?$checked:$checkbox?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                ชั่วคราว &nbsp;&nbsp;<?=($ds['aptype2']==2)?$checked:$checkbox?> <br>


                                ถ้าชั่วคราวกำหนดเวลาจ้าง <span class="font-n u">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> วัน <br>
                                ชื่อผู้ถูกทดแทน
                                <span class="font-n u">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </span><br>
                                ตำแหน่ง
                                <span class="font-n u">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                </span><br>
                                เลขที่งาน
                                <span class="font-n u">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                </span>
                            <p> &nbsp; </p>

                             </td>
                        <td align="" valign="top" class="font-n">

                            ชาย &nbsp;&nbsp;<?=($ds['sxtype']==1 || $ds['sxtype']==3)?$checked:$checkbox?> <br>
                            หญิง &nbsp;&nbsp;<?=($ds['sxtype']==2 || $ds['sxtype']==3)?$checked:$checkbox?> <br>

                            ช่วงอายุ <br>
                            ต่ำสุด <span class="font-n u">
                                    &nbsp;&nbsp;&nbsp;&nbsp; <?=$age[0]?>  &nbsp;&nbsp;&nbsp;&nbsp;
                                </span> ปี <br>
                            สูงสุด <span class="font-n u">
                                    &nbsp;&nbsp;&nbsp;&nbsp; <?=$age[1]?>  &nbsp;&nbsp;&nbsp;&nbsp;
                                </span> ปี
                        </td>
                        <td align=""  valign="top" colspan="2" class="font-n">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <u>การศึกษา</u><br>

                            ประถม &nbsp;&nbsp;<?=($edus[0]==1)?$checked:$checkbox?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            มัธยม &nbsp;&nbsp;<?=($edus[1]==1)?$checked:$checkbox?> <br>

                            ปวส. &nbsp;&nbsp;<?=($edus[2]==1)?$checked:$checkbox?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            ปริญญา &nbsp;&nbsp;<?=($edus[3]==1)?$checked:$checkbox?> <br>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <u>คุณสมบัติ</u><br>

                            <?=$checkbox?>&nbsp;&nbsp; ช่าง
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?=$checkbox?> &nbsp;&nbsp; พาณิชย์  <br>
                            <?=$checkbox?> &nbsp;&nbsp; วิศวกร
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?=$checkbox?> &nbsp;&nbsp; ความชำนาญ
                            <span class="font-n u">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </span> ปี
                            <br>

                        </td>
                    </tr>

                </table>

            </td></tr>

        <tr><td class="font-n" align="" valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <u>เหตุผลที่ขอเพิ่ม</u> <br>

                <? if($ds['note']){ ?>
                <span class="font-n u">
                    <?=$ds['note']?>
                </span><br>
               <? } else { ?>
                <span class="font-n u">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span><br>
                <span class="font-n u">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span><br>
                <span class="font-n u">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span><br>
              <? } ?>
            </td></tr>
        <tr  >
            <td >
<p>&nbsp;</p>

                <table width="800px"   border="1" cellpadding="5" cellspacing="0" >
                    <tr>
                        <td align="center" width="30%" rowspan="5" valign="top"> <span class="font-b"> <u>อนุมัติ</u> </span> </td>
                        <td align="center" width="30%" colspan="5"> <span class="font-b"> <u>บุคคล</u> </span> </td>
                    </tr>
                    <tr>
                        <td align="center" width="5"> <span class="font-b"> ตำแหน่ง </span> </td>
                        <td align="center" width="5%"> <span class="font-b"> เริ่ม </span> </td>
                        <td align="center" width="5%"> <span class="font-b"> อัตรา </span> </td>
                        <td align="center" width="5%"> <span class="font-b"> บ/ช เงินเดือน </span> </td>
                        <td align="center" width="5%"> <span class="font-b"> หมายเหตุ </span> </td>
                    </tr>
                    <tr class="font-n">
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                        <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>

                    </tr>
                    <tr class="font-n">
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>

                    </tr>
                    <tr class="font-n">
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>
                            <p>&nbsp;</p>
                        </td>
                        <td align="center" width="5">
                        <span class="font-n u">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </span>

                            <p>&nbsp;</p>
                        </td>

                    </tr>
                </table>
              <span class="font-n">  รองกรรมการผู้จัดการใหญ่ สายงานกลุ่มการผลิตธุรกิจน้ำตาล </span>

            </td>
        </tr>

        <tr><td>
<p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>

                <table width="800px">
                    <tr>

                        <td align="center" valign="top" width="25%" class="font-n">
                            <span class="font-n u">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span><br><p>&nbsp;</p>
                            แผนกบุคคล </td>
                        <td align="center" valign="top" width="25%" class="font-n">
                                                        <span class="font-n u">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span><br><p>&nbsp;</p>
                            ผู้จัดการโรงงาน </td>
                        <td align="center" valign="top" width="25%" class="font-n">
                                                        <span class="font-n u">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span><br><p>&nbsp;</p>
                            ผู้จัดการสำนักงาน </td>
                        <td align="center" valign="top" width="25%" class="font-n">

                           <span class="font-n u">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span>

                            <br><p>&nbsp;</p>
                            ผู้อำนวยการผลิต เคเอสแอล น้ำพอง

                        </td>


                    </tr>
                </table>


            </td></tr>

        </tbody></table>
    <p> </p>
<?
$html = ob_get_contents();
ob_end_clean();
//==============================================================
//==============================================================
//==============================================================
include("../../../libs/MPDF54/mpdf.php");

//$mpdf=new mPDF('','A4',14,'thsarabunnew',32,25,27,25,16,13);
$mpdf=new mPDF('','A4',14,'thsarabunnew',10,5,10);
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
$stylesheet .= "

.tablex {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
}
.font-n {display: inline; font-size: 24px; }
.font-b {display: inline; font-size: 24px; font-weight: bold;}
.u {  border-bottom: 1px dotted #0000; }



";
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html,2);
$mpdf->Output('mpdf.pdf','I');
exit;



?>