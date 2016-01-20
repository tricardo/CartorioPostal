<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>2RTD-AL</title>
<style media="all" type="text/css">@import "/css/estilo2rtd.css";</style> 
<script type="text/javascript" src="login_data/png.js"></script>
<script type="text/javascript" src="login_data/jquery_002.js"></script>
	<link rel="stylesheet" type="text/css" href="login_data/jquery.css" media="screen">
	<script type="text/javascript" src="login_data/jquery.js"></script>
	<script type="text/javascript">
$(document).ready(function() {
			$("a.zoom").fancybox();

			$("a.zoom1").fancybox({
				'overlayOpacity'	:	0.7,
				'overlayColor'		:	'#FFF'
			});

			$("a.zoom2").fancybox({
				'zoomSpeedIn'		:	500,
				'zoomSpeedOut'		:	500,
				'overlayShow'		:	false
			});
			
			$("a.iframe").fancybox({
		'hideOnContentClick': false
	});
		});
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
    </script>

</head>

<body leftmargin="0" topmargin="0"><div align="center">
<img src="login_data/topo.png" width="850" height="221">
<table width="200" border="0">
  <tbody><tr>
    <td><img src="login_data/pcartorio_postal.png" width="400" height="146"></td>
    <td><form name="form1" method="post" action="http://www.2rtd-al.com.br/admin/login.php">
       <input name="acesso" value="BP" type="hidden">
          <div align="center"><img src="login_data/meio_16.png" width="261" height="46"> <br>
          </div>
          <table width="50%" align="center" border="0" cellpadding="0" cellspacing="0">
            <tbody><tr>
              <td><div align="center"><strong><font size="1" color="#006F39" face="Geneva, Arial, Helvetica, sans-serif">Usuário</font></strong></div></td>
            </tr>
            <tr>
              <td>
                <div align="center">
                  <input name="usuario" class="text_form" id="usuario" size="15" maxlength="20" type="text">
                </div>
              </td>
            </tr>
            <tr>
              <td><div align="center"><strong><font size="1" color="#006F39" face="Geneva, Arial, Helvetica, sans-serif">Senha:</font></strong></div></td>
            </tr>
            <tr>
              <td valign="top" height="32"><div align="center">
                <input name="senha" class="text_form" id="senha" size="15" maxlength="15" type="password">
                <br>
                </div></td>
            </tr>
            <tr>
              <td valign="top" height="32"><div align="center">
                <input src="login_data/lock.png" name="button" id="button" value="Submit" type="submit">
                <br>
                </div></td>
            </tr>
        </tbody></table>
</form></td>
  </tr>
  <tr>
    <td colspan="2"> </td>
  </tr>
</tbody></table>
</div>


</body></html>