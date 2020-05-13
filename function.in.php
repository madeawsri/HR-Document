<?

function getDateTH($xdate='')
{
    $xdate = explode('/',$xdate);
    if($xdate){
        $m = $xdate[1];
        $y=$xdate[2];
        $d  = $xdate[0];
    }else{
        $date_date = getdate();
        $m=$date_date[month];
        $y = $date_date['year']+543;
        $d = $date_date['day'];
    }


    switch ($m) {
        case "01":
            $month = "มกราคม";
            break;
        case "02":
            $month = "กุมภาพันธ์";
            break;
        case "03":
            $month = "มีนาคม";
            break;
        case "04":
            $month = "เมษายน";
            break;
        case "05":
            $month = "พฤษภาคม";
            break;
        case "06":
            $month = "มิถุนายน";
            break;
        case "07":
            $month = "กรกฎาคม";
            break;
        case "08":
            $month = "สิงหาคม";
            break;
        case "09":
            $month = "กันยายน";
            break;
        case "10":
            $month = "ตุลาคม";
            break;
        case "11":
            $month = "พฤศจิกายน";
            break;
        case "12":
            $month = "ธันวาคม";
            break;
    }
    return " {$d} {$month} {$y}  ";
}

function array_substr($ar,$begin=0,$end=0){
// only key of array is NUMBER ONLY
    $ret = array();
    if(!$end) $end = count($ar);
    else $end = ($end > count($ar))?count($ar):$end;
    for($i=$begin; $i<$end; $i++)
        $ret[] = $ar[$i];
    return $ret;
}

if (! function_exists('array_column')) {
    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( !array_key_exists($columnKey, $value)) {
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( !array_key_exists($indexKey, $value)) {
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
}
function ExcelDateToDate($readDate){
    $phpexcepDate = $readDate-25569; //to offset to Unix epoch
    return strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
}
function ConvertUTF8($value){
    return iconv('tis-620','utf-8',$value);
}
function ConvertTIS620($value){
    return iconv('utf-8','tis-620',$value);
}

function MSSQLEncodeTH($ar){ // for 1D
    $rows = array();
    foreach ($ar as $key => $value) {
        # code...
        $rows[$key] = ConvertUTF8($value);
    }
    return $rows;
}

function MSSQLEncodeTH2D($arr){  // for 2D
    $rows = array();
    if($arr)
        foreach($arr as $row ) {
            $rows[] = MSSQLEncodeTH($row);//array_map('utf8_encode', $row);
        }
    return $rows;
}
function _p($uid,$fname,$type){
	$ret = getMYSQLValue("tbpermision",$type,"uid = '{$uid}' and filename = '{$fname}'");
	if(!$ret){
       _alert(" คุณไม่มีสิทธ์เข้าใช้งาน ->  ส่งเมลอ์ของใช้สิทธิ์ได้ที่ boonyadol@gmail.com  ");
        exit(0);
    }
	return (int)$ret;
}
function getPermision($uid,$mid,$type){
	$ret = getMYSQLValue("tbpermision",$type,"uid = '{$uid}' and mid = '{$mid}'");
	return (int)$ret;
}
function FnADLogin( $user, $passwd ) {
 if(empty($user) || empty($passwd)) return false;
 if( $ds = @ldap_connect( "LDAP://10.1.18.2" ) ) {
     $info = @ldap_bind( $ds, $user."@kslgroup.com", $passwd);

        // ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
        // ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

     if( $info ) return true;
  ldap_close($ds);
 }
 return false;
}

function FnDateH($d1,$d2){
  $time_difference = $d2 - $d1 ; // seconds
  $hours = round($time_difference / 3600 );
  return $hours;
}
function FnDateM($d1,$d2){
  $time_difference = $d2 - $d1 ; // seconds
  $minutes = round($time_difference / 60 );
  return $minutes;
}
function FnDateD($d1,$d2){
  $time_difference = $d2 - $d1 ; // seconds
  $days = round($time_difference / 86400 );
  return $days;
}
function tFacebook($session_time,$d2)
{
$time_difference = $d2 - $session_time ;

$seconds = $time_difference ;
$minutes = round($time_difference / 60 );
$hours = round($time_difference / 3600 );
$days = round($time_difference / 86400 );
$weeks = round($time_difference / 604800 );
$months = round($time_difference / 2419200 );
$years = round($time_difference / 29030400 );
// Seconds
if($seconds <= 60)
{
echo "$seconds seconds ago";
}
//Minutes
else if($minutes <=60)
{

   if($minutes==1)
  {
   echo "one minute ago";
   }
   else
   {
    echo "$minutes minutes ago";
   }
}
//Hours
else if($hours <=24)
{

   if($hours==1)
  {
   echo "one hour ago";
  }
  else
  {
   echo "$hours hours ago";
  }

}
//Days
else if($days <= 7)
{

  if($days==1)
  {
   echo "one day ago";
  }
  else
  {
   echo "$days days ago";
   }

}
//Weeks
else if($weeks <= 4)
{
   if($weeks==1)
  {
   echo "one week ago";
   }
  else
  {
   echo "$weeks weeks ago";
  }
}
//Months
else if($months <=12)
{
   if($months==1)
  {
   echo "one month ago";
   }
  else
  {
   echo "$months months ago";
   }
}
//Years
else
{
   if($years==1)
   {
    echo "one year ago";
   }
   else
  {
    echo "$years years ago";
   }
}

}

function vvArray($ret){ print "<pre>";  print_r($ret);	 print "</pre>";}

/**
 * เวลาเรียกใช้ให้เรียก ThaiBahtConversion(1234020.25); ประมาณนี้
 * @param numberic $amount_number
 * @return string 
 */
//function ThaiBahtConversion($amount_number)
function num2txt($amount_number)
{
    $amount_number = number_format($amount_number, 2, ".","");
    //echo "<br/>amount = " . $amount_number . "<br/>";
    $pt = strpos($amount_number , ".");
    $number = $fraction = "";
    if ($pt === false) 
        $number = $amount_number;
    else
    {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }
    
    //list($number, $fraction) = explode(".", $number);
    $ret = "";
    $baht = ReadNumber ($number);
    if ($baht != "")
        $ret .= $baht . "บาท";
    
    $satang = ReadNumber($fraction);
    if ($satang != ""){
        $ret .=  $satang . "สตางค์";
	}else{ 
        if(trim($ret))
		  $ret .= "ถ้วน";
	}
    //return iconv("UTF-8", "TIS-620", $ret);
    return $ret;
}
function ReadNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000)
    {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }
    
    $divider = 100000;
    $pos = 0;
    while($number > 0)
    {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
            ((($divider == 10) && ($d == 1)) ? "" :
            ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}
function f2d($x){return number_format($x,2);}
function f3d($x){return number_format($x,3);}

function lastDay($day,$n,$format="Y/m/d"){
  return date($format, strtotime( $day." -$n day" ) ); // PHP:  2009-03-03
}
function _alert($x){ print "<script>alert('{$x}');</script>"; }
?>