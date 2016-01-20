<? if($_SESSION['usuario']!=''){?>
	Ol&aacute; <?=$_SESSION['usuario']?>.<br/><!--  -->
	<a href="<?=$urlBase?>/usuario/logoff">sair</a>
<? }else{ ?>
	<form action="<?=$submit?>" method="post">
		<label for="usuario">Usu&aacute;rio:</label>
	    <input id="usuario" name="usuario" type="text"/><br/>
	    <label for="senha">Senha:</label>
	    <input id="senha" name="senha" type="password" />
	    <input type="submit" value="Entrar"/>
	</form>
<? }?>