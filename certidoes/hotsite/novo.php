<?
session_start();
	unset($_SESSION['p']);
	unset($_SESSION['id_pedido']);
	header('location: /'.$_GET['id_empresa'].'/'.$_GET['estado'].'/'.$_GET['cidade']);
	#print_r($_GET);
	exit;
?>