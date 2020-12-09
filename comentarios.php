<?php
    session_start();
    require_once "conexao.php";
    $id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/frigideira.svg"><!-- imagem q fica na aba de pesquisa em cima-->
    <link rel="icon" href="imagens/escola.svg">
    <title>Blog comidas</title>
</head>
<body>
     <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
     <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
     <script type="text/javascript" src="bootstrap.min.js"></script> 

     <link rel="stylesheet" type="text/css" href="estilos/posts.css">

    <div class='comentarios'>
            <div class="comentarios_users">
                <?php
                    $query = "SELECT id_comentario,comentario,a.id_usuario,id_postagem,moderado,
                    b.nome as nome_usuario
                    FROM comentarios AS a INNER JOIN usuarios AS b
                    ON a.id_usuario = b.id_usuario
                    WHERE moderado = 0";


                    $executa = mysqli_query($conexao,$query);
                        while ($dados = mysqli_fetch_array($executa)){
                            if($dados['id_postagem']==$_SESSION['id_post']){
                                 if($dados["moderado"] == 0){
                                     echo "<br><strong>$dados[nome_usuario] :</strong>
                                    
                                     <div id='comentario_ok'>
                                         <textarea rows='3' wrap='on' id='contagem_txt'>$dados[comentario]</textarea>
                                     </div>
                                     <form action='' method='post'>
                                     <aside class='col-md-12 text-center btns'>
                                        <input type='submit' name='validar' class='btn_adm' value='Aceitar'>
                                    </aside>
                                        <input type='hidden' name='id_comentario' value='$dados[id_comentario]'>
                                     </form>";
                                 }
                            }
                        }
                        echo " <a href='postagens.php?id=$id'>Voltar</a>";
                ?>
             </div>
            
    </div>

</body>
</html>
    <?php
        if(isset($_POST['validar'])){
            $id_comentario = $_POST['id_comentario'];
            //echo $id_comentario;
            $query = "UPDATE comentarios SET moderado = 1
            WHERE id_comentario = $id_comentario";

            $executa = mysqli_query($conexao,$query);
            if($executa == 1){
                echo "<script>
                      alert('comentário enviado!');
                      location.href = 'comentarios.php?id=$id';
                     </script>";
           }else{
                echo "<script>
                        alert('[ERRO] comentário não enviado, tente mais tarde');
                        location.href = 'comentarios.php?id=$id';
                      </script>";
           }
        
        }
    ?>
