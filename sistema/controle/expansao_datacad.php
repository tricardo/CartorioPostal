<?php require('header.php'); 
$permissao = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
} ?>
<div id="topo">
	<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />Expansão de Franquia - Data de Cadastro</h1>
	<a href="#" class="topo">topo</a>
	<hr class="tit" />
</div>
<div id="meio">
	<? if($controle_id_usuario == 1 || $controle_id_usuario == 56 or $controle_id_usuario == 2360){ ?>
		<form id="form1" name="form1" action="" method="post">
		<table width="80%" border="0" cellspacing="2" cellpadding="0" style="float:left; color:#333; font-size: 11px; 
			padding-top:10px; padding-bottom:10px;">
			<?if($_POST){ 
				$c = new stdClass(); foreach($_POST as $cp => $valor){ $c->$cp = $valor; }
				$ficha  = new ExpansaoFichaDAO();	
				if(isset($c->id_registro) && isset($c->id_datacad)){
					if($c->id_registro != '' && $c->id_datacad != ''){
						$data = explode('/',$c->id_datacad);
						if(checkdate($data[1], $data[0], $data[2])){
							$dt = $ficha->data_cad(2,$c->id_registro,$controle_id_usuario,$data[2].'-'.$data[1].'-'.$data[0]);
							echo "<script>alert('A data da ficha ".$c->id_registro." foi alterado para ".$c->id_datacad." com sucesso!');</script>";
						}
					}
				}
			} ?>
			<tr>
				<td colspan="8" style="height:60px; vertical-align:top">Buscar por número de ficha:<br />
				<input type="text" name="id_ficha" id="id_ficha" class="form_estilo" maxlength="10" value="<?=$c->id_ficha?>" />
				<input type="submit" class="button_busca" value="buscar" /></td>
			</tr>
			<? if(isset($c->id_ficha)){ 
				$dt = $ficha->data_cad(1,$c->id_ficha,0,''); $i = 0;
				foreach($dt as $resultado => $e){ ?>
				<tr style="background-color:#CCC">
				<td style="text-align:center;font-weight:bold;border:dotted 1px #222">Ficha</td>
				<td style="text-align:center;font-weight:bold;border:dotted 1px #222">Status</td>
				<td style="font-weight:bold;border:dotted 1px #222">&nbsp;&nbsp;Consultor</td>
				<td style="font-weight:bold;border:dotted 1px #222">&nbsp;&nbsp;Nome</td>
				<td style="font-weight:bold;border:dotted 1px #222">&nbsp;&nbsp;E-mail</td>
				<td style="font-weight:bold;border:dotted 1px #222">&nbsp;&nbsp;Cidade / UF</td>
				<td style="text-align:center;font-weight:bold;border:dotted 1px #222">Data Cadastro</td>
				<td style="text-align:center;font-weight:bold;border:dotted 1px #222">Nova Data</td>
				</tr>
				<tr style="background-color:#EAF8FF;">			
					<td style="font-size:11px;padding-top:8px;padding-bottom:8px;text-align:center"><?=$e->id_ficha?></td>
					<td style="font-size:11px;text-align:center"><?=ucwords($e->status)?></td>
					<td style="font-size:11px;">&nbsp;&nbsp;<?
					$dt = $objQuery->SQLQuery("SELECT * FROM vsites_user_usuario as uu WHERE  
						uu.id_empresa=".$controle_id_empresa." and uu.id_usuario = ".$e->id_usuario."");
						$usuario = 'Ninguém';
					while($res = mysql_fetch_array($dt)){ 
						$usuario = $res['nome'];
					} echo ucwords($usuario); ?></td>
					<td style="font-size:11px;">&nbsp;&nbsp;<?=ucwords($e->nome)?></td>
					<td style="font-size:11px;">&nbsp;&nbsp;<?=strtolower($e->email)?></td> 
					<td style="font-size:11px;">&nbsp;&nbsp;<?=ucwords($e->cidade_interesse) .' / '. strtoupper($e->estado_interesse)?></td> 
					<td style="font-size:11px;text-align:center"><?
					$data = explode('-',$e->data);
					echo $data[2].'/'.$data[1].'/'.$data[0]; 
					$data = $e->data_cad_updt;
					if($data != '0000-00-00'){
						$data = explode('-',$data);
						$data = $data[2].'/'.$data[1].'/'.$data[0]; 
					} else { $data = ''; } ?></td>
					<td style="text-align:center">
						<input style="width:65px;" type="text" name="id_datacad" id="id_datacad" class="form_estilo" maxlength="10" value="<?=$data?>" />
						<input type="button" style="width:20px;" class="button_busca" value="ok" onclick="document.getElementById('form1').submit();" />
						<input type="hidden" name="id_registro" id="id_registro" value="<?=$e->id_ficha?>" />
						<script>$('#id_datacad').mask('99/99/9999');</script>
					</td>
				</tr>
			<? $i++; }
				if($i == 0){ echo '<tr><td colspan="8" style="color:#FF0000">
					Nenhuma ficha encontrada com este número.</td></tr>'; }
			} ?>
		</table>
	<? } else { echo '<span style="color:#FF0000">Você não tem permissão para visualizar esta página.</span>'; }?>
</div>
<? require "footer.php"; ?>