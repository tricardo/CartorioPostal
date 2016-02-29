<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/funcoes.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/global.php');
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/model/Database.php');

pt_register('GET','id_empresa');
pt_register('GET','cidade');
pt_register('GET','estado');
pt_register('GET','bairro');

$empresaDAO = new EmpresaDAO();
if(isset($_GET['ajax']) AND $_GET['ajax'] == 1){
	$empresas = $empresaDAO->listaEmpresa($estado,$cidade,$bairro);
} else {
	$empresas = $empresaDAO->listaEmpresaId();
}

	foreach($empresas as $emp){
$emp->link_estado = strtolower($emp->estado);

$emp->link_cidade = strtolower(limpa_url(str_replace(' ','',$emp->cidade)));
if($emp->apelido=='')
    $emp->link_bairro = strtolower(limpa_url(str_replace(' ','',$emp->bairro)));
else
    $emp->link_bairro = strtolower(limpa_url(str_replace(' ','',$emp->apelido)));
$p_valor = "";
$p_valor .= '

<div class="dados_franquia">';

if($emp->hotsite=="0"){
    $p_valor .= '<a href="/'.strtolower(limpa_url(str_replace(' ','',$emp->link_estado))).'/'.$emp->link_cidade.'-'.$emp->link_bairro.'" target="_blank"><img src="../images/pages/saiba-mais-sobre-essa-unidade.png" alt="saiba mais sobre a unidade: '.$emp->fantasia.'?>" title="Saiba mais sobre a unidade: '.$emp->fantasia.'" /></a><br />';
}else{
    $p_valor .= '<a href="/'.$emp->id_empresa.'/'.strtolower(limpa_url(str_replace(' ','',$emp->link_estado))).'/'.$emp->link_cidade.'-'.$emp->link_bairro.'" target="_blank">Hotsite da '.$emp->fantasia.'</a><br />';
}

#if($emp->codrev==""){
    #$p_valor .= '<a href="http://www.certisign.com.br/produtos-e-servicos/certificados-digitais?cod_rev=23289" target="_blank"><img src="../images/pages/clique-aqui-e-peca-o-seu-certificado-digital.png" alt="clique aqui e peca o seu certificado digital" title="Clique aqui e peça o seu Certificado Digital" /></a><br />';
#}else{
    #$p_valor .= '<a href="http://www.certisign.com.br/produtos-e-servicos/certificados-digitais?cod_rev='.$emp->codrev.'" target="_blank"><img src="../images/pages/clique-aqui-e-peca-o-seu-certificado-digital.png" alt="clique aqui e peca o seu certificado digital" title="Clique aqui e peça o seu Certificado Digital" /></a><br />';
#}
echo $p_valor;?>

<!--<a href="/'.strtolower(limpa_url(str_replace(' ','',$emp->link_estado))).'/'.$emp->link_cidade.'-'.$emp->link_bairro.'"><img src="../images/pages/saiba-mais-sobre-essa-unidade.png" alt="saiba mais sobre a unidade: '.$emp->fantasia.'?>" title="Saiba mais sobre a unidade: '.$emp->fantasia.'" /></a><br />//-->

<strong>Unidade:</strong> <?= $emp->fantasia?><br />
<? if($emp->id_pais==32){ ?>
<strong>Endereço:</strong> <?= $emp->endereco ?>, <?= $emp->numero?><br />
<strong>Complemento:</strong> <?= $emp->complemento?><br />
<strong>Bairro:</strong> <?= $emp->bairro?><br />
<? } ?>
<strong>Pais:</strong> <?= $emp->pais?> - <strong>Cidade:</strong> <?= $emp->cidade?> - <strong>Estado:</strong> <?= $emp->estado?><br />
<? if($emp->id_pais==32){ ?>
<strong>Cep:</strong> <?= $emp->cep ?><br />
<? } ?>

<!--<strong>E-mail:</strong> <?#= str_replace('diretoria','contato',$emp->email)?><br />
<strong>Fale consoco:</strong> <?#= $emp->tel?>//-->
<? echo '</div>' ?>
<div id="fachada_franquia_unidades">
    <? if($emp->imagem==""){?>
    <img src="../upload/franquia.jpg" width="275" height="198"/>
    <? }else{ ?>
    <img src="../upload/<?= $emp->imagem ?>" title="<?= $emp->fantasia ?>" width="275" height="198" />
    <?}?>
</div>
<? } ?>