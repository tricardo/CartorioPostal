<?
require('header.php');
$permissao = verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

	$dia='1';
	$mes=date('m');
	$ano=date('Y');
?>
<div style="margin:15px;">
<table border="0" height="100%" width="100%" >
<tr>
	<td valign="top">
    <h1 class="tit"><img src="../images/tit/tit_rel.png" alt="Título" /> Relatórios Gerenciais</h1>
    <hr class="tit"/><br />

    <form name="buscador" action="gera_rel_excel.php" target="_blank" method="post" ENCTYPE="multipart/form-data">
		<div style="float:left">
			<img src="../images/lupa.png" alt="busca" />
        </div>
        <div style="width:280px; position:relative">
            <label style="width:90px; font-weight:bold; padding-top:5px; float:left; text-align:right">Mês</label>

			<select name="mes" class="form_estilo" style="width:150px; float:left" >
	                  <option value="01" <? if($mes=='01') echo 'selected="select"'; ?>>Janeiro</option>
	                  <option value="02" <? if($mes=='02') echo 'selected="select"'; ?>>Fevereiro</option>
	                  <option value="03" <? if($mes=='03') echo 'selected="select"'; ?>>Março</option>
	                  <option value="04" <? if($mes=='04') echo 'selected="select"'; ?>>Abril</option>
	                  <option value="05" <? if($mes=='05') echo 'selected="select"'; ?>>Maio</option>
	                  <option value="06" <? if($mes=='06') echo 'selected="select"'; ?>>Junho</option>
	                  <option value="07" <? if($mes=='07') echo 'selected="select"'; ?>>Julho</option>
	                  <option value="08" <? if($mes=='08') echo 'selected="select"'; ?>>Agosto</option>
	                  <option value="09" <? if($mes=='09') echo 'selected="select"'; ?>>Setembro</option>
	                  <option value="10" <? if($mes=='10') echo 'selected="select"'; ?>>Outubro</option>
	                  <option value="11" <? if($mes=='11') echo 'selected="select"'; ?>>Novembro</option>
	                  <option value="12" <? if($mes=='12') echo 'selected="select"'; ?>>Dezembro</option>
           </select>
	       <label style="width:90px; font-weight:bold; padding-top:5px; float:left; text-align:right">Ano</label>

			<select name="ano" class="form_estilo" style="width:150px; float:left">
	                  <option value="2009" <? if($ano=='2009') echo 'selected="select"'; ?>>2009</option>
	                  <option value="2010" <? if($ano=='2010') echo 'selected="select"'; ?>>2010</option>
	                  <option value="2011" <? if($ano=='2011') echo 'selected="select"'; ?>>2011</option>
	                  <option value="2012" <? if($ano=='2012') echo 'selected="select"'; ?>>2012</option>
	                  <option value="2013" <? if($ano=='2013') echo 'selected="select"'; ?>>2013</option>
	                  <option value="2014" <? if($ano=='2014') echo 'selected="select"'; ?>>2014</option>
	       </select>
		   <label style="width:90px; font-weight:bold; padding-top:5px; float:left; text-align:right">Origem: </label>
      <select name="origem" style="width:150px; float:left;" class="form_estilo" onchange="javascript:if(this.value=='Multi Vendas'){ document.getElementById('comissionado').style.visibility='visible'; carrega_comissionado(this.value);} else { document.getElementById('comissionado').style.visibility='hidden'; comissionado.value=''; } if(this.value=='Ponto de Venda'){ document.getElementById('id_ponto').style.visibility='visible'; carrega_pontodevenda(this.value);} else { document.getElementById('id_ponto').style.visibility='hidden'; id_ponto.value=''; }">
        <option value="">Todos</option>
		<?
			$sql = $objQuery->SQLQuery("SELECT * from vsites_origem as o where status='Ativo' order by origem");
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['origem'].'" ';
				if($origem==$res['origem']) echo ' selected="selected"'; 
				echo '>'.$res['origem'].'</option>';
			}
		?>        
        </select>		   
            <label style="width:90px; font-weight:bold; padding-top:5px; float:left; text-align:right">Departamento: </label>

            <select name="busca_id_departamento" style="width:150px; float:left;" class="form_estilo">
                <option value="" <? if($busca_id_departamento=='') echo ' selected="selected" '; ?>>Todos</option>
                <?
                    $sql = $objQuery->SQLQuery("SELECT * from vsites_servico_departamento where ordem='Sim' order by departamento");
                    while($res = mysql_fetch_array($sql)){
					 
                           echo '<option value="'.$res['id_servico_departamento'].'"';
						   if($busca_id_departamento==$res['id_servico_departamento']) echo ' selected="selected" ';
						   echo ' >'.$res['departamento'].'</option>';
                    }
                ?>
            </select>			
			<input type="submit" name="submit" class="button_busca" style="float:left" value=" Buscar " />
        </div>
	</form><br />

	</td>
</tr>

</table>
</div>
<?php 
	require('footer.php');
?>