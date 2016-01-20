<form enctype="multipart/form-data" action="pedido_import_result.php" method="post" name="pedido_print" target="_blank">
	<center>
		<table width="650" class="tabela">
		<tr>
			<td colspan="4" class="tabela_tit"> Importar Arquivo</td>
		</tr>
        <tr>
			<td width="100"> <div align="right"><strong>Arquivo: </strong></div></td>
			<td width="313" colspan="3">
				<input type="file" name="file_import" style="width:150px" class="form_estilo">
			</td>
		</tr>
        <tr>
			<td colspan="4" align="center">
				<input type="submit" name="submit" value="Importar" class="button_busca" />&nbsp; <input type="submit" name="cancelar" value=" Voltar " onclick="document.pedido_print.target='_self'; document.pedido_print.action='pedido.php'" class="button_busca" />
			</td>
		</tr>
		</table>
	</center>
</form>

</td>
</tr>
</table>  
</div>
<? #fim da alteração de status
require('footer.php');
exit;
?>