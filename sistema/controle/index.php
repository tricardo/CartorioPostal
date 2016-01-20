<?
require('header.php');
$servicoDAO = new ServicoDAO();
?>
<?
#
#
#
#if($controle_id_usuario == 1){
if(substr_count($controle_email,'diretoria') > 0){
	
	$conselho = new	ConselhoDAO();
	$teste = $conselho->regiao($controle_id_empresa);
	if($teste > 0){
		$dt = $conselho->campanha(); 
		if($dt){ 
			if($_POST){
				if(isset($_POST['conselho'])){
					$conselho->votar($dt->id_campanha, $_POST['conselho'], $controle_id_empresa, $controle_id_usuario);
				}
			} 
			if(!$conselho->voto($dt->id_campanha, $controle_id_empresa, $controle_id_usuario)){ ?>
				<form method="post" action="index.php">
					<div style="width:650px; height: 420px; margin-left: -325px; margin-top:-210px; position:absolute; z-index: 1; left:50%; top:50%; border: dashed 3px #6DB7E5; background-color:#FFF" id="dv_conselho">
						<table style="width:100%">
							<tr>
								<td colspan="2" style="padding:5px; text-align:right">
									<a href="#" onclick="document.getElementById('dv_conselho').style.display='none'" style="text-decoration:none; color:#6DB7E5; font-weight:bold">Fechar X</a>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="padding:5px; font-weight:bold"><?=$dt->campanha?></td>
							</tr>
							<tr>
								<td colspan="2" style="padding:5px"><?=$dt->texto?></td>
							</tr>
							<?
							#$dt1 = $conselho->usuario($dt->id_campanha, array('id_empresa'=>$controle_id_empresa));
							$dt1 = $conselho->usuario($dt->id_campanha);
							for($i = 0; $i < count($dt1); $i++){ ?>
							<tr>
								<td style="width:50px; text-align:center"><input type="radio" name="conselho" id="conselho<?=$i?>" value="<?=$dt1[$i]->id_usuarioc?>" /></td>
								<td><label for="conselho<?=$i?>" style="cursor:pointer"><?=$dt1[$i]->nome?></label></td>
							</tr>
							<? } ?>
							<tr>
								<td colspan="2" style="height:30px;text-align:right;padding:5px">
									<input type="submit" name="btn" value="votar >>" />
								</td>
							</tr>
						</table>
					</div>
				</form>
			<? } else { 
				if($_POST){
					if(isset($_POST['conselho'])){ ?>
						<div style="width:650px; height: 420px; margin-left: -325px; margin-top:-210px; position:absolute; z-index: 1; left:50%; top:50%; border: dashed 3px #6DB7E5; background-color:#FFF" id="dv_conselho">
							<table style="width:100%">
								<tr>
									<td colspan="2" style="padding:5px; text-align:right">
										<a href="#" onclick="document.getElementById('dv_conselho').style.display='none'" style="text-decoration:none; color:#6DB7E5; font-weight:bold">Fechar X</a>
									</td>
								</tr>
								<tr>
									<td colspan="2" style="padding:5px; font-weight:bold; color: #FF0000; height: 100px; text-align: center">
											Obrigado por votar.</td>
								</tr>
							</table>
						</div>
			<?		}
				 }
			  }
		}
	}
}
#
#
#
?>



<?php /*if($controle_id_usuario == 1){ ?>
<div style="width:650px; height: 420px; margin-left: -325px; margin-top:-210px; position:absolute; z-index: 1; left:50%; top:50%; border: dashed 3px #6DB7E5; background-color:#FFF;" id="dv_conselho">
	<div style="font-size: 15px; padding: 25px; width: auto;">
		<p style="text-align: right"><a href="#" onclick="document.getElementById('dv_conselho').style.display='none'" style="text-decoration:none; color:#6DB7E5; font-weight:bold">Fechar X</a></p>
		<p style="font-size: 16px; font-weight: bold">Prezados usuários,</p>
		<p style="font-size: 16px">A nova versão beta do sistema está em funcionamento, mas devido algumas correções, os pedidos neste sistema ainda estarão em funcionamento.</p>
		<!--<p style="font-size: 16px">Queremos libera-lo em definitivo no dia <strong style="font-size: 16px">12/12/2014, devido as atualizações solicitadas não serem finalizadas até o dia 05/12/2014,</strong> porém, precisamos verificar se ele esta em perfeito funcionamento e não contem erros ou necessita de melhorias.</p>
		<p style="font-size: 16px">Qualquer dúvida, solicito que visualize o <strong style="font-size: 16px">comunicado 1307</strong>.</p>-->
		<p style="font-size: 16px; font-weight: bold">Equipe de TI</p>
	</div>
</div>
<?php }*/ ?>

<div style="margin: 30px 10px 10px; overflow: hidden">

