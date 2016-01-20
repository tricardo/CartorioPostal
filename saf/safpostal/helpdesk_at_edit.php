<?
require "../includes/topo.php";
pt_register('GET','id');
$sql = $objQuery->SQLQuery("SELECT h.* FROM saf_helpdesk as h WHERE h.id_helpdesk='" . $id . "' and h.id_usuario='".$safpostal_id_usuario."'");
$num = mysql_num_rows($sql);

if($safpostal_id_empresa!='1' and $num=='0'){
      
	  echo 'Você não ter permissão de abrir esse chamado e será redirecionado<meta HTTP-EQUIV="refresh" CONTENT="5; URL=helpdesk_at_list.php">';
	  exit;
}
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
            <td width="345" height="20" align="left" valign="middle"><strong>Help Desk</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?
pt_register('POST','submit1');

if ($submit1){
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b> ";
	pt_register('POST','problema');
	pt_register('POST','status');
	if($problema==""){
		$errors=1;
		$error.="<span><br><br>Os campos com * são obrigatórios.</span>";
	}
	
	
    if($errors!=1) {	
	if($status!='on' and $safpostal_id_empresa=='1'){
		$query="UPDATE saf_helpdesk set status='Em andamento' WHERE id_helpdesk='".$id."'";
		$result = $objQuery->SQLQuery($query);
	}
	if($status=='on'){
		$query="UPDATE saf_helpdesk set status='Finalizado' WHERE id_helpdesk='".$id."'";
		$result = $objQuery->SQLQuery($query);
	}	
	
	$query="INSERT INTO saf_helpdesk_resp (id_helpdesk, id_usuario, problema, data) VALUES ('$id', '$safpostal_id_usuario', '$problema' ,NOW())";
	$result = $objQuery->SQLQuery($query);
	$done=1;
	}
}
?>
        <?
		$sql = $objQuery->SQLQuery("SELECT h.*, date_format(data, '%d/%m/%y no horário das %h:%m:%s') as data, d.departamento FROM saf_helpdesk as h, saf_departamento_permissao as d WHERE h.id_helpdesk='" . $id . "' and d.id_departamento_permissao = h.id_departamento");
		$res = mysql_fetch_array($sql);
		$titulo	       = $res['titulo'];
		$problema      = $res['problema'];
		$status	       = $res['status'];	
		$departamento  = $res['departamento'];
		$id_departamento  = $res['id_departamento'];
		$id_usuario  = $res['id_usuario'];
		$data	       = $res['data'];
				
        if($done!=1){

			if(($safpostal_id_empresa!='1' and $id_usuario == $safpostal_id_usuario or $safpostal_id_empresa=='1') and $status!='Finalizado'){
		?> 
        
        <table align="center" border="0" cellpadding="3" cellspacing="0" width="550">
        <tr>
        <tr>
          <td height="30" colspan="5" align="center" valign="middle">
          <a href="helpdesk_at_add.php" title="Clique aqui"><strong>Cadastrar chamada</strong></a> |
<a href="helpdesk_at_list.php" title="Clique aqui"><strong>Meus chamados</strong></a>          </td>
        </tr>
        </tr>
        </table>
        <form name="form_helpdesk_at_edit" action="" method="post" enctype="multipart/form-data">
        <table align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#0071B6">
        <tr>
        <td>
        <table align="center" border="0" cellpadding="3" cellspacing="0" width="550" bgcolor="#FFFFFF">
        <tr>
        <tr>
        <td height="50" colspan="2" align="center" valign="middle">
        <strong>EDITAR CHAMADAS</strong></td>
        </tr>
         <tr>
        <td height="2px"></td>
        </tr>
        <tr>
        <td valign="top"><strong>Resposta:</strong></td><td>
        <textarea name="problema" id="textarea" style="width:400px; height:100px;"></textarea><span style="color:#FF0000"> *</span></td>
        </tr>
        <tr>
        <td height="2px"></td>
        </tr>
        <tr>
        <td></td>
        <td><input type="checkbox" name="status" id="checkbox" /> Finalizar chamado</td>
        </tr>
        <tr>
        <td></td>
        <td>
        <input name="submit1" type="submit" class="botoes" value="Enviar" />
        <input name="Submit2" type="reset" class="botoes" value="Limpar" />
        </td>
        </tr>
        </table>
        </td>
        </tr>   
        </table>
    	</form>
        
        <?
			}

        }	
		if($status=='Finalizado')
		echo '<table border="0" align="center">
			  <tr>
			  <td><img src="../images/paginas/helpdesk/finalizado.png" width="114" height="38" /></td>
			  </tr>
			  </tabe>';	
		?>
        <table align="center" border="0" cellpadding="3" cellspacing="0" width="550">
        <tr>
        <td align="center">
        <?
		if ($errors) {
		echo '<div class="respotas_erro">'.$error.'</div>';
		}
		?>
        
        <?
		if ($done) {
		echo '<div class="respotas_sucesso">Registro efetuado com sucesso!</div>';
		}
		?>
        </td>
        </tr>   
        </table> 
        <strong>Chamado: </strong>Postado por <? echo $safpostal_nome ?> no dia <? echo $data ?> - 
        <strong>Status</strong>: <? echo $status ?><br />
        <div id="linha_h1"></div>        
        <div id="linha_h2"></div>       
        <strong>Título da Pergunta</strong>: <? echo $titulo ?><br />
         <div id="linha_h2"></div>  
		<strong>Pergunta</strong>: <? echo $problema ?>
        <div id="linha_h3"></div>
           
		<?	
		$sql = $objQuery->SQLQuery("SELECT h.*, uu.nome FROM saf_helpdesk_resp as h, vsites_user_usuario as uu WHERE h.id_helpdesk='". $id ."' and h.id_usuario=uu.id_usuario ORDER BY data");
		while($res = mysql_fetch_array($sql)){ 
		
		echo '<table border="0" width="100%" cellpadding="0" cellspacing="0" id="alter">';
		echo '<tr>';
		echo '<td height="20"><strong>Resposta: </strong>Postado por '.$res['nome'].' no dia '.$data.'</td>';
		echo '<tr>';
		echo '<tr class="dif">';
		echo '<td height="30">'.$res['problema'].'</td>';
		echo '<tr>';
		echo '</table>';
		
		}
?>
</table>
        </td>
      </tr>
    </table>
   </td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>