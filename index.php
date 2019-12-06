<html>
<head> </head>

<body>
<h1> Oi!!!!! </h1>
<?php

include "conexao.php";
include "Store.php";

$storeDao = new StoreDao();
$storeDao->findAll();


?>


</body>

</html>