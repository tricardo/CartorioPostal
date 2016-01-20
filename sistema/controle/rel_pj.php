<?php
require('header.php');
$ano = (int) date('Y');
?>
<div id="topo">
	<h1 class="tit">
	<img src="../images/tit/tit_cartorio.png" alt="Título" />Faturamento por Cliente Corporativo</h1>
	<hr class="tit" />
	<br />
</div>
<div id="meio">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<form name="buscador" id="buscador" action="gera_exporta_rel_pj.php" method="post" target="_blank">
		<div style="float: left"><img src="../images/lupa.png" alt="busca" /></div>
		<div style="width: 280px; position: relative">
        	<label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Ano</label>
            <select name="ano" id="ano" class="form_estilo" style="width: 150px; float: left">
            	<? for($i = 2010; $i <= (int)date('Y'); $i++){?>
                	<option value="<?=$i?>" <? if($ano==$i) echo 'selected="select"'; ?>><?=$i?></option>
                <? }?>
            </select> 
			<input type="submit" name="submit" class="button_busca" style="float:left; margin-top:10px;" value=" Buscar " />
        </div>
        <? if($_SESSION['erro_rel_pj'] != 'a'){?>
        	<div style="color:#FF0000; margin-top:10px; width:100%; float:left"><?=$_SESSION['erro_rel_pj']?></div>
        <? }?>
		</form>
		</td>
	</tr>
</table>
</div>
<?php require('footer.php'); ?>
