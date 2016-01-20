<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id_pedido_status');
		$sql 	= "SELECT a.atividade, ps.*  FROM vsites_pedido_status as ps, vsites_atividades as a  where ps.id_pedido_status='$id_pedido_status' and ps.id_atividade=a.id_atividade";
		$query 	= $objQuery->SQLQuery($sql);
		$res = mysql_fetch_array($query);
		if($res['status_dias']<>0 or $res['status_hora']!='00:00:00') {
			$data_agenda = somar_dias_uteis($res['data_i'],$res['status_dias']);
			$data_agenda = invert($data_agenda,'/','PHP').' '.$res['status_hora']; 
		}else{
			$data_agenda='';
		}	

?>
   <form enctype="multipart/form-data" action="" method="post" name="pedido_atividade_edit">
        <table width="650" class="tabela">
	  <tr>
                  <td colspan="4" class="tabela_tit"> Atividade <?= invert($res['data_i'],'/','PHP') ?></td>
      </tr>
	  
	   <tr>
                  <td width="150"> <div align="right"><strong>Atividade: </strong></div></td>
      <td colspan="3">
            <input type="text" class="form_estilo_r" name="atividade_atividade" readonly="readonly" value="<?= $res['atividade'] ?>" style="width:400px" />

		</td>
          </tr>
    <tr>
                  <td> <div align="right"><strong>Dias: </strong></div></td>
      <td colspan="3">
            <input type="text" class="form_estilo_r" readonly name="atividade_status_dias"  onKeyUp="masc_numeros(this,'###');" value="<?= $res['status_dias'] ?>" style="width:150px" /> 
			Hora: <input type="text" class="form_estilo_r" readonly name="atividade_status_hora" onKeyUp="masc_numeros(this,'##:##:##');" value="<?= $res['status_hora'] ?>" style="width:100px" /> <? if($res['status_dias']<>0) echo '<b>Agenda: </b>'. $data_agenda.' '.$res['status_hora']; ?>

		</td>
          </tr>		
		      <tr>
                  <td> <div align="right"><strong>Obs: </strong></div></td>
      <td colspan="3">
            <textarea class="form_estilo_r" readonly name="atividade_status_obs" style="width:400px; height:100px" /><?= $res['status_obs'] ?></textarea>

		</td>
          </tr>	
		      <tr>

      <td colspan="4">
		  
	<center>            
		<input type="hidden" name="id_pedido_status" value="<?= $res['id_pedido_status'] ?>" />
    </center>
		</td>
          </tr>	
			
	  </table>
   </form>

		
