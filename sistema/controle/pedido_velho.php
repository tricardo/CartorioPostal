<?
require('header.php');
require('../includes/dias_uteis.php');
$p_valor ='';
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$servicoDAO 	= new ServicoDAO();
$pedidoDAO 		= new PedidoDAO();
$statusDAO 		= new StatusDAO();
$atividadeDAO 	= new AtividadeDAO();
$departamentoDAO= new DepartamentoDAO();
$usuarioDAO		= new UsuarioDAO();
$empresaDAO		= new EmpresaDAO();

pt_register('GET','busca_submit');
if($busca_submit<>''){
    pt_register('GET','busca_id_status');
    pt_register('GET','busca_id_usuario');
    pt_register('GET','busca_id_usuario_op');
    pt_register('GET','busca_id_atividade');
    pt_register('GET','busca_id_servico');
    pt_register('GET','busca_id_pedido');
    pt_register('GET','busca_id_empresa');
    pt_register('GET','busca_ordem');
    pt_register('GET','busca_ordenar');
    pt_register('GET','busca');
    pt_register('GET','busca_id_departamento');
    pt_register('GET','busca_origem');
    pt_register('GET','busca_data_i');
    pt_register('GET','busca_data_f');
    pt_register('GET','busca_data_i_a');
    pt_register('GET','busca_data_f_a');
    pt_register('GET','busca_data_i_co');
    pt_register('GET','busca_data_f_co');
    pt_register('GET','busca_ord');
    pt_register('GET','busca_exibicao');
    pt_register('GET','busca_e_conclu');
    pt_register('GET','busca_e_inicio');
    pt_register('GET','busca_e_prazo');
    pt_register('GET','busca_e_agenda');
    pt_register('GET','busca_e_data_atividade');
    pt_register('GET','busca_e_valor');
    pt_register('GET','busca_e_departamento');
    pt_register('GET','busca_e_servico');
    pt_register('GET','busca_e_cidade');
    pt_register('GET','busca_e_estado');
    pt_register('GET','busca_e_status');
    pt_register('GET','busca_e_atividade');
    pt_register('GET','busca_e_responsavel');
    pt_register('GET','busca_e_atendimento');
    pt_register('GET','busca_e_devedor');
    pt_register('GET','estado_dir');
    if($estado_dir[0]!='Todos'){
		for($i=0;$i<count($estado_dir);$i++){
			$estado_dir2.="'".$estado_dir[$i]."',";
		}
    }
   
   #grava secao da busca
   $_SESSION['p_busca_id_status'] 		= $busca_id_status;
   $_SESSION['p_busca_id_usuario'] 		= $busca_id_usuario;
   $_SESSION['p_busca_id_empresa'] 		= $busca_id_empresa;
   $_SESSION['p_busca_id_usuario_op'] 	= $busca_id_usuario_op;
   $_SESSION['p_busca_id_atividade'] 	= $busca_id_atividade;
   $_SESSION['p_busca_id_servico'] 		= $busca_id_servico;
   $_SESSION['p_busca'] 				= $busca;
   $_SESSION['p_busca_ordenar'] 		= $busca_ordenar;
   $_SESSION['p_busca_id_departamento'] = $busca_id_departamento;
   $_SESSION['p_busca_origem'] 			= $busca_origem;
   $_SESSION['p_busca_ord'] 			= $busca_ord;   
   $_SESSION['p_busca_data_i'] 			= $busca_data_i;
   $_SESSION['p_busca_data_f'] 			= $busca_data_f;  
   $_SESSION['p_busca_data_i_co'] 		= $busca_data_i_co;
   $_SESSION['p_busca_data_f_co'] 		= $busca_data_f_co;  
   $_SESSION['p_busca_exibicao'] 		= $busca_exibicao;
   setcookie ("p_busca_e_inicio", $busca_e_inicio);
   setcookie ("p_busca_e_conclu", $busca_e_conclu);
   setcookie ("p_busca_e_prazo", $busca_e_prazo);
   setcookie ("p_busca_e_agenda", $busca_e_agenda);
   setcookie ("p_busca_e_data_atividade", $busca_e_data_atividade);
   setcookie ("p_busca_e_valor", $busca_e_valor);
   setcookie ("p_busca_e_departamento", $busca_e_departamento);
   setcookie ("p_busca_e_servico", $busca_e_servico);
   setcookie ("p_busca_e_cidade", $busca_e_cidade);
   setcookie ("p_busca_e_estado", $busca_e_estado);
   setcookie ("p_busca_e_status", $busca_e_status);
   setcookie ("p_busca_e_atividade", $busca_e_atividade);
   setcookie ("p_busca_e_responsavel", $busca_e_responsavel);
   setcookie ("p_busca_e_atendimento", $busca_e_atendimento);
   setcookie ("p_busca_e_devedor", $busca_e_devedor);
   $_SESSION['estado_dir']				= $estado_dir2;
}else{
   $busca_id_status 		= $_SESSION['p_busca_id_status'] ;
   $busca_id_usuario		= $_SESSION['p_busca_id_usuario'] ;
   $busca_id_empresa		= $_SESSION['p_busca_id_empresa'] ;
   $busca_id_usuario_op		= $_SESSION['p_busca_id_usuario_op'] ;
   $busca_id_atividade		= $_SESSION['p_busca_id_atividade'] ;
   $busca_id_servico		= $_SESSION['p_busca_id_servico'] ;
   $busca_ordenar			= $_SESSION['p_busca_ordenar'] ;
   $busca_ord				= $_SESSION['p_busca_ord'] ;
   $busca					= $_SESSION['p_busca'] ;
   $busca_ordem 			= '' ;
   $busca_id_departamento	= $_SESSION['p_busca_id_departamento'] ;
   $busca_origem			= $_SESSION['p_busca_origem'] ;
   $busca_data_i			= $_SESSION['p_busca_data_i'] ;
   $busca_data_f			= $_SESSION['p_busca_data_f'] ;
   $busca_data_i_co			= $_SESSION['p_busca_data_i_co'];
   $busca_data_f_co			= $_SESSION['p_busca_data_f_co'];
   $busca_exibicao   		= $_SESSION['p_busca_exibicao'] ;
   $busca_e_conclu	   		= $_COOKIE['p_busca_e_conclu'] ;
   $busca_e_inicio   		= $_COOKIE['p_busca_e_inicio'] ;
   $busca_e_prazo   		= $_COOKIE['p_busca_e_prazo'] ;
   $busca_e_agenda   		= $_COOKIE['p_busca_e_agenda'] ;
   $busca_e_data_atividade 	= $_COOKIE['p_busca_e_data_atividade'] ;
   $busca_e_valor   		= $_COOKIE['p_busca_e_valor'] ;
   $busca_e_departamento   	= $_COOKIE['p_busca_e_departamento'] ;
   $busca_e_servico   		= $_COOKIE['p_busca_e_servico'] ;
   $busca_e_cidade  		= $_COOKIE['p_busca_e_cidade'] ;
   $busca_e_estado   		= $_COOKIE['p_busca_e_estado'] ;
   $busca_e_status   		= $_COOKIE['p_busca_e_status'] ;
   $busca_e_atividade   	= $_COOKIE['p_busca_e_atividade'] ;
   $busca_e_responsavel   	= $_COOKIE['p_busca_e_responsavel'] ;
   $busca_e_atendimento   	= $_COOKIE['p_busca_e_atendimento'] ;
   $busca_e_devedor	   		= $_COOKIE['p_busca_e_devedor'] ;
   $estado_dir2		   		= $_SESSION['estado_dir'] ;
   $estado_dir2 			= str_replace('\\','',$estado_dir2);

}

