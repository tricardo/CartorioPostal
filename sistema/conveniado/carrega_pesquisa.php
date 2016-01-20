<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
include_once( "../includes/verifica_logado_conveniado.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$erro      = 0;
$msg_error = '';
$padrao    = 25;

foreach($_GET as $cp => $valor){
	$_SESSION[$cp] = $valor;
	pt_register('GET', (string) $cp);
}

$p      = 0;
$pagina = 0;
if($_GET['p']){ $p = $_GET['p']; }
if($_GET['pagina']){ $pagina = $_GET['pagina']; }

if($erro == 0 && $p == 0){
	$d = explode('/', $busca_data_i);
	$busca_data_i_t = $d[2].'-'.$d[1].'-'.$d[0];
	$d = explode('/', $busca_data_f);
	$busca_data_f_t = $d[2].'-'.$d[1].'-'.$d[0];
	
	if(strtotime($busca_data_i_t) > strtotime($busca_data_f_t)){
		$erro 	   = 1;
		$msg_error = "Atenção! <br />A segunda data não pode ser menor que a primeira data no campo [ Iniciado entre: ].";
	}
}

if($erro == 0 && ($busca_data_i_co != '' && $busca_data_f_co != '') && $p == 0){
	$d = explode('/', $busca_data_i_co);
	$busca_data_i_t = $d[2].'-'.$d[1].'-'.$d[0];
	$d = explode('/', $busca_data_f_co);
	$busca_data_f_t = $d[2].'-'.$d[1].'-'.$d[0];

	if(strtotime($busca_data_i_t) > strtotime($busca_data_f_t)){
		$erro 	   = 1;
		$msg_error = "Atenção! <br />A segunda data não pode ser menor que a primeira data no campo [ Conc. Oper.: ].";
	}
}

/*
if($p == 0){
	$campo = '';
	if($erro == 0 && $busca != '0'){
		switch($busca){
			case 1:
			case 3:
				$campo = FormataNumero($cnpj);

				if(strlen($campo) == 0 && $erro == 0){
					$erro 	   = 1;
					$msg_error = "Atenção! <br />Você não digitou o CPF.".'-'.$campo;
					echo '<img src="../images/null.gif" onload="document.getElementById(\'cnpj\').focus(); document.getElementById(\'cpf\').value=\'\'" />';
				}
				if(validaCPF($campo) == 'false' && $erro == 0){
					$erro 	   = 1;
					$msg_error = "Atenção! <br />CPF digitado inválido.";
					echo '<img src="../images/null.gif" onload="document.getElementById(\'cpf\').focus(); document.getElementById(\'cpf\').value=\'\'" />';
				}
			break;
			
			case 4:
				$busca = 3;
				$campo = FormataNumero($cnpj);
				$campo = FormataNumero($cpf);
				if(strlen($campo) == 0 && $erro == 0){
					$erro 	   = 1;
					$msg_error = "Atenção! <br />Você não digitou o CNPJ do Devedor.aa";
					echo '<img src="../images/null.gif" onload="document.getElementById(\'cnpj\').focus(); document.getElementById(\'cnpj\').value=\'\'" />';
				}
				
				if(validaCNPJ($campo) == 'false' && $erro == 0){
					$erro 	   = 1;
					$msg_error = "Atenção! <br />CNPJ digitado inválido.";
					echo '<img src="../images/null.gif" onload="document.getElementById(\'cnpj\').focus(); document.getElementById(\'cnpj\').value=\'\'" />';
				}
			break;
			
			case 2:
				$campo = FormataNumero($cnpj);
				if(strlen($campo) == 0 && $erro == 0){
					$erro 	   = 1;
					$msg_error = "Atenção! <br />Você não digitou o CNPJ.";
					echo '<img src="../images/null.gif" onload="document.getElementById(\'cnpj\').focus(); document.getElementById(\'cnpj\').value=\'\'" />';
				}
				
				if(validaCNPJ($campo) == 'false' && $erro == 0){
					$erro 	   = 1;
					$msg_error = "Atenção! <br />CNPJ digitado inválido.";
					echo '<img src="../images/null.gif" onload="document.getElementById(\'cnpj\').focus(); document.getElementById(\'cnpj\').value=\'\'" />';
				}
			break;
			
			default:
				$campo = $outros;
				if(strlen($campo) < 3 && $erro == 0){
					$erro 	   = 1;
					$msg_error = "Atenção! <br />Você deve digitar ao menos 3 caracteres para continuar a busca.";
					echo '<img src="../images/null.gif" onload="if(document.getElementById(\'outros\')){document.getElementById(\'outros\').focus();}" />';
				}
			break;
		}
	}
}
*/

if($erro == 0){
	echo '<script type="Javascript">' . " \n";
	echo "if(document.getElementById('mensagem')){" . " \n";
	echo "document.getElementById('mensagem').style.display='block';" . " \n";
	echo "document.getElementById('mensagem').innerHTML = '<img src=\"images/aguarde.gif\" id=\"aguarde\" />'" . " \n";
	echo "}" . " \n";
	echo '</script>' . " \n";
	
	$d = explode('/', $busca_data_i);
	$busca_data_i = $d[2].'-'.$d[1].'-'.$d[0].' 00:00:00';
	
	$d = explode('/', $busca_data_f);
	$busca_data_f = $d[2].'-'.$d[1].'-'.$d[0].' 23:59:59';
	
	if(strlen($busca_data_i_co) > 0){
		$d = explode('/', $busca_data_i_co);
		$busca_data_i_co = $d[2].'-'.$d[1].'-'.$d[0];
	}
	if(strlen($busca_data_f_co) > 0){
		$d = explode('/', $busca_data_f_co);
		$busca_data_f_co = $d[2].'-'.$d[1].'-'.$d[0];
	}
	
	$ini = ($pagina * $padrao);
	$fim = $padrao;
	
	$dt = new stdClass();
	$dt->busca=$busca; #0
	#$dt->campo=$campo; #1
	$dt->campo = $cnpj;
	$dt->busca_data_i=$busca_data_i; #2
	$dt->busca_data_f=$busca_data_f; #3
	$dt->busca_controle_cliente=$busca_controle_cliente; #4
	$dt->busca_data_i_co=$busca_data_i_co; #5 
	$dt->busca_data_f_co=$busca_data_f_co; #6
	$dt->busca_id_pacote=$busca_id_pacote; #7
	$dt->busca_id_departamento=$busca_id_departamento; #8
	$dt->busca_id_status=$busca_id_status; #9
	$dt->busca_ordenar=$busca_ordenar; #10
	$dt->busca_ord=$busca_ord; #11
	$dt->busca_id_servico=$busca_id_servico; #12
	$dt->busca_id_pedido=$busca_id_pedido; #13
	$dt->busca_ordem=$busca_ordem; #14
	$dt->conveniado_id_cliente=$conveniado_id_cliente; #15
	$dt->ini=$ini; #16
	$dt->fim=$fim; #17
	$ConveniadoDAO = new ConveniadoDAO();
	
	if($p == 0){
		$conveniado= $ConveniadoDAO->BuscaConveniado($dt);
                
	} else {
		$dt = new stdClass();
		$dt->ini=$ini; #16
		$dt->fim=$fim; #17
		$conveniado= $ConveniadoDAO->SessionBuscaConveniado($dt);
	}
	if(count($conveniado) > 0){
		$tb = '';	
		$tb .= '<script language="javascript" type="text/javascript">' . " \n";	
		$tb .= "if(document.getElementById('mensagem')){" . " \n";	
		$tb .= "document.getElementById('mensagem').innerHTML = '';" . " \n";	
		#$tb .= "document.getElementById('mensagem').style.display='none';" . " \n";	
		$tb .= "}" . " \n";	
		//$tb .= "document.getElementById('".$form."').style.display='none';" . " \n";	
		$tb .= "document.getElementById('retorno').style.marginTop='1px';" . " \n";	
		$tb .= "document.getElementById('retorno').style.marginLeft='1px';" . " \n";	
		$tb .= "document.getElementById('retorno').style.width='98%';" . " \n";	
		$tb .= '</script>' . " \n";	
		/*$tb .= '<img src="images/fazer_outra_busca_1.png" ';	
		$tb .= 'onmouseover="this.src=\'images/fazer_outra_busca_0.png\'" ';	
		$tb .= 'onmouseout="this.src=\'images/fazer_outra_busca_1.png\'" ';	
		$tb .= 'onclick="';	
		$tb .= "document.getElementById('".$form."').style.display='block'; ";	
		$tb .= "document.getElementById('pesquisa').style.height='259px'; ";	
		$tb .= "document.getElementById('retorno').style.display='none'; ";	
		$tb .= "document.getElementById('retorno').innerHTML=''; ";	
		$tb .= "document.getElementById('retorno').style.width='70%'; " . " \n";	
		$tb .= 'RetornaErro(\''.$form.'\', \''.$msg_error.'\', 0); ';	
		$tb .= '" ';	
		$tb .= ' style="cursor:pointer; margin-bottom:8px;" /><br />' . " \n";*/
		echo $tb;
		
		$lista = array(
			$ConveniadoDAO->QTDPaginaAjax(),
			$padrao,
			$pagina,
			'carrega_pesquisa.php',
			$form);
		$paginacao = AjaxPaginacao($lista);
		
		$tb = '';	
		$tb .= '<form action="gera_exporta_todos.php" target="_blank" method="post" id="form2" name="form2">';	
		$tb .= '<table width="100%" style="color:#333333; margin-left:10px; margin-top:10px;" border="0" cellspacing="0" cellpadding="2">' . " \n";	
		$tb .= '<tr class="tr1">' . " \n";	
		$tb .= '<td colspan="11" style="height:40px; border:solid 1px #999; border-bottom:none; font-weight:normal">'.$paginacao;	
		$tb .= '<br /><input type="submit" name="exp" id="exp1" value=" Exportar Todos " class="button_busca" style="margin:3px;" />';	
		$tb .= '</td>' . " \n";	
		$tb .= '</tr>' . " \n";	
		$tb .= '<tr class="tr1">' . " \n";	
		$tb .= '<td class="td1" style="width:40px; text-align:center;">N.º</td>';	
		$tb .= '<td class="td1" style="width:90px;">&nbsp;Ordem</td>' . " \n";	
		$tb .= '<td class="td1" style="text-align:center; width:70px;">Data</td>' . " \n";	
		$tb .= '<td class="td1">&nbsp;CPF / CNPJ</td>' . " \n";	
		$tb .= '<td class="td1">&nbsp;Documento de</td>' . " \n";	
		$tb .= '<td class="td1">&nbsp;Serviço</td>' . " \n";	
		$tb .= '<td class="td1">&nbsp;Status</td>' . " \n";	
		$tb .= '<td class="td1">&nbsp;Atividade</td>' . " \n";	
		$tb .= '<td class="td2">Data do Status</td>' . " \n";	
		$tb .= '<td class="td2">Anexo</td>' . " \n";	
		$tb .= '<td class="td3">Todos Anexo</td>' . " \n";	
		$tb .= '</tr>' . " \n";	
		echo $tb;
		
		$AnexoDAO = new AnexoDAO();
		$color = '#FFF';
		$i = 0;
		foreach($conveniado as $c => $conv){
			$certidao_devedor = '<br />&nbsp;';
			if($conv->certidao_devedor <> ''){
				$certidao_devedor = '<br />&nbsp;<b style="font-size:11px;">Devedor: </b>'.ucwords(strtolower($conv->certidao_devedor));
			}	
			$tb = '';
			$tb .= '<tr style="font-weight:normal; background-color:'.$color.'" onmouseover="this.style.backgroundColor=\'#B9D2F9\'" onmouseout="this.style.backgroundColor=\''.$color.'\'">' . " \n";	
			$tb .= '<td class="td4" style="text-align:center">'.(($ini+$i) + 1).'</td>' . " \n";	
			$tb .= '<td class="td4">&nbsp;#'. $conv->id_pedido . '/'. $conv->ordem .'</td>' . " \n";	
			$tb .= '<td class="td4" style="text-align:center;">' . invert($conv->inicio,'/','PHP').'</td>' . " \n";	
			$tb .= '<td class="td4">&nbsp;';
			if($conv->certidao_cnpj != ''){	$tb .= formatarCPF_CNPJ($conv->certidao_cnpj, true); }
			if($conv->certidao_cpf != ''){	$tb .= formatarCPF_CNPJ($conv->certidao_cpf, true); }	
			$tb .= '</td>' . " \n";	
			$tb .= '<td class="td4">&nbsp;';	
			$tb .= ucwords(strtolower($conv->certidao_nome));	
			$tb .= ucwords(strtolower($conv->certidao_matricula));	
			$tb .= $certidao_devedor.'</td>' . " \n";	
			$tb .= '<td class="td4">&nbsp;'.ucwords(strtolower($conv->servico)).'</td>' . " \n";	
			$tb .= '<td class="td4">&nbsp;'.ucwords(strtolower($conv->status)).'</td>' . " \n";	
			$tb .= '<td class="td4"">&nbsp;'.ucwords(strtolower($conv->atividade)).'</td>' . " \n";	
			$tb .= '<td class="td4" style="border-right:none; text-align:center">'.invert($conv->data_atividade,'/','PHP').'</td>' . " \n"; 	
			$anexo = $AnexoDAO->ListaAnexosConveniado(array($conv->id_pedido_item));
			$link1 = '-';
			$link2 = '-';
			if(count($anexo) > 0){
				$link1 = '<a href="download.php?id='.$conv->id_pedido_item.'&id_ser='.$conv->id_servico.'" target="_blank">';
				$link1 .= '<img src="images/botao_print.png" title="Anexo" border="0"/></a>';
				
				$link2 = '<a href="download_anexos.php?id='.$conv->id_pedido_item.'&id_ser='.$conv->id_servico.'" target="_blank">';
				$link2 .= '<img src="images/botao_print.png" title="Anexo" border="0"/></a>';
			}	
				$tb .= '<td class="td4" style="text-align:center;">'.$link1.'</td>' . " \n";	
				$tb .= '<td class="td5">'.$link2.'</td>' . " \n";	
				$tb .= '</tr>' . " \n";
			echo $tb;
			if($color == '#FFF'){ $color = '#E8E8E8'; } else { $color = '#FFF';	}
			$i++;
		}
		$tb = '';
		$tb .= '<tr class="tr1">' . " \n";
		$tb .= '<td colspan="11" style="height:40px; border:solid 1px #999; border-top:none; font-weight:normal">'.$paginacao;
		$tb .= '<br /><input type="submit" name="exp" id="exp2" value=" Exportar Todos " class="button_busca" style="margin:3px;" />';
		$tb .= '</td>' . " \n";
		$tb .= '</tr>' . " \n";
		$tb .= '</table>' . " \n";
		$tb .= '</form>';
		echo $tb;
		echo '<img src="../images/null.gif" style="height:80px;" />';
	} else {
		$tb = '';
		$tb .= '<script type="Javascript">' . " \n";
		$tb .= "document.getElementById('mensagem').innerHTML = 'Nenhum registro encontrado nesta forma de busca.'" . " \n";
		$tb .= '</script>' . " \n";
		$tb .= '<img src="../images/null.gif" onload="RetornaErro(\''.$form.'\', \''.$msg_error.'\', 0);" />' . " \n";
		echo $tb;
	}		
} else {
	echo '<img src="../images/null.gif" onload="RetornaErro(\''.$form.'\', \''.$msg_error.'\', 1);" />' . " \n";
}
echo '<div id="mensagem"></div>';
echo '<script>RetornaErro(\''.$form.'\', \''.$msg_error.'\', 0);</script>';
?>