            	<!-- box -->
            	<div class="coluna_bg">
                    <div class="coluna_topo">
	                    <div class="coluna_conteudo">
    	                    <div class="tit_icon"><img src="images/icon/classificados.png" /></div>
                            <div class="tit_text">Categorias</div>
                            <div id="menu_clas">
                                <ul>
                                <? 
								$sql = $objQuery->SQLQuery("SELECT * from vsites_categorias, vsites_subcategorias where vsites_categorias.id_categoria = vsites_subcategorias.id_categoria order by vsites_categorias.categoria, vsites_subcategorias.subcategoria");
								while($res = mysql_fetch_array($sql)){
									echo '<li><a href="classificados.php?id_categoria='.$res['id_categoria'].'&id_subcategoria='.$res['id_subcategoria'].'">'.$res['subcategoria'].'</a></li>';
								}
								?>
                                </ul>
                            </div>
        				</div>              
                    </div>
	                <div class="coluna_rodape"><!-- Não mexer --></div>
                </div>  
                <!-- fim do box -->   
                 
            	<!-- box -->
            	<div class="coluna_bg">
                    <div class="coluna_topo">
                        <div class="coluna_conteudo">
                         <div class="tit_icon"><img src="images/icon/news.png" /></div><div class="tit_text">Newsletter</div>
                         <form name="newsletter" method="post" enctype="multipart/form-data" action="newsletter.php" style="margin-left:5px; width:130px">
                         	<b>Digite seu e-mail:</b><br />
							<input type="text" value="" name="newsletter" style="width:130px" class="textfield" />
                            <center><input type="submit" class="button_busca" name="submit" value="Cadastrar" /></center>
                         </form>
                         <br />
                        </div>
                    </div>
	                <div class="coluna_rodape"><!-- Não mexer --></div>
                </div>  
                <!-- fim do box -->    