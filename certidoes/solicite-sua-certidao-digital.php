<?
$id_meta=41;
$pg = 'paginas';
require_once 'includes/url.php';
require_once(URL_SITE_INCLUDE.'header.php');
?>
<div id="container">
    <div class="box_e">
        <h2 style="color: #202A72;">SOLICITE SUA CERTIDÃO AGORA</h2>
        <div class="faixa_h"></div>
        <div id="servicos">
            <?require_once(URL_SITE_INCLUDE.'colunae.php');?>
        </div>
    </div>
    <div id="contant">
        <h1 style="color: #202A72;">SOLICITE SUA CERTIDÃO DIGITAL</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/solicite-sua-certidao-digital.png" alt="solicite sua certidao digital" title="Solicite sua Certidão Digital" style="margin: 5px 0 0 0;" />
        <div id="texto">
            Prezado Cliente,<br /><br />			Agora, quando solicitar qualquer serviço na <strong>Cartório Postal</strong>, você receberá <strong>LOGIN E SENHA</strong> para acompanhar o andamento do seu pedido, além da certidão digital, assim que ela for emitida pelo respectivo orgão. A idéia é agilizar o atendimento e evitar atrasos, uma vez que sabemos que nossos serviços são de extrema importância para quem os solicita.<br /><br />			Para sua segurança, recomendamos sempre solicitar o número da Ordem de Serviço (OS) no protocolo de atendimento. Dessa forma, podemos acompanhar sua solicitação e evitar possíveis equívocos e atrasos.<br /><br />			<strong>Cartório Postal. Sempre rápido e fácil!</strong>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>