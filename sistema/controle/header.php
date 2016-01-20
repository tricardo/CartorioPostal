<?
ob_start();
require("../includes/funcoes.php");
require("../includes/verifica_logado_controle.inc.php");
require("../includes/global.inc.php");

$perm_fin = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_pgto = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_cobr = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_sup = verifica_permissao('Supervisor', $controle_id_departamento_p, $controle_id_departamento_s);

echo '<?xml version="1.0" encoding="iso-8859-1"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Sistecart</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="Refresh" content="atualiza">
        <!-- Inicio -->
        <link href="../js/box_movel2/inettuts.css" rel="stylesheet"	type="text/css" />
        <link rel="shortcut icon" href="../images/icone.gif" />

        <!-- Geral -->
        <style type="text/css">
            @import url(../css/style.css);
            @import url(../css/help.css);
        </style>

        <script	src="../js/jquery.js" type="text/javascript"></script> 
        <script src="../js/box_movel2/jquery-1.2.6.min.js" type="text/javascript"></script>
        <script src="../js/ajax.js" language="javascript"></script> 
        <script	src="../js/interface.js" type="text/javascript"></script> 
        <script	src="../js/maskedinput.js" type="text/javascript"></script>
        <script	src="../js/jquery-mask-money.js" type="text/javascript"></script>
        <script src="../js/js.js" language="javascript"></script> 

        <!-- tooltip - HELP -->
        <script	src="../js/jtip.js" type="text/javascript"></script> 

        <!-- efeito de abas -->
        <link rel="stylesheet" href="../css/jquery.tabs.css" type="text/css" media="print, projection, screen">
            <script	src="../js/abas/jquery.tabs.pack.js" type="text/javascript"></script> 

            <!-- jquery models -->
            <link href="../css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
            <script	src="../js/jquery.alerts.js" type="text/javascript"></script> 

            <script	type="text/javascript">
                $(function() {
                    $('#container-hotsite').tabs({ fxSlide: false, fxFade: false, fxSpeed: 'normal' });
                });
            </script> 
            <!-- fim do efeito de abas --> 

            <script>
                $(function(){                
                    $(".menuv li.submenu").each(function(){
                        var el = $('#' + $(this).attr('id') + ' ul:eq(0)');
                    
                        $(this).hover(function(){
                            el.show();
                        }, function(){
                            el.hide();
                        });
                    });
                
                    $(".menuh li.subv").each(function(){
                        var el = $('#' + $(this).attr('id') + ' ul:eq(0)');
                    
                        $(this).hover(function(){
                            el.show();
                        }, function(){
                            el.hide();
                        });
                    });
                });
            </script>
            <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58589188-19', 'auto');
  ga('send', 'pageview');

