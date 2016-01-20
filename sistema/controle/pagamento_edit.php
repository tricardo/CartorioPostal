<?php require('header.php'); ?>
<div id="topo"><?php
$permissao = verifica_permissao('Financeiro Pgto',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' and $controle_depto_p[27]!=1){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />Contas à Pagar - Editar</h1>
<a href="#" class="topo">topo</a>
<hr class="tit" />
</div>
<div id="meio">
	<div style="position: relative; width: 600px; margin: auto;" id="container-hotsite">
		<ul>
			<li><a href="#aba1">Conta</a></li>
			<li><a href="#aba2">Anexo</a></li>
		</ul>
		<div id="aba1">
			<?php require("pagamento_form.php");?>
		</div>
		<div id="aba2">
			<?php require("pagamento_anexo.php");?>
		</div>
	</div>
</div>
<?php require('footer.php'); ?>