<? session_start();
session_destroy();

if(substr_count($_SERVER['HTTP_HOST'], 'localhost') > 0){
	echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=http://localhost/www.cartoriopostal.com.br/login">';
} else {
	echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=http://www.cartoriopostal.com.br/login">';
}	
exit(); ?>	



