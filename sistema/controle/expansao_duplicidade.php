<?php require('header.php'); 
$permissao = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
} ?>
<div id="topo">
	<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />Expansão de Franquia - Duplicidade</h1>
	<a href="#" class="topo">topo</a>
	<hr class="tit" />
</div>
<div id="meio">
	<? if($controle_id_usuario == 1 || $controle_id_usuario == 56 or $controle_id_usuario == 2360){
		$ficha  = new ExpansaoFichaDAO();
		$c      = new stdClass();
		if($_POST){ 
			foreach($_POST as $cp => $valor){ $c->$cp = $valor; } 
			if(isset($c->duplicidades)){
				if(substr_count($c->duplicidades,';') > 0){
					$dups = explode(';', $c->duplicidades);
					for($i = 0; $i < count($dups); $i++){
						if($dups[$i] != ''){
							$dt = $ficha->duplicidade(3,$dups[$i],$controle_id_usuario,''); 
						}
					}
				}
			}
		}
		$total = $ficha->duplicidade(4,0,0,'');
		$total = $total[0]->total;
		$div = 500;
		$pagina = (($total % $div) == 0) ? ($total / $div) : ((int)($total / $div) + 1);

		echo '<form id="form1" name="form1" action="" method="post">'. "\n";
		echo '<table width="100%" border="0" cellspacing="2" cellpadding="0" style="float:left; color:#333; font-size: 11px; 
			padding-top:10px; padding-bottom:10px;">'."\n";
		echo '<tr>' . "\n";
		$c->pagina = (isset($c->pagina)) ? $c->pagina : 1;
		echo '<td colspan="9">
				<strong>Total de Fichas cadastradas no sistema: '.$total.'</strong><br />
				<Strong>Página '.$c->pagina.' de '.$pagina.'<br />
				Ir para página:</strong>';?>
		<select name="pagina" onchange="this.form.submit();">
			<?for($i = 1; $i <= $pagina; $i++){?>
			<option value="<?=$i?>"<?=($i == $c->pagina)?' selected="selected"':''?>><?=$i?></option>
			<?}?>
		</select>
		<?
		
		echo '</td>'."\n";
		echo '</tr>' . "\n";
		echo '<tr>' . "\n";
		echo '<td colspan="9">
		Os campos selecionados serão considerados duplicidades e serão varridos do sistema.
			<input type="button" class="button_busca" value="Duplicidade" onclick="excluir_duplicidades()" />
			<input type="hidden" id="duplicidades" name="duplicidades" /><br />&nbsp;
			</td>'."\n";
		echo '</tr>' . "\n";?>
		<tr style="background-color:#EAF8FF;font-weight:bold">
			<td style="width:20px"></td>
			<td>&nbsp;ID</td>
			<td>&nbsp;Nome</td>
			<td>&nbsp;E-mail</td>
			<td>&nbsp;Cidade</td>
			<td>&nbsp;UF</td>
			<td>&nbsp;Consultor</td>
			<td>&nbsp;Data</td>
			<td>&nbsp;Status</td>
		</tr>		
		<?$dt = $ficha->duplicidade(1,0,0,$c->pagina); 
		foreach($dt as $resultado => $e){
			$dt1 = $ficha->duplicidade(2,$e->id_ficha,0,$e->email);
			if(count($dt1) > 0){
			$color = ($color == '#FFF') ? '#EAF8FF' : '#FFF'; 
			$data = explode('-',$e->data);
			$data = $data[2].'/'.$data[1].'/'.$data[0];
			$dt2 = $objQuery->SQLQuery("SELECT * FROM vsites_user_usuario as uu WHERE  
				uu.id_empresa=".$controle_id_empresa." and uu.id_usuario = ".ucwords(strtolower($e->id_usuario))."");
				$usuario = '';
			while($res = mysql_fetch_array($dt2)){ 
				$usuario = $res['nome'];
			}
			$usuario = (strlen($usuario) > 0) ? $usuario : '<span style="color:#FF0000;font-size:10px;">Ninguém</span>';?>
			<tr style="background-color:<?=$color?>">
				<td style="text-align:center"><input type="checkbox" name="dups" value="<?=$e->id_ficha?>" /></td>
				<td>&nbsp;<?=$e->id_ficha?></td>
				<td>&nbsp;<?=strtoupper(strtolower($e->nome))?></td>
				<td>&nbsp;<?=strtolower($e->email)?></td>
				<td>&nbsp;<?=strtoupper(strtolower($e->cidade_interesse))?></td>
				<td>&nbsp;<?=strtoupper($e->estado_interesse)?></td>
				<td>&nbsp;<?=strtoupper($usuario)?></td>
				<td>&nbsp;<?=$data?></td>
				<td>&nbsp;<?=strtoupper($e->status)?></td>
			</tr>
			<?foreach($dt1 as $resultado1 => $e1){
				$data = explode('-',$e1->data);
				$data = $data[2].'/'.$data[1].'/'.$data[0];
				$dt2 = $objQuery->SQLQuery("SELECT * FROM vsites_user_usuario as uu WHERE  
					uu.id_empresa=".$controle_id_empresa." and uu.id_usuario = ".ucwords(strtolower($e1->id_usuario))."");
					$usuario = '';
				while($res = mysql_fetch_array($dt2)){ 
					$usuario = $res['nome'];
				}
				$usuario = (strlen($usuario) > 0) ? $usuario : '<span style="color:#FF0000;font-size:10px;">Ninguém</span>';?>
				<tr style="background-color:<?=$color?>">
				<td style="text-align:center"><?if(trim($e1->status) != 'Finalizado'){?><input 
					type="checkbox" name="dups" value="<?=$e1->id_ficha?>" /><?}?></td>
				<td>&nbsp;<?=$e1->id_ficha?></td>
				<td>&nbsp;<?=strtoupper(strtolower($e1->nome))?></td>
				<td>&nbsp;<?=strtolower($e1->email)?></td>
				<td>&nbsp;<?=strtoupper(strtolower($e1->cidade_interesse))?></td>
				<td>&nbsp;<?=strtoupper($e1->estado_interesse)?></td>
				<td>&nbsp;<?=strtoupper($usuario)?></td>
				<td>&nbsp;<?=$data?></td>
				<td>&nbsp;<?=strtoupper($e1->status)?></td>
			</tr>
			<?}?>
			<tr>
				<td colspan="9" style="height:2px;background-color:#333;"></td>
			</tr>
			<?}
		} 
		echo '<tr>' . "\n";
		echo '<td colspan="9" style="padding-top:10px;">
		Os campos selecionados serão considerados duplicidades e serão varridos do sistema.
			<input type="button" class="button_busca" value="Duplicidade" onclick="excluir_duplicidades()" />
			<br />&nbsp;</td>'."\n";
		echo '</tr>' . "\n";
		echo '</table>'."\n";
		echo '</form>' ."\n";
	} else { echo '<span style="color:#FF0000">Você não tem permissão para visualizar esta página.</span>'; }?>
</div>
<? require "footer.php"; ?>