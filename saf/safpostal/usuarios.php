<?
require "../includes/topo.php";
$permissao = verifica_permissao('USUARIOS',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','busca');

?>
<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3" height="2"></td>
    </tr>
  <tr>
    <td width="150" align="left" valign="top">
    <table width="150" border="0" cellspacing="0" cellpadding="0" align="left">
      <tr>
        <td><? require "menu_lateral.php"; ?></td>
      </tr>
    </table>
    </td>
    <td width="2"></td>
    <td align="left" valign="top"><table width="768" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="764" align="center" valign="top" background="../images/paginas/index/barra_de_titulo1.png"><table width="768" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="345" height="20" align="left" valign="middle"><strong>Usuários</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
        <div id="conteudo_adm_usuario">
        <table border="0">
<tr>
	<td align="center" valign="top">

    <form name="form_usuarios" action="" method="get" enctype="multipart/form-data">
		<div style="float:left">    
			<img src="../images/paginas/chat/lupa.png" alt="busca" />
        </div>
        <div>    
			<input type="text" class="form_estilo" name="busca" value="<?= $busca ?>" size="30" />
			<input type="submit" name="submit" class="button_busca" value=" Buscar " />
        	<input type="submit" name="limpar" class="button_busca" onclick="busca.value='';" value=" Mostrar Todos " />
        </div>
	</form><br />
	<table bgcolor="#0071B6" cellpadding="0" cellspacing="0">
    <tr>
    <td>
	<table width="100%" cellpadding="5" cellspacing="1" class="result_tabela" border="0">
	<tr>
		<td class="result_menu" bgcolor="#FFFFFF"><b>Nome - Email</b></td>
		<td align="center" width="40" class="result_menu" bgcolor="#FFFFFF"><b>Status</b></td>
        <td align="center" width="80" class="result_menu" bgcolor="#FFFFFF"><b>Departamentos</b></td>
	</tr>

<?php

$onde = "";
if($busca<>'') $onde .= " and (uu.nome like '$busca%' or uu.email like '$busca%')";

$condicao = "FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE ue.id_empresa = uu.id_empresa and uu.id_empresa='1' and uu.id_usuario !='1' and uu.status='Ativo' ".$onde." ORDER BY uu.nome ASC";

$campo = "uu.email, uu.nome, uu.status, uu.id_usuario,  ue.fantasia";
pt_register('GET','pagina');
$query = $objQuery->paginacao( $campo , $condicao,$pagina , 'busca='.$busca);
$p_valor = "";
while($res = mysql_fetch_array($query)){ 

	$p_valor .= '
	<tr><td class="result_celula" bgcolor="#FFFFFF">' . $res["nome"] .' - '. $res["email"]. '</a></td>
	<td class="result_celula" align="center" nowrap bgcolor="#FFFFFF">' . $res["status"] . '</td>
	<td class="result_celula" align="center" nowrap bgcolor="#FFFFFF"><a href="usuario_departamento.php?id='.$res["id_usuario"].'"><img src="../images/paginas/chat/botao_editar.png" title="Editar Departamento" border="0"/></a></td>
	</tr>';
}
echo $p_valor;
?>
		<tr>
			<td colspan="9" class="barra_busca" bgcolor="#FFFFFF">
				<?
                    $objQuery->QTDPagina();
                ?>			
            </td>
		</tr>
		</table>
        </td>
        </tr>
        </table>
	</td>
</tr>
</table>
</div>
        
        </td>
      </tr>
    </table></td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>