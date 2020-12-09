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
     <title>Escrever post</title>

     <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
     <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
     <script type="text/javascript" src="bootstrap.min.js"></script> 
     <link rel="stylesheet" type="text/css" href="estilos/style_post.css">

</head>
<body>
        
     <script src="https://cdn.tiny.cloud/1/xdnu2x31f1uqlmsb90u431ron6apvqqmwfq852y5o62bjlke/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

     
     <form action="cadastro_post.php" method="post" enctype="multipart/form-data">
    
        <div class='imagem_top'><p> <input type="file" name="arquivo" /></p><br></div>
       <br>
        <div class='text-center col-md-12'>
             <p>Titulo: <input type="text" name="titulo">
             Autor :<select name="autor">
                        <?php
                            $query="SELECT id_usuario,nome FROM usuarios WHERE id_usuario = '$_SESSION[id_usuario]'";
                            $executa = mysqli_query($conexao,$query);
                            while($dados=mysqli_fetch_array($executa)){
                                echo "<option value='$dados[id_usuario]'>$dados[nome] </option>";
                            }
                        ?>
                    </select>
             </p>
             <p>
                 <?php
                 
                    
                        $query_cat = "SELECT * FROM categorias";
                        $executa_cat = mysqli_query($conexao,$query_cat);
                    ?>
                        Categoria: <select name="categoria">
                        <?php
                            while($dados_cat = mysqli_fetch_array($executa_cat)){
                                echo "<option value='$dados_cat[id_categoria]'>$dados_cat[categoria] </option>";
                            }
                           
                        ?>
                    </select><br>
                   <?php
                         if($_SESSION["tipo_usuario"] == 1){
                            echo " <a href='categoria.php'>Criar categoria</a>";
                        }
                   ?>
                </p>
        </div>


        <div class="meio" id="meio">
          
         <div class="container">
            <p>
              texto: <textarea name="pesquisa" placeholder="Digite o conteudo" rows="1"></textarea>
                 <script>
                   tinymce.init({
                     selector: 'textarea',
                     plugins: '',
                     toolbar: '',
                     toolbar_mode: 'floating',
                     tinycomments_mode: 'embedded',
                     tinycomments_author: 'Author name'
                    });
                </script>
                <br>
                Descrição: <textarea name="descricao" rows="1" placeholder="Descrição do texto"></textarea><br>
            </p>
         </div>
       </div>
      <p>
         
      </p>
             
      <div class='text-center col-md-12'>
           <input type="submit" value="salvar" name="salvar"/>
            <a href='index.php'><input type="button" value="voltar"></a>
      </div>
    </form>
    <br>
</body>
</html>


<?php
if(isset($_POST['salvar'])){

    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $autor = $_POST['autor'];
    $arquivos = $_FILES['arquivo'];
    $conteudo = $_POST['pesquisa'];
    $descricao = $_POST['descricao'];
    

        if($arquivos['error']==4){
            echo "<script>
                      alert('Imagem vazia');
                      location.href = 'cadastro_post.php';  
                  </script>
            ";
       }else{

              $extensao = strtolower(substr($_FILES['arquivo']['name'], -4)); //pegar a extensão do arquivo
              $nome = md5(uniqid(time())) . $extensao; // nome do arquivo
              $diretorio = "upload/"; //lugar q o arquivo vai

              move_uploaded_file($_FILES['arquivo']['tmp_name'],$diretorio.$nome);


              $query = "INSERT INTO postagens (id_postagem,imagem,texto,autor,titulo,descricao,categoria,data)
                        VALUES (null,'$nome','$conteudo','$autor','$titulo','$descricao','$categoria',NOW())";
              $executa = mysqli_query($conexao,$query);

              if($executa==1){
                  echo "
                        <script>
                             alert('Dados inseridos meu parceiro!');
                             location.href = 'index.php';
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