<?php
$num1 = 50;
$Name = "DevBook";
$br = "<br>";
print "ตัวแปร num1 =".$num1.$br;
print "ตัวแปร Name {$Name} $br";
print "ชื่อ Server Name {$_SERVER['SERVER_NAME']} $br";
print "ซอฟต์แวร์ของ Server =".$_SERVER['SERVER_SOFTWARE'];

print "<pre>";
print_r($_SERVER);
print "</pre>";