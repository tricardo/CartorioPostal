<?php
#ESSE ARQUIVO ESTÁ AMARRADO COM O ARQUIVO pedido_retorno.php
#arquivo de importação de retorno do cartorio de Maceio
$permissao = verifica_permissao('Pedido Import Cart',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
    header('location:pagina-erro.php');
    exit;
} 

#$file_import_name é definido no arquivo pedido_add.php
$fp = "retorno/".$file_import_name;

#abre o arquivo
$handle = @fopen($fp, "r");

#importação de arquivo de retorno de notificação
require("includes/importacao/notificacao_retorno_cart.php");

#if o arquivo estiver errado finaliza
if($erro<>''){
	$errors=1;
	$error=$erro;
} else {
	$ordens_a = explode(',',$ordens);
	$ordens='';
	foreach ($ARRAY as $i => $value) {
		$result = $objQuery->SQLQuery($ARRAY[$i]);
		$num = $objQuery->QUERY_A();
		if($num==0)
                    $ordens .= $ordens_a[$i-1].': não houve nenhuma atualização nessa ordem';
		else
                    $ordens .= $ordens_a[$i-1].': '.$num.' registro(s) atualizados';
	}
	$done = 1;
}