<html>
<head> </head>

<body>
<h1> Oi!!!!! </h1>
<?php

$str = file_get_contents("../info.json");
$arr = json_decode($str, true);
$keys = array_keys($arr);

$arr1 = $arr[$keys[0]];
var_dump($arr1);
?>


</body>

</html>