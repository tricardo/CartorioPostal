<?php
   //Incluir a classe excelwriter
   include("excelwriter.inc.php");

   //Você pode colocar aqui o nome do arquivo que você deseja salvar.
    $excel=new ExcelWriter("excel3.xls");

    if($excel==false){
        echo $excel->error;
   }

   //Escreve o nome dos campos de uma tabela
   $myArr=array('CODIGO','DESCRICAO','VALOR');
   $excel->writeLine($myArr);

   //Seleciona os campos de uma tabela
	$conn = mysql_connect("localhost", "usuario", "senha") or die ('Não foi possivel conectar ao banco de dados! Erro: ' . mysql_error());
	if($conn)
	{
	mysql_select_db("banco", $conn);
	}
   $consulta = "select * from produtos order by descricao";
   $resultado = mysql_query($consulta);
   if($resultado==true){
      while($linha = mysql_fetch_array($resultado)){
         $myArr=array($linha['codigo'],$linha['descricao'],$linha['valor']);
         $excel->writeLine($myArr);
      }
   }


    $excel->close();
    echo "O arquivo foi salvo com sucesso. <a href=\"excel3.xls\">excel.xls</a>";

?>