if($busca_id_pedido and $busca_ordem){
    echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=pedido_edit.php?id='.$busca_id_pedido.'&ordem='.$busca_ordem.'">';
    exit;
}

if($busca_e_prazo<>'') $busca_e_prazo=''; else $busca_e_prazo='on';
if($busca_e_conclu<>'') $busca_e_conclu=''; else $busca_e_conclu='on'; 
if($busca_e_inicio<>'') $busca_e_inicio=''; else $busca_e_inicio='on'; 
if($busca_e_agenda<>'') $busca_e_agenda=''; else $busca_e_agenda='on';
if($busca_e_data_atividade<>'') $busca_e_data_atividade=''; else $busca_e_data_atividade='on';
if($busca_e_valor<>'') $busca_e_valor=''; else $busca_e_valor='on';
if($busca_e_departamento<>'') $busca_e_departamento=''; else $busca_e_departamento='on';
if($busca_e_servico<>'') $busca_e_servico=''; else $busca_e_servico='on';
if($busca_e_cidade<>'') $busca_e_cidade=''; else $busca_e_cidade='on';
if($busca_e_estado<>'') $busca_e_estado=''; else $busca_e_estado='on';
if($busca_e_status<>'') $busca_e_status=''; else $busca_e_status='on';
if($busca_e_atividade<>'') $busca_e_atividade=''; else $busca_e_atividade='on';
if($busca_e_responsavel<>'') $busca_e_responsavel=''; else $busca_e_responsavel='on';
if($busca_e_atendimento<>'') $busca_e_atendimento=''; else $busca_e_atendimento='on';
if($busca_e_devedor<>'') $busca_e_devedor=''; else $busca_e_devedor='on';

if($busca_data_i <> '') $busca_data_i = invert($busca_data_i,'-','SQL'); else
$busca_data_i = date('Y-m-d',strtotime("- 1 year"));

if($busca_data_f <> '') $busca_data_f = invert($busca_data_f,'-','SQL'); else
$busca_data_f = date('Y-m-d');

if($busca_data_i_a <> '') $busca_data_i_a = invert($busca_data_i_a,'-','SQL'); else
$busca_data_i_a = date('Y-m-d',strtotime("- 1 year"));
if($busca_data_f_a <> '') $busca_data_f_a = invert($busca_data_f_a,'-','SQL'); else
$busca_data_f_a = date('Y-m-d');


if($busca_data_i_co <> '') $busca_data_i_co = invert($busca_data_i_co,'-','SQL');
if($busca_data_f_co <> '') $busca_data_f_co = invert($busca_data_f_co,'-','SQL');

if($busca_id_usuario=='' and in_array('6',$departamento_p)==1){
   $busca_id_usuario = $controle_id_usuario;
}

if($busca_id_usuario=='_'){
   $busca_id_usuario = '';
}

if(in_array('1',$departamento_p)!=1 and $busca_id_usuario_op=='' and $busca_id_usuario=='' and (in_array('3',$departamento_p)==1 or in_array('4',$departamento_p)==1 or in_array('5',$departamento_p)==1 or in_array('8',$departamento_p)==1 or in_array('9',$departamento_p)==1 or in_array('11',$departamento_p)==1 or in_array('12',$departamento_p)==1)){
   $busca_id_usuario_op = $controle_id_usuario;
}

if($busca_id_usuario_op=='_'){
   $busca_id_usuario_op = '';
}

if($busca_id_empresa=='_'){
   $busca_id_empresa = '';
}

if($busca_ord=='Decr') 				$busca_ordenar_por_o.= ' DESC ';

$busca_ordenar_por=' pi.id_pedido '.$busca_ordenar_por_o.', pi.ordem '.$busca_ordenar_por_o;
if($busca_ordenar=='Documento de') 	$busca_ordenar_por = ' pi.certidao_nome '.$busca_ordenar_por_o; else
if($busca_ordenar=='Ordem') 		$busca_ordenar_por = ' pi.id_pedido '.$busca_ordenar_por_o.', pi.ordem '.$busca_ordenar_por_o; else
if($busca_ordenar=='Serviço') 		$busca_ordenar_por = ' pi.id_servico '.$busca_ordenar_por_o; else
if($busca_ordenar=='Data') 			$busca_ordenar_por = ' pi.data '.$busca_ordenar_por_o; else
if($busca_ordenar=='Cidade') 		$busca_ordenar_por = ' pi.certidao_estado '.$busca_ordenar_por_o.', pi.certidao_cidade '.$busca_ordenar_por_o; else
if($busca_ordenar=='Estado') 		$busca_ordenar_por = ' pi.certidao_estado '.$busca_ordenar_por_o; else
if($busca_ordenar=='Departamento') 	$busca_ordenar_por = ' pi.id_servico_departamento '.$busca_ordenar_por_o; else
if($busca_ordenar=='Prazo') 		$busca_ordenar_por = ' pi.data_prazo '.$busca_ordenar_por_o; else
if($busca_ordenar=='Data Status') 	$busca_ordenar_por = ' pi.data_atividade '.$busca_ordenar_por_o; else
if($busca_ordenar=='Agenda') 		$busca_ordenar_por = ' pi.data_i, pi.status_hora '.$busca_ordenar_por_o;

$onde='';

if($busca_id_empresa<>''){
	if($busca_id_empresa=='minha'){
		$onde .= " and pi.id_empresa_resp != '".$controle_id_empresa."' and u.id_empresa='".$controle_id_empresa."'"; 
	} else {
		if($busca_id_empresa=='naominha'){
			$onde .= " and pi.id_empresa_resp != '0' and pi.id_empresa_resp != '".$controle_id_empresa."' ";
		} else {
			if($busca_id_empresa=='naominha_r'){
				$onde .= " and pi.id_empresa_resp != '0' and pi.id_empresa_resp = '".$controle_id_empresa."' ";
			} else {
				$onde .= " and pi.id_empresa_resp = '".$busca_id_empresa."' ";
			}	
		}		
	}	
}

