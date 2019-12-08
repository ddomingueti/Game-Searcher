<html>
<head> </head>

<body>
<h1> Oi!!!!! </h1>
<?php

#include "conexao.php";
include "Store.php";

$storeDao = new Store("steam", "...");
$data = $storeDao->jsonSerialize();
$data['id'] = '123';
var_dump($data);

?>


</body>

</html>