<?
include('header.php');
pt_register('GET','id');
pt_register('GET','id_pedido_item');
	$sql = $objQuery->SQLQuery("SELECT * from vsites_pedido_item where id_pedido='" . $id . "' and id_pedido_item='" . $id_pedido_item . "' order by ordem");
	$res = mysql_fetch_array($sql);	
	$ordem					= $res['ordem'];
	
if($id=='' or $id_pedido_item=='' or $ordem==''){
	echo 'Procedimento Incorreto. Entre em contato com o suporte técnico!!!';
	exit;
}
?>
     
        	
<div style="margin:15px">
<h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" /> Ordem #<?= $id.'/'.$ordem ?></h1>
<hr class="tit"/><br />

<?

pt_register('POST','submit');


if ($submit) {
	$error="";
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','cartorio_estado');
	pt_register('POST','cartorio_cidade');
	pt_register('POST','cartorio_cartorio');
	pt_register('POST','cartorio_atribuicao');
	pt_register('POST','id_pedido_item');
	if(!$cartorio_cartorio){
		$errors=1;
		$error.="<li><b>Selecione um cartório.</b></li>";	
	}	
	if ($errors!=1) {		
		$query="insert into vsites_pedido_cartorio (id_pedido_item,id_usuario,data,cartorio_estado,cartorio_cidade,cartorio_atribuicao,cartorio_cartorio) values ('".$id_pedido_item."','".$controle_id_usuario."',NOW(),'".$cartorio_estado."','".$cartorio_cidade."','".$cartorio_atribuicao."','".$cartorio_cartorio."')";
		$result = $objQuery->SQLQuery($query);
		$done = '1';
	}	
?>
    <table border="0">
		<tr>
        	<td valign="top">
<?
	if ($errors) {
		echo $error;
	}
	if ($done) {
		?><h3>Registro atualizado com sucesso!</h3>
		<h3>O que você deseja fazer?</h3>
		<h3 style="margin:0"><img src="../images/seta.png" /> <a href="pedido.php">Visualizar Registros</a></h3>
		<?
	}	
	?> 
    		</td>
    	</tr>
    </table>
	<?		
}


	pt_register('GET','id');
	$sql = $objQuery->SQLQuery("SELECT * from vsites_pedido where id_pedido='" . $id . "'");
	$res = mysql_fetch_array($sql);
	$nome						= $res['nome'];
	$id_conveniado				= $res['id_conveniado'];
	$cpf						= $res['cpf'];
	$origem						= $res['origem'];
	$comissionado				= $res['comissionado'];
	$rg							= $res['rg'];
	$tipo						= $res['tipo'];
	$tel2						= $res['tel2'];
	$tel						= $res['tel'];
	$cel						= $res['cel'];
	$fax						= $res['fax'];
	$ramal						= $res['ramal'];
	$ramal2						= $res['ramal2'];
	$outros						= $res['outros'];
	$email						= $res['email'];
	$endereco					= $res['endereco'];
	$cidade						= $res['cidade'];
	$estado						= $res['estado'];
	$bairro						= $res['bairro'];
	$cep						= $res['cep'];
	$numero						= $res['numero'];
	$complemento				= $res['complemento'];
	$retem_iss					= $res['retem_iss'];

	$sql = $objQuery->SQLQuery("SELECT * from vsites_pedido_item where id_pedido='" . $id . "' and id_pedido_item='" . $id_pedido_item . "' order by ordem");
	$res = mysql_fetch_array($sql);	
	$ordem						= $res['ordem'];
	$id_servico					= $res['id_servico'];
	$obs						= $res['obs'];
	$certidao_orgao_emissor		= $res['certidao_orgao_emissor'];
	$certidao_matricula			= $res['certidao_matricula'];
	$certidao_cartorio			= $res['certidao_cartorio'];
	$certidao_marido			= $res['certidao_marido'];
	$certidao_esposa			= $res['certidao_esposa'];
	$certidao_nascimento		= $res['certidao_nascimento'];
	$certidao_casamento			= $res['certidao_casamento'];
	$certidao_cidade			= $res['certidao_cidade'];
	$certidao_estado			= $res['certidao_estado'];
	$certidao_rg				= $res['certidao_rg'];
	$certidao_cpf				= $res['certidao_cpf'];
	$certidao_naturalidade		= $res['certidao_naturalidade'];
	$certidao_transcricao		= $res['certidao_transcricao'];
	$certidao_proprietario		= $res['certidao_proprietario'];
	$certidao_registro			= $res['certidao_registro'];
	$certidao_data_registro		= $res['certidao_data_registro'];
	$certidao_obito				= $res['certidao_obito'];
	$certidao_livro				= $res['certidao_livro'];
	$certidao_folha				= $res['certidao_folha'];
	$certidao_termo				= $res['certidao_termo'];
	$certidao_nome				= $res['certidao_nome'];
	$certidao_cidade2			= $res['certidao_cidade2'];
	$certidao_estado2			= $res['certidao_estado2'];
	$certidao_mae				= $res['certidao_mae'];
	$certidao_pai				= $res['certidao_pai'];
	$id_servico_var				= $res['id_servico_var'];
	$dias						= $res['dias'];
	$valor						= $res['valor'];
	$id_servico_departamento	= $res['id_servico_departamento'];
	
	$sql = $objQuery->SQLQuery("SELECT departamento from vsites_servico_departamento where id_servico_departamento='$id_servico_departamento' order by departamento");
	$res = mysql_fetch_array($sql);
	$departamento				= $res['departamento'];
	
	$sql = $objQuery->SQLQuery("SELECT descricao from vsites_servico where id_servico='$id_servico'");
	$res = mysql_fetch_array($sql);
	$certidao_servico			= $res['descricao'];	
	
	$sql = $objQuery->SQLQuery("SELECT vsites_cartorio.nome from vsites_cartorio, vsites_pedido_cartorio where vsites_pedido_cartorio.id_pedido_item='$id_pedido_item' and vsites_cartorio.id_cartorio = vsites_pedido_cartorio.cartorio_cartorio order by id_pedido_cartorio DESC");
	$res = mysql_fetch_array($sql);
	$cartorio				= $res['nome'];	
	
	$sql = $objQuery->SQLQuery("SELECT vsites_status.status from vsites_pedido_status, vsites_atividades, vsites_status  where vsites_pedido_status.id_pedido_item='" . $id_pedido_item . "' and vsites_pedido_status.id_atividade=vsites_atividades.id_atividade and vsites_atividades.id_status = vsites_status.id_status");
	$res = mysql_fetch_array($sql);
	$pedido_status				= $res['status'];	
	
	$sql = $objQuery->SQLQuery("SELECT nome from vsites_user_usuario where id_usuario='$comissionado'");
	$res = mysql_fetch_array($sql);
	$comissionado_nome			= $res['nome'];	


	
	$certidao_nascimento 		= invert($certidao_nascimento,'/','PHP');
	$certidao_obito 			= invert($certidao_obito,'/','PHP');
	$certidao_casamento 		= invert($certidao_casamento,'/','PHP');
	$certidao_data_registro 	= invert($certidao_data_registro,'/','PHP');
	if($id_conveniado<>'') $conveniado = 'Conveniado'; else $conveniado='Não Conveniado';
