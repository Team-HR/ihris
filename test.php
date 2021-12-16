<?php
$arr = array('name','rollno','address');
file_put_contents('array.txt',  '<?php return ' . var_export($arr, true) . ';');