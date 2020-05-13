<?php



$html = '
<h3>Rotating Tables</h3>
<p>This is set to rotate -90 degrees (counterclockwise).</p>

<h5>Periodic Table</h5>
<p>
<table rotate="-90" class="bpmClearC"><thead>
<tr><th>1A</th><th>2A</th><th>3B</th><th>4B</th><th>5B</th><th>6B</th><th>7B</th><th>8B</th><th>8B</th><th>8B</th><th>1B</th><th>2B</th><th>3A</th><th>4A</th><th>5A</th><th>6A</th><th>7A</th><th>8A</th></tr></thead><tbody>
<tr>
<td></td>
<td colspan="18"></td>
</tr>
<tr>
<td>H </td>
<td colspan="15"></td>
<td></td>
<td>He </td>
</tr>
<tr>
<td>Li </td>
<td>Be </td>
<td colspan="10"></td>
<td>B </td>
<td>C </td>
<td>N </td>
<td>O </td>
<td>F </td>
<td>Ne </td>
</tr>
<tr>
<td>Na </td>
<td>Mg </td>
<td colspan="10"></td>
<td>Al </td>
<td>Si </td>
<td>P </td>
<td>S </td>
<td>Cl </td>
<td>Ar </td>
</tr>
<tr>
<td>K </td>
<td>Ca </td>
<td>Sc </td>
<td>Ti </td>
<td>V </td>
<td>Cr </td>
<td>Mn </td>
<td>Fe </td>
<td>Co </td>
<td>Ni </td>
<td>Cu </td>
<td>Zn </td>
<td>Ga </td>
<td>Ge </td>
<td>As </td>
<td>Se </td>
<td>Br </td>
<td>Kr </td>
</tr>
<tr>
<td>Rb </td>
<td>Sr </td>
<td>Y </td>
<td>Zr </td>
<td>Nb </td>
<td>Mo </td>
<td>Tc </td>
<td>Ru </td>
<td>Rh </td>
<td>Pd </td>
<td>Ag </td>
<td>Cd </td>
<td>In </td>
<td>Sn </td>
<td>Sb </td>
<td>Te </td>
<td>I </td>
<td>Xe </td>
</tr>
<tr>
<td>Cs </td>
<td>Ba </td>
<td>La </td>
<td>Hf </td>
<td>Ta </td>
<td>W </td>
<td>Re </td>
<td>Os </td>
<td>Ir </td>
<td>Pt </td>
<td>Au </td>
<td>Hg </td>
<td>Tl </td>
<td>Pb </td>
<td>Bi </td>
<td>Po </td>
<td>At </td>
<td>Rn </td>
</tr>
<tr>
<td>Fr </td>
<td>Ra </td>
<td>Ac </td>
</tr>
<tr>
<td></td>
<td colspan="18"></td>
</tr>
<tr>
<td colspan="3"></td>
<td>Ce </td>
<td>Pr </td>
<td>Nd </td>
<td>Pm </td>
<td>Sm </td>
<td>Eu </td>
<td>Gd </td>
<td>Tb </td>
<td>Dy </td>
<td>Ho </td>
<td>Er </td>
<td>Tm </td>
<td>Yb </td>
<td>Lu </td>
<td></td>
</tr>
<tr>
<td colspan="3"></td>
<td>Th </td>
<td>Pa </td>
<td>U </td>
<td>Np </td>
<td>Pu </td>
<td>Am </td>
<td>Cm </td>
<td>Bk </td>
<td>Cf </td>
<td>Es </td>
<td>Fm </td>
<td>Md </td>
<td>No </td>
<td>Lr </td>
<td></td>
</tr>
</tbody></table>
<p>&nbsp;</p>

<pagebreak />
';
$html = '
<h3>ทดสอบการสร้างไฟล์ PDF</h3>

