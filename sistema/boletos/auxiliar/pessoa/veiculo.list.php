<div class="lista" id="listaVeiculo">
    <? if(count($veiculos)==0) { ?>
    <div class="alerta">
		nenhum ve&iacute;culo encontrado
    </div>
    &nbsp;
    <? } ?>
    <ul>

        <? foreach($veiculos as $i=>$veiculo) { ?>
        <li class="cor<?=$i%2?>">
                <?if($orcamento) { ?>
            <a href="javascript:void(0);" onclick="populaOrcamento('veiculo',<?=$veiculo->id ?>, '<?=$veiculo ?>')">
                <img alt="editar" src="<?=$baseUrl?>/img/icones/add.gif">
            </a>
                <? } ?>
            <a href="<?=$oficinaUrlBase.'/veiculo/detalhe/'.$veiculo->placa ?>"><?=$veiculo ?></a>
        </li>
        <? } ?>

    </ul>

</div>