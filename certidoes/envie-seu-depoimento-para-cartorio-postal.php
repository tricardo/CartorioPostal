<?
$id_meta=6;
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
        <h1 style="color: #202A72;">ENVIE SEU DEPOIMENTO PARA CARTÓRIO POSTAL</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/envie-seu-depoimento-para-cartorio-postal.png" alt="envie seu depoimento para cartorio postal" title="Envie seu depoimento para Cartório Postal" style="margin: 5px 0 20px 0;" />
        <h3 style="color: #202A72;">PREENCHA OS CAMPOS ABAIXO</h3>
        <div class="faixa_h"></div>
        <?
        pt_register('POST','submit1');
        if($submit1){
            $errors=array();
            pt_register('POST','nome');
            pt_register('POST','email');
            pt_register('POST','depoimento');
            if($nome=="" || $email=="" || $depoimento==""){
                if($nome=="")       $errors['nome']=1;
                if($email=="")      $errors['email']=1;
                if($depoimento=="") $errors['depoimento']=1;
                $error.="<span style='font: 12px Arial; color:#000000;'>Nome / E-mail / Depoimento / </span>";
            }
            $valida = validaEMAIL($email);
            if($valida=='false'){
                $errors['email']=1;
                $error.="<span style='font: 12px Arial; color:#000000;'>E-mail Inválido, digite corretamente / </span>";
            }
            if(count($errors)<1){
                $query="INSERT INTO cp_depoimento(";
                $query .="nome, email, depoimento, data)";
                $query .="VALUES";
                $query .="('".$nome."','".$email."','".$depoimento."',NOW())";
                $result = $objQuery->SQLQuery($query);
                $id = $objQuery->ID;
                $done=1;
                $msg .= "------------------------------------------------------------------------<br />";
                $msg .= "<strong>Novo depoimento:.</strong><br />";
                $msg .= "------------------------------------------------------------------------<br />";
                $msg .= "<strong>Nome completo:</strong> $nome<br />";
                $msg .= "<strong>E-mail:</strong> $email<br />";
                $msg .= "<strong>Mensagem:</strong><br /> $depoimento";
                $formato = "\nContent-type: text/html\n charset=iso-8859-1\n";
                #$destinatario = "antonio.alves@softfox.com.br";
                $destinatario = "paco@midiatix.com.br";
                $titulo = "Depoimento: Cartório Postal";
                mail("$destinatario","$titulo","$msg","from: ".$email.$formato);
            }
        }
        if($done!=1){
        ?>
        <form name="frm" action="" method="post" enctype="multipart/form-data">
            <table border="0" width="100%" align="center" cellpadding="3" cellspacing="3">
                <tr>
                    <td align="left" valign="middle" colspan="4">
                        <?
                        if($error!=''){
                                echo '
                                    <div id="apDiv_erro">
                                        <table width="100%" border="0" height="200" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td colspan="3" align="center" valign="middle" height="50">
                                                <strong style="font-size:15px;">OCORRERAM OS SEGUINTES ERROS</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%" align="center" valign="top">

                                            </td>
                                            <td width="70%" colspan="2" align="left" valign="top">
                                                '.$error.'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" align="center" valign="top">
                                               <a href="#" onclick="fecharErro()"><img src="'.URL_IMAGES.'pages/image-bt-fechar.png" alt="Clique aqui para fechar este informativo." title="Clique aqui para fechar este informativo." /></a>
                                            </td>
                                        </tr>
                                        </table>
                                    </div>
                                    ';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle">
                         <label for="nome" accesskey="1">Nome:</label>
                    </td>
                    <td align="left" valign="middle">
                         <label for="email" accesskey="2">E-mail:</label>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle">
                         <input name="nome" type="text" id="nome" value="<?= $nome;?>" <?=($errors['nome'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                    </td>
                    <td align="left" valign="middle">
                         <input name="email" type="text" id="email" value="<?= $email;?>" <?=($errors['email'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle" colspan="2">
                         <label for="campo1" accesskey="4">Depoimento:</label>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle" colspan="2">
                        <textarea name="depoimento" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,300,'spcontando1');contarCaracteres(this.value,300,'sprestante1','campo1')" <?=($errors['depoimento'])?'style="border: 1px solid #FF0000; width: 100%; height: 80px;"':''; ?> ><?= $depoimento;?></textarea>
                        <span id="spcontando1" style="font-size: 12px;">Ainda não temos nada digitado..</span><br />
                        <span id="sprestante1" style="font-size: 12px;"></span>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="middle" colspan="4">
                        <input name="submit1" type="submit" value=" " title="Clique aqui para fazer o cadastro" class="bt_enviar" />
                    </td>
                </tr>
            </table>
        </form>
        <?
        }
        if($done){
            echo '<img src="'.URL_IMAGES.'pages/mensagem-enviada-com-sucesso.png" alt="mensagem enviada com sucesso" title="Mensagem enviada com sucesso!" />';
            echo '<meta HTTP-EQUIV="refresh" CONTENT="5; URL='.URL_SITE.'">';
        }
        ?>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>