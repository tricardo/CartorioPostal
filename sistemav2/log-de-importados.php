<?php
require("includes.php");

$permissao = verifica_permissao('Pedido Import',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){
    header('location:pagina-erro.php');
    exit;
}

$arquivoitemDAO = new ArquivoItemDAO();

$c = Post_StdClass($_GET);
if(isset($c->opcao) AND isset($c->id_arquivo) AND is_numeric($c->id_arquivo) AND $c->id_arquivo > 0){
    switch($c->opcao){
        case 'download':
            
            require("includes/geraexcel/excelwriter.inc.php");
            
            $arquivoDiretorio = "exporta/log-import-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";
            
            $excel=new ExcelWriter($arquivoDiretorio);

            if($excel==false){
                echo $excel->error;
                exit;
            }
            
            //Escreve o nome dos campos de uma tabela
            $linha_arq = 'Pedidos Importados';

            $myArr = explode(';',$linha_arq);
            $excel->writeLine($myArr);	

            $linha_arq = 'CPF;Nome;Cidade;UF;Protocolo';

            $myArr = explode(';',$linha_arq);
            $excel->writeLine($myArr);	

            $c->dup = 0;
            foreach($arquivoitemDAO->log_importado($c) AS $f){
                $linha_arq = $f->certidao_cpf.';'.$f->certidao_nome.';'.$f->certidao_cidade.';'.$f->certidao_estado.';#'.$f->id_pedido_dup.'/'.$f->ordem_dup;
                $myArr = explode(';',$linha_arq);
                $excel->writeLine($myArr);
            }
        
            $linha_arq = ' ';

            $myArr = explode(';',$linha_arq);
            $excel->writeLine($myArr);	

            $linha_arq = 'Duplicidades';

            $myArr = explode(';',$linha_arq);
            $excel->writeLine($myArr);	

            $linha_arq = 'CPF;Nome;Cidade;UF;Protocolo';

            $myArr = explode(';',$linha_arq);
            $excel->writeLine($myArr);	
            
            $c->dup = 1;
            foreach($arquivoitemDAO->log_importado($c) AS $f){
                $linha_arq = $f->certidao_cpf.';'.$f->certidao_nome.';'.$f->certidao_cidade.';'.$f->certidao_estado.';#'.$f->id_pedido_dup.'/'.$f->ordem_dup;
                $myArr = explode(';',$linha_arq);
                $excel->writeLine($myArr);
            }
            
            header ("Content-type: octet/stream");
            header ("Content-disposition: attachment; filename=".$arquivoDiretorio.";");
            header("Content-Length: ".filesize($arquivoDiretorio));
            readfile($arquivoDiretorio);
        
            exit;
            break;
        
    }
    
    
    
}

$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';


$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

include('header2.php');
?>
<script>
    menu(3,'bt-06');
    $('#titulo').html('arquivos &rsaquo;&rsaquo; log de importados');
    $('#sub-42').css({'font-weight':'bold'});
</script>
<div class="content-list-forms"></div>
<div class="content-list-table">   
<?php $listar = $arquivoitemDAO->listaRemessaC($controle_id_empresa); ?>
    <table>
        <thead>
            <tr>
                <th class="buttons">#</th>
                <th>cliente</th>
                <th class="buttons size100">data</th>
                <th class="buttons size100">erros</th>
                <th class="buttons">baixar</th>
            </tr>
        </thead>
        <tbody>
            <?php $color = '#FFFEEE';
            foreach ($listar as $f) { 
                $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
            <tr <?=TRColor($color)?>>
                <td class="buttons"><?=$f->id_arquivo?></td>
                <td><?= utf8_encode($f->nome) ?></td>
                <td class="buttons"><?= invert($f->data,'/','PHP')?></td>
                <td class="buttons"><?php if($f->erros > 0){?><a href="log-de-importados-erro.php?id_arquivo=<?=$f->id_arquivo?>"><?=$f->erros?></a><?php } else { echo '-'; }?></td>
                <td class="buttons"><?php if($f->erros == 0){?><a href="log-de-importados.php?id_arquivo=<?=$f->id_arquivo?>&opcao=download" target="_blank"><img src="images/bt-download.png"></a><?php } else { echo '-'; }?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>PaginacaoWidth()</script>
</div>
<?php include('footer.php'); ?>