if($estado_dir2<>''){ $onde .= " and pi.certidao_estado IN (".$estado_dir2."'SS') "; }
if($busca_id_pedido<>''){   $onde .= " and pi.id_pedido='".$busca_id_pedido."'"; }
if($busca_id_servico<>''){  $onde .= " and pi.id_servico='".$busca_id_servico."'"; }
if($busca_origem<>''){      $onde .= " and p.origem='".$busca_origem."'"; }
if($busca_data_i<>''){      $onde .= " and pi.data>='".$busca_data_i." 00:00:00'"; }
if($busca_data_f<>''){      $onde .= " and pi.data<='".$busca_data_f." 23:59:59'"; }
if($busca_data_i_co<>''){      $onde .= " and pi.operacional>='".$busca_data_i_co."'"; }
if($busca_data_f_co<>''){      $onde .= " and pi.operacional<='".$busca_data_f_co."'"; }
if($busca_data_i_a<>''){ 	$onde .= " and pi.data_atividade>='".$busca_data_i_a." 00:00:00'"; }
if($busca_data_f_a<>''){ $onde .= " and pi.data_atividade<='".$busca_data_f_a." 23:59:59'"; }
if($busca_id_departamento<>''){ $onde .= " and pi.id_servico_departamento='".$busca_id_departamento."'"; }
if($busca_id_atividade<>''){ $onde .= " and pi.id_atividade='".$busca_id_atividade."'"; }
if($busca_id_status=='') $busca_id_status='3';
if($busca_id_status=='Todos') $busca_id_status='';
if($busca_id_status=='Cad/Sol/Des/Exe/Par/Ret'){ 
	$onde .= " and pi.id_status IN ('3','4','5','6','7','15')"; 
}else{
	if($busca_id_status=='Cad/Sol/Des/Exe/Ret'){ 
		$onde .= " and pi.id_status IN ('3','4','5','6','7')"; 
	}else{
		if($busca_id_status<>''){ $onde .= " and pi.id_status='".$busca_id_status."'"; }
		else { 
			if($busca<>'' or $busca_data_i_co<>'') $onde .= " and pi.id_status!='14' "; 
			else $onde .= " and pi.id_status!='14' and pi.id_status!='10' ";
		}
	}	
}

#trava a exibição os pedidos que estão sendo executados por outra empresa
if(($busca_id_status=='3' or $busca_id_status=='4' or $busca_id_status=='5' or $busca_id_status=='6' or $busca_id_status=='7' or $busca_id_status=='15' or $busca_id_status=='Cad/Sol/Des/Exe/Ret' or $busca_id_status=='Cad/Sol/Des/Exe/Par/Ret') and $busca_id_empresa==''){
	$onde .= " and (pi.id_empresa_resp=0 or pi.id_empresa_resp='".$controle_id_empresa."' and pi.operacional='0000-00-00' or pi.id_empresa_resp<>'' and pi.id_empresa_resp!='".$controle_id_empresa."' and pi.operacional!='0000-00-00')";
}

if($busca_id_usuario<>''){ $onde .= " and pi.id_usuario='".$busca_id_usuario."'"; }
if($busca_id_usuario_op<>''){ $onde .= " and (pi.id_usuario_op='".$busca_id_usuario_op."' or pi.id_usuario_op2='".$busca_id_usuario_op."' and pi.id_empresa_resp<>'' and pi.id_empresa_resp!='".$controle_id_empresa."')"; }
if($busca<>''){ $onde .= " and (pi.certidao_cidade like '".$busca."%' and p.nome like '".$busca."%' or pi.certidao_devedor like '".$busca."%' or pi.certidao_pai like '".$busca."%' or pi.certidao_mae like '".$busca."%' or pi.certidao_esposa like '".$busca."%' or pi.certidao_marido like '".$busca."%'  or p.nome like '".$busca."%' or pi.certidao_nome like '".$busca."%' or pi.certidao_cidade like '".$busca."%' or replace(replace(replace(pi.certidao_cnpj,'.',''),'-',''),'/','') = '".$busca."' or replace(replace(replace(pi.certidao_cpf,'.',''),'-',''),'/','') = '".$busca."' or replace(replace(replace(p.cpf,'.',''),'-',''),'/','') = '".$busca."' or p.email = '".$busca."') "; }
?>
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" /> Ordem</h1>
    <a href="#" class="topo">topo</a><br />
    <hr class="tit"/>
</div>
<div id="meio">
<table border="0" height="100%" width="100%" >
<tr>
	<td valign="top">
<? 
pt_register('POST','submit_exporta');
if($submit_exporta <> ''){
   require('../includes/exporta_csv.php');
   echo '<br><br><a href="pedido.php">Clique aqui para voltar</a>';
   exit;
}

pt_register('POST','submit_exporta_txt');
if($submit_exporta_txt <> ''){
   require('../includes/exporta_txt.php');
   echo '<br><br><a href="pedido.php">Clique aqui para voltar</a>';
   exit;
}

pt_register('POST','submit_protocolo');
if($submit_protocolo <> ''){
   require('../includes/pedido_protocolo.php');
   echo '<br><br><a href="pedido.php">Clique aqui para voltar</a>';
   exit;
}

pt_register('POST','submit_oficio');
if($submit_oficio <> ''){
   require('../includes/pedido_oficio.php');
}

pt_register('POST','submit_fax');
if($submit_fax <> ''){
   require('../includes/pedido_fax.php');
}

pt_register('POST','submit_2via');
if($submit_2via <> ''){
   require('../includes/pedido_2via.php');
}

pt_register('POST','submit_etiqueta');
if($submit_etiqueta <> ''){
   require('../includes/pedido_etiqueta.php');
}

pt_register('POST','submit_direcionamento');
if($submit_direcionamento <> ''){
   require('../includes/pedido_direcionamento.php');
}

pt_register('POST','submit_direcionamento_aplica');
if($submit_direcionamento_aplica <> ''){
   require('../includes/pedido_direcionamento_aplica.php');
}

pt_register('POST','submit_processos');
if($submit_processos <> ''){
   require('../includes/pedido_processos.php');
   exit;
}

pt_register('POST','submit_imoveis_busca');
if($submit_imoveis_busca <> ''){
   require('../includes/pedido_imoveis_busca.php');
   exit;
}

pt_register('POST','submit_desembolso');
if($submit_desembolso <> ''){
   require("../includes/pedido_desembolso.php");
   exit;   
}

pt_register('POST','submit_financeiro');
if ($submit_financeiro) {
	require("../includes/pedido_desembolso_conf.php");
	echo '<a href="pedido.php">Clique aqui para voltar</a>';
	exit;
}

pt_register('POST','submit_acao');
if($submit_acao <> ''){
    require("../includes/pedido_atividades.php");
}

pt_register('POST','submit_status');
if($submit_status){
    require("../includes/pedido_atividades_aplica.php");
}	

