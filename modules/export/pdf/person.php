<?php
include "../../../conn.php";
ini_set("memory_limit","128M");
ob_start();
?>
    <table class="tablex" align="center">
        <thead>
        <tr  >
            <th class="xxx" style="color:black;background-color:#fff;border:0px;" colspan="18" align="right">
                <h3>ปพ.๗</h3>
            </th></tr><tr>
            <th class="xxx" style="color:black;background-color:#fff;border:0px;" colspan="18">
                <img src="<?=SERVER_NAME?>/../assets/images/CRUT1.png" width="100px" height="100px" />
                <h2>หนังสือรับรองความประพฤติ</h2>
                <h2>โรงงานสาธิตมหาวิทยาลัยขอนแก่น ฝ่ายมัธยยมศึกษา (มอดินแดง)</h2>
                <h2>ตำบลในเมือง  อำเภอเมืองขอนแก่น  จังหวัดขอนแก่น</h2>

            </th>
        </tr>
        </thead>
        <tbody>
            <tr><td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font-n"> ขอรับรองว่า  </span>
                    <span class="font-b">นางสาวณัฐพีรา  นาจันทอง</span> </td></tr>

            <tr><td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font-n"> เลขประจำตัว  </span>
                    <span class="font-b">๕๙๔๑๔๒</span>

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font-n"> เกิดวันที่ </span> <span class="font-b"> ๙ </span>
                    <span class="font-n"> เดือน </span> <span class="font-b"> มิถุนายน </span>
                    <span class="font-n"> พ.ศ. </span> <span class="font-b"> ๒๕๔๓ </span>

                </td></tr>

            <tr><td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font-n"> บิดาชื่อ  </span>
                    <span class="font-b">นายเจษฐา  นาจันทอง</span>

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font-n"> มารดาชื่อ  </span>
                    <span class="font-b">นางอรุณรัตน์  นาจันทอง</span>

                </td></tr>

            <tr><td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font-b"> เป็นนักเรียนโรงงานสาธิตมหาวิทยาลัยขอนแก่น ฝ่ายมัธยมศึกษา (มอดินแดง)</span>

                </td></tr>
            <tr><td>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="font-n"> มีความประพฤติ  </span>
                    <span class="font-b">เรียบร้อย</span>

                </td></tr>

            <tr><td><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <span class="font-n"> ออกให้ ณ วันที่ </span> <span class="font-b"> ๑๗ </span>
                    <span class="font-n"> เดือน </span> <span class="font-b"> พฤศจิกายน </span>
                    <span class="font-n"> พ.ศ. </span> <span class="font-b"> ๒๕๕๙ </span>

                </td></tr>

        </tbody></table>
    <p>&nbsp;</p>
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
";
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html,2);
$mpdf->Output('mpdf.pdf','I');
exit;



?>