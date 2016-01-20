<?
ob_start();
header("Content-Type: text/html; charset=iso-8859-1",true);
require("../includes/funcoes.php");
require("../includes/verifica_logado_controle.inc.php");
require("../includes/global.inc.php");

$perm_fin = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_pgto = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_cobr = verifica_permissao('Financeiro Cobran�a', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_sup = verifica_permissao('Supervisor', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    echo '<br><br><strong>Voc� n�o tem permiss�o para acessar essa p�gina</strong>';
    exit;
}
$permissao_admin = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
$id_departamento_p = explode(',', $controle_id_departamento_p);

$franquia = new FranquiasDAO();
$c = new stdClass();
if($_POST){ 
	foreach($_POST as $cp => $valor){ 
		$valor = str_replace('por100tagem','%',$valor);
		$c->$cp = str_replace('**amp**','&',trim($valor)); 
	} 
}
if($_GET){ 
	foreach($_GET as $cp => $valor){ 
		$valor = str_replace('por100tagem','%',$valor);
		$c->$cp = str_replace('**amp**','&',trim($valor)); 
	} 
} 
$c->id_usuario = $controle_id_usuario;

if($c->acao_implementacao == 1){
	if($c->id_implantacao == 7){
		$franquia->faixa_cep($c);
		$c->id_empresa_chk= 0;
		$c->data1      = ($c->ativo == 0) ? '' : date('d').'/'.date('m').'/'.date('Y');
		$c->data2      = ($c->ativo == 0) ? '' : date('d').'/'.date('m').'/'.date('Y');
		$c->observacao = '';
		$franquia->checklist_exec($c);
		echo '<script>carregar_implantacao('.$c->id_implantacao.','.$c->empresa.');</script>';		
		exit;
	}
	
	$c->permissao_admin = $permissao_admin;
	$c->permissao_user = $permissao;

	for($i = 0; $i < $c->totali; $i++){
		$registro   = 'registroi' . $i;
		$ativo      = 'ativo' . $i;
		$observacao = 'observacao' . $i;
		$data1 = 'datai' . $i; 
		$data2 = 'datai' . $i;
		$c->item = '';
		if($c->id_implantacao == 3 || $c->id_implantacao == 5 || $c->id_implantacao == 6 || $c->id_implantacao == 8){		
			$data1 = 'datai1' . $i;
			$data2 = 'datai2' . $i;
		} elseif($c->id_implantacao == 9){
			$item = 'itemi'.$i;
			$c->item = $c->$item;
		}
		$c->id_empresa_chk=$c->$registro;
		$c->ativo      = $c->$ativo;
		$c->data1      = $c->$data1;
		$c->data2      = $c->$data2;
		$c->observacao = $c->$observacao;
		$franquia->checklist_exec($c);
	}

	for($i = 0; $i < $c->totalj; $i++){
		$registro   = 'registroj' . $i;
		$data	    = 'dataj' . $i;
		
		$c->id_empresa_chk= $c->$registro;
		$c->ativo 	   = (strlen($c->$data) == 0) ? 0 : 1;
		$c->data1      = $c->$data;
		$c->data2	   = $c->$data;
		$c->observacao = '';
		$franquia->checklist_exec($c);
	}
	if($c->id_implantacao == 10){
		echo '<script>implantacao_email(2, '.$c->empresa.','.$c->id_usuario.');</script>';
		exit;
	}
	echo '<script>carregar_implantacao('.$c->id_implantacao.','.$c->empresa.');</script>';
} else {
	switch($c->id_implantacao){
		case 1: 
			$pagina = 'implantacao-franquia.php'; $titulo = 'Dados do Franqueado';
			break;
		case 2:
			$pagina = 'inicio-da-implantacao.php'; $titulo = 'Documenta��o';
			break;
		case 3: 
			$pagina = 'envio-do-manual.php'; $titulo = 'Informa��es sobre o ponto';
			break;
		case 5: 
			$pagina = 'envio-de-layout.php'; $titulo = 'Layouts'; 
			break;
		case 6: 
			$pagina = 'abertura-da-empresa.php'; $titulo = 'Abertura da Empresa';
			break;
		case 7: 
			$pagina = 'faixa-de-ceps.php'; $titulo = 'Faixa de CEPs';
			break;
		case 8: 
			$pagina = 'treinamento.php'; $titulo = 'Treinamento';
			break;
		case 9: 
			$pagina = 'checklist-de-inauguracao.php'; $titulo = 'Checklist de Inaugura��o';
			break;
		case 10: 
			$pagina = 'inicio-das-atividades.php'; $titulo = 'In�cio das Atividades';
			break;
		case 11: 
			$pagina = 'inauguracao.php'; $titulo = 'Inaugura��o';
			break;
		case 12: 
			$pagina = 'ficha-dos-correios.php'; $titulo = 'Ficha dos Correios';
			break;
		case 13:
			$pagina = 'contratos.php'; $titulo = 'Contratos';
			break;
		default:
			$pagina = 'cadastro.php'; $titulo = 'Dados da Franquia';
	}
	echo '<script>document.getElementById(\'errors\').style.display = \'none\';</script>
		<table style="width:690px;border:0" class="tabela">
		<tr>
			<td class="tabela_tit">'.$titulo.'</td>
		</tr>
		<tr>
			<td id="td_implantacao">
				<div id="alterar"></div>';
	include($pagina);
	echo '</td>
		</tr>
	</table>'; 
} ?>