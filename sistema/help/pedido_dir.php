<? header("Content-Type: text/html; charset=ISO-8859-1",true); 
$fantasia = htmlentities(str_replace('_',' ',$_GET['fantasia']));
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"></head><body>
<ul>
<li>1) Esse pedido precisa ser direcionado para a seguinte franquia: <?= $fantasia ?></li>
</ul>
</body></html>