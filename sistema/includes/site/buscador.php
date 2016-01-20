            	<!--  buscador -->
                <div class="busca_bg">
                    <div class="busca_topo">
              	 <form action="classificados.php" method="get" action="classificados.php" id="form_busca" enctype="multipart/form-data">
                        <div style="float:left; margin-left:23px">
                          <strong>Categoria:</strong>
                          <select name="id_categoria" style="width:270px" class="textfield_busca" onchange="carrega_subcategoria(this.value,'');">
                            <option value="">Selecione a Categoria</option>
                            	<? 
								$id_categoria = $_GET['id_categoria'];
								$sql = $objQuery->SQLQuery("SELECT * from vsites_categorias order by categoria");
								while($res = mysql_fetch_array($sql)){
									echo '<option value="'.$res['id_categoria'].'"';
									if($res['id_categoria'] == $id_categoria) echo ' selected="selected"';
									echo '>'.$res['categoria'].'</option>';
								}
								?>
                          </select>
                          </div>
                    	  <div style="float:left; margin-left:2px">
                          <strong>Subcategoria:</strong>
                          <select name="id_subcategoria" style="width:270px" id="subcategoria" class="textfield_busca">
                           	  <option value="">Selecione a Subcategoria</option>
                          </select>                          
                          <input type="submit" name="submit" class="button_busca" value=" Buscar " />
                          
                          <?
	                       if($id_subcategoria=='null')$id_subcategoria='';
						   if($_GET['id_categoria']<>''){ ?>
                          	<script type="text/javascript">
								carrega_subcategoria('<?= $_GET['id_categoria'] ?>', '<?= $_GET['id_subcategoria'] ?>');
							</script>
						  <? } ?>
                          </div>
                        </form>
                    </div>
	                <div class="busca_rodape"><!-- Não mexer --></div>
                </div> 
                <!--  Fim do buscador -->