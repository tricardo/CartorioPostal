<?php require('header.php'); ?>
<div id="topo"><?php
$permissao = verifica_permissao('Financeiro Pgto',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Voc� n�o tem permiss�o para acessar essa p�gina</strong>';
	exit;
}
$submit='inserir';
?>
<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="T�tulo" />Contas � Pagar - Cadastro</h1>
<a href="#" class="topo">topo</a>
<hr class="tit" />
</div>
<div id="meio">
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">
			<?php require("pagamento_form.php");?>
		</td>
	</tr>
</table>
</div>
<?php require('footer.php'); ?>