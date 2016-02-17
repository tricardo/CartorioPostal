<?
require('header.php');

pt_register('GET','id');

if($id > 0){

    $usuarioDAO = new UsuarioDAO();
    $usuarioDAO->deleta_usuario($id);

    echo "<script>alert('Registro excluido com sucesso!');location.href='usuario.php'</script>";
}


?>