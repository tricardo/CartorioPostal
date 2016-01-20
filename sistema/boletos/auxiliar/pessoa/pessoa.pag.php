<? if($pagina=="") { ?>
<div id="pessoas" class="lista">
<? } ?>
	<? if($pagina>0){?>
	<a href="<?=$oficinaUrlBase?>/pessoa/listar/<?=$_GET["valor"]?>/pagina/<?=$_GET["pagina"]-1?>"><<</a>
	<? }?>
	<a href="<?=$oficinaUrlBase?>/pessoa/listar/<?=$_GET["valor"]?>/pagina/<?=$_GET["pagina"]+1?>">>></a>
<? include("pessoa.list.php"); ?>	
<? if($pagina=="") { ?>
	</div>
<? } ?>