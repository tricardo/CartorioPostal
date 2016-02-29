<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/funcoes.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/global.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/model/Database.php');


pt_register('GET','id');
pt_register('GET','form');
pt_register('GET','id_pedido_item');
pt_register('GET','id_pedido');
pt_register('GET','largura');
if($largura=='') $largura=540;

$servicosDAO = new ServicoDAO();
$servicocampos = $servicosDAO->listaCamposSite($id);
$p_valor = '<table>';
foreach($servicocampos as $servicocampo){
	$p_valor .= '<tr><td><label for="'. $servicocampo->campo .'" class="label_pedido">'. $servicocampo->nome .': </label>';
        $p_valor .= ($servicocampo->obrigatorio)?'<strong style="color:#ff0000">*</strong>':'';
        $p_valor .= '</td><td>';
	if($id_pedido<>'') ${$servicocampo->campo} = $res_campo->{$servicocampo->campo};
            if($servicocampo->campo!='certidao_estado' and $servicocampo->campo!='certidao_cidade'){
                    $p_valor .= '<input type="'. $servicocampo->tipo .'" name="'. $servicocampo->campo .'" id="'. $servicocampo->campo .'" value="'. ${$servicocampo->campo}.'" style="width:'.$largura.'px"';
                    if($servicocampo->mascara<>''){
                        $p_valor .= ' onKeyUp="masc_numeros(this,\''.$servicocampo->mascara.'\');"';
                    }
                    $p_valor .= ' class="form_estilo"/>';
		} else {
                    if($servicocampo->campo=='certidao_estado')	$java_script = ' onchange="carrega_cidade2(this.value);" ';
                    else 
                        if($servicocampo->campo=='certidao_cidade') $java_script = ' id="carrega_cidade_campo" '; 
                        else $java_script = '';
                    $p_valor .= '<select name="'. $servicocampo->campo .'" id="'. $servicocampo->campo .'" style="width:'.$largura.'px" '.$java_script.' class="form_estilo">
                                    <option value="'. ${$servicocampo->campo} .'">'. char_upper(strtoupper(strtolower(${$servicocampo->campo}))) .'</option>';
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
                    $p_valor .= 'onKeyUp="masc_numeros(this,\''.$servicocampo->mascara.'\');"'; 
		} 
                $p_valor .= '</td>';
}
$p_valor .= '</tr></table>';
echo $p_valor;

?>