?>	
    <form name="buscador" action="" method="get" ENCTYPE="multipart/form-data">
		<div style="float:left">    
			<img src="../images/lupa.png" alt="busca" />
        </div>
        <div style="float:left; width:320px; text-align:right">
			<label style="width:70px; font-weight:bold; padding-top:5px; float:left">Buscar: </label>
            <input type="text" class="form_estilo" name="busca" value="<?= $busca ?>" style="width:200px; float:left" /><br />
            <label style="width:70px; font-weight:bold; padding-top:5px; float:left">Servico: </label>
            <select name="busca_id_servico" style="width:200px; float:left" class="form_estilo">
                <option value="">Todos</option>
                <?
					$p_valor = '';
					$var = $servicoDAO->lista();
                    foreach($var as $s){
                        $p_valor .= '<option value="'.$s->id_servico.'"';
						if($busca_id_servico==$s->id_servico) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.$s->descricao.'</option>';
                    }
					echo $p_valor;
                ?>
            </select> <br />	
            <label style="width:70px; font-weight:bold; padding-top:5px; float:left">Origem: </label>
            <select name="busca_origem" style="width:200px; float:left" class="form_estilo">
                <option value="">Todos</option>
				<?
					$p_valor = '';
					$var = $pedidoDAO->listarOrigem();
                    foreach($var as $s){
                        $p_valor .= '<option value="'.$s->origem.'"';
						if($busca_origem==$s->origem) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.$s->origem.'</option>';
                    }
					echo $p_valor;
                ?>
            </select> <br />			
            <label style="width:70px; font-weight:bold; padding-top:5px; float:left">Status: </label>
            <select name="busca_id_status" style="width:200px; float:left" class="form_estilo">
                <option value="Todos">Todos</option>
                <option value="Cad/Sol/Des/Exe/Ret" <? if($busca_id_status == 'Cad/Sol/Des/Exe/Ret') echo 'selected'; ?>>Cad/Sol/Des/Exe/Ret</option>
                <option value="Cad/Sol/Des/Exe/Par/Ret" <? if($busca_id_status == 'Cad/Sol/Des/Exe/Par/Ret') echo 'selected'; ?>>Cad/Sol/Des/Exe/Par/Ret</option>
				<?
					$p_valor = '';
					$var = $statusDAO->listarTodos();
                    foreach($var as $s){
                        $p_valor .= '<option value="'.$s->id_status.'"';
						if($busca_id_status==$s->id_status) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.$s->status.'</option>';
                    }
					echo $p_valor;
                ?>        
            </select> <br />
            <label style="width:70px; font-weight:bold; padding-top:5px; float:left">Atividade: </label>
            <select name="busca_id_atividade" style="width:200px; float:left" class="form_estilo">
                <option value="" <? if($busca_id_atividade=='') echo ' selected="selected" '; ?>>Todos</option>
                <?
					$p_valor = '';
					$var = $atividadeDAO->listaAtividadesTodas();
                    foreach($var as $s){
                        $p_valor .= '<option value="'.$s->id_atividade.'"';
						if($busca_id_atividade==$s->id_atividade) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.$s->atividade.'</option>';
                    }
					echo $p_valor;
                ?>
            </select> <br />

			<label style="width:70px; font-weight:bold; padding-top:5px; float:left">Exibição: </label>
            <select name="busca_exibicao" style="width:200px; float:left" class="form_estilo">
                <option value="" <? if($busca_exibicao=='') echo ' selected="selected" '; ?>>Serviço</option>
                <option value="Ordem" <? if($busca_exibicao=='Ordem') echo ' selected="selected" '; ?>>Ordem</option>
                <option value="Atraso" <? if($busca_exibicao=='Atraso') echo ' selected="selected" '; ?>>Atraso</option>
                <option value="Atraso Operacional" <? if($busca_exibicao=='Atraso Operacional') echo ' selected="selected" '; ?>>Atraso Operacional</option>
            </select> <br />						

            <label style="width:70px; font-weight:bold; padding-top:5px; float:left">Ordem: </label>
            <input type="text" name="busca_id_pedido" value="<?= $busca_id_pedido ?>" style="width:90px; float:left" class="form_estilo" />
            <label style="width:60px; font-weight:bold; padding-top:5px; float:left">Serviço: </label>
            <input type="text" name="busca_ordem" value="<?= $busca_ordem ?>" style="width:50px; float:left" class="form_estilo" />
		 </div>
         <div style="float:left; width:290px; text-align:right">
            <strong>Departamento: </strong>
            <select name="busca_id_departamento" style="width:200px" class="form_estilo">
                <option value="" <? if($busca_id_departamento=='') echo ' selected="selected" '; ?>>Todos</option>
                <?
					$p_valor = '';
					$var = $departamentoDAO->listarDptoOrdem();
                    foreach($var as $s){
                        $p_valor .= '<option value="'.$s->id_servico_departamento.'"';
						if($busca_id_departamento==$s->id_servico_departamento) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.$s->departamento.'</option>';
                    }
					echo $p_valor;
                ?>
            </select>
            <strong>Atendente: </strong>
            <select name="busca_id_usuario" style="width:200px" class="form_estilo">
                <option value="_" <? if($busca_id_usuario=='') echo ' selected="selected" '; ?>>Todos</option>
                <?
					$p_valor = '';
					$var = $usuarioDAO->listarAtendentes($controle_id_empresa);
                    foreach($var as $s){
                        $p_valor .= '<option value="'.$s->id_usuario.'"';
						if($busca_id_usuario==$s->id_usuario) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.$s->nome.'</option>';
                    }
					echo $p_valor;
                ?>        
            </select>
					
            <strong>Responsável: </strong>
            <select name="busca_id_usuario_op" style="width:200px" class="form_estilo">
                <option value="_" <? if($busca_id_usuario_op=='') echo ' selected="selected" '; ?>>Todos</option>
                <?
					$p_valor = '';
					$var = $usuarioDAO->listarOp($controle_id_empresa);
                    foreach($var as $s){
                        $p_valor .= '<option value="'.$s->id_usuario.'"';
						if($busca_id_usuario_op==$s->id_usuario) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.$s->nome.'</option>';
                    }
					echo $p_valor;
                ?>        
            </select>
			
            <strong>Unidade: </strong>
            <select name="busca_id_empresa" style="width:200px" class="form_estilo">
                <option value="" <? if($busca_id_empresa=='') echo ' selected="selected" '; ?>>Todas Unidades</option>
				<option value="minha" <? if($busca_id_empresa=='minha') echo ' selected="selected" '; ?>>Minha Unidade</option>
				<option value="naominha" <? if($busca_id_empresa=='naominha') echo 'selected="select"'; ?>>Minha Unidade (Enviado)</option>
                <option value="naominha_r" <? if($busca_id_empresa=='naominha_r') echo 'selected="select"'; ?>>Outras Unidades (Recebido)</option>
                <?
 					$p_valor = '';
					$var = $empresaDAO->listarTodasN($controle_id_empresa);
                    foreach($var as $s){
                        $p_valor .= '<option value="'.$s->id_empresa.'"';
						if($busca_id_empresa==$s->id_empresa) $p_valor .= ' selected="selected" ';
						$p_valor .=  ' >'.str_replace('Cartório Postal - ','',$s->fantasia).'</option>';
                    }
					echo $p_valor;
                 ?>        
            </select>

            <strong>Aberto Entre: </strong>
            <input type="text" name="busca_data_i" value="<? if($busca_data_i <> '') echo invert($busca_data_i,'/','PHP'); ?>" style="width:90px;" class="form_estilo" />
            <strong>e </strong>
            <input type="text" name="busca_data_f"  value="<?  if($busca_data_f <> '') echo invert($busca_data_f,'/','PHP'); ?>" style="width:90px;" class="form_estilo" />
			<br>
            <strong>Alterado Entre: </strong>
            <input type="text" name="busca_data_i_a" value="<? if($busca_data_i_a <> '') echo invert($busca_data_i_a,'/','PHP'); ?>" style="width:90px;" class="form_estilo" />
            <strong>e </strong>
            <input type="text" name="busca_data_f_a"  value="<?  if($busca_data_f_a <> '') echo invert($busca_data_f_a,'/','PHP'); ?>" style="width:90px;" class="form_estilo" />
            <strong>Conc. Oper.: </strong>
            <input type="text" name="busca_data_i_co" value="<? if($busca_data_i_co <> '') echo invert($busca_data_i_co,'/','PHP'); ?>" style="width:90px;" class="form_estilo" />
            <strong>e </strong>
            <input type="text" name="busca_data_f_co"  value="<?  if($busca_data_f_co <> '') echo invert($busca_data_f_co,'/','PHP'); ?>" style="width:90px;" class="form_estilo" />

            
            


            <label style="width:85px; font-weight:bold; padding-top:5px; float:left">Ordenar Por: </label>
            <select name="busca_ordenar" style="width:150px; float:left" class="form_estilo">
                <option value="" <? if($busca_ordenar=='') echo ' selected="selected" '; ?>></option>
				<option value="Ordem" <? if($busca_ordenar=='Ordem') echo ' selected="selected" '; ?>>Ordem</option>
				<option value="Documento de" <? if($busca_ordenar=='Documento de') echo ' selected="selected" '; ?>>Documento de</option>
				<option value="Data" <? if($busca_ordenar=='Data') echo ' selected="selected" '; ?>>Data</option>
				<option value="Departamento" <? if($busca_ordenar=='Departamento') echo ' selected="selected" '; ?>>Departamento</option>
				<option value="Serviço" <? if($busca_ordenar=='Serviço') echo ' selected="selected" '; ?>>Serviço</option>
				<option value="Estado" <? if($busca_ordenar=='Estado') echo ' selected="selected" '; ?>>Estado</option>
				<option value="Cidade" <? if($busca_ordenar=='Cidade') echo ' selected="selected" '; ?>>Cidade</option>
				<option value="Prazo" <? if($busca_ordenar=='Prazo') echo ' selected="selected" '; ?>>Prazo</option>
                <option value="Agenda" <? if($busca_ordenar=='Agenda') echo ' selected="selected" '; ?>>Agenda</option>
				<option value="Data Status" <? if($busca_ordenar=='Data Status') echo ' selected="selected" '; ?>>Data Status</option>
            </select>
            <select name="busca_ord" style="width:50px; padding-top:5px; float:left" class="form_estilo">
                <option value="" <? if($busca_ord=='') echo ' selected="selected" '; ?>>Cres</option>
				<option value="Decr" <? if($busca_ord=='Decr') echo ' selected="selected" '; ?>>Decr</option>			
            </select> <br />	
			<input type="submit" name="busca_submit" class="button_busca" value=" Buscar " />
        	
        </div>
        <div style="float:left; width:150px; text-align:right">
			<b><a href="#" onclick="if(document.getElementById('selecionar_campos').style.visibility=='hidden') document.getElementById('selecionar_campos').style.visibility='visible'; else document.getElementById('selecionar_campos').style.visibility='hidden';">Selecionar colunas</a></b><br>
			<div style="width:150px; float:left; text-align:left; height:140px; visibility:hidden; overflow:scroll" class="form_estilo" id="selecionar_campos">
				<input type="checkbox" name="busca_e_todos" onclick="if(this.checked==1) { selecionar_campos('pedidos'); } else{ deselecionar_campos('pedidos'); }" />Todos
				<br><input type="checkbox" name="busca_e_inicio" <? if($busca_e_inicio=='') echo 'checked' ?> />Início
				<br><input type="checkbox" name="busca_e_prazo" <? if($busca_e_prazo=='') echo 'checked' ?> />Prazo
				<br><input type="checkbox" name="busca_e_conclu" <? if($busca_e_conclu=='') echo 'checked' ?> />Concluído Oper.
				<br><input type="checkbox" name="busca_e_agenda" <? if($busca_e_agenda=='') echo 'checked' ?> />Agenda
				<br><input type="checkbox" name="busca_e_data_atividade" <? if($busca_e_data_atividade=='') echo 'checked' ?> />Data do Status
				<br><input type="checkbox" name="busca_e_valor" <? if($busca_e_valor=='') echo 'checked' ?> />Valor	
				<br><input type="checkbox" name="busca_e_departamento" <? if($busca_e_departamento=='') echo 'checked' ?> />Departamento
				<br><input type="checkbox" name="busca_e_servico" <? if($busca_e_servico=='') echo 'checked' ?> />Serviço
				<br><input type="checkbox" name="busca_e_cidade" <? if($busca_e_cidade=='') echo 'checked' ?> />Cidade
				<br><input type="checkbox" name="busca_e_estado" <? if($busca_e_estado=='') echo 'checked' ?> />Estado
				<br><input type="checkbox" name="busca_e_status" <? if($busca_e_status=='') echo 'checked' ?> />Status
				<br><input type="checkbox" name="busca_e_atividade" <? if($busca_e_atividade=='') echo 'checked' ?> />Atividade
				<br><input type="checkbox" name="busca_e_responsavel" <? if($busca_e_responsavel=='') echo 'checked' ?> />Responsável
				<br><input type="checkbox" name="busca_e_atendimento" <? if($busca_e_atendimento=='') echo 'checked' ?> />Atendimento
				<br><input type="checkbox" name="busca_e_devedor" <? if($busca_e_devedor=='') echo 'checked' ?> />Devedor
			</div>
	    </div>

		<? if($controle_id_empresa=='1'){ ?>
        <div style="float:left; width:150px; text-align:right; margin-left:5px">
			<b><a href="#" onclick="if(document.getElementById('selecionar_estados').style.visibility=='hidden') document.getElementById('selecionar_estados').style.visibility='visible'; else document.getElementById('selecionar_estados').style.visibility='hidden';">Selecionar Estados</a></b><br>
                <select multiple="multiple" name="estado_dir[]" id="selecionar_estados" style="width:150px; float:left; text-align:left; height:140px; visibility:hidden;">
					<option value="Todos">Todos</option>
					<option value="AC">AC</option>
					<option value="AL">AL</option>
					<option value="AM">AM</option>
					<option value="AP">AP</option>
					<option value="BA">BA</option>
					<option value="CE">CE</option>
					<option value="DF">DF</option>
					<option value="ES">ES</option>
					<option value="GO">GO</option>
					<option value="MA">MA</option>
					<option value="MG">MG</option>
					<option value="MS">MS</option>
					<option value="MT">MT</option>
					<option value="PA">PA</option>
					<option value="PB">PB</option>
					<option value="PE">PE</option>
					<option value="PI">PI</option>
					<option value="PR">PR</option>
					<option value="RJ">RJ</option>
					<option value="RN">RN</option>
					<option value="RO">RO</option>
					<option value="RR">RR</option>
					<option value="RS">RS</option>
					<option value="SC">SC</option>
					<option value="SE">SE</option>
					<option value="SP">SP</option>
					<option value="TO">TO</option>
				</select>
	    </div>
		<? } ?>
		
		</form>
			