<h5>Periodic Table</h5>
<table>
<thead>
<tr text-rotate="90" >
<th valign="bottom"><p>Element type 1A</p><p>Second line</p>
<th valign="bottom"><p>Element type longer 2A</p></th>
<th valign="bottom">Element type 3B</th>
<th valign="bottom">Element type 4B</th>
<th valign="bottom">Element type 5B</th>
<th valign="bottom">Element type 6B</th>
<th valign="bottom">7B</th>
<th valign="bottom">8B</th>
<th valign="bottom">Element type 8B R</th>
<th valign="bottom">8B</th>
<th valign="bottom">Element <span>type</span> 1B</th>
<th valign="bottom">2B</th>
<th valign="bottom">Element type 3A</th>
<th valign="bottom">Element type 4A</th>
<th valign="bottom">Element type 5A</th>
<th valign="bottom">Element type 6A</th>
<th valign="bottom">7A</th>
<th valign="bottom">Element type 8A</th>
</tr>
</thead>

<tbody>
<tr>
<td>H</td>
<td colspan="15"></td>
<td></td>
<td>He </td>
</tr>
<tr>
<td>Li </td>
<td>Be </td>
<td colspan="10"></td>
<td>B </td>
<td>C </td>
<td>N </td>
<td>O </td>
<td>F </td>
<td>Ne </td>
</tr>
<tr>
<td>Na </td>
<td>Mg </td>
<td colspan="10"></td>
<td>Al </td>
<td>Si </td>
<td>P </td>
<td>S </td>
<td>Cl </td>
<td>Ar </td>
</tr>
<tr style="text-rotate: 45">
<td>K </td>
<td>Ca </td>
<td>Sc </td>
<td>Ti</td>
<td>Va</td>
<td>Cr</td>
<td>Mn</td>
<td>Fe</td>
<td>Co</td>
<td>Ni </td>
<td>Cu </td>
<td>Zn </td>
<td>Ga </td>
<td>Ge </td>
<td>As </td>
<td>Se </td>
<td>Br </td>
<td>Kr </td>
</tr>
<tr>
<td>Rb </td>
<td>Sr </td>
<td>Y </td>
<td>Zr </td>
<td>Nb </td>
<td>Mo </td>
<td>Tc </td>
<td>Ru </td>
<td style="text-align:right; ">Rh</td>
<td>Pd </td>
<td>Ag </td>
<td>Cd </td>
<td>In </td>
<td>Sn </td>
<td>Sb </td>
<td>Te </td>
<td>I </td>
<td>Xe </td>
</tr>
<tr>
<td>Cs </td>
<td>Ba </td>
<td>La </td>
<td>Hf </td>
<td>Ta </td>
<td>W </td>
<td>Re </td>
<td>Os </td>
<td>Ir </td>
<td>Pt </td>
<td>Au </td>
<td>Hg </td>
<td>Tl </td>
<td>Pb </td>
<td>Bi </td>
<td>Po </td>
<td>At </td>
<td>Rn </td>
</tr>
<tr>
<td>Fr </td>
<td>Ra </td>
<td colspan="16">Ac </td>
</tr>
<tr>
<td colspan="3"></td>
<td>Ce </td>
<td>Pr </td>
<td>Nd </td>
<td>Pm </td>
<td>Sm </td>
<td>Eu </td>
<td>Gd </td>
<td>Tb </td>
<td>Dy </td>
<td>Ho </td>
<td>Er </td>
<td>Tm </td>
<td>Yb </td>
<td>Lu </td>
<td></td>
</tr>
<tr>
<td colspan="3"></td>
<td>Th </td>
<td>Pa </td>
<td>U </td>
<td>Np </td>
<td>Pu </td>
<td>Am </td>
<td>Cm </td>
<td>Bk </td>
<td>Cf </td>
<td>Es </td>
<td>Fm </td>
<td>Md </td>
<td>No </td>
<td>Lr </td>
<td></td>
</tr>
</tbody></table>
<p>&nbsp; ทดสอบ</p>

';

//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

//==============================================================
//==============================================================
//==============================================================
include("../mpdf.php");

//$mpdf=new mPDF('','A4',14,'thsarabunnew',32,25,27,25,16,13); 
$mpdf=new mPDF('','A4',14,'thsarabunnew'); 
//$mpdf->allow_charset_conversion=true;
//$mpdf->charset_in='UTF-8';

// กำหนด Font กรณีใช้ภาษาไทยใช้ freeserif
//$mpdf->SetFont('thsarabunnew', '', 10);

$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
//$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html,2);
$mpdf->Output('mpdf.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>