?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">
		
          <blockquote>
            <form enctype="multipart/form-data" action="gera_pdf.php" method="post" name="pedido_print" target="_blank">
                         
       <table width="650" class="tabela">                       
	  <tr>
                  <td colspan="4" class="tabela_tit"> Selecione o Modelo da Impress&atilde;o</td>                  
      </tr>  

          <tr>
                  <td width="100"> <div align="right"><strong>Modelo: </strong></div></td>
      <td width="313" colspan="3">
        <input type="hidden" name="id_pedido" value="<?= $id ?>" />
        <input type="hidden" name="id_pedido_item" value="<?= $id_pedido_item ?>" />
        <input type="hidden" name="certidao_nome" value="<?= $certidao_nome ?>" />
        <input type="hidden" name="certidao_pai" value="<?= $certidao_pai ?>" />
        <input type="hidden" name="certidao_mae" value="<?= $certidao_mae ?>" />
        <input type="hidden" name="certidao_matricula" value="<?= $certidao_matricula ?>" />
        <input type="hidden" name="certidao_orgao_emissor" value="<?= $certidao_orgao_emissor ?>" />
        <input type="hidden" name="certidao_marido" value="<?= $certidao_marido ?>" />
        <input type="hidden" name="certidao_esposa" value="<?= $certidao_esposa ?>" />
        <input type="hidden" name="certidao_estado" value="<?= $certidao_estado ?>" />
        <input type="hidden" name="certidao_cidade" value="<?= $certidao_cidade ?>" />
        <input type="hidden" name="certidao_nascimento" value="<?= $certidao_nascimento ?>" />
        <input type="hidden" name="certidao_casamento" value="<?= $certidao_casamento ?>" />
        <input type="hidden" name="certidao_cpf" value="<?= $certidao_cpf ?>" />
        <input type="hidden" name="certidao_rg" value="<?= $certidao_rg ?>" />
        <input type="hidden" name="certidao_naturalidade" value="<?= $certidao_naturalidade ?>" />
        <input type="hidden" name="certidao_transcricao" value="<?= $certidao_transcricao ?>" />
        <input type="hidden" name="certidao_proprietario" value="<?= $certidao_proprietario ?>" />
        <input type="hidden" name="certidao_registro" value="<?= $certidao_registro ?>" />
        <input type="hidden" name="certidao_data_registro" value="<?= $certidao_data_registro ?>" />
        <input type="hidden" name="certidao_obito" value="<?= $certidao_obito ?>" />
        <input type="hidden" name="certidao_livro" value="<?= $certidao_livro ?>" />
        <input type="hidden" name="certidao_folha" value="<?= $certidao_folha ?>" />
        <input type="hidden" name="certidao_termo" value="<?= $certidao_termo ?>" />
        <input type="hidden" name="certidao_servico" value="<?= $certidao_servico ?>" />


        <select name="tipo_impresso" style="width:470px" onchange="carrega_cartorio_texto(this.value);" class="form_estilo">
        	<option value=""></option>
	        <option value="FAX">FAX</option>
        </select></td></tr>
	  <tr>
                  <td colspan="4" class="tabela_tit"> Cart&oacute;rio</td>                  
      </tr>        
          <tr>
                  <td width="100"> <div align="right"><strong>Atribui&ccedil;&atilde;o: </strong></div></td>
      <td colspan="3">
      <select name="cartorio_atribuicao" style="width:150px" class="form_estilo">
      <?
      	$sql = $objQuery->SQLQuery("SELECT * from vsites_cartorio_atribuicoes");
		while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['id_atribuicao'].'" >'.$res['atribuicao'].'</option>';
		}
	  ?>	</select>

        <strong>Estado: </strong> 
        
              <select name="cartorio_estado" style="width:150px" class="form_estilo" onchange="carrega_cartorio_cidade(this.value,cartorio_atribuicao.value)">
              <option value=""></option>
      <?
      	$sql = $objQuery->SQLQuery("SELECT distinct estado from vsites_cartorio order by estado");
		while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['estado'].'" >'.$res['estado'].'</option>';
		}
	  ?>	</select></td>
          </tr>             
               <tr>
                  <td width="100"> <div align="right"><strong>Cidade: </strong></div></td>
      <td colspan="3">
            <select name="cartorio_cidade" id="cartorio_cidade" style="width:470px" class="form_estilo" onchange="carrega_cartorio_impressao(cartorio_estado.value,cartorio_atribuicao.value,this.value)">
      		</select>
        <font color="#FF0000">*</font></td></tr>
               <tr>
                  <td width="100"> <div align="right"><strong>Cartório: </strong></div></td>
      <td colspan="3">
            <select name="cartorio" id="cartorio_impressao" style="width:470px" class="form_estilo">
      		</select><font color="#FF0000">*</font>

      		
        </td>
        </tr>                
         
          <tr>
      <td colspan="4" align="center">
        <input type="submit" name="submit" value="Imprimir" class="button_busca" />&nbsp;  <input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_print.target='_self'; document.pedido_print.action='pedido.php'" class="button_busca" /></td></tr>           
      </table>
              
            </form>
      </blockquote></td>
</tr>
</table>

<?php 
include('footer.php');
?>