<br />
 <form name="f1" action="" method="post" ENCTYPE="multipart/form-data">

	<? 
	$permissao = verifica_permissao('Pedido Add',$controle_id_departamento_p,$controle_id_departamento_s);
	if($permissao == 'TRUE'){ 
	?>
    <div style="clear:both"><br />
	
		<h3><a href="pedido_add.php" style="text-decoration:none"> <img src="../images/botao_add.png" border="0" /> Adicionar novo registro</a></h3>
	
    </div>
	<br />
    <? } ?>

<div style="clear:both; padding:5px">
            <input type="submit" name="submit_acao" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Alterar Status " />
			<input type="submit" name="submit_exporta" onclick="document.f1.target='_blank'; document.f1.action='gera_exporta.php'" class="button_busca" value=" Exportar " />
            <? if($controle_id_empresa=='1'){ ?>
				<input type="submit" name="submit_exporta_2" onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_todos.php'" class="button_busca" value=" Exportar Todos " />
            <? } ?>
			<input type="submit" name="submit_exporta_txt" onclick="document.f1.target='_blank'; document.f1.action='gera_exporta_txt.php'" class="button_busca" value=" Exporta TXT " />
			<input type="submit" name="submit_desembolso" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Desembolso " />
            <input type="submit" name="submit_fax" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Fax c/ Depósito " />
            <input type="submit" name="submit_protocolo" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Protocolo " />
			<input type="submit" name="submit_etiqueta" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Etiqueta " />
            <? if($controle_id_empresa=='1'){ ?>
				<input type="submit" name="submit_anucec" onclick="document.f1.target='_blank'; document.f1.action='gera_anucec.php'" class="button_busca" value=" Inscrição Anucec " />
            <? } ?>

			<br>
			<b>Ofícios:</b><br>
            <? $permissao = verifica_permissao('Departamento',$controle_id_departamento_p,$controle_id_departamento_s);
			if($permissao == 'TRUE' and $controle_id_empresa=='1'){ ?>
			<input type="submit" name="submit_direcionamento" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Direciona p/ Franquia " />
			<? } ?>
		    <? $permissao = verifica_permissao('2via',$controle_id_departamento_p,$controle_id_departamento_s);
			if($permissao == 'TRUE'){ ?>
            <input type="submit" name="submit_2via" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" 2 Via " />
			<? } ?>
			<? $permissao = verifica_permissao('Imoveis',$controle_id_departamento_p,$controle_id_departamento_s);
			if($permissao == 'TRUE'){ ?>
            <input type="submit" name="submit_oficio" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Ofício Imóveis " />
			<input type="submit" name="submit_imoveis_busca" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Busca Imóveis " />
				<? if($controle_id_empresa==1 ){ ?>
					<input type="submit" name="submit_imoveis_busca" onclick="document.f1.target='_self'; document.f1.action='gera_imoveis_busca_import.php'" class="button_busca" value=" Busca Imóveis2 " />
				<? } 
			 } ?>
			<? $permissao = verifica_permissao('Processos',$controle_id_departamento_p,$controle_id_departamento_s);
			if($permissao == 'TRUE'){ ?>
			<input type="submit" name="submit_processos" onclick="document.f1.target='_self'; document.f1.action=''" class="button_busca" value=" Busca Detran " />
			<? } ?>		    			
