<?
require_once('header.php');
?>
<div id="fundo_tela">
	<div id="titulo">
		<strong>ACESSO A ÁREA ADMINISTRATIVA</strong>
	</div>
	<div id="form_login">
		<form name="form_login" action="login-usuario.php" method="post" enctype="multipart/form-data">
		<label style="margin-left:5px;"><strong>EMAIL:</strong></label><input name="login" type="text" value="<?= $login ?>" style="margin-left:2px;margin-bottom:5px;width:230px" /><br />
		<label style="margin-left:2px;"><strong>SENHA:</strong></label><input name="senha" type="password" value="" style="margin-left:2px;width:175px" />
		<label style="margin-left:0px;"><input type="submit" name="submit1" value="login" /></label>
		</form>
	</div>
	<div id="canal_dos_profissionais1">
		<a href="http://www.canaldosprofissionais.com.br" title="Clique aqui" target="_blank"><img src="../images/canal_dos_profissionais1.png" alt="" border="0" /></a>
	</div>
</div>
<?
require_once('footer.php');
?>