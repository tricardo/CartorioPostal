<?
require('includes/url.php');
?>
<div id="container">
        <img src="<?= URL_IMAGES;?>pages/fale-conosco.png" alt="fale conosco" title="Fale Conosco" style="margin: 5px 0 20px 0;" />
        <h3 style="color: #202A72;">PREENCHA OS CAMPOS ABAIXO</h3>
        <div class="faixa_h"></div>
        <?
        pt_register('POST','submit1');
        if($submit1){
            $errors=array();
            pt_register('POST','id_empresa');
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
                $query .="id_empresa, nome, email, assunto, data)";
                $query .="VALUES";
                $query .="('".$fr->id_empresa."','".$nome."','".$email."','".$assunto."',NOW())";
                $result = $objQuery->SQLQuery($query);
                $id = $objQuery->ID;
                $done=1;
            }
        }
        if($done!=1){
        ?>
        <form name="frm" action="" method="post" enctype="multipart/form-data">
            <div style="width: 690px;">
            <table border="0" width="100%" align="center" cellpadding="3" cellspacing="3">
                <tr>
                    <td align="left" valign="middle" colspan="4">
                        <?
                        if($error!=''){
                                echo '<fieldset>
                                      <legend><strong style="font-size: 12px; color: #FF0000;">Ocorreram os seguintes erros:</strong></legend>';
                                if ($errors){
                                    echo $error;
                                }
                                echo '</fieldset>';
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
            </div>
        </form>
        <?
        }
        if($done){
            echo '<img src="'.URL_IMAGES.'pages/mensagem-enviada-com-sucesso.png" alt="mensagem enviada com sucesso" title="Mensagem enviada com sucesso!" />';
            echo '<meta HTTP-EQUIV="refresh" CONTENT="5; URL='.URL_SITE.'">';
        }
        ?>
</div>