</div>
<?php

if($controle_id_departamento_p=='6,') $onde_resp = " u.id_empresa = '" . $controle_id_empresa . "' and ";
else $onde_resp = "(
u.id_empresa              = '" . $controle_id_empresa . "' or
pi.id_empresa_resp              = '" . $controle_id_empresa . "'
) and";
$sql_empresa_resp = " CASE WHEN pi.id_empresa_resp != '0' and pi.id_empresa_resp='".$controle_id_empresa."'  THEN (SELECT fantasia from vsites_user_empresa as ue_resp where  ue_resp.id_empresa=u.id_empresa) ELSE ('') END";

$sql_empresa_dir = " CASE WHEN (pi.id_empresa_resp != '0' and pi.id_empresa_resp != '".$controle_id_empresa."') THEN (SELECT fantasia from vsites_user_empresa as ue_dir where  ue_dir.id_empresa=pi.id_empresa_resp) ELSE ('') END";
$sql_usuario_resp = " CASE WHEN pi.id_usuario_op != 0 THEN (SELECT uu_resp.nome from vsites_user_usuario as uu_resp where  uu_resp.id_usuario=pi.id_usuario_op) ELSE ('') END";
	
$hoje=date('Y-m-d');
$hoje_prox=date('Y-m-d', strtotime('+3 day'));