</script>
    </head>
    <body>
        <div id="menu_topo">
            <div id="logo_menu" style="text-align: center"><img src="../images/logo_menu.png" alt="Logo Menu" /></div>
            <div id="menu-h">
                <div style="float: left;">
                    <ul class="menuh">
                        <li id="submenu-110" class="subv"><a href="index.php">
                                <img src="../images/icon/icon_iniciar.png" style="border: 0" /> Iniciar </a>
                            <ul class="menuv">
							<!--
                                <li id="submenu-138"><a href="meu_cadastro.php">
                                        <img src="../images/icon/icon_pessoa.png" style="border: 0" /> Meu Cadastro</a>
                                </li>
								-->
                                <li id="submenu-138"><a href="alterar_senha.php">
                                        <img src="../images/icon/icon_senha.png" style="border: 0" /> Alterar Senha</a>
                                </li>
                                <? $permissao = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
                                if ($permissao == 'TRUE') { ?>
                                    <li id="submenu-138"><a href="servico.php"><img
                                                src="../images/icon/icon_servico.png" style="border: 0" /> Serviços</a>
                                    </li>
                                <? } ?>
                                <? $permissao = verifica_permissao('Conta', $controle_id_departamento_p, $controle_id_departamento_s);
                                if ($permissao == 'TRUE') { ?>
                                    <li id="submenu-138"><a href="conta.php"><img
                                                src="../images/icon/icon_conta.png" style="border: 0" /> Contas</a>
                                    </li>
                                <? } ?>
                                <? if ($controle_id_empresa == 1 and ($controle_id_usuario == 1 or $controle_id_usuario == 915)) { ?>
                                    <li id="submenu-138"><a href="correios.php">
                                            <img src="../images/icon/icon_conta.png" style="border: 0" /> Correios</a>
                                    </li>
                                <? } ?>
                                <li id="submenu-138"><a href="rels.php">
                                        <img src="../images/icon/icon_rel.png" style="border: 0" /> Relatórios</a>
                                </li>
                            </ul>
                        </li>
                        <li id="submenu-111" class="subv">
                            <a href="#"><img src="../images/icon/icon_pessoas.png" style="border: 0" /> Cadastros</a>
                            <ul class="menuv">
                                <? $permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
                                if ($permissao == 'TRUE' and $controle_id_empresa == '1') { ?>
                                    <li id="submenu-138">
                                        <a href="franquias-listar.php"><img src="../images/icon/icon_empresa.png" style="border: 0" /> Franquias</a>
                                    </li>
                                    <?
                                }
                                $permissao = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
                                if ($permissao == 'TRUE') {
                                    ?>
                                    <li id="submenu-138"><a href="usuario.php"><img src="../images/icon/icon_usuario.png" style="border: 0" /> Usuários</a></li>
                                    <?
                                }
                                ?>
                                <? $permissao = verifica_permissao('Cliente', $controle_id_departamento_p, $controle_id_departamento_s);
                                if ($permissao == 'TRUE') { ?>
                                    <li id="submenu-138">
                                        <a href="cliente.php"><img src="../images/icon/icon_cliente.png" style="border: 0" /> Clientes</a>
                                    </li>
                                <? }
                                if ($controle_id_empresa == 1 and $controle_id_usuario == 1){ ?>
									<li id="submenu-138">
                                        <a href="parceiro.php"><img src="../images/icon/icon_cliente.png" style="border: 0" /> Parceiros</a>
                                    </li>
                                <? }
                                if ($perm_pgto == 'TRUE' or $perm_comp == 'TRUE') { ?>
                                    <li id="submenu-138"><a	href="fornecedor.php"><img src="../images/icon/icon_empresa.png" style="border: 0" /> Fornecedores</a></li>
                                    <?
                                }
                                $permissao = verifica_permissao('Cartorio', $controle_id_departamento_p, $controle_id_departamento_s);
                                if ($permissao == 'TRUE' or $controle_id_usuario == '22' or $controle_id_usuario == '184') {
                                    ?>
                                    <li id="submenu-138"><a	href="cartorio.php"><img src="../images/icon/icon_cartorio.png" style="border: 0" /> Cartórios</a></li>
                                <? } ?>
                                <? $permissao = verifica_permissao('Protesto', $controle_id_departamento_p, $controle_id_departamento_s);
                                if ($permissao == 'TRUE') { ?>
                                    <li id="submenu-138">
                                        <a href="protesto.php"><img src="../images/icon/icon_protesto.png" style="border: 0" /> Protesto</a>
                                    </li>
                                    <?
                                }
                                $permissao = verifica_permissao('Direcionamento', $controle_id_departamento_p, $controle_id_departamento_s);
                                if ($permissao == 'TRUE') {
                                    ?>
                                    <li id="submenu-138">
                                        <a href="pedido_direcionamento.php"><img src="../images/icon/icon_cartorio.png" style="border: 0" /> Direcionamento</a>
                                    </li>
                                    <?
                                }
                                $permissao = verifica_permissao('Direcionamento_site', $controle_id_departamento_p, $controle_id_departamento_s);
                                if ($permissao == 'TRUE') {
                                    ?>
                                    <li id="submenu-138">
                                        <a href="pedido_direcionamento_site.php"><img src="../images/icon/icon_cartorio.png" style="border: 0" />	Direcionamento Site</a>
                                    </li>
                                    <?
                                }
                                $permissao = verifica_permissao('Pedido', $controle_id_departamento_p, $controle_id_departamento_s);
                                if ($permissao == 'TRUE') {
                                    ?>
                                    <li id="submenu-138"><a href="pedido.php"><img src="../images/icon/icon_pedido.png" style="border: 0" /> Pedidos</a>
                                    </li>
                                    <?
                                }
								$expansao = new ExpansaoDAO();
								$exp_item = $expansao->verAcesso(1, $controle_id_empresa, $controle_id_usuario, 
									$controle_id_departamento_p, $controle_id_departamento_s, $controle_nome);
                                if($exp_item->acesso == 1 and $controle_id_empresa == 1) { ?>
                                    <li id="submenu-138"><a href="expansao.php"><img src="../images/icon/icon_pedido.png" style="border: 0" /> Expansão</a></li>
                                <? } ?>
                            </ul>
                        </li>
                        <?php if ($perm_fin == 'TRUE' || $perm_cobr == 'TRUE' || $perm_comp == 'TRUE' || $perm_sup == 'TRUE') { ?>
                            <li id="submenu-112" class="subv"><a href="#">
                                    <img src="../images/icon/icon_calc.png" style="border: 0" /> Financeiro</a>
                                <ul class="menuv">

                                    <? if ($perm_fin == 'TRUE') { ?>
                                        <li id="submenu-138">
                                            <a href="financeiro2.php"><img src="../images/icon/icon_desembolso.png" style="border: 0" /> Desembolso</a>
                                        </li>
                                    <? } ?>
                                    <?php if ($perm_cobr == 'TRUE') { ?>
                                        <li id="submenu-138"><a href="financeiro_cobranca.php">
                                                <img src="../images/icon/icon_recebimento.png" style="border: 0" />Cobrança</a>
                                        </li>
                                        <?php
                                    }
                                    if ($perm_fin == 'TRUE') {
                                        ?>
                                        <li id="submenu-138"><a href="financeiro_pagamento.php">
                                                <img src="../images/icon/icon_recebimento.png" style="border: 0" />Recebimento</a>
                                        </li>
                                        <li id="submenu-138"><a href="financeiro_pagamento_f.php">
                                                <img src="../images/icon/icon_recebimento.png" style="border: 0" />Recebimento Franq.</a>
                                        </li>
                                        <li id="submenu-138"><a href="financeiro_gerarroyalties.php">
                                                <img src="../images/icon/icon_recebimento.png" style="border: 0" />Gerar Royalties</a>
                                        </li>
                                        <? if ($controle_id_empresa == 1) { ?>
                                            <li id="submenu-138"><a href="financeiro_royalties.php">
                                                    <img src="../images/icon/icon_recebimento.png" style="border: 0" />Royalties e FPP</a>
                                            </li>
                                        <? } ?>

                                        <? if ($controle_id_empresa == 1) { ?>
                                            <li id="submenu-138"><a href="emitir_boletos.php">
                                                    <img src="../images/icon/icon_recebimento.png" style="border: 0" />Emitir Boletos</a>
                                            </li>
                                        <? } ?>

                                        <? if ($controle_id_empresa == 1) { ?>
                                            <li id="submenu-138"><a href="financeiro_boleto.php">
                                                    <img src="../images/icon/icon_recebimento.png" style="border: 0" />Boletos</a>
                                            </li>
                                        <? } ?>
                                        <?php
                                    }
                                    if ($perm_comp == 'TRUE') {
                                        ?>
                                        <li id="submenu-138"><a href="compra.php">
                                                <img src="../images/icon/icon_recebimento.png" style="border: 0" />Compras</a>
                                        </li>
                                        <?php
                                    }
                                    if ($perm_pgto == 'TRUE') {
                                        ?>
                                        <li id="submenu-138"><a href="pagamento.php">
                                                <img src="../images/icon/icon_recebimento.png" style="border: 0" />Contas à Pagar</a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <? $permissao = verifica_permissao('Remessa_Retorno', $controle_id_departamento_p, $controle_id_departamento_s);
                        if ($permissao == 'TRUE' and  in_array($controle_id_empresa, array('1','6','20','192'))) { ?>
                            <li id="submenu-113" class="subv"><a href="#"><img
                                        src="../images/icon/icon_pessoas.png" style="border: 0" /> Troca de	Arquivo</a>
                                <ul class="menuv">
									<? if($controle_id_empresa == '1'){ ?>
                                    <li id="submenu-138"><a
                                            href="arquivo_retorno.php"><img src="../images/icon/icon_empresa.png" style="border: 0" /> Retorno do Cliente</a>
                                    </li>
									<? 
									}
									if(in_array($controle_id_empresa, array('1','6','20','192'))){
									?>
                                    <li id="submenu-138"><a
                                            href="pedido_remessa.php"><img src="../images/icon/icon_usuario.png" style="border: 0" /> Remessa do Cart.</a>
                                    </li>
									<? 
									}
									if($controle_id_empresa == '1'){
									?>
                                    <li id="submenu-138"><a
                                            href="pedido_retorno.php"><img src="../images/icon/icon_usuario.png" style="border: 0" /> Retorno do Cart.</a>
                                    </li>
                                    <li id="submenu-138">
                                        <a href="pedido_remessa_c.php"><img src="../images/icon/icon_usuario.png" style="border: 0" /> Log de Importados</a>
                                    </li>
									<? } ?>
                                </ul>
                            </li>
                        <? } ?>
                        <li id="submenu-114" class="subv"><a href="sair.php"><img
                                    src="../images/icon/icon_sair.png" style="border: 0" /> Finalizar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
