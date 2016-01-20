<?
require('header.php');
$permissao = verifica_permissao('Pedido Import Cart',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);
?>
<div style="margin:15px;">
<table border="0" height="100%" width="100%" >
<tr>
	<td valign="top">
    <h1 class="tit"><img src="../images/tit/tit_rel_banco.png" alt="Título" /> Retorno do Cliente</h1>
    <hr class="tit"/><br />

            <form enctype="multipart/form-data" action="gera_retorno.php" method="post" name="pedido_print" target="_blank">
              <center>
       <table width="650" class="tabela">
       <tr>
                  <td colspan="4" class="tabela_tit"> Retorno</td>
      </tr>

          <tr>
          <td width="100"> <div align="right"><strong>Cliente: </strong></div></td>
          <td width="313" colspan="3">
			<select name="id_cliente" style="width:493px" class="form_estilo">
				<option value=""></option>
				<?
				$sql = $objQuery->SQLQuery("SELECT uc.* from vsites_user_cliente as uc, vsites_user_usuario as uu where uc.status='Ativo' and uc.conveniado='Sim' and uc.id_usuario=uu.id_usuario and uu.id_empresa='$controle_id_empresa' and (uc.id_cliente='49117' or uc.id_cliente='52045') order by uc.nome");
				while($res = mysql_fetch_array($sql)){
					echo '<option value="'.$res['id_cliente'].'" ';
					if($id_cliente==$res['id_cliente']) echo ' selected="selected"';
					echo '>'.$res['nome'].'</option>';
				}
		
				?>        
			</select> 

        </td>
        </tr>
          <tr>
          <td width="100"> <div align="right"><strong>Serviço: </strong></div></td>
          <td width="313" colspan="3">
			<select name="id_servico" style="width:493px" class="form_estilo">
				<?
				$sql = $objQuery->SQLQuery("SELECT id_servico, descricao from vsites_servico as s where s.status='Ativo' and id_servico='17' order by descricao");
				while($res = mysql_fetch_array($sql)){
					echo '<option value="'.$res['id_servico'].'" ';
					if($id_servico==$res['id_servico']) echo ' selected="selected"';
					echo '>'.$res['descricao'].'</option>';
				}		
				?>        
			</select> 

        </td>
        </tr>
        <tr>
          <td width="100"> <div align="right"><strong>Tipo de Arquivo: </strong></div></td>
          <td width="313" colspan="3">
			<select name="h_tiporetorno" style="width:493px" class="form_estilo">
				<option value="CONF">CONFIRMAÇÃO DE RECEBIMENTO</option>        
				<option value="REGI">REGISTRO DA NOTIFICAÇÃO</option>
				<option value="OCOR">OCORRÊNCIA DA NOTIFICAÇÃO</option>
			</select> 

        </td>
        </tr>


        <tr>
		<td colspan="4" align="center">
        <input type="submit" name="submit" value="Gerar" onclick="document.gera_retorno.action='gera_retorno.php'" class="button_busca" />&nbsp; 
		</td>
		</tr>
      </table>
        </center>

              <center>
			  <br><br>
       <table width="650" class="result_tabela"  cellpadding="4" cellspacing="1">
          <tr>
          <td class="tabela_tit"><strong>Data </strong></td>
		  <td class="tabela_tit"><strong>Arquivo </strong></td>
		  </tr>
				<?
				$sql = $objQuery->SQLQuery("SELECT r.* from vsites_retorno as r, vsites_user_usuario as uu where r.id_usuario=uu.id_usuario and uu.id_empresa='".$controle_id_empresa."' order by r.data desc limit 50");
				$p_valor = '';
				while($res = mysql_fetch_array($sql)){
					$p_valor .= '
					<tr>
						<td class="result_celula"> '.invert($res['data'],'/','PHP').'</td>
						<td class="result_celula"> <a href="download_retorno.php?id_retorno='.$res['id_retorno'].'">'.$res['arquivo'].'</a></td>
					</tr>';
				}		
				echo $p_valor;
				?>        
      </table>
        </center>
		
	</form>

</div>
<?php
	require('footer.php');
?>