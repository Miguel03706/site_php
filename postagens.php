<?php
    session_start();
    require_once "conexao.php";
    $id = $_GET['id'];
    @$id_usuario = $_SESSION["id_usuario"];
    $_SESSION['id_post'] = $id;
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


   <header>
         <?php
            $query = "SELECT id_postagem,imagem FROM postagens WHERE id_postagem = '$id'";
            $executa = mysqli_query($conexao,$query);
            $dados= mysqli_fetch_array($executa);

            echo "<style type='text/css'>
           .img_top{ 
            width: auto;
            height: 80vh;
            background-image: url('upload/$dados[imagem]');
            background-size: cover;  
            background-repeat: no-repeat;
            background-position:center;}
        </style>";

        echo " <div class='img_top'>
            <nav class='menu_top'>
             <ul>
                <a href='index.php'>    <li>  Inicio     </li> </a>
                <a href='#meio'>     <li>  Postagem </li> </a>
                <a href='#footer'>   <li>  Contatos  </li> </a>";
                if(!isset($_SESSION['nome'])){
               echo "<a href='login.php'> <li>  Logar     </li> </a>";
                }else{
                    echo "<a href='logout.php'> <li>  Deslogar     </li> </a>";  
                }?>
             </ul>
                <?php 
                     $query = "SELECT id_postagem,titulo FROM postagens WHERE id_postagem = '$id'";
                     $executa = mysqli_query($conexao,$query);
                     $dados=mysqli_fetch_array($executa);

                     echo "<div id='teste'><a>$dados[titulo]</a></div>";
                ?>
            </nav>
        </div>     
    </header>

    <div class="text-center">
            <p>
                postado em:
                <?php 
                    $query = "SELECT data FROM postagens WHERE id_postagem = '$id'";
                    $executa = mysqli_query($conexao,$query);
                    $dados=mysqli_fetch_array($executa);
                    $data = str_replace("/", "-", $dados["data"]);
                    echo date('d-m-Y, H:i', strtotime($data));
                    
                

                ?>
            </p>
    </div>
   <div class="meio" id="meio">
        <?php  
            
            $query = "SELECT id_postagem,texto FROM postagens WHERE id_postagem = '$id'";
            $executa = mysqli_query($conexao,$query);
            $dados=mysqli_fetch_array($executa);

            echo "<div id='texto'>$dados[texto]</div>";
            
        ?>    
         
   </div>
   
                <!-- ADM/AUTOR APROVAR COMENTÁRIOS -->
             <?php

                    if (!isset($_SESSION["nome"])) {
                    }else{

                            if ($_SESSION["tipo_usuario"] == 1) {
                                 echo "
                                     <div class='container-fluid'>
                                     <form action='' method='post'>
                                         <div class='row'>
                                            <aside class='col-md-6 text-center btns'> 
                                                <a href='#'><input type='submit' value='Excluir post' class='btn_autor' name='excluir'></a>
                                            </aside>
                                            </form>
                                            <aside class='col-md-6 text-center btns'> 
                                             <a href='comentarios.php?id=$id'><input type='button' value='validar comentários' class='btn_autor'></a>
                                            </aside>
                                        </div>
                                    </div>";
                            }else if($_SESSION["tipo_usuario"] == 2) {
                                $query= "SELECT a.autor,a.id_postagem,b.id_usuario FROM postagens AS a 
                                        INNER JOIN usuarios AS b
                                        ON a.autor = b.id_usuario
                                        WHERE a.id_postagem = $id";
                                         $executa = mysqli_query($conexao,$query);
                                         $dados = mysqli_fetch_array($executa);
                                             if($dados['autor'] == $_SESSION['id_usuario']){
  
                                echo "          
                                    <div class='container-fluid'>
                                      <form action='' method='post'>    
                                        <div class='row'>
                                            <aside class='col-md-6 text-center btns'> 
                                             <a href='#'><input type='button' value='Excluir post' class='btn_autor' name='excluir'></a>    
                                             </aside>
                                             </form>
                                            <aside class='col-md-6 text-center btns'> 
                                             <a href='comentarios.php?id=$id'><input type='button' value='validar comentários' class='btn_autor'></a>
                                            </aside>
                                         </div>
                                        </div>
                                    </div>";
                                }
                            } else {
                                echo "";
                            }
                    }
                ?>
        <!-- FAZER COMENTÁRIOS -->
        <?php 
            if(isset($_SESSION['nome'])){
                    
        ?>
   <div class='comentarios col-md-12 text-left'> 
       <p>comentários:</p>
         <div class='container'>
             <form action="" method="post">
             <div id='caracteres'>
             <span class="caracteres">300</span> Restantes <br></div>
             <textarea id="TxtObservacoes" name="comentario" style="resize:none"></textarea>
             <input type="submit" value="Enviar" name="Enviar_comentario">
             </form>
               <?php 
               }else{
                echo "<p>Comentários:</p>";
                echo "<div class='text-center'>*para comentar é necessário estar logado</div>";
              }
              ?>
                <!-- EXIBIR COMENTÁRIOS APROVADOS -->
             <div class="comentarios_users">
                <?php
                    $query = "SELECT id_comentario,comentario,a.id_usuario,id_postagem,moderado,
                    b.nome as nome_usuario
                     FROM comentarios AS a INNER JOIN usuarios AS b
                    ON a.id_usuario = b.id_usuario
                    ORDER BY id_comentario DESC";


                    $executa = mysqli_query($conexao,$query);
                        while ($dados = mysqli_fetch_array($executa)){
                            if($dados['id_postagem']==$id){
                                 if($dados["moderado"] == 1){
                                     echo "<br><strong>$dados[nome_usuario] :</strong><div id='res'></div>
                                     <div id='comentario_ok'>
                                         <textarea rows='3' wrap='on' id='contagem_txt'>$dados[comentario]</textarea>
                                     </div>";
                                 }
                            }
                        }
                ?>
             </div>
         </div>
    </div>

   

 <!-- aparecer no desktop -->  
 <div class="mobile-hide"></div>
      <!-- aparecer no mobile -->  
            <div class="mobile">
                <div class="desktop-hide">
                    
                </div>
            </div>


  
            <footer class="footer" id="footer">
        <div class="container-fluid">
            <div class="row">
                <aside class="col-md-4 text-center">Trabalho realizado na Etec de Itaquaquecetuba</aside>
                <aside class="col-md-4 text-center">
                    <p>&copy; Matheus | Miguel | Natália | Niely | Ryan | Vinicius</p>
                </aside>
                <aside class="col-md-4 text-center">
                    <p>2º ETIM DS</p>
                </aside>
                <!--  cada "row" tem 12cols, dividir eles formam colunas-->
            </div>
        </div>
    </footer>
