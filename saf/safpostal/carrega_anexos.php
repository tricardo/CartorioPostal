<?
session_start();
require( "../includes/verifica_logado_safpostal.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );		
pt_register('GET','acao');
pt_register('GET','id_ficha');
pt_register('GET','id_anexo');
$dt  = new ListaInteressadosDAO();
switch($acao){
	case 1:
		$e = $dt->listaAnexo($id_ficha); 
		if(count($e) > 0){?>
			<div style="margin-left:14px; width:756px; font-weight:normal"><strong>Arquivos salvos:<a name="arquivos_salvos"></a></strong><br />
				<?foreach($e as $j => $arr){?>
					<div style="width:656px; float:left"><a href="<?=$arr->arquivo?>" target="_blank">- <?=$arr->nome?></a></div>
					<div style="width:100px; float:left"><a href="#arquivos_salvos" onclick="Anexos(<?=$id_ficha?>, 2, <?=$arr->id_anexo?>)" style="text-transform:lowercase">excluir</a></div>
				<? }?>
			</div>
			<div style="height:10px; width:756px;"></div>
	<?	}
	break;
	
	case 2:
		$e = $dt->excluiAnexo($id_anexo);
		echo '<img src="../images/null.gif" border="0" onload="Anexos('.$id_ficha.', 1)" />';
	break;
}
?>