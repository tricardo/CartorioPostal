<?
if($controle_id_usuario==""){
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );
	pt_register('GET','id_pedido_item');
	$departamento_s = explode(',' ,$controle_id_departamento_s);
	$departamento_p = explode(',' ,$controle_id_departamento_p);
	$pedidoDAO = new PedidoDAO();
}
#verifica se o usuário não está tentando burlar a url
$anexoDAO = new AnexoDAO();
if($controle_id_empresa==1)
    $a = $pedidoDAO->buscaPorId($id_pedido_item,0);
else
    $a = $pedidoDAO->buscaPorId($id_pedido_item,$controle_id_empresa);    

if($a->id_pedido_item==''){
	echo 'Você não tem permissão de alterar esse pedido';
	exit;
}

?>
<form action="#aba5" method="post" name="p_anexo" id="p_anexo" enctype="multipart/form-data">
<input type="hidden" name="p_anexo" value="1" />
<table width="800" class="tabela">
	<tr>
		<td colspan="4" class="tabela_tit">Certid&otilde;es em Anexo (Somente
		para conveniados)</td>
	</tr>
	<tr>
	  <td colspan="4" align="left"><table border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px; margin-top:10px;">
        <tr>
          <td width="150" height="28" align="right"><strong>Arquivo:&nbsp;&nbsp;<img src="../images/null.gif" onload="CarregaAnexo('Certidão')" /> </strong></td>
          <td><select name="anexo_nome" style="width:280px" class="form_estilo" onchange="CarregaAnexo(this.value);">
            <?
			$p_valor="";
			$anexo_nome = $anexoDAO->listaAnexoNome();
			foreach($anexo_nome as $ane){
				$p_valor .= '<option value="'.$ane->anexo_nome.'" >'.$ane->anexo_nome.'</option>';
			}
			echo $p_valor;
			?>
          </select></td>
          <td><input type="file" class="form_estilo" name="file_anexo" style="margin-left:10px;" /></td>
          </tr>
        <tr>
          <td height="28" align="right"><strong>Resultado:&nbsp;&nbsp;</strong></td>
          <td colspan="2"><input style="width:550px" type="text" maxlength="80" id="certidao_resultado"
           name="certidao_resultado" value="<?= $a->certidao_resultado ?>" class="form_estilo" /></td>
          </tr>
        <tr>
          <td height="28" align="right">&nbsp;</td>
          <td colspan="2"><input type="submit" class="button_busca" name="submit_anexo" value="Anexar" /></td>
          </tr>
      </table></td>
    </tr>
	<?	$p_valor="";
		$anexo_nome = $anexoDAO->listaAnexoPedido($id_pedido_item);
		foreach($anexo_nome as $ane){					
			#correção temporaria
			$dt = explode(' ',$ane->data);
			$dt1 = explode('-', $dt[0]);
			$file_path = '../anexos/'.$ane->anexo;
			if((int)$dt1[0] > 2010 && (int)$dt1[1] > 6 && (int)$dt1[2] > 6){
				if(!file_exists($ane->anexo)){
					$file_path = $ane->anexo;
				}				
			}
			$p_valor .= '
			<tr><td colspan="4">
			<input style="width:140px; margin-left:25px;" type="submit" class="button_busca" name="submit_anexo_deleta" value="Deletar Anexo '. $ane->id_pedido_anexo .'" />
			&nbsp;&nbsp;<a href="'.$file_path.'" target="_blank">'.invert($ane->data,'/','PHP').' - '.$ane->anexo_nome.'</a>				
			</td></tr>';
			#**********************
		}
		echo $p_valor; ?>
    <tr>
    	<td colspan="4" style="height:10px;">&nbsp;</td>
    </tr>
</table>
</form>
