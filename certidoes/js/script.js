var site = window.location.hostname;
var HTTP_HOST = 'http://www.cartoriopostal.com.br/certidoes';
if(site.indexOf("canal") != -1){
	HTTP_HOST = 'http://www.cartoriopostal.com.br/certidoes';
} else if(site.indexOf("127.0.0.1") != -1 || site.indexOf("localhost") != -1){
	HTTP_HOST = 'http://127.0.0.1/certidoes/';
}
var oScripts = new Array('ajax','jquery','cycle','jcarousellite','js','maskedinput','mask_form','shadowbox/shadowbox','jkmegamenu');
for(i = 0; i < oScripts.length; i++){
	document.write('<script src="'+HTTP_HOST+'/js/' + oScripts[i] + '.js" language="javascript" type="text/javascript"></script>');
}