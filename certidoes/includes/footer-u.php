<?
if($id_afiliado != ""){
    $empresaDAO = new EmpresaDAO();
    $fr = $empresaDAO->listaEmpresaAfiliado($id_afiliado);
}
?>
<div class="faixa-h-parceria"></div>
</body>
</html>