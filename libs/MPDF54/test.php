<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Bangkok');
// http://php.net/manual/en/timezones.php
 
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />'); // ส่วนนี้ไม่มีอะไรกำหนดค่าไว้ใช้ในการ echo
require_once 'Classes/PHPExcel.php';  // เรียกใช้งาน class
 
//     กำหนด Rendering library pdf ที่ต้องการ ในที่นี้ใช้ mpdf รองรับภาษาไทย เวอร์ชั่น 5.4
$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;  
$rendererLibraryPath = "libraries/MPDF54";  
 
 
 
// เชื่อมต่อฐานข้อมูล  
//$link=mysql_connect("localhost","root","test") or die("error".mysql_error());  
//mysql_select_db("test",$link);  
//mysql_query("set character set utf8");  
 
// โฟลเดอร์เก็บไฟล์ กรณีใช้ใน server ให้กำหนด permission เป็น 777
$placeFilesSave="pdf_files/";
 
// สร้าง PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();
 
// กำหนดค่าต่างๆ ของเอกสาร excel
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("PHPExcel Test Document")
                             ->setSubject("PHPExcel Test Document")
                             ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                             ->setKeywords("office PHPExcel php")
                             ->setCategory("Test result file");
 
// กำหนด รูปภาพ style ที่จะใช้
$styleArray = array(
    'font'  => array(
//        'bold'  => true,
//        'color' => array('rgb' => 'FF0000'),
        'size'  => 14,
        'name'  => 'thsarabunnew'  // ภาษาไทย
    ));
 
 
// การจัดรูปแบบของ cell
$objPHPExcel->getDefaultStyle()
                        ->applyFromArray($styleArray)
                        ->getAlignment()
                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        //HORIZONTAL_CENTER //VERTICAL_CENTER
 
 
// การเพิ่มข้อมูล
echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'หัวข้อ')           
            ->setCellValue('B1', 'หัวข้อย่อย');
 
 
// เราจะทดสอบเพิ่มข้อมูลในตาราง excel อย่างง่าย
$start_row=2;
for($i=1;$i<=10;$i++){
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$start_row, $i)
            ->setCellValue('B'.$start_row, $i*2);
    $start_row++;
}
  
 
// กำหนดชื่อให้กับ worksheet ที่ใช้งาน
echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Simple');
 
// กำหนด worksheet ที่ต้องการให้เปิดมาแล้วแสดง ค่าจะเริ่มจาก 0 , 1 , 2 , ......
$objPHPExcel->setActiveSheetIndex(0);
 
// ชื่อไฟล์
$saveFileName="pdfl_by_phpexcel1";
 
// ตรวจสอบการตั้งค่า Rendering library pdf แล้วหรือไม่
if(!PHPExcel_Settings::setPdfRenderer(  
        $rendererName,  
        $rendererLibraryPath 
    )) {  
    die(  
        'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .  
        '<br />' .  
        'at the top of this script as appropriate for your directory structure' 
    );  
}  
   
     
// แสดงการเขียนไฟล์เรียกร้อยแล้ว และมีลิ้งค์ให้ดาวโหลด
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');  
$saveFileNameFull=$saveFileName.".pdf";
$pathSaveFile1=$placeFilesSave.$saveFileNameFull;
$objWriter->save($pathSaveFile1);
echo date('H:i:s') , " Done writing files" , EOL;
echo 'Files have been created in ' , $placeFilesSave , EOL;
echo "<a href='".$pathSaveFile1."' target='_blank'>Download PDF</a>",EOL;
?>