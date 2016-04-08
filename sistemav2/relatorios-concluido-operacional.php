<?php
require("includes.php");

$permissao = verifica_permissao('Rel_n_supervisores',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

if($_POST){
    
    require("includes/geraexcel/excelwriter.inc.php");
    require("includes/dias_uteis.php");
    
    pt_register('POST','busca_data_i_co');
    pt_register('POST','busca_data_f_co');
    pt_register('POST','id_conveniado');	
    pt_register('POST','id_usuario');
    
    if(!in_array(9,explode(',',$controle_id_departamento_s))
            && !in_array(3,explode(',',$controle_id_departamento_s))
            && !in_array(5,explode(',',$controle_id_departamento_s))
            && !in_array(8,explode(',',$controle_id_departamento_s))
            && !in_array(6,explode(',',$controle_id_departamento_s))){
            $id_usuario=$controle_id_usuario;
    }
    
    $arquivoDiretorio = "exporta/conc-oper-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";
    
    $excel=new ExcelWriter($arquivoDiretorio);

    if($excel==false){
        echo $excel->error;
        exit;
    }
    
    //Escreve o nome dos campos de uma tabela
   $linha_arq = utf8_decode('Relatorio dos Concluídos Operacional;');
   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	

   $linha_arq = utf8_decode('Referência:; '.$busca_data_i_co.'/'.$busca_data_f_co.';');
   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	   

   $linha_arq = utf8_decode('Contato;#;Data de Abertura;Prazo;Concluído Operacional;Status;CPF;CNPJ;Documento de;Responsável;Servico;UF;Cidade;Atividade;Resultado;Motivo do Atraso');
   $myArr = explode(';',$linha_arq);
   $excel->writeLine($myArr);	   

 
    $busca_data_f_co = invert($busca_data_f_co,'/','SQL');
    $busca_data_i_co = invert($busca_data_i_co,'/','SQL');

    if((strtotime($busca_data_f_co)-strtotime($busca_data_i_co))/(60*60*24) > 31){      
        pt_register('GET','pg');
        $pagina = RelTipTit($pg);
        $bt = '05';
        $titulo = "'relatórios &rsaquo;&rsaquo; <a href=\"".$pagina['retorno']."\" id=\"voltar\">".$pagina['titulo']."</a> &rsaquo;&rsaquo; Concluído Operacional'";
        $h3 = "Período de ".(strtotime($busca_data_f_co)-strtotime($busca_data_i_co))/(60*60*24)." dias é  muito longo!";
        include('template.php');
    } else {
	$pedidoDAO = new PedidoDAO();
        foreach($pedidoDAO->concluido_operacional($controle_id_departamento_p, $id_usuario, $id_conveniado, $data_prazo_inc, $busca_data_i_co, $busca_data_f_co, $controle_id_empresa) AS $res){
            if($res->certidao_resultado<>"" and $res->certidao_resultado!="Negativa") $resultado = "Positiva"; else $resultado = $res->certidao_resultado;
            $linha_arq = $res->contato.';'.$res->id_pedido.'/'.$res->ordem.';'.invert($res->inicio,'/','PHP').';'.invert($res->prazo,'/','PHP').';'.invert($res['operacional'],'/','PHP').';'.invert($res['data_atividade'],'/','PHP').';'.$res['certidao_cpf'].'. ;'.$res['certidao_cnpj'].'. ;'.$res['certidao_nome'].';'.$res['responsavel'].';'.$res['servico'].';'.$res['certidao_estado'].';'.$res['certidao_cidade'].';'.$res['atividade'].';'.$resultado.';'.$res['motivo_atraso'];
            $myArr = explode(';',$linha_arq);
            $excel->writeLine($myArr);
        }
        header ("Content-type: octet/stream");
        header ("Content-disposition: attachment; filename=".$arquivoDiretorio.";");
        header("Content-Length: ".filesize($arquivoDiretorio));
        readfile($arquivoDiretorio);
    }
    
} else {
    pt_register('GET','pg');
    pt_register('POST','mes');
    pt_register('POST','ano');
    $pagina = RelTipTit($pg);
    
     $busca_data_i_co = date('01/m/Y');
     $busca_data_f_co = date('t/m/Y');
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Concluído Operacional');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Concluído Operacional</legend>
                <dt>Conc. Oper.:</dt>
                <dd><input type="text" id="busca_data_i_co" name="busca_data_i_co" class="data" value="<?=$busca_data_i_co?>"></dd>
                <dt>E:</dt>
                <dd><input type="text" id="busca_data_f_co" name="busca_data_f_co" class="data" value="<?=$busca_data_f_co?>"></dd>
                <?php if($controle_id_empresa == 1){ ?>
                    <dt>Cliente:</dt>
                    <dd>
                        <select name="id_conveniado" id="id_conveniado" class="chzn-select">
                            <option value="">Todos</option>
                            <option value="635">HSBC (Processos Judiciais)</option>
                            <option value="-635">Exceto HSBC</option>
                        </select>				
                        
                    </dd>
                <?php } 
                if(in_array(9,explode(',',$controle_id_departamento_s))
                    || in_array(3,explode(',',$controle_id_departamento_s))
                    || in_array(5,explode(',',$controle_id_departamento_s))
                    || in_array(8,explode(',',$controle_id_departamento_s))
                    || in_array(6,explode(',',$controle_id_departamento_s))){
                        $usuarioDAO = new UsuarioDAO();
                        $usuarios = $usuarioDAO->listarPorDepartamentoEmpresa($controle_id_empresa,array(3,4,5,8,9,15))	?>
                    <dt>Usuário:</dt>
                    <dd>
                        <select name="id_usuario" id="id_usuario" class="chzn-select">
                            <option value="">Todos</option>
                            <?php foreach($usuarios as $u){ ?>
                                <option value="<?php echo $u->id_usuario ?>"><?php echo utf8_encode($u->nome)?></option>
                            <?php } ?>
                        </select>
                    </dd>
                <?php } ?>
                <div class="buttons">
                    <input type="hidden" value="1" id="f" name="f">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                    <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                    <input type="submit" value="buscar &rsaquo;&rsaquo;">
                </div>
                <div class="instrictions">
                    <p>
                        <strong class="active">Observações:</strong><br>
                        * O intervalo de datas é feito mensalmente
                    </p>
                </div>
            </dl>
        </form>
        <script>preencheCampo()</script>
    </div>
    <div class="content-list-table">
        <?php if($_POST){
            RetornaVazio();
        } else {
            RetornaVazio(2); } ?>
    </div>
    <?php include('footer.php'); 
}?>