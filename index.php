<?php
session_start();
require_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/frigideira.svg"><!-- imagem q fica na aba de pesquisa em cima-->
    <title>Blog comidas</title>
</head>

<body>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="estilos/style.css">

<header>
     <!-- aparecer no desktop -->
     <div class="mobile-hide">
        <div class='text-center pesquisas'>
            <form action="" method="post" autocomplete="off">
                <input type="search" name="pesquisar" placeholder="pesquisar" class="text-center">
            </form>
        </div>
    </div>
    <!-- aparecer no mobile -->
    <div class="mobile">
        <div class="desktop-hide">
           <div class='text-center pesquisas_mobile'>
                <form action="" method="post"  autocomplete="off">
                    <input type="search" name="pesquisar" placeholder="pesquisar" class="text-center">
                </form>
           </div>
        </div>
    </div>
       
        <nav class="menu_top">
            <ul>
                <a href="#sobre">
                    <li> Sobre </li>
                </a>
                <a href="#meio">
                    <li> Postagens </li>
                </a>
                <a href="#footer">
                    <li> Contatos </li>
                </a>
                <?php
                if (!isset($_SESSION["nome"])) { //eu criei uma sessão em "login.php" se ela existir vai exibir isso:
                    echo "<a href='login.php'> <li>  Logar     </li> </a>";
                } else {
                    echo "<a href='logout.php'> <li>  Deslogar     </li> </a>";
                    //se essa sessão não existir, significa q o usuário n logou
                } ?>
            </ul>
        </nav>
    </header>

    <div id="sobre"></div>
    <div class="mobile-hide">
        <div class="sobre">
            <p>
                <div class="sobre1">
                    <img src="imagens/sobre1.jpg" alt="desenho de utencilios de cozinha" height="100px" width="100px">
                    <p>
                        <h2>Dicas</h2>
                    </p>
                    <p> diversas dicas e postagens sobre alimentos e todos os seus benefícios </p>
                </div>
                <div class="vazia"></div>
                <div class="sobre2">
                    <img src="imagens/icone_jornal.png" alt="Icone de um jornal" height="100px" width="100px">
                    <p>
                        <h2>Informação</h2>
                    </p>
                    <p>diversas noticias sobre alimentos e receitas esplêndidas para você </p>
                </div>
                <div class="vazia"></div>
                <div class="sobre3">
                    <img src="imagens/sobre3.png" alt="desenho de utencilios de cozinha" height="100px" width="100px">
                    <p>
                        <h2>Interação</h2>
                    </p>
                    <p> aqui você pode interagir com diversas outras pessoas sobre os mais diversos assuntos que envolvam culinária</p>
                </div>
            </p>
        </div>
    </div>

    <div class="mobile">
        <div class="desktop-hide">
            <div class="sobre_mobile">
                <p>
                    <div class="sobre1_mobile">
                        <img src="imagens/sobre1.jpg" alt="desenho de utencilios de cozinha" height="100px" width="100px">
                        <p>
                            <h2>Dicas</h2>
                        </p>
                        <p>diversas dicas e postagens sobre alimentos e todos os seus benefícios </p>
                    </div><br>
                    <div class="sobre2_mobile">
                        <img src="imagens/icone_jornal.png" alt="Icone de um jornal" height="100px" width="100px">
                        <p>
                            <h2>Informação</h2>
                        </p>
                        <p>diversas noticias sobre alimentos e receitas esplêndidas para você </p>
                    </div>
                    <div class="sobre3_mobile">
                        <img src="imagens/sobre3.png" alt="desenho de utencilios de cozinha" height="100px" width="100px">
                        <p>
                            <h2>Interação</h2>
                        </p>
                        <p>aqui você pode interagir com diversas outras pessoas sobre os mais diversos assuntos que envolvam culinária </p>
                    </div>
                </p>
            </div>

        </div>
    </div>
    <?php

    if (!isset($_SESSION["nome"])) {
    } else {

        if ($_SESSION["tipo_usuario"] == 1) {
            echo "
                            <div class='container-fluid'>
                                <div class='row'>
                                    <aside class='col-md-6 text-center btns'> 
                                            <a href='cadastro_post.php'><input type='button' value='Escrever' class='btn_autor'></a>
                                    </aside>
                                    <aside class='col-md-6 text-center btns'> 
                                            <a href='usuarios.php'><input type='button' value='Ver usuários' class='btn_autor'></a>
                                    </aside>
                                </div>
                            </div>";
        } else if ($_SESSION["tipo_usuario"] == 2) {
            echo "
                        <div class='container-fluid'>
                            <div class='row'>
                                <aside class='col-md-12 text-center btns'> 
                                        <a href='cadastro_post.php'><input type='button' value='Escrever' class='btn_autor'></a>    
                                </aside>
                            </div>
                        </div>";
        } else {
            echo "";
        }
    }
    //}
    ?>
    <!-- MEIO -->

    <!-- aparecer no desktop -->
    <div class="mobile-hide">
        <div class="meio text-center" id="meio">
            <?php

                if(isset($_POST['pesquisar'])){

                    echo "
                        <script>
                        $('html, body').scrollTop(1100);
                        </script>
                    ";
                    $pesquisa = $_POST['pesquisar'];
                    $query = "SELECT * FROM postagens 
                    WHERE titulo LIKE  '%$pesquisa%'
                    ORDER BY id_postagem desc LIMIT 7";
                    $executa = mysqli_query($conexao, $query);
                    echo "<br><a href='index.php'>Voltar<br></a>";
                    while($dados = mysqli_fetch_array($executa)){
                        echo "<a href='postagens.php?id=$dados[id_postagem]'>
                        <div class='postagens'><br><img src='upload/$dados[imagem]' id='img_post'>
                         <p><b>$dados[titulo]</b></p>
                         <p>$dados[descricao]</p>
                         </div></a>";
                    }
                    echo "<br><a href='index.php'>Voltar</a>";
                }else{


            $query1 = "SELECT * FROM postagens ORDER BY id_postagem desc";
            $executa = mysqli_query($conexao, $query1);
            
            @$p = $_GET['p'];
            if (!$p) {
                $pc = "1";
            } else {
                $pc = $p;
            }

            //QUANTIDADE DE POSTS POR PAGINA
            $qtd = "3";

            $inicio = ($pc*$qtd) - $qtd;

            $limite = "SELECT * FROM postagens ORDER BY id_postagem desc LIMIT $inicio,$qtd";
            $todos = mysqli_query($conexao, $limite);

            //visualização
            while ($dados = mysqli_fetch_array($todos)) {
               
                    echo "<a href='postagens.php?id=$dados[id_postagem]'>
                               <div class='postagens'><br><img src='upload/$dados[imagem]' id='img_post'>
                                <p><b>$dados[titulo]</b></p>
                                <p>$dados[descricao]</p>
                                </div></a>";
                
            }

            $sql_todos = "SELECT * FROM postagens "; // Executa o query da seleção acima
            $sql_registros = mysqli_query($conexao,$sql_todos);
            $total_registros = mysqli_num_rows($sql_registros);
            $pags = ceil($total_registros/$qtd);
            $max_links = 3;
            echo "<br><a href='index.php?p=1#meio'target='_self'>primeira pagina</a>";

            for($i = $p-$max_links; $i <= $p-1; $i++) {
                if($i <=0) {
                }else{
                     echo "<a href='index.php?p=$i#meio'target='_self'>$i</a>";
                }
             }
             echo $p;
             for($i = $p+1; $i <= $p+$max_links; $i++) {
                if($i > $pags) {
                     }else{
                          echo "<a href='index.php?p=$i#meio'target='_self'>$i</a>";
                    }
             }
             echo "<a href='index.php?p=$pags#meio'target='_self'>ultima pagina</a>";
            }
            

            ?>
        </div>
    </div>

    <!-- MEIO MOBILE -->
    
    <!-- aparecer no mobile -->
    <div class="mobile">
        <div class="desktop-hide">
            <div class="meio_mobile" id="meio_mobile">
            <?php

