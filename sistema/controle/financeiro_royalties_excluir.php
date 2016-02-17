<?
require('header.php');

pt_register('GET', 'id');

$financeiroDAO = new FinanceiroDAO();

if ($id > 0) {
    $financeiroDAO->exclui_royaltie_id($id);
    $financeiroDAO->exclui_boleto_brasil($id);

    echo "<script>alert('Registro excluido com sucesso!');location.href='financeiro_royalties.php'</script>";
}
?>

