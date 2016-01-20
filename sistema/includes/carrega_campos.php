<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
pt_register('GET','id');
pt_register('GET','ordem');
pt_register('GET','id_pedido');

$servicosDAO = new ServicoDAO();
$servicocampos = $servicosDAO->listaCampos($id);
if($conveniado_login<>''){
    $p_valor = '<table cellspacing="0" cellpadding="0" style="border:solid 1px #999; width:744px;" id="nav">';
} else {
    $p_valor = '<table class="tabela">';
}
if($id_pedido<>''){
	$pedidoDAO = new PedidoDAO();
	$res_campo = $pedidoDAO->selectPorId($id_pedido,$ordem,$controle_id_empresa);
	$controle_cliente = $res_campo->controle_cliente;
}

foreach($servicocampos as $servicocampo){
	$p_valor .= '
	<tr>
		<td width="150">
		<div align="right"><strong>'. $servicocampo->nome .': </strong></div>
		</td>
		<td colspan="3" width="540">';
		
			if($id_pedido<>'') ${$servicocampo->campo} = $res_campo->{$servicocampo->campo};
            if($servicocampo->campo!='certidao_estado' and $servicocampo->campo!='certidao_cidade'){
				$p_valor .= '<input type="'. $servicocampo->tipo .'" name="'. $servicocampo->campo .'" value="'. ${$servicocampo->campo}.'" style="width:500px"';
				if($servicocampo->mascara<>''){
					$p_valor .= ' onKeyUp="masc_numeros(this,\''.$servicocampo->mascara.'\');"';
				}
				$p_valor .= ' class="form_estilo"/>';
			} else {
				if($servicocampo->campo=='certidao_estado')	$java_script = ' onchange="carrega_cidade2(this.value);" ';
				else 
					if($servicocampo->campo=='certidao_cidade') $java_script = ' id="carrega_cidade_campo" '; 
					else $java_script = '';

				$p_valor .= '<select name="'. $servicocampo->campo .'" style="width:500px" '.$java_script.' class="form_estilo">
								<option value="'. ${$servicocampo->campo} .'">'. ${$servicocampo->campo} .'</option>';
				if(${$servicocampo->campo}<>''){
					$p_valor .= '<option value=""></option>';
				}
				
	            if($servicocampo->campo=='certidao_estado'){
					$servicocampo_sel = $servicosDAO->listaEstados();
					foreach($servicocampo_sel as $scs){
						$p_valor .= '<option value="'. $scs->estado .'">'.$scs->estado.'</option>';
					}				
				} else {
					if($servicocampo->campo=='certidao_cidade' and $certidao_estado<>'' ){
						$servicocampo_sel = $servicosDAO->listaCidades($certidao_estado);
						foreach($servicocampo_sel as $scs){
							$p_valor .= '<option value="'. $scs->cidade .'">'.$scs->cidade.'</option>';
						}
					}
				}
				
				$p_valor .= '</select>';
			}
			
			if($servicocampo->mascara<>''){
				$p_valor .= 'onKeyUp="masc_numeros(this,\''.$servicocampo->mascara.'\');"'; } 
			
			$p_valor .= ($servicocampo->obrigatorio)?'<font color="#F00">*</font>':'';
		$p_valor .= '</td>
	</tr>';
}
echo $p_valor;
?>
	<tr>
		<td width="150">
		<div align="right"><strong>CONTROLE DO CLIENTE: </strong></div>
		</td>
		<td colspan="3"><input type="text" name="controle_cliente" value="<?= $controle_cliente ?>" style="width: 500px" class="form_estilo" /></td>
	</tr>
</table>