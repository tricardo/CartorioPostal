			<div class="post_comp">
				<div class="esq">
					<a class="a2a_dd" href="http://www.addtoany.com/share_save?linkurl=<?= $url_rede ?>;linkname=CabideiroCultural">
						<img src="<?= URL_IMAGES ?>icon/bt_compartilhar.png" alt="Compartilhar" border="0"/>
					</a>
					<script type="text/javascript">
						var a2a_config = a2a_config || {};
						a2a_config.linkname = "Cartório Postal";
						a2a_config.linkurl = "<?= $url_rede ?>";
						a2a_config.locale = "pt-BR";
						a2a_config.num_services = 8;
						a2a_config.prioritize = ["email", "google_gmail", "live", "myspace", "orkut", "yahoo_mail", "blogger_post"];
					</script>
					<script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>
				</div>
				<div class="esq">
					<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
					<div>
						<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?= $url_rede ?>" data-text="Buscamos suas certidões em qualquer lugar do Brasil" data-count="horizontal" data-via="cartoriopostal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
					</div>
				</div>
				<div class="esq">
						<iframe src="http://www.facebook.com/plugins/like.php?href=<?= $url_rede ?>&amp;layout=button_count&amp;show_faces=false&amp;width=205&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=25" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:25px;" allowTransparency="true"></iframe>
				</div>
				<div id="orkut-button" class="esq">
					<script type="text/javascript" src="http://www.google.com/jsapi"></script>
					<script type="text/javascript">
					  google.load('orkut.share', '1');
					  google.setOnLoadCallback(function() {
						new google.orkut.share.Button({
						  lang: 'pt_BR',
						  style: google.orkut.share.Button.STYLE_MINI,
						  title: 'Google Internet Bus',
						  
						  summary: ('The Internet Bus Project is an attempt ' +
									'to educate people about the Internet'),
						  thumbnail: ('http://lh5.ggpht.com/_AS18ZY6z1m8/SYWgcvA5beI' +
									  '/AAAAAAAAANw/DfoApipJxcY/s128/DSC_0013%20.jpg'),
						  destination: 'http://www.google.co.in/en/internetbus/'
						}).draw('orkut-button');
					  });
					</script>
				</div>
				
				<div class="esq">
					<g:plusone></g:plusone>
				</div>
			</div>
