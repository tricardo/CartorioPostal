var hoje=new Date();
var dia=hoje.getDay();
var data=hoje.getDate();
if (data<10){data="0"+data;}
var mes=hoje.getMonth();
var ano=hoje.getFullYear();

var dias=new Array("Domingo", "Segunda feira", "Terça feira", "Quarta feira", "Quinta feira", "Sexta feira", "Sábado");
var meses=new Array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

var d = new Date()
var h = d.getHours()
if (h < 12)
document.write("Bom dia!")
else
if (h < 18)
document.write("Boa tarde!")
else
document.write("Boa noite! ")

document.write(" "+dias[dia]+", "+data+" de "+meses[mes]+" de "+ano+". ");