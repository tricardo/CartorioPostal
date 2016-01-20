<?
setcookie("dir_id_pedido_item", $_COOKIE['p_id_pedido_item']);
setcookie("dir_id_pedido", $_COOKIE['p_id_pedido']);

$ext = explode(',', $_COOKIE['p_id_pedido']);
$ext_num = count($ext) - 1;

$empresa_dir = 0;
$erro = 0;
if(isset($_POST['empresa_dir'])){
	$emp_dir = array(); $emp_cont = 0;
	for($i = 0; $i < count($_POST['empresa_dir']); $i++){
		if($_POST['empresa_dir'][$i] != ''){
			$emp_dir[$emp_cont] = $_POST['empresa_dir'][$i]; $emp_cont++;
		}
	}
	for($i = 0; $i < count($emp_dir); $i++){
		if($i == 0){
			$empresa_dir = $emp_dir[$i];
		} else {
			if($empresa_dir == $emp_dir[$i]){
				$empresa_dir = $emp_dir[$i];
			} else {
				$empresa_dir = 0;
				$erro = 1;
				$i = count($emp_dir);
			}
		}
	}
}
?>
<form enctype="multipart/form-data" action="" method="post" name="pedido_add">
<?if($erro == 1 || $ext_num == 0){?>
<div id="errors" style="display: block;">
	<div class="erro"><b>Ocorreram os seguintes erros:</b>
		<ul>
			<?
			echo ($erro == 1) ? '<li>Você selecionou pedidos de diferentes franquias.<br /> 
				Para continuar, volte e selecione apenas pedidos da mesma franquia para direcionar.</li>' : '';
			echo ($ext_num == 0) ? '<li>Você não selecionou nenhum pedido para direcionar!</li>' : '';
			?>
		</ul>
	</div><br />
</div>
<? } ?>
    <table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
        <tr>
            <td colspan="4" class="tabela_tit"> Direcionamento para franquia</td>
        </tr>   
        <tr>
            <td width="150" valign="top"> <div align="right"><strong>Referente as ordens: </strong></div></td>
            <td width="532" colspan="3">
                <?= str_replace(',', ' - ', $_COOKIE['p_id_pedido']); ?>
                <br><br><b>Foram selecionados <?= $ext_num ?> pedidos.</b>
            </td>
        </tr>  
        <tr>
            <td width="150"> <div align="right"><strong>Direcionar para: </strong></div></td>
            <td colspan="3">
                <select name="id_empresa_resp" style="width:200px; float:left" class="form_estilo">
                    <?=($controle_id_empresa == 1) ? '<option value=""></option>' : '';?>
                    <?
                    $p_valor = '';
                    $empresaDAO = new EmpresaDAO();
                    $lista = $empresaDAO->listarTodasN($controle_id_empresa);
                    foreach($lista as $l){
						if($controle_id_empresa == 1){
							$p_valor .= '<option value="' . $l->id_empresa . '"';
								$p_valor .= ($empresa_dir == $l->id_empresa) ? ' selected="selected" ' : '';
								//if ($id_empresa == $l->id_empresa) $p_valor .= ' selected="selected" ';
								$p_valor .= '>' . str_replace('Cartório Postal - ','',$l->fantasia) . '</option>';
						} else {
							if($empresa_dir == $l->id_empresa){
								$p_valor .= '<option value="' . $l->id_empresa . '"';
								$p_valor .= ($empresa_dir == $l->id_empresa) ? ' selected="selected" ' : '';
								//if ($id_empresa == $l->id_empresa) $p_valor .= ' selected="selected" ';
								$p_valor .= '>' . str_replace('Cartório Postal - ','',$l->fantasia) . '</option>';
							}
						}
                    }
                    echo $p_valor;
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div align="center">
                    <?if($erro == 0 && $ext_num > 0){?><input type="submit" name="submit_direcionamento_aplica" value=" Enviar " class="button_busca" />&nbsp;<?}?>
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
<?
#fim da alteração de status
require('footer.php');
exit;
?>