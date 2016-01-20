<?php

// pega o endereço do diretório

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

// abre o diretório

$dir_encontrado=0;

$ponteiro  = opendir($diretorio);

// monta os vetores com os itens encontrados na pasta

while ($nome_itens = readdir($ponteiro)) {    $itens[] = $diretorio.'/'.$nome_itens;}



//sort: ordena os vetores (arrays), de acordo com os parâmetros informados. Aqui estou ordenando por pastas e depois arquivos 

// ordena o vetor de itens

	



	sort($itens);

	$dir_encontrato=0;

	// percorre o vetor para fazer a separacao entre arquivos e pastas 

	foreach ($itens as $listar) {

	// retira "./" e "../" para que retorne apenas pastas e arquivos   

		if ($listar!=$diretorio.'/.' && $listar!=$diretorio.'/..'){ 

			// checa se o tipo de arquivo encontrado é uma pasta   		

			if (is_dir($listar)) { // caso VERDADEIRO adiciona o item à variável de pastas

				$pastas[]=$listar;

				$dir_encontrado++;

			} else{ 

				// caso FALSO adiciona o item à variável de arquivos

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

// pega o endereço do diretório

// abre o diretório

$ponteiro  = opendir($diretorio);

// monta os vetores com os itens encontrados na pasta

while ($nome_itens = readdir($ponteiro)) {    $itens[] = $diretorio.'/'.$nome_itens;}



//sort: ordena os vetores (arrays), de acordo com os parâmetros informados. Aqui estou ordenando por pastas e depois arquivos 

// ordena o vetor de itens

	



	sort($itens);

	// percorre o vetor para fazer a separacao entre arquivos e pastas 

	foreach ($itens as $listar) {

	// retira "./" e "../" para que retorne apenas pastas e arquivos   

		if ($listar!=$diretorio.'/.' && $listar!=$diretorio.'/..'){ 

			// checa se o tipo de arquivo encontrado é uma pasta 

			if (is_dir($listar)) { // caso VERDADEIRO adiciona o item à variável de pastas

				$pastas2[]=$listar;

				$pastas[]=$listar;

				$dir_encontrado++;

			} else{ 

				// caso FALSO adiciona o item à variável de arquivos

				$arquivos[]=$listar;		

			}   

		}

	}

$i++;

unset($itens);

unset($listar);

}

}

//Vimos acima, a expressão is_dir, indicando que as ações devem esntão ser executadas, ali mesmo, no diretório que já foi aberto e lido. As ações que executamos ali, foram: ver se tem pastas, listar. Ver se tem arquivos, listar.



//Agora, se houverem pastas, serão apresentadas antes dos arquivos, em odem alfabética.

//Se não houverem, serão apresentados apenas os arquivos, na mesma ordem.

//E se houverem os dois, serão mostrados igualmente.







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