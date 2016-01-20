<?
$tipo = $_GET['tipo'];
$cpf  = $_GET['cpf'];
	?>
    <input type="text" name="cpf" value="<?= $cpf ?>" style="width:150px" onKeyUp="if(tipo.value=='cpf') masc_numeros(this,'###.###.###-##'); else masc_numeros(this,'##.###.###/####-##');" class="form_estilo"/>
    <?

