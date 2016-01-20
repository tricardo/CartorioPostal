<?php
require('header.php');
$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' and $controle_id_empresa!='1'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','id_cliente_anexo');

$clienteDAO = new ClienteDAO();
//$anexo = $clienteDAO->buscaPorIdAnexo($id_cliente_anexo);
$clienteDAO->excluirAnexo($anexo,$controle_id_empresa);

//if(is_file($anexo->anexo))
//unlink($file_path.$anexo->anexo);
?>