if(in_array('6',$departamento_p)!=1){
   $onde .= " and (pi.id_usuario_op!='' or pi.id_usuario_op='' and  pi.id_empresa_resp!='') ";
}
if($busca_exibicao=='Ordem'){ 
	$agrupa = ' group by pi.id_pedido'; 
}else{ 
	$agrupa = ''; 
	if($busca_exibicao=='Atraso') $onde .= " and (pi.id_status!='10' and DATE(NOW()) > (@DIAS_PRAZO:=(".$data_prazo_inc.")) or pi.id_status='10' and pi.encerramento > (".$data_prazo_inc.")) ";
	if($busca_exibicao=='Atraso Operacional') $onde .= " and (pi.operacional='0000-00-00' and DATE(NOW()) > (@DIAS_PRAZO:=(".$data_prazo_inc.")) or pi.id_status='10' and pi.operacional > (".$data_prazo_inc.")) ";
}
$condicao = "from vsites_atividades as a, vsites_status as st, vsites_pedido as p, vsites_pedido_item as pi, vsites_servico as s, vsites_servico_departamento as sd, vsites_user_usuario as u where
p.id_pedido  = pi.id_pedido and
pi.id_status = st.id_status and
pi.id_usuario = u.id_usuario and
".$onde_resp."
pi.id_servico_departamento 	= sd.id_servico_departamento and
pi.id_atividade	= a.id_atividade and
pi.id_servico 	= s.id_servico
".$onde.$agrupa."
order by ".$busca_ordenar_por;
$campo = " pi.data_prazo, pi.operacional, pi.inicio, 
st.status,p.restricao, pi.certidao_devedor, pi.encerramento, p.nome, pi.certidao_matricula,pi.certidao_n_matricula, s.descricao as servico, p.data, pi.id_pedido_item, pi.id_pedido, pi.data_atividade, a.atividade, pi.data_i,pi.certidao_estado, pi.certidao_cidade, pi.ordem, pi.id_usuario_op, pi.id_pedido_item, pi.certidao_nome_proprietario, pi.certidao_nome, u.nome as atendente, pi.valor, pi.dias, pi.status_hora,  sd.departamento,(".$sql_empresa_resp.") as empresa_resp,(".$sql_usuario_resp.") as responsavel,(".$sql_empresa_dir.") as empresa_dir, pi.id_empresa_resp";
pt_register('GET','pagina');
if($pagina=='') {
	echo "
	<script>
		eraseCookie('p_id_pedido_item');
		eraseCookie('p_id_pedido');
	</script>
	";
	unset( $_COOKIE['p_id_pedido_item'] );
	unset( $_COOKIE['p_id_pedido'] );	
}

$url_busca = $_SERVER['REQUEST_URI'];
$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
$_SESSION['pedido_campo']=$campo;
$_SESSION['pedido_condicao']=$condicao;
$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca);

$cont=0;
$permissao = verifica_permissao('Pedido Add',$controle_id_departamento_p,$controle_id_departamento_s);
?>
	<table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
	<tr>
		<td colspan="18" class="barra_busca">
<?
           $objQuery->QTDPagina();
?> 			
        </td>
	</tr>
<?
$p_valor = '';

