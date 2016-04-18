<?php
require("includes.php");

pt_register('GET','id_comunicado');
if(!isset($id_comunicado) OR !is_numeric($id_comunicado) OR $id_comunicado == 0){
    header('location:pagina-erro.php');
    exit;
}

$safDAO = new SafDAO();
$listar = $safDAO->ComunicadoId($id_comunicado);
if(count($listar) == 0){
    header('location:pagina-erro.php');
    exit;
}

define('COMUNICADOS',1);
$listar = UTF_Encodes($listar[0]); 
include('header3.php')?>
<div class="informativos">
    <div class="header">
        <div class="logo">
            <img src="images/logo-interno.png">
        </div>
        <div class="texto">
            <p>
                <strong>COMUNICADO <?=$listar->id_maladireta?>:</strong>
                <?=$listar->assunto?>
            </p>
            <p style="text-align: right; float: right">
                <strong><?=$listar->data?></strong>
            </p>
        </div>
    </div>
    <div class="footer">
        <div class="texto"><?=$listar->texto?></div>
    </div>
</div>
<?php include('footer.php') ?>

