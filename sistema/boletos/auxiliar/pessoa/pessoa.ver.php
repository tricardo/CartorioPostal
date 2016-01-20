
<fieldset>
    <legend>
        <? if($pessoa->cliente) { ?>
            Cadastro de Cliente
        <? } if($pessoa->fornecedor) { ?>
	    Cadastro de Fornecedor
        <? } if($pessoa->funcionario) { ?>
            Cadasro de Funcionario
        <? }else{ ?>
            Cadastro de Pessoa
        <? } ?>
    </legend>

    <form method="post" name="pessoaForm" >

        <input type="hidden" id="tipo" name="tipo" value="<?=$pessoa->tipo ?>"/>
        <?php if($pessoa->tipo=='F'){ ?>
        <div id="fisica">
            <label for="cpfV">CPF:</label>
            <input type="text" name="cpf" id="cpfV" value="<?=$pessoa->cpf ?>"/>
            <label for="sexo">Sexo:</label>
            <select name="sexo" id="sexo">
                <option value=""></option>
                <option value="FEMININO"<?=($pessoa->sexo=='FEMININO') ?'selected="selected"':''?>>FEMININO</option>
                <option value="MASCULINO"<?=($pessoa->sexo=='MASCULINO') ?'selected="selected"':''?>>MASCULINO</option>
            </select>
            <label for="nascimento"> Anivers&aacute;rio:</label>
            <input type="text" name="nascimento" value="<?=($pessoa->tipo=='F')?$pessoa->getFormatNascimento():'' ?>" onkeyup="dataMascAni(this)" maxlength="5"  size="5" align="right"/>
        	(dd/mm)
            <br />

            <? if( !$pessoa->funcionario && $valor!="funcionario") { ?>
            <label for="idprofissao">Profiss&atilde;o:</label>
            <select name="idProfissao" id="idprofissao">
                    <? foreach($profissoes as $profissao) { ?>
                <option value="<?=$profissao->id ?>" <?=($profissao->id==$pessoa->idProfissao)?'selected="selected"':'' ?>>
                            <?=$profissao ?>
                </option>
                    <? }?>
            </select>
            <? } ?>
            <script type="text/javascript" language="javascript">
                //<![CDATA[
                cpfMasc($('cpfV'));
                alert('x');
                //]]>
            </script>
        </div>
        <?php }elseif($pessoa->tipo=='J'){ ?>
        <div id="juridica">
            <label for="cnpj">CNPJ:</label><input type="text" id="cnpj" name="cnpj" value="<?=$pessoa->cnpj?>" onkeypress="mascara(this,cnpjMasc)" align="right"/>
            <label for="inscEstadual">Insc.Estadual:</label><input type="text" name="inscEstadual" value="<?=$pessoa->inscEstadual ?>" align="right"/>
  	    CCM:<input type="text" name="ccm" value="<?=$pessoa->ccm ?>" align="right"/>
            <script type="text/javascript" language="javascript">
                //<![CDATA[
                mascara($('cnpj'),cnpjMasc);
                //]]>
            </script>
        </div>
        <?php } ?>
        <label for="nome">Nome:</label><input id="nome" type="text" size="50" name="nome" value="<?=$pessoa->nome ?>"/><br/>
        <label for="email">Email:</label><input id="email" type="text" size="50" name="email" value="<?=$pessoa->email?>"/>

        <?
        $telefones = $pessoa->telefones;
        include("telefone.form.php");
        ?>
    </form>
</fieldset>

<script type="text/javascript" language="javascript">
    //<![CDATA[
    mudaForm();
    AlternarAbas('td_opcao1','div_opcao1');
    //]]>
</script>
