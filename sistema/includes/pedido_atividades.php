<?
setcookie ("atividade_id_pedido_item", $_COOKIE['p_id_pedido_item']);
setcookie ("atividade_id_pedido", $_COOKIE['p_id_pedido']);

$ext = explode(',',$_COOKIE['p_id_pedido']);
$ext_num = count ($ext)-1;
$atividadeDAO = new AtividadeDAO();

?>
	<form enctype="multipart/form-data" action="" method="post" name="pedido_add">
	<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
		<tr>
			<td colspan="4" class="tabela_tit"> Nova Atividade</td>
		</tr>   
		<tr>
			<td width="150" valign="top"> <div align="right"><strong>Referente as ordens: </strong></div></td>
			<td width="532" colspan="3">
				<?= str_replace(',',' - ',$_COOKIE['p_id_pedido']); ?>
				<br><br><b>Foram selecionados <?= $ext_num ?> pedidos.</b>
			</td>
		</tr>  
		<tr>
			<td width="150"> <div align="right"><strong>Atividade: </strong></div></td>
			<td colspan="3">
				<select name="acao_id_atividade" style="width:280px" class="form_estilo">
					<option value=""></option>
					<?
						$ativs = $atividadeDAO->listaAtividades($controle_atividade);
						$p_valor = "";
						foreach($ativs as $ati){
							$p_valor .= '<option value="'.$ati->id_atividade.'" >'.$ati->atividade.'</option>';
						}
						echo $p_valor;
					?>
				</select>
				<font color="#FF0000">*</font> 
				<strong>Dias: </strong>
				<input type="text" name="status_dias" value="" style="width:50px" class="form_estilo" onKeyUp="masc_numeros(this,'###');buscaData(this);"/>
				<b>Hora:</b>
				<input type="text" name="status_hora"   onKeyUp="masc_numeros(this,'##:##');" value="" style="width:50px" class="form_estilo"/>
			</td>
		</tr>
		<tr>
			<td align="right"><strong>Data</strong></td>
			<td>
				<input id="data_posdias" class="form_estilo" readonly="readonly"/>
			</td>
		</tr>
		<tr>
			<td width="150" valign="top"><div align="right"><strong>Obs: </strong></div></td>
			<td width="532" colspan="3">
				<textarea name="status_obs" class="form_estilo" style="width:493px; height:100px"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<div align="center">
				<input type="submit" name="submit_status" value=" Enviar " class="button_busca" />&nbsp;  
				<input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_add.action='pedido.php'" class="button_busca" />
				</div>
			</td>
		</tr>
	</table>
	</form>
	  
	</td>
	</tr>
</table>  
</div>
<? #fim da alteração de status
require('footer.php');
exit;  	
?>