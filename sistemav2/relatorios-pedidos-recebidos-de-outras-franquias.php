<?php
require("includes.php");


if($_POST){
    
    $permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
    require("includes/geraexcel/excelwriter.inc.php");
    
    pt_register('POST', 'datai');
    pt_register('POST', 'dataf');
    
    
    $datai = strlen($datai) == 0 ? date('01/m/Y') : $datai;
    $dataf = strlen($dataf) == 0 ? date('t/m/Y') : $dataf;
    $datai = explode('/',$datai);
    $dataf = explode('/',$dataf);
    
    $anoi = $datai[2];
    $mesi = $datai[1];
    $diai = $datai[0];
    $anof = $dataf[2];
    $mesf = $dataf[1];
    $diaf = $dataf[0];
    
    $data_i = $anoi.'-'.$mesi.'-'.$diai.' 00:00:00';
    $data_f = $anof.'-'.$mesf.'-'.$diaf.' 23:59:59';
    
    $pedidoDAO = new PedidoDAO();
    $pedidos = $pedidoDAO->listaPedidosRecFranquia($controle_id_empresa,$data_i,$data_f);
    
    $arquivoDiretorio = "exporta/ped-rec-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";
    
    $excel=new ExcelWriter($arquivoDiretorio);
    if($excel==false){
        echo $excel->error."????";
        exit;
    }
    
    $semana=0;
    $toral = 0;
    $pedidos_conta = 0;
    
    $valor_valor = 0;
    $valor_sedex = 0;
    $valor_rateio = 0;

    $excel->writeLine(array('Data','Ordem','Franquia',utf8_decode('Serviço'),'Cidade','Estado',
        'Status','Prazo','Custas',utf8_decode('Honorários'),'Sedex'));
    
    foreach($pedidos as $i=>$p){
        $data = date('d/m/Y',strtotime($p->data));
        $pedidos_conta++;
        $total = (float)($p->financeiro_valor)+(float)($p->financeiro_sedex)+(float)($p->financeiro_rateio);
        $lucro = (float)($p->valor)-(float)($total);
        $excel->writeLine(array($data,$p->id_pedido.'/'.$p->ordem,$p->fantasia,$p->servico,$p->certidao_cidade,$p->certidao_estado,$p->status,invert($p->data_prazo,'/','PHP'),$p->financeiro_valor,$p->financeiro_rateio,$p->financeiro_sedex));

        $valor_valor = (float)($p->financeiro_valor)+(float)($valor_valor);
        $valor_sedex = (float)($p->financeiro_sedex)+(float)($valor_sedex);
        $valor_rateio = (float)($p->financeiro_rateio)+(float)($valor_rateio);

    }
    $excel->writeLine(array('Total','','','','','',$valor_valor,$valor_rateio,$valor_sedex));

    $excel->close();
    header ("Content-type: octet/stream");
    header ("Content-disposition: attachment; filename=".$arquivoDiretorio.";");
    header("Content-Length: ".filesize($arquivoDiretorio));
    readfile($arquivoDiretorio);
    exit;
        
} else {
    pt_register('GET','pg');
    pt_register('POST','mes');
    pt_register('POST','ano');
    $pagina = RelTipTit($pg);
    
     $datai = date('01/m/Y');
     $dataf = date('t/m/Y');
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; pedidos recebidos de outras franquias');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório pedidos recebidos de outras franquias</legend>
                <dt>Início:</dt>
                <dd><input type="text" id="datai" name="datai" class="data" value="<?=$datai?>"></dd>
                <dt>Fim:</dt>
                <dd><input type="text" id="dataf" name="dataf" class="data" value="<?=$dataf?>"></dd>
                <div class="buttons">
                    <input type="hidden" value="1" id="f" name="f">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                    <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                    <input type="submit" value="buscar &rsaquo;&rsaquo;">
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