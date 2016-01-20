/* 
***********************
* Mascara de Numeros  *
***********************
*/
	function masc_numeros(obj,mascara) {
		str   = obj.value
		len   = str.length
		str2  = ""
		digito = /^\d$/
		for (i = 0; i < len ; i ++ ) {
			if (digito.test(str.charAt(i))) str2 += str.charAt(i)
		}
		str   = str2
		len   = str.length
		str2  = ""
		for (i = 0 , j = 0 ; j < len && i<mascara.length; i ++ ) {
			if (mascara.charAt(i) == "#") {
				str2 += str.charAt(j)
				j++
			} else {
				str2 += mascara.charAt(i)
			}
		}
		obj.value = str2
	}


/* 
***********************
* Popup  *
***********************
*/

function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}

//-->

// Script Source: CodeLifter.com
// Copyright 2003
// Do not remove this notice.

// SETUPS:
// ===============================

// Set the horizontal and vertical position for the popup

PositionX = 0;
PositionY = 0;

// Set these value approximately 20 pixels greater than the
// size of the largest image to be used (needed for Netscape)

defaultWidth  = 800;
defaultHeight = 800;

// Set autoclose true to have the window close automatically
// Set autoclose false to allow multiple popup windows

var AutoClose = true;

// Do not edit below this line...
// ================================
if (parseInt(navigator.appVersion.charAt(0))>=4){
var isNN=(navigator.appName=="Netscape")?1:0;
var isIE=(navigator.appName.indexOf("Microsoft")!=-1)?1:0;}
var optNN='scrollbars=no,width='+defaultWidth+',height='+defaultHeight+',left='+PositionX+',top='+PositionY;
var optIE='scrollbars=no,width=150,height=100,left='+PositionX+',top='+PositionY;

function popImage(imageURL,imageTitle){
if (isNN){imgWin=window.open('about:blank','',optNN);}
if (isIE){imgWin=window.open('about:blank','',optIE);}
with (imgWin.document){
writeln('<html><head><title>Loading...</title><style>body{margin:0px;}</style>');writeln('<sc'+'ript>');
writeln('var isNN,isIE;');writeln('if (parseInt(navigator.appVersion.charAt(0))>=4){');
writeln('isNN=(navigator.appName=="Netscape")?1:0;');writeln('isIE=(navigator.appName.indexOf("Microsoft")!=-1)?1:0;}');
writeln('function reSizeToImage(){');writeln('if (isIE){');writeln('window.resizeTo(100,100);');
writeln('width=100-(document.body.clientWidth-document.images[0].width);');
writeln('height=100-(document.body.clientHeight-document.images[0].height);');
writeln('window.resizeTo(width,height);}');writeln('if (isNN){');       
writeln('window.innerWidth=document.images["George"].width;');writeln('window.innerHeight=document.images["George"].height;}}');
writeln('function doTitle(){document.title="'+imageTitle+'";}');writeln('</sc'+'ript>');
if (!AutoClose) writeln('</head><body bgcolor=000000 scroll="no" onload="reSizeToImage();doTitle();self.focus()">')
else writeln('</head><body bgcolor=000000 scroll="no" onload="reSizeToImage();doTitle();self.focus()" onblur="self.close()">');
writeln('<img name="George" src='+imageURL+' style="display:block"></body></html>');
close();		
}}

/* 
***********************
* Confirma se é pra deletar  *
***********************
*/
function confirmDelete() {
 return confirm("Você tem certeza que deseja excluir esse registro?");   
} 