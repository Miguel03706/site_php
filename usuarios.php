<?php
    require_once "conexao.php";
    session_start();


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/frigideira.svg"><!-- imagem q fica na aba de pesquisa em cima-->
    <title>Lista de usuários</title>
</head>
<body>
    
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="estilos/style_post.css">
    <div class='text-center' style='font-size: 20px;'><a href='index.php'>Voltar</a></div>
    <div class='text-center pesquisas'>
                <form action="" method="post"  autocomplete="off">
                    <input type="search" name="pesquisar" placeholder="pesquisar" class="text-center">
                </form>
           </div>

           

            <?php
            
            if(isset($_POST['pesquisar'])){
                $pesquisa = $_POST['pesquisar'];
                $query = "SELECT * FROM usuarios 
                WHERE nome LIKE '%$pesquisa%'
                ORDER BY id_usuario";
                $executa = mysqli_query($conexao, $query);
                while($dados = mysqli_fetch_array($executa)){
                    if($dados['tipo_usuario'] == 1){
                        $usuario =  "
                         <select name='tipo_usuario'>
                             <option value='1'>ADM</option>
                             <option value='2'>Autor</option>
                             <option value='3'>Normal</option>
                         </select>";
                    }else if($dados['tipo_usuario'] == 2){
                        $usuario = 
                        "
                        <select name='tipo_usuario'>
                            <option value='2'>Autor</option>
                            <option value='1'>ADM</option>
                            <option value='3'>Normal</option>
                        </select>";
                    }else{
                        $usuario =
                        "
                         <select name='tipo_usuario'>
                             <option value='3'>Normal</option>
                             <option value='2'>Autor</option>
                             <option value='1'>Adm</option>
                         </select>";
                    }
            
                    echo "
                    <table border='1px' align='center' style='width:50%; margin-top:10%;'>
                    <tr align='center'>
                        <td>Nome</td>
                        <td>Email</td>
                        <td>Tipo de usuário</td>
                        <td>Editar</td>
                        <td>Excluir</td>
                    </tr>
            
            
                                <tr align='center'>
                                    <td>$dados[nome]</td>
                                    <td>$dados[email]</td>
                                    <form action='' method='post'>
                                    <td>
                                       $usuario
                                    </td>
                                    <input type='hidden' name='id_usuario' value='$dados[id_usuario]'/>
                                    <td><input type='submit' value='Editar' name='editar'></td>
                                    </form>
                                    <form action='' method='post'>
                                    <td><input type='submit' value='Excluir' name='excluir'>
                                    <input type='hidden' name='id_usuario' value='$dados[id_usuario]'/>
                                    </form></td>
                                <tr>
                            ";
                }
            }
            
            
            ?>


    <table border="1px" align="center" style="width:50%; margin-top:10%;">
        <tr align="center">
            <td>Nome</td>
            <td>Email</td>
            <td>Tipo de usuário</td>
            <td>Editar</td>
            <td>Excluir</td>
        </tr>
        <?php
    


            $query = "SELECT * FROM usuarios";
            $executar = mysqli_query($conexao,$query);

            while($dados = mysqli_fetch_array($executar)){

                if($dados['tipo_usuario'] == 1){
                    $usuario =  "
                     <select name='tipo_usuario'>
                         <option value='1'>ADM</option>
                         <option value='2'>Autor</option>
                         <option value='3'>Normal</option>
                     </select>";
                }else if($dados['tipo_usuario'] == 2){
                    $usuario = 
                    "
                    <select name='tipo_usuario'>
                        <option value='2'>Autor</option>
                        <option value='1'>ADM</option>
                        <option value='3'>Normal</option>
                    </select>";
                }else{
                    $usuario =
                    "
                     <select name='tipo_usuario'>
                         <option value='3'>Normal</option>
                         <option value='2'>Autor</option>
                         <option value='1'>Adm</option>
                     </select>";
                }

                echo "
                    <tr align='center'>
                        <td>$dados[nome]</td>
                        <td>$dados[email]</td>
                        <form action='' method='post'>
                        <td>
                           $usuario
                        </td>
                        <input type='hidden' name='id_usuario' value='$dados[id_usuario]'/>
                        <td><input type='submit' value='Editar' name='Editar'></td>
                        </form>
                        <form action='' method='post'>
                        <td><input type='submit' value='Excluir' name='excluir'>
                        <input type='hidden' name='id_usuario' value='$dados[id_usuario]'/>
                        </form></td>
                    <tr>
                ";

            }
           
        ?>
    </table>
</body>
</html>

<?php
    if(isset($_POST['editar'])){
        $usuario = $_POST['id_usuario'];
        $tipo = $_POST['tipo_usuario'];
        $query = "UPDATE usuarios SET tipo_usuario = $tipo
                  WHERE id_usuario = $usuario";
        $executar = mysqli_query($conexao,$query);
        if($executar==0){
            echo "<script>alert('não foi possivel atualizar os dados, tente novamente!')
                        location.href = 'usuarios.php';
                  </script>";
        }else{
            echo "<script>alert('Dados Atualizados com sucesso!')
                          location.href = 'usuarios.php';
                 </script>";

        }
    }

    


if(isset($_POST['excluir'])){
    $usuario = $_POST['id_usuario'];
    $query = "DELETE FROM usuarios 
    WHERE id_usuario = $usuario";
    $executa = mysqli_query($conexao, $query);

    if($executar==0){
        echo "<script>alert('não foi possivel excluir os dados, tente novamente!')
                    location.href = 'usuarios.php';
              </script>";
    }else{
        echo "<script>alert('Dados excluidos com sucesso!')
                      location.href = 'usuarios.php';
             </script>";

    }
}
?>
