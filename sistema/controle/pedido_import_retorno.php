<? 
#ESSE ARQUIVO EST� AMARRADO COM O ARQUIVO pedido_retorno.php
#arquivo de importa��o de retorno do cartorio de Maceio
$permissao = verifica_permissao('Pedido Import Cart',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
	echo '<br><br><strong>Voc� n�o tem permiss�o para importar arquivo</strong>';
	exit;
} 

#$file_import_name � definido no arquivo pedido_add.php
$fp = "./retorno/".$file_import_name;

#abre o arquivo
$handle = @fopen($fp, "r");

#importa��o de arquivo de retorno de notifica��o
require("../includes/importacao/notificacao_retorno_cart.php");

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
			$ordens .= '<font color="#FF0000"><br><b>'.$ordens_a[$i-1].': </b> n�o houve nenhuma atualiza��o nessa ordem</font>';
		else
			$ordens .= '<br><b>'.$ordens_a[$i-1].': </b>'.$num.' registro(s) atualizados';
	}
	$done = 1;
}

?>