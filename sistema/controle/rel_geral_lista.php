<? require('header.php');?>
<div id="topo"><?
pt_register('GET','relatorio');

if(verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
	&& verifica_permissao('Rel_comercial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
	&& verifica_permissao('Supervisor Atendimento',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
	&& verifica_permissao('Supervisor Financeiro',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' 
	){
	if($relatorio=='royalties'){
		if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE'){
			echo '<br><br><strong>Você não tem permissão para acessar essa página de royalties</strong>';
			exit;
		}
	}else{
		echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
		exit;
	}
}
pt_register('GET','mes');
pt_register('GET','ano');
pt_register('GET','id_empresa');
pt_register('GET','pagina');

switch($relatorio){
	case 'geral':
		$relatorio = 'relatório geral';
		$desc = 'Geral';
		break;
	case 'pendente':
		$relatorio = 'em pendente';
		$desc = 'Pendente';
		break;
	case 'cancelados':
		$relatorio = 'relatório de cancelados';
		$desc = 'Cancelados';
		break;
	default:
		$desc = $relatorio;
}

$id_empresa=($controle_id_empresa!=1)?$controle_id_empresa:$id_empresa;

$relatorioDAO = new RelatorioDAO();
$relatorios = $relatorioDAO->busca($id_empresa,$mes,$ano,$relatorio,$pagina);
if($_SESSION['monitoramento_id_usuario'] == 1){
	print_r($relatorios);
	#exit;
}
?>
<h1 class="tit"><img src="../images/tit/tit_rel.png" alt="Título" />
Relatório <?php echo $desc ?></h1>
<hr class="tit" />
<a href="#" onclick="javascript:history.back();">voltar</a> <br />
</div>
<div id="meio">
<table class="result_tabela" width="100%">
	<tbody>
		<tr>
			<td><? echo $relatorioDAO->QTDPagina(); ?></td>
		</tr>
		<tr>
			<td class="result_menu"><b>arquivo</b></td>
			<td class="result_menu"><b>data</b></td>
			<td class="result_menu"><b>franquia</b></td>
			<? if($relatorio=='royalties') echo '<td align="center" width="80" class="result_menu"><b>Abrir Boleto</b></td>' ?>
			<td align="center" width="80" class="result_menu"><b>Baixar</b></td>
		</tr>
		<?
		$p_valor='';
		foreach($relatorios as $i=>$r){
			//			if(is_file($r->arquivo))
			$p_valor.='<tr>
				<td class="result_celula">'.$r->descricao.'</td>
				<td class="result_celula">'.invert($r->data_relatorio,'/','XP').'</td>
				<td class="result_celula">'.$r->empresa.'</td>';
			if($relatorio=='royalties') 
				$p_valor .='
					<td align="center" class="result_celula">
						<a href="rel_baixar_boleto.php?id='.$r->id_relatorio.'" target="_blank">
						<img border="0" title="Baixar" src="../images/botao_editar.png">
						</a>
					</td>
				';
			
			$p_valor .='
				<td align="center" class="result_celula">
					<a href="rel_baixar.php?id_relatorio='.$r->id_relatorio.'">
					<img border="0" title="Baixar" src="../images/botao_editar.png">
					</a>
				</td>
			</tr>';
		} echo $p_valor;?>
		<tr>
			<td><? echo $relatorioDAO->QTDPagina(); ?></td>
		</tr>
	</tbody>
</table>
</div>
		<? require('footer.php'); ?>