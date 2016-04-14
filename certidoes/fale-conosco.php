<?
$id_meta=8;
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
        <h1 style="color: #202A72;">FALE CONOSCO</h1>
        <a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/fale-conosco.png" alt="fale conosco" title="Fale Conosco" style="margin: 5px 0 20px 0;" />
        <h3 style="color: #202A72;">PREENCHA OS CAMPOS ABAIXO</h3>
        <div class="faixa_h"></div>
        <?
        pt_register('POST','submit1');
        if($submit1){
            $errors=array();
            pt_register('POST','nome');
            pt_register('POST','email');
            pt_register('POST','assunto');
            if($nome=="" || $email=="" || $assunto==""){
                if($nome=="")       $errors['nome']=1;
                if($email=="")      $errors['email']=1;
                if($assunto=="")    $errors['assunto']=1;
                $error.="<span style='font: 12px Arial; color:#000000;'>Nome / E-mail / Assunto / </span>";
            }
            $valida = validaEMAIL($email);
            if($valida=='false'){
                $errors['email']=1;
                $error.="<span style='font: 12px Arial; color:#000000;'>E-mail Inválido, digite corretamente / </span>";
            }
            if(count($errors)<1){
                $query="INSERT INTO cp_fale_conosco(";
                $query .="nome, email, assunto, data)";
                $query .="VALUES";
                $query .="('".$nome."','".$email."','".$assunto."',NOW())";
                $result = $objQuery->SQLQuery($query);
                $id = $objQuery->ID;
                $done=1;
                $msg .= "------------------------------------------------------------------------<br />";
                $msg .= "<strong>Mensagem enviada pelo Fale Conosco:.</strong><br />";
                $msg .= "------------------------------------------------------------------------<br />";
                $msg .= "<strong>Nome completo:</strong> $nome<br />";
                $msg .= "<strong>E-mail:</strong> $email<br />";
                $msg .= "<strong>Assunto:</strong><br /> $assunto<br />";
                $formato = "\nContent-type: text/html\n charset=iso-8859-1\n";
                $destinatario = "cartoriopostal@cartoriopostal.com.br,thauan.ricardo@ssiconsultoria.com.br";
                #$destinatario = "antonio.alves@softfox.com.br";
                $titulo = "Fale Conosco: Cartório Postal";
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
                                    <div id="apDiv-contato">
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
                                               <a href="#" onclick="fecharContato()"><img src="'.URL_IMAGES.'pages/image-bt-fechar.png" alt="Clique aqui para fechar este informativo." title="Clique aqui para fechar este informativo." /></a>
                                            </td>
                                        </tr>
                                        </table>
                                    </div>';
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
                         <label for="campo1" accesskey="3">Assunto:</label>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle" colspan="2">
                        <textarea name="assunto" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,300,'spcontando1');contarCaracteres(this.value,300,'sprestante1','campo1')" <?=($errors['assunto'])?'style="border: 1px solid #FF0000; width: 100%; height: 80px;"':''; ?> ><?= $assunto;?></textarea>
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
        <h4 style="color: #202A72;">OUTRAS UNIDADES DA CARTÓRIO POSTAL</h4>
        <div class="faixa_h"></div>
        <img src="<?= URL_IMAGES;?>pages/localize-a-unidade-cartorio-postal-mais-proxima-de-voce.png" alt="localize a unidade cartorio postal mais proxima de voce" title="Localize a unidade Cartório Postal mais próxima de você" style="margin: 5px 0 0 0;" />
        <fieldset style="margin-top: 5px; font-size: 12px;">        
        <form name="frm" action="" method="post" enctype="multipart/form-data">
            <table border="0" width="100%" align="center" cellpadding="3" cellspacing="3">
                <tr>
                    <td width="15%" align="left" valign="middle"><label for="fale_estado" accesskey="4">Seu Estado</label></td>
                    <td><label for="carrega_cidade" accesskey="5">Sua Cidade</label></td>
                    <td><label for="carrega_bairro" accesskey="6">Seu Bairro</label></td>
                </tr>
                <tr>
                    <td>
                        <select name="fale_estado" id="fale_estado" onChange="carrega_cidades(this.value,'');">
                            <option value="">UF</option>
                            <?
                            $servicoDAO = new ServicoDAO();
                            $lista = $servicoDAO->listaEstados();
                            $p_valor = '';
                            foreach ($lista as $l){
                                $p_valor .= '<option value="'.$l->estado.'"';
                                if($fale_estado==$l->estado) $p_valor .= 'selected="selected"'; 
                                $p_valor .= '>'.$l->estado.'</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="fale_cidade" id="carrega_cidade" class="form_estilo" onChange="carrega_bairros(fale_estado.value,this.value); carrega_franquias(this.value,fale_estado.value,'');">
                            <? if($fale_estado<>''){ ?>
                                <script language="javascript" type="text/javascript">
                                    carrega_cidades('<?= $fale_estado ?>','<?= $fale_cidade ?>');
                                </script>
                            <? } ?>	
                        </select>
                    </td>
                    <td>
                        <select name="fale_bairro" id="carrega_bairro" onChange="carrega_franquias(fale_cidade.value,fale_estado.value,this.value);">
                        <? if($fale_estado<>'' and $fale_cidade<>''){ ?>
                            <script language="javascript" type="text/javascript">
                                    carrega_bairros('<?= $fale_estado ?>','<?= $fale_cidade ?>');
                            </script>
                        <? } ?>	
                        </select>
                        <?
                        $empresaDAO = new EmpresaDAO();
                        $emp = $empresaDAO->listaEmpresa('','','');
                        ?>
                    </td>
                </tr>
            </table>
            </form>
        </fieldset>
        <div id="carrega_franquia"></div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>