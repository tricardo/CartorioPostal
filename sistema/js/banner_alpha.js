function banner(imgSource,url,alt,chance) {
this.imgSource = imgSource;
this.url = url;
this.alt = alt;
this.chance = chance;
}
function dispBanner() {
with (this) document.write("<A HREF='" + url + "'><IMG SRC='" + imgSource + "' WIDTH='518' HEIGHT='68' BORDER='0' ALT='" + alt + "'></A>");
}
banner.prototype.dispBanner = dispBanner;
banners = new Array();

banners[0] = new banner("http://www.alphatem.com.br/alphatem/alphatem-1/images/index_r11_c4.jpg","#1","Banner 1",10);
banners[1] = new banner("http://www.alphatem.com.br/alphatem/images/publicidade/sub_epocamais.png","http://www.epocamais.com.br","Época Mais Comunicação",11);
banners[2] = new banner("http://www.alphatem.com.br/alphatem/alphatem-1/images/index_r11_c4.jpg","#3","Banner 3",12);
banners[3] = new banner("http://www.alphatem.com.br/alphatem/images/publicidade/sub_epocamais.png","http://www.epocamais.com.br","Época Mais Comunicação",12);
banners[4] = new banner("http://www.alphatem.com.br/alphatem/alphatem-1/images/index_r11_c4.jpg","#5","Banner 5",14);

sum_of_all_chances = 0;
for (i = 0; i < banners.length; i++) {
sum_of_all_chances += banners[1].chance;
}
function randomBanner() {
chance_limit = 0;
randomly_selected_chance = Math.round((sum_of_all_chances - 1) * Math.random()) + 1;
for (i = 0; i < banners.length; i++) {
chance_limit += banners[1].chance;
if (i>5){ cont=1; }
else { cont =i; }
if (randomly_selected_chance <= chance_limit) {
document.write("<A HREF='" + banners[cont].url + "'><IMG SRC='" + banners[cont].imgSource + "' WIDTH='519' HEIGHT='68' BORDER='0' ALT='" + banners[cont].alt + "'></A>");
return banners[cont];
break;
}
}
}

























function banner2(imgSource,url,alt,chance) {
this.imgSource = imgSource;
this.url = url;
this.alt = alt;
this.chance = chance;
}
function dispBanner2() {
with (this) document.write("<A HREF='" + url + "'><IMG SRC='" + imgSource + "' WIDTH='218' HEIGHT='162' BORDER='0' ALT='" + alt + "'></A>");
}
banner2.prototype.dispBanner2 = dispBanner2;
banners2 = new Array();

banners2[0] = new banner2("http://www.alphatem.com.br/alphatem/alphatem-1/images/index_r2_c29.jpg","#1","Banner 1",10);
banners2[1] = new banner2("http://www.alphatem.com.br/alphatem/images/publicidade/epoca_mais.png","http://www.epocamais.com.br","Epoca Mais",11);
banners2[2] = new banner2("http://www.alphatem.com.br/alphatem/images/publicidade/luzevida.png","http://www.fontedeluzevida.com.br","Livraria evangelica",12);
banners2[3] = new banner2("http://www.alphatem.com.br/alphatem/images/publicidade/epoca_mais.png","http://www.epocamais.com.br","Epoca Mais",11);
banners2[4] = new banner2("http://www.alphatem.com.br/alphatem/images/publicidade/luzevida.png","http://www.fontedeluzevida.com.br","Livraria evangelica",12);

sum_of_all_chances2 = 0;
for (i = 0; i < banners.length; i++) {
sum_of_all_chances2 += banners2[1].chance;
}
function randomBanner2() {
chance_limit2 = 0;
randomly_selected_chance2 = Math.round((sum_of_all_chances2 - 1) * Math.random()) + 1;
for (i = 0; i < banners2.length; i++) {
chance_limit2 += banners2[1].chance;
if (i>5){ cont=1; }
else { cont =i; }
if (randomly_selected_chance2 <= chance_limit2) {
document.write("<A HREF='" + banners2[cont].url + "'><IMG SRC='" + banners2[cont].imgSource + "' WIDTH='218' HEIGHT='162' BORDER='0' ALT='" + banners2[cont].alt + "'></A>");
return banners2[cont];
break;
}
}
}

