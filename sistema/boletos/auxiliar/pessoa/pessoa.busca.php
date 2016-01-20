
<div class="busca" >
	<fieldset>
		<legend>Busca</legend>
		<form method="post" name="busca" action="<?=$submit?>">
		<input type="hidden" name="valor" value="<?=$valor?>"/>
		<input type="hidden" name="acao" value="<?=$acao?>"/><br/>
		<input type="hidden" name="id" value="<?=$pessoa->id?>"/>
        <div class="fom_label">
			Nome : <input type="text" name="nome" value="<?=$pessoa->nome ?>"/>
        </div>
        <div class="fom_label">
			Email :	<input type="text" name="email" value="<?=$pessoa->email?>"/>
        </div>
        <input type="submit" value="BUSCA"/>
        </form>
	</fieldset>
</div>
<div id="lista">

</div>
