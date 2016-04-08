<?php
require("includes.php"); 

$permissao = verifica_permissao('Pedido Import Cart',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){
    header('location:pagina-erro.php');
    exit;
}

$usuarioDAO = new UsuarioDAO();
$servicoDAO = new ServicoDAO();
$remessaCartDAO = new RemessaCartDAO();
$retornoDAO = new RetornoDAO();
$pedidoDAO = new PedidoDAO();

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

if(isset($_GET['download']) AND isset($_GET['id']) AND !$_POST){
    require( "includes/zip/zip.php" );

    pt_register('GET','id');

    $arq = $retornoDAO->selectPorId($id,$controle_id_empresa);
    if(count($arq) == 0){
        header('location:pagina-erro.php?erro=1');
        exit;
    }

    $zipfile = new zipfile(md5($controle_id_usuario.'_'.date("d-m-Y H:i:s")).".zip");
    
    if(file_exists('../sistema/controle/exporta/retorno/'.$arq->arquivo)){
        $arquivo = '../sistema/controle/exporta/retorno/'.$arq->arquivo;
    } else {
        $arquivo = 'exporta/retorno/'.$arq->arquivo;
    }
    
    $zipfile->addFileAndRead($arquivo);

    echo $zipfile->file();
    exit;
}

if($_POST){
    pt_register('POST','id_cliente');
    pt_register('POST','id_servico');
    pt_register('POST','h_tiporetorno');
    
    
    require("includes/exportacao/retorno_".$id_cliente.".php");
    if(is_file($arquivoDiretorio)) {
        unlink($arquivoDiretorio);
    }


    if(fopen($arquivoDiretorio,"w+")) {

        if (!$handle = fopen($arquivoDiretorio, 'w+')) {
           header('location:pagina-erro.php?erro=3');
           exit;
        }

        if(!fwrite($handle, $arquivoConteudo)) {
           header('location:pagina-erro.php?erro=4');
           exit;
        }
  
	if($h_tiporetorno=='CONF'){
            $usuarioDAO->editar_retorno_cliente($id_cliente, $controle_id_empresa, $onde, 1);
	} else {
		if($h_tiporetorno=='REGI'){
                    $usuarioDAO->editar_retorno_cliente($id_cliente, $controle_id_empresa, $onde, 2);
		} else {
                    $usuarioDAO->editar_retorno_cliente($id_cliente, $controle_id_empresa, $onde, 3);
		}
	}

	$retornoDAO->inserir($id_cliente, $controle_id_usuario, $nomeArquivo);
        
	header ("Content-type: octet/stream");
	header ("Content-disposition: attachment; filename=exporta/retorno/".$nomeArquivo.";");
	header("Content-Length: ".filesize($arquivoDiretorio));
	readfile($arquivoDiretorio);
   
    } else {
        header('location:pagina-erro.php?erro=3');
       exit;
    }
    
    
    exit;
}
include('header2.php'); ?>

<script>
    menu(3,'bt-06');
    $('#titulo').html('arquivos &rsaquo;&rsaquo; retorno do cliente');
    $('#sub-39').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php CamposObrigatorios(); ?>  

    <form enctype="multipart/form-data" method="post" action="retorno-do-cliente-editar.php" target="_blank">
    <h3>informações</h3>
    <dl>
        <dt>Cliente <span>*</span>:</dt>
        <dd class="line1">
            <select id="id_cliente" name="id_cliente" class="chzn-select required line1">
                <?php foreach($usuarioDAO->combo_retorno_cliente() AS $f){ ?>
                <option value="<?=$f->id_cliente?>"><?=utf8_encode($f->nome)?></option>
                <?php } ?>
            </select>
        </dd>
        <dt>Serviço <span>*</span>:</dt>
        <dd class="line1">
            <select id="id_servico" name="id_servico" class="chzn-select required line1">
                <?php foreach($servicoDAO->remessa() AS $f){ ?>
                <option value="<?=$f->id_servico?>"><?=utf8_encode($f->descricao)?></option>
                <?php } ?>
            </select>
        </dd>
        <dt>Tipo do Arquivo <span>*</span>:</dt>
        <dd class="line1">
            <select name="h_tiporetorno" id="h_tiporetorno" class="chzn-select required line1">
                <option value="CONF">CONFIRMAÇÃO DE RECEBIMENTO</option>        
                <option value="REGI">REGISTRO DA NOTIFICAÇÃO</option>
                <option value="OCOR">OCORRÊNCIA DA NOTIFICAÇÃO</option>
            </select> 
        </dd>
        <div class="buttons">
            <input type="submit" value="gerar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
        </div>
    </dl>
   </form>
    <script>
        preencheCampo();
    </script>
</div>
<div class="content-list-table"> 
    <table>
            <thead>
                <tr>
                    <th class="buttons size100">data</th>
                    <th>arquivo</th>
                    <th class="buttons">download</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($remessaCartDAO->listartodasRetorno() as $f) {
                     $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';  ?>
                    <tr <?=TRColor($color)?>>
                        <td class="buttons size100"><?=invert($f->data,'/','PHP')?></td>
                        <td><?=$f->arquivo?></td>
                        <td class="buttons">
                            <a href="retorno-do-cliente-editar.php?id=<?=$f->id_retorno?>&download=1" target="_blank"><img src="images/bt-download.png"></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    
</div>
<?php include('footer.php'); ?>
