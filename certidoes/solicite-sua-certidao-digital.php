<?
$id_meta=41;
$pg = 'paginas';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');
?>
<div id="container">
    <div class="box_e">
        <h2 style="color: #202A72;">SOLICITE SUA CERTID�O AGORA</h2>
        <div class="faixa_h"></div>
        <div id="servicos">
            <?require_once(URL_SITE_INCLUDE.'colunae.php');?>
        </div>
    </div>
    <div id="contant">
        <h1 style="color: #202A72;">SOLICITE SUA CERTID�O DIGITAL</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a p�gina anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/solicite-sua-certidao-digital.png" alt="solicite sua certidao digital" title="Solicite sua Certid�o Digital" style="margin: 5px 0 0 0;" />
        <div id="texto">
            Prezado Cliente,<br /><br />			Agora, quando solicitar qualquer servi�o na <strong>Cart�rio Postal</strong>, voc� receber� <strong>LOGIN E SENHA</strong> para acompanhar o andamento do seu pedido, al�m da certid�o digital, assim que ela for emitida pelo respectivo org�o. A id�ia � agilizar o atendimento e evitar atrasos, uma vez que sabemos que nossos servi�os s�o de extrema import�ncia para quem os solicita.<br /><br />			Para sua seguran�a, recomendamos sempre solicitar o n�mero da Ordem de Servi�o (OS) no protocolo de atendimento. Dessa forma, podemos acompanhar sua solicita��o e evitar poss�veis equ�vocos e atrasos.<br /><br />			<strong>Cart�rio Postal. Sempre r�pido e f�cil!</strong>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>