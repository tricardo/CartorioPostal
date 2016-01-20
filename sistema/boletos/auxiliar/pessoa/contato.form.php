<script src="<?=$baseUrl?>/especjs/pessoa.form" language="javascript" type="text/javascript"></script>﻿﻿
<a href="<?=$oficinaUrlBase.'/pessoa/detalhe/'.$cliente->id?>"><?=$cliente?></a>

﻿<fieldset>    <legend>Contato</legend>

    <form method="post" name="contatoForm" action="<?=$submit?>">
        <input type="hidden" name="valor" value="<?=$valor?>"/>
        <input type="hidden" name="acao" value="<?=$acao?>"/><br/>
        <input type="hidden" name="id" value="<?=$pessoa->id?>" id="id"/>
        <input type="hidden" name="idPessoa" value="<?=$pessoa->idPessoa?>"/>
        <input type="hidden" name="cliente" value="<?=($pessoa->cliente)?'1':'0'?>"/>
        <input type="hidden" name="fornecedor" value="<?=($pessoa->fornecedor)?'1':'0'?>"/>
        <input type="hidden" name="funcionario" value="<?=($pessoa->funcionario)?'1':'0'?>"/>
        <input type="hidden" name="contato" value="1"/>

        <input type="hidden" name="tipo" value="F"/>

        <div id="fisica">
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" onkeypress="cpfMasc(this)" value="<?=$pessoa->cpf ?>"/>
            <label for="sexo">Sexo:</label>
            <select name="sexo" id="sexo">
                <option value=""></option>
                <option value="FEMININO"<?=($pessoa->sexo=='FEMININO') ?'selected="selected"':''?>>FEMININO</option>
                <option value="MASCULINO"<?=($pessoa->sexo=='MASCULINO') ?'selected="selected"':''?>>MASCULINO</option>
            </select>
            <label>Anivers&aacute;rio:</label>
            <input type="text" name="nascimento" value="<?=($pessoa->tipo=='F')?$pessoa->getFormatNascimento():'' ?>" onkeyup="dataMascAni(this)" maxlength="5"  size="5" align="right"/>(dd/mm)

            <script type="text/javascript" language="javascript">
                //<![CDATA[
                cpfMasc($('cpf'));
                //]]>
            </script>
        </div>

        <label for="nome">Nome:</label>
        <input  class="strUpper" type="text" size="50" name="nome" value="<?=$pessoa->nome ?>" id="nome"/>
        <br/>
        <label for="email">Email:</label>
        <input  class="strLower"  type="text" size="50" name="email" value="<?=$pessoa->email?>" id="email"/>
        <br />
        <?
        $telefones = $pessoa->telefones;
        include("telefone.form.php");
        ?>


        <input  type="submit" value="ENVIAR"/>

    </form>
</fieldset>

