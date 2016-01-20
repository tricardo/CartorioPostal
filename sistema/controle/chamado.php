<?php require('header.php'); ?>
<div id="topo">
<?php
$permissao = verifica_permissao('Franchising',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!=1){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','id_pedido');
pt_register('GET','ordem');
pt_register('GET','id_empresa');
pt_register('GET','id_usuario');
pt_register('GET','submit');
pt_register('GET','pagina');
pt_register('GET','status');
pt_register('GET','data_f');
pt_register('GET','data_i');
pt_register('GET','forma_atend');
if($data_i=='') $data_i= date('d/m/Y',strtotime("- 1 month"));
if($data_f=='') $data_f= date('d/m/Y');
if($submit || isset($_GET['pagina'])){
	$b = new stdClass();
	$b->id_pedido = $id_pedido;
	$b->ordem = $ordem;
	$b->id_empresa = $id_empresa;
	$b->id_usuario = $id_usuario;
	$b->data_i = invert($data_i,'-','SQL');
	$b->data_i2 = $data_i;
	$b->data_f = invert($data_f,'-','SQL');
	$b->data_f2 = $data_f;
	$b->status = $status;
	$b->forma_atend = $forma_atend;
}

$empresaDAO = new EmpresaDAO();
$usuarioDAO = new UsuarioDAO();

$empresas = $empresaDAO->listarTodasStatus();
$usuarios = $usuarioDAO->listarAtivosDpto($controle_id_empresa,'17');
?>
<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />
Chamado</h1>
<a href="#" class="topo">topo</a>
<hr class="tit" />
</div>
<div id="meio">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<form name="buscador" action="" method="get" ENCTYPE="multipart/form-data">
			
			<div class="busca1">
				<label>Pedido: </label>
				<input type="text" class="form_estilo" name="id_pedido" value="<?= $busca ?>" /> / 
				<input type="text" class="form_estilo" name="ordem" value="<?= $busca ?>" size="1" />
				<br/>
				<label>Franquia: </label>
				<select name="id_empresa" style="width: 200px" class="form_estilo">
					<option></option>
					<?php foreach($empresas as $e){ ?>
						<option value="<?=$e->id_empresa;?>"
						<?=($b->id_empresa == $e->id_empresa)?'selected="selected"':''?>><?=$e->fantasia; ?></option>
					<?php }?>
				</select>
				<label>Usuário: </label>
				<select name="id_usuario" style="width: 200px" class="form_estilo">
					<option></option>
					<?php foreach($usuarios as $e){ ?>
						<option value="<?=$e->id_usuario;?>"
						<?=($b->id_usuario == $e->id_usuario)?'selected="selected"':''?>><?=$e->nome; ?></option>
					<?php }?>
				</select>
				<br/>
				<label>Status: </label>
				<select name="status" style="width: 200px" class="form_estilo">
					<option></option>
					<option <?=($b->status=="0")?'selected="selected"':'';?> value="0">Pendente</option>
					<option <?=($b->status=="1")?'selected="selected"':'';?> value="1">Resolvido</option>
				</select>
				<br>
				<label>Aberto Entre: </label>
				<input type="text" name="data_i" value="<?= $data_f ?>" style="width:90px;" class="form_estilo" />
				<b>e </b>
				<input type="text" name="data_f"  value="<?= $data_f ?>" style="width:90px;" class="form_estilo" />
				<br/>
                <label>Forma de Atendimento: </label>
				<select name="forma_atend" style="width: 200px" class="form_estilo">
					<option value="0">--</option>
					<option <?=($b->forma_atend=="1")?'selected="selected"':'';?> value="1">Telefone</option>
					<option <?=($b->forma_atend=="2")?'selected="selected"':'';?> value="2">E-mail</option>
                    <option <?=($b->forma_atend=="3")?'selected="selected"':'';?> value="3">Skype</option>
				</select><br />
				<input type="submit" name="submit" class="button_busca" value="Buscar" />
			</div>
		</form>
		<div style="clear: both"><br />
			<a href="chamado_add.php">
				<h3><img src="../images/botao_add.png" border="0" /> Adicionar novo registro</h3>
			</a>
		</div>
		<?php
		if($submit!='' || isset($pagina)) {
			$chamadoDAO = new ChamadoDAO();		
			$pagina = 1;
			if(isset($_GET['pagina'])){
				$pagina = $_GET['pagina'];
			} elseif(isset($_POST['pagina'])){
				$pagina = $_POST['pagina'];
			}
			$chamados = $chamadoDAO->busca($b,$pagina);
			$p_valor = "";
		?> <br />
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="7" class="barra_busca"><?php $chamadoDAO->QTDPagina();?></td>
			</tr>
			<tr>
				<td class="result_menu"><b>Franquia</b></td>
				<td class="result_menu"><b>Usuário</b></td>
				<td class="result_menu"><b>Assunto</b></td>
				<td class="result_menu" style="width:18%"><b>Abertura | Fechamento</b></td>
				<td class="result_menu" style="width:7%"><b>Atend.</b></td>
				<td class="result_menu" style="width:7%"><b>Status</b></td>
				<td align="center" class="result_menu"  style="width:7%"><b>&nbsp;</b></td>
			</tr>

			<? $userd = new UsuarioDAO();
			foreach($chamados as $c){
				if($c->status==0) $c->status='Pendente'; else $c->status='Resolvido';
				$dt = explode('-',$c->data_cadastro);
				$dt1 = substr($dt[2],0,2).'/'.$dt[1].'/'.$dt[0].' '.substr($dt[2],3,5);
				$dt2 = '-';
				if($c->data_atualizacao != '0000-00-00 00:00:00'){
					$dt = explode('-',$c->data_atualizacao);
					$dt2 = substr($dt[2],0,2).'/'.$dt[1].'/'.$dt[0].' '.substr($dt[2],3,5);
				}
				switch($c->forma_atend){
					case 1: $c->forma_atend = 'Telefone'; break;
					case 2: $c->forma_atend = 'E-mail'; break;
					case 3: $c->forma_atend = 'Skype'; break;
					default: $c->forma_atend = '-';
				}
				$dt4 = $userd->selectPorId($c->id_usuario);
				$nome = ($dt4 != '') ? $dt4->nome : '-';
				$ordem = ($c->id_pedido > 0) ? $c->id_pedido.'/'.$c->ordem : '&nbsp;';
				$p_valor .= '
					<tr>
					<td class="result_celula">' . str_replace(' - Sistema de Cartório Certidões S/C Ltda', '', $c->franquia). '</td>
					<td class="result_celula">' . $nome. '</td>
					<td class="result_celula">' . $c->pergunta. '</td>
					<td class="result_celula">' . $dt1.'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;'. $dt2. '</td>
					<td class="result_celula">' . $c->forma_atend. '</td>
					<td class="result_celula">' . $c->status. '</td>
					<td class="result_celula" align="center"><a href="chamado_edit.php?id=' .$c->id_chamado. '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
					</tr>';
			}
			echo $p_valor;
			?>
			<tr>
				<td colspan="7" class="barra_busca"><?php $chamadoDAO->QTDPagina(); ?>
				</td>
			</tr>
			<?php } ?>
		</table>
		</td>
	</tr>
</table>
</div>
<?php
require('footer.php');
?>