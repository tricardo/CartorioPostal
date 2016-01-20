<?php

// pega o endere�o do diret�rio

$diretorio 		 = '../../'.$url; 
$pasta_principal = '../../'.$url; 
unset($ponteiro);
unset($itens);
unset($listar);
unset($arquivos);
unset($pastas2);
unset($pastas);
unset($nome_itens);
unset($subdiretorio);

// abre o diret�rio

$dir_encontrado=0;

$ponteiro  = opendir($diretorio);

// monta os vetores com os itens encontrados na pasta

while ($nome_itens = readdir($ponteiro)) {    $itens[] = $diretorio.'/'.$nome_itens;}



//sort: ordena os vetores (arrays), de acordo com os par�metros informados. Aqui estou ordenando por pastas e depois arquivos 

// ordena o vetor de itens

	



	sort($itens);

	$dir_encontrato=0;

	// percorre o vetor para fazer a separacao entre arquivos e pastas 

	foreach ($itens as $listar) {

	// retira "./" e "../" para que retorne apenas pastas e arquivos   

		if ($listar!=$diretorio.'/.' && $listar!=$diretorio.'/..'){ 

			// checa se o tipo de arquivo encontrado � uma pasta   		

			if (is_dir($listar)) { // caso VERDADEIRO adiciona o item � vari�vel de pastas

				$pastas[]=$listar;

				$dir_encontrado++;

			} else{ 

				// caso FALSO adiciona o item � vari�vel de arquivos

				$arquivos[]=$listar;		

			}   

		}

	}



$pastas2=$pastas;	

while($dir_encontrado > 0){	

unset($subdiretorio);

$subdiretorio = $pastas; 	

$i=0;

$final=$dir_encontrado;

$dir_encontrado=0;

unset($itens);

unset($listar);

unset($pastas);

while($i < $final){

$diretorio=$subdiretorio [$i];

// pega o endere�o do diret�rio

// abre o diret�rio

$ponteiro  = opendir($diretorio);

// monta os vetores com os itens encontrados na pasta

while ($nome_itens = readdir($ponteiro)) {    $itens[] = $diretorio.'/'.$nome_itens;}



//sort: ordena os vetores (arrays), de acordo com os par�metros informados. Aqui estou ordenando por pastas e depois arquivos 

// ordena o vetor de itens

	



	sort($itens);

	// percorre o vetor para fazer a separacao entre arquivos e pastas 

	foreach ($itens as $listar) {

	// retira "./" e "../" para que retorne apenas pastas e arquivos   

		if ($listar!=$diretorio.'/.' && $listar!=$diretorio.'/..'){ 

			// checa se o tipo de arquivo encontrado � uma pasta 

			if (is_dir($listar)) { // caso VERDADEIRO adiciona o item � vari�vel de pastas

				$pastas2[]=$listar;

				$pastas[]=$listar;

				$dir_encontrado++;

			} else{ 

				// caso FALSO adiciona o item � vari�vel de arquivos

				$arquivos[]=$listar;		

			}   

		}

	}

$i++;

unset($itens);

unset($listar);

}

}

//Vimos acima, a express�o is_dir, indicando que as a��es devem esnt�o ser executadas, ali mesmo, no diret�rio que j� foi aberto e lido. As a��es que executamos ali, foram: ver se tem pastas, listar. Ver se tem arquivos, listar.



//Agora, se houverem pastas, ser�o apresentadas antes dos arquivos, em odem alfab�tica.

//Se n�o houverem, ser�o apresentados apenas os arquivos, na mesma ordem.

//E se houverem os dois, ser�o mostrados igualmente.







// lista as pastas se houverem

// lista os arquivos se houverem

$conta = count($pastas2);

echo $conta;

if ($arquivos != "") {foreach($arquivos as $listar){ unlink($listar);  print " Arquivo: <a href='$listar'>$listar</a><br>";}   }

if ($pastas2 != "" ) { 

	while($conta>0){

		$apaga=$pastas2[$conta-1];
		rmdir($apaga);  

		print "Pasta: <a href='".$apaga."'>".$apaga."</a><br>";

		$conta--;

	}	

}
rmdir($pasta_principal);

?>