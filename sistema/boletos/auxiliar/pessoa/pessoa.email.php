	
		<h3>Enviar email</h3>		
	
		<form method="post" name="pessoaForm" action="<?=$submit?>">
			<input type="hidden" name="valor" value="<?=$valor?>"/>
			<input type="hidden" name="acao" value="<?=$acao?>"/><br/>
			<input type="hidden" name="id" value="<?=$pessoa->id?>"/>
			
			Nome: <input type="text" name="nome" value="<?=$pessoa->nome ?>"/><br/>
				Usu&aacute;rio: <input type="text" name="usuario" value="<?=$pessoa->usuario ?>"/><br/>	
			Email : <input type="text" name="email" value="<?=$pessoa->email?>"/><br/>
		
			Mensagem:
			<br/>
			<textarea rows="10" cols="55" name="mensagem"></textarea>	
			<input type="submit" value="ENVIAR" />
		</form>