<div id="columns">
<ul id="column1" class="column">
	<?php #if($controle_id_usuario == 1){ 
		if(date('Y-m-d H:i') > date('Y-m-d H:i', strtotime('2015-06-03 17:30'))){?>
		<li class="widget color-red" id="widget6">
			<div class="widget-head">
				<h3>Sistema Novo</h3>
			</div>
			<div class="widget-content">
				<p style="font-size:15px;line-height:25px;font-weight:bold">
					O sistema novo esta quase finalizado,
					para conhece-lo <a href="../../sistemav2/principal.php" style="font-size:15px">clique aqui.</a><br>
					Dúvidas, melhorias, problemas no sistema novo, envie uma mensagem para <a href="mailto:ti@cartoriopostal.com.br">ti@cartoriopostal.com.br</a> com o título 'Sistema Novo'.
				</p>
			</div>
		</li>
	<?php } 
	#}?>
	
	<li class="widget color-blue" id="widget6">
		<div class="widget-head">
			<h3>Comunicado de Alteração do sistema</h3>
		</div>
		<div class="widget-content">
		<p><font color="#FF0000"><b>Alterações no menu do sistema:</b></font><br>
		1) A partir de 29/08 a atividade "Serviço Concluído" passará a ser apenas "Concluído"</b><br>
		</p>
		</div>
	</li>

	<li class="widget color-blue" id="widget4">
	<div class="widget-head">
	<h3>Tabela de Valores</h3>
	</div>
	<div class="widget-content"><br>

	<div style="float: left; width: 50px; height: 18px">Serviço:</div>
	<select name="id_servico" style="width: 180px; float: left"
		id="id_servico" class="form_estilo"
		onchange="carrega_servico_var_valor(this.value,'');">
		<option value="">Selecione o Serviço</option>
		<?
			$p_valor = '';
			$var = $servicoDAO->listaAtivos();
			foreach($var as $s){
				$p_valor .= '<option value="'.$s->id_servico.'"';
				if($busca_id_servico==$s->id_servico) $p_valor .= ' selected="selected" ';
				$p_valor .=  ' >'.$s->descricao.'</option>';
			}
			echo $p_valor;
		?>
	</select> <br>
	<div id="id_servico_var_valor" style="clear: both"></div>
	<p></p>
	</div>
	</li>

	<li class="widget color-blue" id="widget2">
	<div class="widget-head">
	<h3>Outros</h3>
	</div>
	<div class="widget-content">
	<p>Em Breve</p>
	</div>
	</li>
</ul>

<ul id="column2" class="column">

	<li class="widget color-blue" id="widget3">
	<div class="widget-head">
	<h3>Tarefas Diárias</h3>
	</div>
	<div class="widget-content">
	<p>
		1) Verificar pedidos que entraram pelo site no menu <b>Direcionamento Site</b><br>
		2) Dar baixa nos Recebimentos dos clientes no menu <b>Financeiro > Recebimento</b><br>
		3) Dar baixa nos Recebimentos de outras franquias no menu <b>Financeiro > Recebimento</b><br>
		4) Aprovar ou Reprovar pedidos de Desembolso no menu <b>Financeiro > Desembolso</b><br>
		5) Atualizar o andamento de cada pedido até o momento da sua conclusão <br>
	</p>
	</div>
	</li>

	<li class="widget color-blue" id="widget5">
	<div class="widget-head">
	<h3>SAF</h3>
	</div>
	<div class="widget-content"><br>
	Essa area é destinada a suporte técnico, download de documentos e
	informações sobre outras franquias.<br>
	<br>
	<b>- <a href="http://www.cartoriopostal.com.br/saf/safpostal/index.php">Acessar o SAF</a></b><br>
	<br>
	<? $permissao = verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s);
		if($permissao == 'TRUE' and $controle_id_empresa=='1'){  ?> 
			<b>- <a href="pedido_franquias.php">Suporte</a></b><br><br>
			<b>- <a href="chamado.php">Chamados</a></b><br><br>
			<b>- <a href="chamado_add.php">Abrir Chamado</a></b><br><br>
		<br>
	<? } ?>
	<p></p>
	</div>
	</li>
	<li class="widget color-blue" id="intro">
	<div class="widget-head">
	<h3>Mensagens não lidas</h3>
	</div>
	<div class="widget-content">
	<p>Em Breve</p>
	</div>
	</li>
</ul>

</div>

</div>
<script	type="text/javascript" src="../js/box_movel2/jquery-ui-personalized-1.6rc2.min.js"></script>
<script	type="text/javascript" src="../js/box_movel2/cookie.jquery.js"></script>
<script	type="text/javascript" src="../js/box_movel2/inettuts.js"></script>
<?
#$cham = new ChamadoDAO();
#$cham->chamado_mail();
?>
<? require('footer.php');?>
