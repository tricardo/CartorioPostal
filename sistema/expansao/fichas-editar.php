<? require('topo.php'); ?>
<form id="form1" name="form1" method="post" action="fichas-editar.php" enctype="multipart/form-data">
<script>parent.document.getElementById('titulo_pagina').innerHTML = 'Fichas - #ID <?=$c->id_ficha?>';</script>
<div id="meio">
	<div style="margin:0 auto;margin-top:-80px;width:800px">
		<div id="container-hotsite" style="text-align:center;">
			<ul>
				<li><a href="#" onclick="ficha_form_edita(0);document.getElementById('erros_exibir').style.display='none';parent.document.getElementById('expansao_frame').style.height='1350px'" style="cursor:pointer">Cadastro</a></li>
				<li><a href="#" onclick="ficha_form_edita(1);document.getElementById('erros_exibir').style.display='none';parent.document.getElementById('expansao_frame').style.height='1450px'">Empresarial</a></li>
				<li><a href="#" onclick="ficha_form_edita(2);document.getElementById('erros_exibir').style.display='none';parent.document.getElementById('expansao_frame').style.height='1050px'">Bancário</a></li>
				<li><a href="#" onclick="ficha_form_edita(3);document.getElementById('erros_exibir').style.display='none';parent.document.getElementById('expansao_frame').style.height='700px'">Histórico</a></li>
				<li><a href="#" onclick="ficha_form_edita(4);document.getElementById('erros_exibir').style.display='none';parent.document.getElementById('expansao_frame').style.height='1000px'">Jurídico</a></li>
			</ul>
			<a href="<?=$voltar?>" style="float:right;margin-top:-25px;font-weight:bold">Voltar</a>
		</div>
		<table style="width:800px">
			<tr>
				<td class="erro" style="display:none" id="erros_exibir"></td>
			</tr>
		</table>
		<? 
		if(isset($c->excluir_arquivo)){
			if(!(is_nan($c->id_arquivo))){
				$expansao->excluiAnexo($c);
			}
		}
		
		if(isset($c->finaliza_processo)){
			if($c->finaliza_processo == 1){
				$dt = $expansao->verDadosAdm($c->id_ficha);
				if($dt[0] > 0){
					$expansao->email_finalizar($c);
				} else {
					$erro_finaliza_processo = 1;
				}
			}
		}
		
		if(isset($c->acao_btn)){		
			if($c->executar_alteracoes == 1){
				switch($c->acao_btn){
					case  'cadastro': $c->aba = 0; break;
					case 'empresarial': 
						$c->aba = 1; 
						$a = $expansao->table_empresarial(2, $c);				
						break;
					case 'bancario':
						$c->aba = 2;
						$a = $expansao->table_bancario(2, $c);
						if($a != ''){
							foreach($a as $nome => $b){ $c->$nome = $b; }
						}
						break;
					case 'historico':
						$c->aba = 3;
						$a = $expansao->historico($c);
						if($a[0] == 1){
							$c->erro_js = $a[1];
						} else {
							foreach($a[1] as $nome => $b){ $c->$nome = $b; }
						}
						break;
					case 'juridico':						
						$c->aba = 4;
						$a = $expansao->cadDadosAdm($c,$_FILES);
						if($a[0] == 1){
							$c->erro_js = $a[1];
						} else {
							if($a[1] != ''){
								foreach($a[1] as $nome => $b){ $c->$nome = $b; }
							}
						}
						break;
					default:
						if(isset($c->aba)){
							$c->aba = $c->aba;
						} else {
							$c->aba = 0;
						}
				}
				$acao = ($c->acao_btn == 'cadastro') ? 2 : 1;
				$a = $expansao->table_cadastro($acao, $c); 
				foreach($a as $nome => $b){ $c->$nome = $b; }
			} else {
				$a = $expansao->carrega_todos_forms($c);
				foreach($a as $nome => $b){ $c->$nome = $b; }
				$a = $expansao->buscaDadosAdinistrativo(1,$c);
				foreach($a as $nome => $b){ $c->$nome = $b; }
			}
		} else {
			if(isset($c->aba)){
				$c->aba = $c->aba;
			} else {
				$c->aba = 0;
			}
			$acao = ($c->acao_btn == 'cadastro') ? 2 : 1;
			$a = $expansao->carrega_todos_forms($c);
			#$a = $expansao->table_cadastro($acao, $c); 
			foreach($a as $nome => $b){ $c->$nome = $b; }
			$a = $expansao->buscaDadosAdinistrativo(1,$c);
			if($a != ''){
				foreach($a as $nome => $b){ $c->$nome = $b; }
			}
		}
		switch($c->id_status){
			case 14: case 18:
				$executar_alteracoes = 0;
				break;
			#case 16:
			#	$executar_alteracoes = ($c->c_id_usuario == 1) ? 1 : 0;
			#	break;
			default: $executar_alteracoes = 1;
		}
		
		echo '<input type="hidden" name="executar_alteracoes" id="executar_alteracoes" value="'.$executar_alteracoes.'" />';
		
		function criarBotao($executar_alteracoes, $status, $aba){
			if($executar_alteracoes == 1){
				$botao = '<input name="btn" id="btn" value="Atualizar" class="button_busca" type="button" onclick="submit_expansao_edit(\''.$aba.'\')" />';
			} else {
				$expansao = new ExpansaoDAO();
				$status = $expansao->buscarStatus($status);
				$botao = '<span style="color:#FF0000;">Este pedido não pode ser mais alterado porque seu status esta como '.$status.'</span>';
			}
			echo $botao;
		}
		
		switch($c->aba){
			case 0: $height = 1350; break;
			case 1: $height = 1450; break;
			case 2: $height = 1050; break;
			case 3: $height = 700; break;
			case 4: $height = 400; break;
		}
		echo "<script>parent.document.getElementById('expansao_frame').style.height='".$height."px'</script>";
		include('fichas-editar-table-cadastro.php');
		include('fichas-editar-table-empresarial.php');		
		include('fichas-editar-table-financeiro.php');
		include('fichas-editar-table-historico.php');
		include('fichas-editar-table-juridico.php'); ?>
	</div>
</div>
<? echo '<input type="hidden" name="acao_btn" id="acao_btn" />'."\n";
echo '<input type="hidden" name="aba" id="aba" value="'.$c->aba.'" />'."\n";
echo '<input type="hidden" name="id_ficha" id="id_ficha" value="'.$c->id_ficha.'" />'."\n";
echo "<script>\n";
if(isset($c->erro_js)){ echo $c->erro_js; }
echo "\tficha_form_edita('".$c->aba."');\n";
echo "</script><br />"; ?>
</form>
<? require('rodape.php'); ?>