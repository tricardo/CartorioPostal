<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_safpostal.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require( '../includes/browser.php' );

$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

$dt  = new ListaInteressadosDAO();
$dt1 = new StatusDAO();

pt_register('GET','acao');
pt_register('GET','id_status');
pt_register('GET','pagina');
pt_register('GET','uf');
pt_register('GET','cidade');
pt_register('GET','id_status');
pt_register('GET','total_registro');
pt_register('GET','nome');
pt_register('GET','data1');
pt_register('GET','data2');
pt_register('GET','usuario');

$ini = 0;
if($pagina > 1){
	$ini = (($pagina * $total_registro) - $total_registro);
}

if($data1){
	$d = explode('/',$data1);
	$d1 = $d[2].'-'.$d[1].'-'.$d[0]; 
	$d = explode('/',$data2);
	$d2 = $d[2].'-'.$d[1].'-'.$d[0]; 
	$e = $dt->listaInteressadosDataReuniao($acao, $id_status, $ini, $total_registro, $uf, $cidade, $nome, $d1, $d2, $usuario);
} else {
	$e = $dt->listaInteressados($acao, $id_status, $ini, $total_registro, $uf, $cidade, $id_status, $nome, $usuario);
}

$total = count($e);
$tot_pag = 8;

if($total == 0){
	echo '<div style="color:#FF0000; width:765px; margin-top:40px; margin-bottom:40px; ';
	echo 'text-align:center; float:left">Nenhum registro encontrado com esta forma de busca.</div>' . "\n";
} else {
	if($acao != 1){
		$tabela .= '<div style="margin-bottom:10px;">Clique na linha para visualizar o pedido.</div>';
	}
	$tabela .= '<table width="765" border="0" cellspacing="1" cellpadding="0" ';
	$tabela .= 'style="border:solid 1px #0071B6; color:#333333">' . "\n";
	$cor = '#FFF';
  	$i = 0;
	switch($acao){
		case 1:
			$colspan = 7;
			$tabela .= '<tr style="font-weight:bold; font-size:9px; text-transform:uppercase; background-color:#CEEDFF">' . "\n";
			$tabela .= '<td width="30" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;"></td>' . "\n";
			$tabela .= '<td width="157" height="25" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">&nbsp;Nome</td>' . "\n";
			$tabela .= '<td style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">&nbsp;Email</td>' . "\n";
			$tabela .= '<td width="95" align="center" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">Telefone</td>' . "\n";
			$tabela .= '<td align="center" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">&nbsp;UF&nbsp;</td>' . "\n";
			$tabela .= '<td width="150" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">&nbsp;Cidade</td>' . "\n";
			$tabela .= '<td width="65" align="center" style="border-bottom:solid 2px #0071B6; border-right:none">Data</td>' . "\n";
			$tabela .= '</tr>' . "\n";
			foreach($e as $j => $arr){
				$tabela .= '<tr style="font-size:9px; text-transform:uppercase; cursor:pointer; background-color:'.$cor.'" ';
				$tabela .= 'onmouseover="this.style.backgroundColor=\'#FFCC66\'" ';
				$tabela .= 'onmouseout="this.style.backgroundColor=\''.$cor.'\'" ';
				$tabela .= "onclick=\"CheckDirecionamento('id_ficha".$i."')\">" . "\n";
				$tabela .= '<td style="border-bottom:solid 1px #0071B6; ';
				$tabela .= 'border-right:solid 1px #0071B6; border-left:none;" ';
				$tabela .= "onclick=\"CheckDirecionamento('id_ficha".$i."')\" ";
				$tabela .= 'align="center"><input type="checkbox" class="form_estilo" ';
				$tabela .= 'value="'.$arr->id_ficha.'" id="id_ficha'.$i.'" name="id_ficha" /></td>' . "\n";
				$tabela .= '<td height="24" style="border-bottom:solid 1px #0071B6; ';
				$tabela .= 'border-right:solid 1px #0071B6; border-left:none;">&nbsp;'.trim(substr($arr->nome, 0, 20)). '</td>' . "\n";
				$tabela .= '<td height="24" style="border-bottom:solid 1px #0071B6; ';
				$tabela .= 'border-right:solid 1px #0071B6; border-left:none; text-transform:lowercase;">&nbsp;'.$arr->email. '</td>' . "\n";
				$tabela .= '<td height="24" style="border-bottom:solid 1px #0071B6; ';
				$tabela .= 'border-right:solid 1px #0071B6; border-left:none;" align="center">'.$arr->tel_res. '</td>' . "\n";
				$tabela .= '<td height="24" style="border-bottom:solid 1px #0071B6; ';
				$tabela .= 'border-right:solid 1px #0071B6; border-left:none;" align="center">'.$arr->estado_interesse. '</td>' . "\n";
				$tabela .= '<td height="24" style="border-bottom:solid 1px #0071B6; ';
				$tabela .= 'border-right:solid 1px #0071B6; border-left:none;">&nbsp;'.trim(substr($arr->cidade_interesse, 0, 20)). '</td>' . "\n";
				$data = explode('-', $arr->data);
				$tabela .= '<td height="24" style="border-bottom:solid 1px #0071B6; ';
				$tabela .= 'border-right:solid 1px #0071B6; border-left:none;" align="center">&nbsp;'.$data[2].'/'.$data[1].'/'.$data[0]. '&nbsp;</td>' . "\n";
				$teste = ($cor == '#FFF') ? $cor = '#EAF8FF' : $cor = '#FFF'; 
				$i++;
			}
		break;
		
		case 2:	
		case 3:
			$colspan = 10;
			$tabela .= '<tr style="font-weight:bold; font-size:8px; text-transform:uppercase; background-color:#CEEDFF">' . "\n";
			$tabela .= '<td width="157" height="25" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">&nbsp;Nome</td>' . "\n";
			$tabela .= '<td style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">&nbsp;Email</td>' . "\n";
			$tabela .= '<td width="95" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">&nbsp;Consultor</td>' . "\n";
			$tabela .= '<td align="center" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">Telefone</td>' . "\n";
			$tabela .= '<td align="center" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">&nbsp;UF&nbsp;</td>' . "\n";
			$tabela .= '<td style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">&nbsp;Cidade</td>' . "\n";
			if($acao == 2){
				$tabela .= '<td width="65" align="center" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">Data</td>' . "\n";
				if($data1){
					$tabela .= '<td align="center" style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">Data Reunião</td>' . "\n";
				} else {
					$tabela .= '<td  style="border-bottom:solid 2px #0071B6; border-right:solid 1px #0071B6;">&nbsp;Status</td>' . "\n";
				}

			} else {
				$tabela .= '<td width="65" align="center" style="border-bottom:solid 2px #0071B6; border-right:none">Data</td>' . "\n";
			}
			$tabela .= '<td style="border-bottom:solid 2px #0071B6;" width="25"></td>';
			$tabela .= '</tr>' . "\n";
			foreach($e as $j => $arr){
				$tabela .= '<tr style="font-size:9px; cursor:pointer; text-transform:uppercase; background-color:'.$cor.'" ';
				$tabela .= 'onmouseover="this.style.backgroundColor=\'#FFCC66\'" ';
				if($acao != 1){ $tabela .= 'title="Clique na linha para visualizar pedido." '; }
				$tabela .= 'onmouseout="this.style.backgroundColor=\''.$cor.'\'">' . "\n";
				$tabela .= '<td height="24" style="border-bottom:solid 1px #0071B6; border-right:solid 1px #0071B6; border-left:none;"';
				$tabela .= ' onclick="javascript:location.href=\'interessados_edit.php?id='.$arr->id_ficha.'\'">&nbsp;'.trim(substr($arr->nome, 0, 20)). '</td>' . "\n";
				$tabela .= '<td style="border-bottom:solid 1px #0071B6; border-right:solid 1px #0071B6; border-left:none; text-transform:lowercase;"';
				$tabela .= ' onclick="javascript:location.href=\'interessados_edit.php?id='.$arr->id_ficha.'\'">&nbsp;'.$arr->email. '</td>' . "\n";
				$sql= "SELECT * FROM vsites_user_usuario as uu WHERE id_usuario=".$arr->id_usuario;
				$dt2 = $objQuery->SQLQuery($sql);
				$res = mysql_fetch_array($dt2);
				$tabela .= '<td style="border-bottom:solid 1px #0071B6; border-right:solid 1px #0071B6; border-left:none;"';
				$tabela .= ' onclick="javascript:location.href=\'interessados_edit.php?id='.$arr->id_ficha.'\'">'.$res['nome'].'</td>' . "\n";
				$tabela .= '<td style="border-bottom:solid 1px #0071B6; border-right:solid 1px #0071B6; border-left:none;" align="center"';
				$tabela .= 'onclick="javascript:location.href=\'interessados_edit.php?id='.$arr->id_ficha.'\'">'.$arr->tel_res. '</td>' . "\n";
				$tabela .= '<td style="border-bottom:solid 1px #0071B6; border-right:solid 1px #0071B6; border-left:none;" align="center"';
				$tabela .= 'onclick="javascript:location.href=\'interessados_edit.php?id='.$arr->id_ficha.'\'">'.$arr->estado_interesse. '</td>' . "\n";
				$tabela .= '<td style="border-bottom:solid 1px #0071B6; border-right:solid 1px #0071B6; border-left:none;"';
				$tabela .= 'onclick="javascript:location.href=\'interessados_edit.php?id='.$arr->id_ficha.'\'">&nbsp;'.trim(substr($arr->cidade_interesse, 0, 20)). '</td>' . "\n";
				if($acao == 2){
					$data = explode('-', $arr->data);
					$tabela .= '<td align="center" style="border-bottom:solid 1px #0071B6; border-right:solid 1px #0071B6; border-left:none;"';
					$tabela .= 'onclick="javascript:location.href=\'interessados_edit.php?id='.$arr->id_ficha.'\'">&nbsp;'.$data[2].'/'.$data[1].'/'.$data[0]. '&nbsp;</td>' . "\n";
					if($data1){
						if($arr->data_reuniao){
							$data = explode('-', $arr->data_reuniao);
							$d = $data[2].'/'.$data[1].'/'.$data[0];
						} else {
							$d = '';
						}
						$tabela .= '<td style="border-bottom:solid 1px #0071B6; border-left:none; border-right:solid 1px #0071B6;"';
						$tabela .= ' onclick="javascript:location.href=\'interessados_edit.php?id='.$arr->id_ficha.'\'" align="center">&nbsp;'.$d.'&nbsp;</td>' . "\n";
					} else {
						$tabela .= '<td style="border-bottom:solid 1px #0071B6; border-left:none; border-right:solid 1px #0071B6;"';
						$tabela .= ' onclick="javascript:location.href=\'interessados_edit.php?id='.$arr->id_ficha.'\'">&nbsp;'.trim(substr($arr->status, 0, 20)). '</td>' . "\n";
					}
				} else {
					$data = explode('-', $arr->data);
					$tabela .= '<td style="border-bottom:solid 1px #0071B6; border-left:solid 1px #0071B6;" align="center"';
					$tabela .= 'onclick="javascript:location.href=\'interessados_edit.php?id='.$arr->id_ficha.'\'">&nbsp;'.$data[2].'/'.$data[1].'/'.$data[0]. '&nbsp;</td>' . "\n";
				}
				$tabela .= '<td style="border-bottom:solid 1px #0071B6; text-align:center"><a href="imprimir_ficha.php?id='.$arr->id_ficha.'" target="_blank"><img src="http://www.cartoriopostal.com.br/saf/images/estrutura/botoes/imprimir.png" style="width:15px; height:15px; border:none" /></a></td>';
				$tabela .= '</tr>' . "\n";
				$teste = ($cor == '#FFF') ? $cor = '#EAF8FF' : $cor = '#FFF'; 
			}
			
		break;
	}
	if($data1){
		$e = $dt->somaListaInteressadosDataReuniao($acao, $id_status, $uf, $cidade, $nome, $d1, $d2, $usuario);
	} else {
		$e = $dt->somaListaInteressados($acao, $id_status, $uf, $cidade, $id_status, $nome, $usuario);
	}
	if(fmod($e->total, $total_registro) == 0){
		$total_pagina = (int) $e->total/$total_registro;
	} else {
		$tot  = explode('.', $e->total/$total_registro);
		$total_pagina= ((int) $tot[0]) + 1;
	}
	$tabela .= '<tr>' . "\n";
	$tabela .= '<td colspan="'.$colspan.'" height="35" align="center" valign="middle" style=" background-color:#0071B6; color:#FFFFFF;">';
	if($total_pagina == 1){
		if($e->total > 1){
			$tabela .= 'Foram encontrados <span style="text-decoration:underline; font-weight:bold">'.$e->total.'</span> registros.<br />' . "\n";
		} else {
			$tabela .= 'Foi encontrado <span style="text-decoration:underline; font-weight:bold">01</span> registro.<br />' . "\n";
		}
	} else {
		if($pagina < 10){ $pagina = '0'.$pagina; }
			$tabela .= '<p style="margin:0; margin-bottom:5px; margin-top:5px;">';
			$tabela .= 'Foram encontrado(s) <span style="text-decoration:underline; font-weight:bold">';
			$tabela .= $e->total.'</span> registros.<br />' . "\n";
			
			if($total_pagina < 10){ 
				$tabela .= 'Exibindo página '.$pagina.' de 0'.$total_pagina.'.<br />' . "\n";
			} else {
				$tabela .= 'Exibindo página '.$pagina.' de '.$total_pagina.'.<br />' . "\n";
			}
			
			if($pagina < $tot_pag){
				$ini = 1;
				$fim = $tot_pag;
			} else {
				$ini = $pagina - ($tot_pag - 1);
				$fim = $pagina + ($tot_pag - 1);
			}
			
			if($pagina > 10){
				$tabela .= "<a style=\"color:#FFF; font-weight:bold\" href=\"#Página 1\" onclick=\"paginarInteressados(";
				$tabela .= $acao. ", 1, '".$uf."', '".$cidade."', '".$id_status."', ".$total_registro.",'".$nome."')";
				$tabela .= '"><< primeira</a>&nbsp;&nbsp;' . "\n";
			}
			
			if($pagina > 1){
				$tabela .= "<a style=\"color:#FFF;font-weight:bold\" href=\"#Página ".($pagina - 1)."\" onclick=\"paginarInteressados(";
				$tabela .= $acao.", ".($pagina - 1).", '".$uf."', '".$cidade."', '".$id_status."', ".$total_registro.",'".$nome."')";
				$tabela .= '">< anterior</a>&nbsp;' . "\n";
			}
			
			$tabela .= '| ';
			
			for($i = $ini; $i <= $fim; $i++){
				$numero = $i;
				if($i < 10){
					$numero = '0'.$i;
				}
				if($i <= $total_pagina){
					if($i == $pagina){
						$tabela .= ' <span style="font-weight:bold; background-color:#FFF; color:#000">'.$numero.'</span>&nbsp; ' . "\n";
					} else {
						$tabela .= "<a style=\"color:#FFF\" href=\"#Página ".$i."\" onclick=\"paginarInteressados(".$acao.", ".$i.", '".$uf."', '".$cidade."', '".$id_status."', ".$total_registro.",'".$nome."')\">".$numero."</a>&nbsp; \n";
					}
				}
			}
			
			$tabela .= '| ';
			
			if($pagina < $total_pagina){
				$tabela .= "<a style=\"color:#FFF; font-weight:bold\" href=\"#Página ".($pagina + 1)."\" onclick=\"paginarInteressados(".$acao.", ".($pagina + 1).", '".$uf."', '".$cidade."', '".$id_status."', ".$total_registro.",'".$nome."')\">próxima ></a> \n";
			}
			
			if($pagina > $tot_pag && $pagina < ($total_pagina - $tot_pag)){
				$tabela .= "&nbsp;&nbsp;<a style=\"color:#FFF; font-weight:bold\" href=\"#Página ".$total_pagina."\" onclick=\"paginarInteressados(".$acao.", ".$total_pagina.", '".$uf."', '".$cidade."', '".$id_status."', ".$total_registro.",'".$nome."')\">última >></a> \n";
			}
			$tabela .= '</p>';
			
			
		
	}
	$tabela .= '</td>' . "\n";
	$tabela .= '</tr>' . "\n";
	$tabela .=  '</table>' . "\n";
	echo $tabela;
}?>