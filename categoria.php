<?php
    require_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/frigideira.svg"><!-- imagem q fica na aba de pesquisa em cima-->
    <title>Nova categoria</title>
     <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
     <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
     <script type="text/javascript" src="bootstrap.min.js"></script> 
    <style>
        header{
            width: auto;
            height: 100vh;
            text-align: center;
        }
        header input{
            margin-top: 50vh;
            text-align: center;
        }

    </style>
</head>
<body>
    
    <header>
        <form action="" method="post">
            <p>Nova categoria: <input type="text" name="nova_categoria">
            <input type="submit" value="Criar" name="criar"> </p>
            
        </form>
    </header>
</body>
</html>

<?php
    $nova_categoria = $_POST["nova_categoria"];
    if(isset($_POST["criar"])){
        if($nova_categoria=='' || strlen($nova_categoria) < 4){
            echo "
            <script>
                 alert('Insira uma categoria válida!');
                location.href = 'cadastro_post.php';
            </script>";
        }else{
            $query = "INSERT INTO categorias (id_categoria,categoria)
                      VALUES(null,'$nova_categoria')";
            $executar = mysqli_query($conexao,$query);
            if($executar == 1){
                echo "
                <script>
                     alert('Dados inseridos meu parceiro!');
                    location.href = 'cadastro_post.php';
                </script>";
            }else{
                echo "
                     <script>
                         alert('Deu errado meu parceiro');
                        location.href = 'cadastro_post.php';
                     </script>";
            }
        }
    }

?>