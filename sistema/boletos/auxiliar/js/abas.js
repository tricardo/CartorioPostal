
 function stAba(menu,conteudo)
 {
 this.menu = menu;
 this.conteudo = conteudo;
 }

 var arAbas = new Array();
 arAbas[0] = new stAba('td_opcao1','div_opcao1');
 arAbas[1] = new stAba('td_opcao2','div_opcao2');
 arAbas[2] = new stAba('td_opcao3','div_opcao3');
 arAbas[3] = new stAba('td_opcao4','div_opcao4');

 function AlternarAbas(menu,conteudo)
 {
 for (i=0;i<arAbas.length;i++)
 {
  m = document.getElementById(arAbas[i].menu);
  m.className = 'menu';
  c = document.getElementById(arAbas[i].conteudo)
  c.style.display = 'none';
 }
 m = document.getElementById(menu)
 m.className = 'menu-sel';
 c = document.getElementById(conteudo)
 c.style.display = '';
 }