$p_valor .= '	
	<tr>
		<td align="center" width="20" class="result_menu"><input type="checkbox" name="todos" onclick="if(this.checked==1) { selecionar_tudo_cache(\'p_id_pedido_item\'); selecionar_tudo(); } else { deselecionar_tudo_cache(\'p_id_pedido_item\'); deselecionar_tudo(); }"></td>';

    $permissao = verifica_permissao('Pedido Add',$controle_id_departamento_p,$controle_id_departamento_s);
    if($permissao == 'TRUE'){ 
		$p_valor .= '<td align="center" width="60" class="result_menu"><b>Novo Serviço</b></td>';
    } 
	$p_valor .= '<td align="center" width="60" class="result_menu"><b>Editar</b></td>
		<td align="center" width="50" class="result_menu"><b>Ordem</b></td>';
	if($busca_exibicao=='') { 
		$p_valor .= '<td class="result_menu"><b>Documento de</b></td>';
	} else { 
		$p_valor .= '<td class="result_menu"><b>Solicitante</b></td>';
    } 
	if($busca_e_devedor=='') 		$p_valor .=  '<td class="result_menu"><b>Devedor</b></td>';
	if($busca_e_inicio=='') 		$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Início</b></td>';
    if($busca_e_conclu=='')			$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Concluído Oper.</b></td>';
	if($busca_e_prazo=='') 			$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Prazo</b></td>';
	if($busca_e_agenda=='') 		$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Agenda</b></td>';
	if($busca_e_data_atividade=='') $p_valor .=  '<td align="center" width="50" class="result_menu"><b>Data Status</b></td>';
	if($busca_e_valor=='') 			$p_valor .=  '<td align="center" width="50" class="result_menu"><b>Valor</b></td>';
    if($busca_e_departamento=='') 	$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Departamento</b></td>';
	if($busca_e_servico=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Serviço</b></td>';
	if($busca_e_cidade=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Cidade</b></td>';
	if($busca_e_estado=='') 		$p_valor .=  '<td align="center" width="40" class="result_menu"><b>UF</b></td>';
	if($busca_e_status=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Status</b></td>';
	if($busca_e_atividade=='') 		$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Atividade</b></td>';
	if($busca_e_responsavel=='') 	$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Responsável</b></td>';
	if($busca_e_atendimento=='') 	$p_valor .=  '<td align="center" width="80" class="result_menu"><b>Atendimento</b></td>';
	
	$p_valor .= '</tr>';
	$p_id_pedido_item = explode(',',$_COOKIE["p_id_pedido_item"]);
while($res = mysql_fetch_array($query)){
	$cont++;
	$id_pedido_item = $res["id_pedido_item"];
	$atendente   	= $res["atendente"];
	$restricao   	= $res["restricao"];
	$id_usuario_op	= $res["id_usuario_op"];
	$id_usuario	    = $res["id_usuario"];
	$id_empresa_resp	    = $res["id_empresa_resp"];
	$departamento	= $res["departamento"];
	$status_hora	= $res["status_hora"];
	$data_operacional	= invert($res["operacional"],'/','PHP');
	$data_prazo	= invert($res["data_prazo"],'/','PHP');
	if($res['empresa_resp']<>'') $empresa_resp	= ' - <b>'.$res['empresa_resp'].'</b>';
	else $empresa_resp = "";
	if($res['empresa_dir']<>'') $empresa_dir	= ' - <b>'.$res['empresa_dir'].'</b>';
	else $empresa_dir = "";	
	$data_prazo_sql	= invert($data_prazo,'/','SQL');
	$operacional	= invert($res["operacional"],'-','PHP');
	$encerramento	= invert($res["encerramento"],'-','PHP');	
	$encerramento	= invert($encerramento,'-','SQL');	
	$data_agenda = invert($res["data_i"],'/','PHP');
    $valor            = $res["valor"];
    $valor            = 'R$ '.number_format($valor,2,".",",");
	$responsavel = $res['responsavel'];
	
	if($hoje>$data_prazo_sql and $res["status"]!='Concluído' or $res["status"]=='Concluído' and $encerramento > $data_prazo_sql) {
		$erro_atraso = "_erro"; 
	}else{ 
		if($hoje_prox>=$data_prazo_sql and $res["status"]!='Concluído') $erro_atraso = "_erro_aviso";
		else $erro_atraso = "";
	}
	
	if($hoje>$data_prazo_sql and $res["operacional"]=='0000-00-00' or $res["operacional"]!='0000-00-00' and $res['operacional']>$data_prazo_sql){
		$erro_atraso_op = "_erro";
	}else{
		if($hoje_prox>=$data_prazo_sql and $res["operacional"]=='0000-00-00') $erro_atraso_op = "_erro_aviso";
		else $erro_atraso_op = "";
	}
	
	if($restricao=='on') $erro_restricao = "_restricao";
	else $erro_restricao = "";
 	
	if($empresa_dir<>'') $class = '_franquia'; else
	if($empresa_resp<>'') $class = '_franqueado'; else
	$class='';

	if(in_array($res["id_pedido_item"],$p_id_pedido_item)==1) $item_checked = ' checked '; else $item_checked = '';
	$p_valor .= '<tr>
	   <td class="result_celula'.$class.'" align="center" nowrap>
  	   <input type="hidden" name="acao_' . $cont .'" value="' . $res["id_pedido_item"] .'"/>
	   <input type="hidden" name="acao_pedido_' . $cont .'" value="' . $res["id_pedido"] . '/'.$res["ordem"] .'"/>
       <input type="checkbox" name="acao_sel_' . $cont .'" value="' . $res["id_pedido_item"] .'" onclick="if(this.checked==true) { createCookie(\'p_id_pedido_item\',\''.$res["id_pedido_item"].',\',\'1\',\'1\'); createCookie(\'p_id_pedido\',\'#'.$res["id_pedido"].'/'.$res["ordem"].',\',\'1\',\'1\'); } else {eraseCookieItem(\'p_id_pedido_item\',\''.$res["id_pedido_item"].'\'); eraseCookieItem(\'p_id_pedido\',\'#'.$res["id_pedido"].'/'.$res["ordem"].'\'); }" '.$item_checked.' /></td>';
	
    if($permissao == 'TRUE'){
		$p_valor .= '<td class="result_celula'.$class.'" align="center"><a href="pedido_add_servico.php?id=' . $res["id_pedido"] . '&ordem=' . $res["ordem"] . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>';
	}

	if($busca_exibicao=='') $nome = $res["certidao_nome"].$res["certidao_nome_proprietario"];
	else $nome = $res["nome"];
	
	if($nome=='') $nome = $res["certidao_matricula"];	

	$p_valor .= '
	<td class="result_celula'.$class.'" align="center"><a href="pedido_edit.php?id=' . $res["id_pedido"] . '&ordem=' . $res["ordem"] . '"><img src="../images/botao_editar.png" title="Editar" border="0"/></a></td>
    <td class="result_celula'.$class.'" align="center" nowrap>#' . $res["id_pedido"] . '/'.$res["ordem"].'</td>
	<td class="result_celula'.$class.'" nowrap>'.$nome.'</td>';
	if($busca_e_devedor=='') 		$p_valor .= '<td class="result_celula'.$class.'">' . $res["certidao_devedor"].'</td>';
	if($busca_e_inicio=='') 		$p_valor .= '<td class="result_celula'.$class.' result_celula'.$erro_restricao.'" align="center" nowrap>' . invert($res["inicio"],'/','PHP') . '</td>';
	if($busca_e_conclu=='') 		$p_valor .= '<td class="result_celula'.$class.' result_celula'.$erro_atraso_op.'" align="center" nowrap>' . $data_operacional.'</td>';
	if($busca_e_prazo=='') 			$p_valor .= '<td class="result_celula'.$class.' result_celula'.$erro_atraso.'" align="center" nowrap>' . $data_prazo.'</td>';
	if($busca_e_agenda=='') 		$p_valor .= '<td class="result_celula'.$class.'" align="center" nowrap>' . $data_agenda . ' '.$status_hora.'</td>';
	if($busca_e_data_atividade=='') $p_valor .= '<td class="result_celula'.$class.'" align="center" nowrap>' . invert($res["data_atividade"],'/','PHP') . '</td>';
	if($busca_e_valor=='') 			$p_valor .= '<td class="result_celula'.$class.'" align="right" nowrap>' . $valor . '</td>';
	if($busca_e_departamento=='') 	$p_valor .= '<td class="result_celula'.$class.'" nowrap>' . $res["departamento"] . '</td>';
	if($busca_e_servico=='') 		$p_valor .= '<td class="result_celula'.$class.'" nowrap>' . $res["servico"] . '</td>';
	if($busca_e_cidade=='') 		$p_valor .= '<td class="result_celula'.$class.'" align="center" nowrap>' . $res["certidao_cidade"] . '</td>';
	if($busca_e_estado=='') 		$p_valor .= '<td class="result_celula'.$class.'" align="center" nowrap>' . $res["certidao_estado"] . '</td>';
	if($busca_e_status=='') 		$p_valor .= '<td class="result_celula'.$class.'" nowrap>' . $res["status"] . '</td>';
	if($busca_e_atividade=='') 		$p_valor .= '<td class="result_celula'.$class.'" nowrap>' . $res["atividade"] . '</td>';
	if($busca_e_responsavel=='') 	$p_valor .= '<td class="result_celula'.$class.'" nowrap>' . $responsavel .$empresa_dir . '</td>';
	if($busca_e_atendimento=='') 	$p_valor .= '<td class="result_celula'.$class.'" align="center">' . $atendente .$empresa_resp.'</td>';
    $p_valor .= '</tr>';

}
 echo  $p_valor;
?>
		<tr>
			<td colspan="18" class="barra_busca">
				<?
                    $objQuery->QTDPagina();
                ?> 			
            </td>
		</tr>
		</table>
		</form>
<br><br>
        <table width="400" cellpadding="4" cellspacing="1" class="result_tabela">
          <tr>
            <td colspan="2" class="result_menu"><strong>Legenda</strong></td>
          </tr>
          <tr>
            <td class="result_celula_franquia" width="10">&nbsp;</td>
            <td class="result_celula">Serviço direcionado para outra Franquia</td>
          </tr>
          <tr>
            <td class="result_celula_franqueado" width="10">&nbsp;</td>
            <td class="result_celula" nowrap="nowrap">Serviço que veio de outra Franquia</td>
          </tr>          
		  <tr>
            <td class="result_celula_restricao" width="10">&nbsp;</td>
            <td class="result_celula" nowrap="nowrap">Cliente com restrição</td>
          </tr>          
		  <tr>
            <td class="result_celula_erro" width="10">&nbsp;</td>
            <td class="result_celula" nowrap="nowrap">Serviço finalizado após o prazo</td>
          </tr>          		  
		  <tr>
            <td class="result_celula_erro_aviso" width="10">&nbsp;</td>
            <td class="result_celula" nowrap="nowrap">Faltam 3 dias para atingir o prazo</td>
          </tr>          		  
        </table>	

		</td>
</tr>
</table>
</div>
<?php 
	require('footer.php');
?>