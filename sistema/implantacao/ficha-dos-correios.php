<?
$correioDAO = new CorreioDAO();
if(isset($c->submit)){
	$error = "";
	$errors = array();
	$error = "<b>Ocorreram os seguintes erros:</b><ul>";

	if ($c->id_fichacorreio == "" || $c->quantidade == "") {
		if ($c->id_fichacorreio == "")
			$errors['id_fichacorreio'] = 1;
		if ($c->quantidade == "")
			$errors['quantidade'] = 1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}
	
	if (count($errors) == 0) {
		$correioDAO->inserirFichaCorreio($c->id_empresa, $controle_id_usuario, $c->id_fichacorreio, $c->quantidade);
		$titulo = 'Mensagem da página web';
		$msg = 'Registro adicionado com sucesso!';
		$pagina = 'franquias_editar.php?id='.$c->id_empresa;
		$funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
		echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
	} else {
		echo "<script>
			document.getElementById('errors').style.display = 'block';
			document.getElementById('errors').innerHTML = '<div class=\"erro\">".$error."</div><br />';
		</script>";
	}
} ?>
<label>Tipo de Ficha:</label>
<select name="id_fichacorreio" class="form_estilo<? if ($errors['id_fichacorreio'] == 1)
echo '_erro'; ?>">
	<option value=""></option>
	<?
	$p_valor = "";
	$lista = $correioDAO->listarTipoFicha();
	foreach ($lista as $l) {
		$p_valor .='<option value="' . $l->id_fichacorreio . '" ';
		if ($c->id_fichacorreio == $l->id_fichacorreio) $p_valor .= ' selected ';
		$p_valor .= '>' . $l->fichacorreio . '</option>';
	}
	echo $p_valor;
	?>
</select> <font style="color:#FF0000;float:left;">*</font>

<label>Quantidade:</label>
<input type="text" class="form_estilo<? if ($errors['quantidade'] == 1) echo '_erro'; ?>" name="quantidade" 
value="<?= $c->quantidade ?>" onkeyup="mascara(this.value,'#####');" style="width: 150px" />
<font style="color:#FF0000;float:left;">*</font><br />

<div style="text-align:center;width:100%">
	<input style="float:none;margin:0" type="button" name="submit" value="Cadastrar" class="button_busca" onclick="franquia_editar(2,<?=$c->id_empresa?>)" />
</div><br />

<div class="frq_title">Histórico de Fichas</div><br />
<table style="width:100%;float:left">
<tr>
	<td>
		<?
		$p_valor = '
			<div class="form_estilo_r" style="width:85px; float:left; clear:left; font-weight:bold">Data</div>
			<div class="form_estilo_r" style="width:85px; float:left; font-weight:bold">Tipo de Ficha</div>
			<div class="form_estilo_r" style="width:75px; float:left; font-weight:bold">Quantidade</div>';
		$lista = $correioDAO->listarFicha($c->id_empresa);
		foreach ($lista as $l) {
			$p_valor .= '
				<div class="form_estilo_r" style="width:85px; float:left; clear:left">' . invert($l->data, '/', 'PHP') . '</div>
				<div class="form_estilo_r" style="width:85px; float:left;">' . $l->fichacorreio . '</div>
				<div class="form_estilo_r" style="width:75px; float:left">' . $l->quantidade . '</div>';
		}
		echo $p_valor;
		?>
	</td>
</tr>
</table>
