<script src="<?=$urlBase?>/especjs/pessoa.form" language="javascript" type="text/javascript"></script>
<script src="<?=$urlBase?>/mjs/abas" language="javascript" type="text/javascript"></script>
<fieldset>
    <legend>
        <?php if($pessoa->fornecedor) { ?>
	    Cadastro de Fornecedor
        <?php } ?>
    </legend>

    <form method="post" name="pessoaForm" action="<?=$submit?>">
        <input type="hidden" name="valor" value="<?=$valor?>"/>
        <input type="hidden" name="acao" value="<?=$acao?>"/><br/>
        <input type="hidden" name="id" value="<?=$pessoa->id?>" id="id"/>

        <input type="hidden" name="cliente" value="<?=($pessoa->cliente)?'1':'0'?>"/>
        <input type="hidden" name="outros" value="<?=($pessoa->outros)?'1':'0'?>"/>
        <input type="hidden" name="fornecedor" value="<?=($pessoa->fornecedor)?'1':'0'?>"/>
        <input type="hidden" name="funcionario" value="<?=($pessoa->funcionario)?'1':'0'?>"/>
      
        <label for="tipo">Tipo:</label>
        <select name="tipo"  id="tipo" tabindex="1">
            <option value="F" <?=($pessoa->tipo=='F')?'selected="selected"':'' ?>>Pessoa F&iacute;sica</option>
            <option value="J" <?=($pessoa->tipo=='J')?'selected="selected"':'' ?>>Pessoa Jur&iacute;dica</option>
        </select>
         
        <div id="fisica">
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" value="<?=$pessoa->cpf ?>" maxlength="14" tabindex="2" align="right"/><br/>
            <label for="sexo">Sexo:</label>
            <select name="sexo" id="sexo" tabindex="3">
                <option value=""></option>
                <option value="FEMININO"<?=($pessoa->sexo=='FEMININO') ?'selected="selected"':''?>>FEMININO</option>
                <option value="MASCULINO"<?=($pessoa->sexo=='MASCULINO') ?'selected="selected"':''?>>MASCULINO</option>
            </select>
            <label for="nascimento"> Anivers&aacute;rio:</label>
            <input type="text" name="nascimento" value="<?=($pessoa->tipo=='F')?$pessoa->getFormatNascimento():'' ?>" onkeyup="dataMascAni(this)" maxlength="5"  size="5" tabindex="4" align="right"/>
        	(dd/mm)
            <? if($acao=="insere") { ?>
                <input type="hidden" name="ativo"  checked='checked'  value="1" />
            <? }else { ?>
            <label for="ativo" >Ativo </label>
            <input  class="chk" type="checkbox" name="ativo" tabindex="4"  <?php if($pessoa->ativo==1) echo 'checked="checked"'?> />
                <? } ?>
            <img src="<?=$baseUrl?>/imagens/icones/verde.bmp" alt="" class="imagem">
            <br />

            <? if( !$pessoa->funcionario && $valor!="funcionario") { ?>
                <label for="idprofissao">Profiss&atilde;o:</label>
                <select name="idProfissao" id="idprofissao"tabindex="5" >
                        <? foreach($profissoes as $profissao) { ?>
                    <option value="<?=$profissao->id ?>" <?=($profissao->id==$pessoa->idProfissao)?'selected="selected"':'' ?>>
                                <?=$profissao ?>
                    </option>
                            <? }?>
                </select>
            <? } ?>
            <script type="text/javascript" language="javascript">
                //<![CDATA[
                cpfMasc(document.getElementById("cpf"));
                //]]>
            </script>
        </div>

        <div id="juridica">
            <label for="cnpj">CNPJ:</label><input type="text" id="cnpj" name="cnpj" maxlength="18" value="<?=$pessoa->cnpj?>" onkeypress="mascara(this,cnpjMasc)" align="right"/><br/>
            <label for="inscEstadual">Insc.Estadual:</label><input type="text" name="inscEstadual" value="<?=$pessoa->inscEstadual ?>" align="right" onkeyup="toUpper(this)"/><br/>
  	    	<label for="ccm">CCM:</label><input type="text" name="ccm" value="<?=$pessoa->ccm ?>" align="right"/>	<br/>
            <? if($acao=="insere") { ?>
            <input type="hidden" name="ativo"  checked='checked'  value="1" />
            <? }else { ?>
            <label for="ativo">Ativo</label>
            <input  class="chk" type="checkbox" name="ativo" tabindex="4"  <?php if($pessoa->ativo==1) echo 'checked="checked"'?>/>
                <? } ?>
                <img src="<?=$baseUrl?>/imagens/icones/verde.bmp" alt="" class="imagem">
            <script type="text/javascript" language="javascript">
                //<![CDATA[
                cnpjMasc(document.getElementById("cnpj"));
                //]]>
            </script>
        </div>

        <label for="nome">Nome:</label><input class="strUpper" id="nome" type="text" size="50" name="nome" maxlength="45" value="<?=$pessoa ?>" tabindex="6" onkeyup="toUpper(this)"/>
        <span id="nfantasia">
            <label for="nomefantasia">Nome Fantasia:</label><input class="strUpper" id="nomefantasia" type="text" size="30" name="nomefantasia" maxlength="30" tabindex="7" onkeypress="toUpper(this)" value="<?=$pessoa->nomefantasia ?>"/><br/>
        </span>
        
        <label for="email">Email:</label><input class="strLower" id="email" type="text" size="30" maxlength="45" tabindex="7" name="email" value="<?=$pessoa->email?>"/>
        <? include("endereco.form.php"); ?>
        <?
        $telefones = $pessoa->telefones;
        include("telefone.form.php");
        ?>

        <input type="hidden" name="idempresa" value="<?=$pessoa->idempresa ?>" id="idempresa"/>
        <input type="hidden" name="idcontato" value="<?=$pessoa->idcontato ?>" id="idcontato"/>

        <div class="semborda"><input  type="submit" value="ENVIAR"/></div>

    </form>
</fieldset> 

<script type="text/javascript" language="javascript">
    //<![CDATA[
    mudaForm();
    AlternarAbas('td_opcao1','div_opcao1');
    //]]>
</script>
