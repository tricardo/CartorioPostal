<?
require('header.php');
require('../includes/dias_uteis.php');
?>
<div id="topo">
<?
$permissao = verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<h1 class="tit"><img src="../images/tit/tit_rel.png" alt="Título" />Relatório de Planejamento Econômico Financeiro </h1>
<hr class="tit" />
<br />
</div>
<div id="meio">
<form name="buscador" action="gera_viabilidade.php" target="_blank" method="post" ENCTYPE="multipart/form-data">
<div style="float: left"><img src="../images/lupa.png" alt="busca" /></div>
<div style="width: 600px; float: left; text-align:right">
	<strong>Crescimento: </strong>
	<input type="text" name="crescimento" value="<?= $crescimento ?>" onKeyUp="masc_numeros(this,'###');" style="width: 50px;" class="form_estilo" />%
            <strong>Unidade: </strong>
            <select name="id_empresa" style="width:200px" class="form_estilo">
                <?
                    $sql = $objQuery->SQLQuery("SELECT id_empresa, fantasia from vsites_user_empresa as uu where id_empresa!='$controle_id_empresa' and status='Ativo' order by fantasia");
                    while($res = mysql_fetch_array($sql)){
                        echo '<option value="'.$res['id_empresa'].'"';
						if($busca_id_empresa==$res['id_empresa']) echo ' selected="selected" ';
						echo ' >'.str_replace('Cartório Postal - ','',$res['fantasia']).'</option>';
                    }
                ?>        
            </select>

	<input type="submit" name="submit" class="button_busca" value=" Buscar " />
	<br><br>
</div>
</form>
<br />
<br />
</div>
	<?php
	require('footer.php');
	?>