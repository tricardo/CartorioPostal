<div id="marca"><img src="images/<?=$_SESSION['backGroundImage'] ?>" alt="" /></div>
<div id="topo">
    <div id="menu">
        <div title="Ordens" id="bt1" class="botao" style="border:<?=$_SESSION['borderColor'] ?> solid 2px;" onmouseover="MudaCorBotao(1,this.id)" onmouseout="MudaCorBotao(2,this.id)" onclick="CarregaPagina('ordem.php')">
            <img src="images/bt_ordens.png" alt="Ordens" /><br />
            Ordens
        </div>
        <div title="Editar Senha" id="bt2" class="botao" style="border:<?=$_SESSION['borderColor'] ?> solid 2px;" onmouseover="MudaCorBotao(1,this.id)" onmouseout="MudaCorBotao(2,this.id)" onclick="CarregaPagina('editar-senha.php')">
            <img src="images/bt_editar.png" alt="Editar Senha" /><br />
            Editar Senha
        </div>
        <div title="Editar Senha" id="bt3" class="botao" style="border:<?=$_SESSION['borderColor'] ?> solid 2px;" onmouseover="MudaCorBotao(1,this.id)" onmouseout="MudaCorBotao(2,this.id)" onclick="CarregaPagina('pedido-edit.php')">
            <img src="images/bt_editar.png" alt="Solicitação" /><br />
            Solicitação
        </div>        
        <div title="Sair" id="bt4" class="botao" style="border:<?=$_SESSION['borderColor'] ?> solid 2px;" onmouseover="MudaCorBotao(1,this.id)" onmouseout="MudaCorBotao(2,this.id)" onclick="CarregaPagina('sair.php')">
            <img src="images/bt_sair.png" alt="Sair" /><br />
            Sair
        </div>
    </div>
    <div style="background-color:<?=$_SESSION['backGroundColor1']?>" class="backCor1"></div>
    <div style="background-color:<?=$_SESSION['backGroundColor2']?>" class="backCor2"></div>
</div>