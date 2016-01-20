<script src="<?=$baseUrl?>/especjs/pessoa.form" language="javascript" type="text/javascript"></script>﻿﻿
<script src="<?=$baseUrl?>/mjs/abas" language="javascript" type="text/javascript"></script>﻿﻿
﻿<fieldset>
    <legend>
			Cadastro de Franquia
    </legend>
    <form method="post" name="empresaForm" action="<?=$submit?>">
        <input type="hidden" name="valor" value="<?=$valor?>"/>
        <input type="hidden" name="acao" value="<?=$acao?>"/><br/>
        <input type="hidden" name="id" value="<?=$pessoa->id?>"/>
        <input type="hidden" name="idPessoa" value="<?=$pessoa->idPessoa?>"/>
        <input type="hidden" name="cliente" value="<?=($pessoa->cliente)?'1':'0'?>"/>
        <input type="hidden" name="fornecedor" value="<?=($pessoa->fornecedor)?'1':'0'?>"/>
        <input type="hidden" name="funcionario" value="<?=($pessoa->funcionario)?'1':'0'?>"/>
        <input type="hidden" name="empresa" value="1"/>

        <input type="hidden" name="tipo" value="J"/>
        
        <div id="juridica">
            <label>CNPJ:</label>
            <input type="text" name="cnpj" value="<?=$pessoa->cnpj?>" onkeypress="mascara(this,cnpjMasc)" align="right"/>
            <label>Insc. Estadual:</label>
            <input type="text" name="inscEstadual" value="<?=$pessoa->inscEstadual ?>" align="right"/>
            <label>CCM:</label>
            <input type="text" name="ccm" value="<?=$pessoa->ccm ?>" align="right"/>
        </div>
        <label>Nome: </label>
        <input  class="strUpper" type="text" size="50" name="nome" value="<?=$pessoa->nome ?>"/>

        <? if($pessoa->ativo=='1') { ?>
        <input type="checkbox" name="ativo"  checked='checked'  value="1"/>Ativo
        <? }else { ?>
        <input type="checkbox" name="ativo" value="1"/>Ativo
        <? } ?>
        <br/>
        <label>Email:</label>
        <input  class="strLower"  type="text" size="50" name="email" value="<?=$pessoa->email?>"/>
	<label for="cep">CEP:</label>
        <input  id="cep" type="text" name="cep[4]" value="<?=$pessoa->getEndereco(4)->cep ?>" onkeyup="cepMasc(this);" onblur="buscaCep(this.value, 'endereco');" maxlength="9" align="right"/><br />
				<label for="end">Endere&ccedil;o:</label>
                                <input class="strUpper" id="end" type="text" name="endereco[4]" value="<?=$pessoa->getEndereco(4)->endereco ?>" id="endereco" size="50"/>
				<label for="nro">No.:</label> <input  id="nro" type="text" name="numero[<?=4?>]" value="<?=$pessoa->getEndereco(4)->numero ?>" size="4" align="right"/>

				<label for="compl">Compl.:</label>
				<input class="strUpper" id="compl" type="text" name="compl[4]" value="<?=$pessoa->getEndereco(4)->compl ?>" size="10"/><br />
				<label for="bairro">Bairro:</label>
				<input class="strUpper" id="bairro" type="text" value="<?=$pessoa->getEndereco(4)->bairro ?>" name="bairro[4]" size="50"/>
				<br/>
				<label for="uf">UF:</label>
				<select id="uf" name="uf[4]" size="1">
					<option value="SP" <?=($pessoa->getEndereco(4)->uf=='SP') ?'selected="selected"':''?>>SP</option>
					<option value="AC" <?=($pessoa->getEndereco(4)->uf=='AC') ?'selected="selected"':''?>>AC</option>
					<option value="AL" <?=($pessoa->getEndereco(4)->uf=='AL') ?'selected="selected"':''?>>AL</option>
					<option value="AM" <?=($pessoa->getEndereco(4)->uf=='AM') ?'selected="selected"':''?>>AM</option>
					<option value="AP" <?=($pessoa->getEndereco(4)->uf=='AP') ?'selected="selected"':''?>>AP</option>
					<option value="BA" <?=($pessoa->getEndereco(4)->uf=='BA') ?'selected="selected"':''?>>BA</option>
					<option value="DF" <?=($pessoa->getEndereco(4)->uf=='DF') ?'selected="selected"':''?>>DF</option>
					<option value="ES" <?=($pessoa->getEndereco(4)->uf=='ES') ?'selected="selected"':''?>>SP</option>
					<option value="GO" <?=($pessoa->getEndereco(4)->uf=='GO') ?'selected="selected"':''?>>GO</option>
					<option value="MA" <?=($pessoa->getEndereco(4)->uf=='MA') ?'selected="selected"':''?>>MA</option>
					<option value="MG" <?=($pessoa->getEndereco(4)->uf=='MG') ?'selected="selected"':''?>>MG</option>
					<option value="MS" <?=($pessoa->getEndereco(4)->uf=='MS') ?'selected="selected"':''?>>MS</option>
					<option value="MT" <?=($pessoa->getEndereco(4)->uf=='MT') ?'selected="selected"':''?>>MT</option>
					<option value="PA" <?=($pessoa->getEndereco(4)->uf=='PA') ?'selected="selected"':''?>>PA</option>
					<option value="PB" <?=($pessoa->getEndereco(4)->uf=='PB') ?'selected="selected"':''?>>PB</option>
					<option value="PI" <?=($pessoa->getEndereco(4)->uf=='PI') ?'selected="selected"':''?>>PI</option>
					<option value="PR" <?=($pessoa->getEndereco(4)->uf=='PR') ?'selected="selected"':''?>>PR</option>
					<option value="RJ" <?=($pessoa->getEndereco(4)->uf=='RJ') ?'selected="selected"':''?>>RJ</option>
					<option value="RN" <?=($pessoa->getEndereco(4)->uf=='RN') ?'selected="selected"':''?>>RN</option>
					<option value="RO" <?=($pessoa->getEndereco(4)->uf=='RO') ?'selected="selected"':''?>>RO</option>
					<option value="RR" <?=($pessoa->getEndereco(4)->uf=='RR') ?'selected="selected"':''?>>RR</option>
					<option value="RS" <?=($pessoa->getEndereco(4)->uf=='RS') ?'selected="selected"':''?>>RS</option>
					<option value="SC" <?=($pessoa->getEndereco(4)->uf=='SC') ?'selected="selected"':''?>>SC</option>
					<option value="SE" <?=($pessoa->getEndereco(4)->uf=='SE') ?'selected="selected"':''?>>SE</option>
					<option value="TO" <?=($pessoa->getEndereco(4)->uf=='TO') ?'selected="selected"':''?>>TO</option>
				</select>
				<label for="cidade">Cidade:</label>
				<input class="strUpper" id="cidade" type="text" value="<?=$pessoa->getEndereco(4)->cidade ?>" name="cidade[4]"/>

        <?
        $telefones = $pessoa->telefones;
        include("telefone.form.php");
        ?>

        <br />
        <fieldset class="semborda">
            <input  type="submit" value="ENVIAR"/>
        </fieldset>

    </form>

    <script type="text/javascript" language="javascript">
        //<![CDATA[
        AlternarAbas('td_opcao1','div_opcao1');
        //]]>
    </script>
</fieldset>