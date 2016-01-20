
<fieldset>
    <legend>Telefones</legend>
    
    <div class="form" id="telListaForm">
	<a href="#" class="add" id="addTelefone">x</a>
    </div>
    <div id="telefoneForm">
        <input type="hidden" name="removerTels" value="" id="removerTels"/>
        <? foreach($telefones as $n=>$telefone){ ?>
                <? include("telefone_unit.form.php"); ?>
        <? } ?>
    </div>
</fieldset>