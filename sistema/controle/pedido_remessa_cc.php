<?
require('header.php');
$permissao = verifica_permissao('Pedido Import',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','id_arquivo');
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);	

?>
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_rel_banco.png" alt="Título" /> Log de arquivos - Erros (<a href="pedido_remessa_c.php">Log de Arquivos</a>)</h1>
    <hr class="tit"/>
</div>
<div id="meio">
<table border="0" height="100%" width="100%" >
<tr>
	<td valign="top">

            <form enctype="multipart/form-data" action="gera_retorno.php" method="post" name="pedido_print" target="_blank">
              <center>
       <table width="850" class="result_tabela"  cellpadding="4" cellspacing="1">
          <tr>
          <td class="tabela_tit"><strong>Nome</strong></td>
          <td class="tabela_tit"><strong>CPF/CNPJ</strong></td>
          <td class="tabela_tit"><strong>Cidade </strong></td>
		  <td class="tabela_tit"><strong>Estado </strong></td>
		  <td class="tabela_tit"><strong>Erro </strong></td>
		  <td class="tabela_tit"><strong>Registrar </strong></td>
        </tr>
				<?
			$arquivoitemDAO = new ArquivoItemDAO();
			$lista = $arquivoitemDAO->listaRemessaCPorID($id_arquivo,$controle_id_empresa);
			$p_valor = '';
			foreach($lista as $l){
					$p_valor .= '
					<tr id="result_'.$l->id_arquivo_item.'">
						<td class="result_celula"> <input type="text" name="nome_'.$l->id_arquivo_item.'" value = "'.$l->certidao_nome.'"></td>
						<td class="result_celula"> <input type="text" name="cpf_'.$l->id_arquivo_item.'" value = "'.$l->certidao_cpf.'"></td>
						<td class="result_celula"> <input type="text" name="cidade_'.$l->id_arquivo_item.'" value = "'.$l->certidao_cidade.'"></td>
						<td class="result_celula"> <input type="text" name="estado_'.$l->id_arquivo_item.'" value = "'.$l->certidao_estado.'"></td>
						<td class="result_celula" width="150"> '.$l->erro.'</td>
						<td class="result_celula">
							<input type="button" name="registro_'. $l->id_arquivo_item .'" onclick="remessa_registra(nome_'. $l->id_arquivo_item .'.value,cpf_'. $l->id_arquivo_item .'.value,cidade_'. $l->id_arquivo_item .'.value,estado_'. $l->id_arquivo_item .'.value,\''. $l->id_arquivo_item.'\')" value = "Processar">
						</td>
					</tr>';
				}		
				echo $p_valor;
				?>        
      </table>
        </center>
    </form>

</div>
<?php
	require('footer.php');
?>