if(isset($_POST['pesquisar'])){

    echo "
        <script>
        $('html, body').scrollTop(1100);
        </script>
    ";
    $pesquisa = $_POST['pesquisar'];
    $query = "SELECT * FROM postagens 
    WHERE titulo LIKE  '%$pesquisa%'
    ORDER BY id_postagem desc LIMIT 7";
    $executa = mysqli_query($conexao, $query);
    echo "<br><a href='index.php'>Voltar<br></a>";
    while($dados = mysqli_fetch_array($executa)){
        echo "<a href='postagens.php?id=$dados[id_postagem]'>
        <div class='postagens'><br><img src='upload/$dados[imagem]' id='img_post'>
         <p><b>$dados[titulo]</b></p>
         <p>$dados[descricao]</p>
         </div></a>";
    }
    echo "<br><a href='index.php'>Voltar</a>";
}else{
            $query1 = "SELECT * FROM postagens ORDER BY id_postagem desc";
            $executa = mysqli_query($conexao, $query1);
            
            @$p = $_GET['p'];
            if (!$p) {
                $pc = "1";
            } else {
                $pc = $p;
            }

            $qtd = "3";

            $inicio = ($pc*$qtd) - $qtd;

            $limite = "SELECT * FROM postagens ORDER BY id_postagem desc LIMIT $inicio,$qtd";
            $todos = mysqli_query($conexao, $limite);

            // visualização
            while ($dados = mysqli_fetch_array($todos)) {
               
                    echo "<a href='postagens.php?id=$dados[id_postagem]'>
                               <div class='postagens'><br><img src='upload/$dados[imagem]' height='100vh' width='200vw'>
                                <p><b>$dados[titulo]</b></p>
                                <p>$dados[descricao]</p>
                                </div></a>";
                
            }

            $sql_todos = "SELECT * FROM postagens "; // Executa o query da seleção acima
            $sql_registros = mysqli_query($conexao,$sql_todos);
            $total_registros = mysqli_num_rows($sql_registros);
            $pags = ceil($total_registros/$qtd);
            $max_links = 3;
            echo "<br><a href='index.php?p=1#meio'target='_self'>primeira pagina</a>";

            for($i = $p-$max_links; $i <= $p-1; $i++) {
                if($i <=0) {
                }else{
                     echo "<a href='index.php?p=$i#meio'target='_self'>$i</a>";
                }
             }
             echo $p;
             for($i = $p+1; $i <= $p+$max_links; $i++) {
                if($i > $pags) {
                     }else{
                          echo "<a href='index.php?p=$i#meio'target='_self'>$i</a>";
                    }
                }
                echo "<a href='index.php?p=$pags#meio'target='_self'>ultima pagina</a>";
               }
            ?>
            </div>
        </div>
    </div>


    <!-- aparecer no desktop -->
    <div class="mobile-hide">
    </div>
    <!-- aparecer no mobile -->
    <div class="mobile">
        <div class="desktop-hide">
        </div>
    </div>

    <!-- RODAPÉ -->
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