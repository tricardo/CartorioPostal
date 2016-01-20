<?php
require('header.php');
$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' and $controle_id_empresa!='1'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','id_fornecedor_anexo');

$fornecedorDAO = new FornecedorDAO();
$anexo = $fornecedorDAO->buscaPorIdAnexo($id_fornecedor_anexo);
$fornecedorDAO->excluirAnexo($anexo);

if(is_file($anexo->anexo))
unlink($file_path.$anexo->anexo);
?>