</body>
</html>
<script>
        $(document).on("keydown", "#TxtObservacoes", function () {
             var caracteresRestantes = 300;
             var caracteresDigitados = parseInt($(this).val().length);
             var caracteresRestantes = caracteresRestantes - caracteresDigitados;
            
             $(".caracteres").text(caracteresRestantes);
        });
</script>

<?php
    if(isset($_POST['Enviar_comentario'])){
           $query = "SELECT * FROM comentarios WHERE id_usuario = $id_usuario AND id_postagem = $id";
           $executa = mysqli_query($conexao,$query);
           $quantidade = mysqli_num_rows($executa);
            if($quantidade >= 3){
                $query_mod  = "SELECT moderado FROM comentarios";
                $executa_mod = mysqli_query($conexao,$query_mod);
                while($dados = mysqli_fetch_array($executa_mod)){
                    if($dados['moderado'] == 0){
                        echo "
                    <script>
                        alert('você escreveu 3 comentarios, espere eles serem validados para escrever mais!');
                        location.href = 'postagens.php?id=$id';
                    </script>
                    ";}
                }
            }else{
                    $comentario = $_POST["comentario"];
                    // echo $id;
                    $id = $_GET['id'];
                       
                    $tamanho = strlen($comentario);
                         if(!$comentario == ""){
                             if($tamanho > 300){
                                 echo "<script>
                                 alert('[ERRO] comentário muito grande!');
                                 location.href = 'postagens.php?id=$id';
                                 </script>";
                             }else{
                                 $query = "INSERT INTO comentarios(id_comentario,comentario,id_usuario,id_postagem,moderado)
                                         VALUES ('null','$comentario','$id_usuario','$id','0')";
                                  $executa = mysqli_query($conexao,$query);
                                  if($executa == 1){
                                      echo "<script>
                                            alert('comentário enviado! Espere a permissão do autor/adm para que ele apareça');
                                            location.href = 'postagens.php?id=$id';
                                           </script>";
                                 }else{
                                      echo "<script>
                                              alert('[ERRO] comentário não enviado, tente mais tarde');
                                              location.href = 'postagens.php?id=$id';
                                            </script>";
                                 }
                             }
                         }else{
                              echo "<script>
                                      alert('[ERRO] comentário vazio');
                                      location.href = 'postagens.php?id=$id';
                                    </script>";
                         }
            }
    }
        
    if(isset($_POST['excluir'])){
        $query_img = "SELECT imagem FROM postagens WHERE id_postagem = $id";
        $executa_img = mysqli_query($conexao,$query_img);
        $dados_img = mysqli_fetch_array($executa_img);
        $nome_img = $dados['imagem'];
        $excluirarquivo = unlink("imagens/".$nome_img);

        $query_delete = "DELETE FROM postagens WHERE id_postagem = $id";
        $executa_delete = mysqli_query($conexao,$query_delete);
        
        if($executa == 1){
            echo "<script>
                  alert('Postagem excluida com sucesso!');
                  location.href = 'index.php';
                 </script>";
        }else{
            echo "<script>
                     alert('[ERRO] Não foi possivel excluir postagem!');
                     location.href = 'index.php'
                  </script>";
        }    
    }
    
?>