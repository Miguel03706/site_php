<?php
    require_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/frigideira.svg"><!-- imagem q fica na aba de pesquisa em cima-->
    <title>Cadastro</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
     <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
     <script type="text/javascript" src="bootstrap.min.js"></script> 
	 <link rel="stylesheet" type="text/css" href="estilos/stylelogin.css">
</head>
<body>
    <header>   
    
        <div class="cadastrar">
            <p><h2>Cadastrar</h2></p>
            <form action="" method="post">
                <p> <input type="text" name="nome" id="nome" placeholder="Digite o seu nome"></p>
                <p> <input type="email" name="email" id="email" placeholder="Digite o seu email"></p>
                <p> <input type="password" name="senha" id="senha" placeholder="Digite uma senha"></p>
                <p><input type="submit" value="Cadastrar" name="cadastrar" id="btn_login"></p>
            </form>
            <p>Já possui uma conta? <a href="login.php"> Conectar!</a></p>
		    <a href="index.php">Retornar</a>
        </div>
    </header> 
</body>
</html>

<?php
    if(isset($_POST['cadastrar'])){
          $nome = $_POST['nome'];
          $email = $_POST['email'];
          $senha = $_POST['senha'];
   

         if($nome == ''){
               echo "<script> alert('digite seu nome')</script>";
         }else if($email == ''){
                echo "<script> alert('digite seu email')</script>";
         }else if(!isset($senha)){
                echo "<script> alert('digite uma senha')</script>";
         }else{

                 $querychecagem = "SELECT email FROM usuarios WHERE email='$email'";
                 $executar = mysqli_query($conexao, $querychecagem);
                 $achei = mysqli_num_rows($executar);
                 if($achei >= 1){
                     echo "<script>
                             alert('Já existe um usuario com esse email!');
                             location.href='cadastro.php';
                          </script>";
                 }else{	            
                    $senha = sha1($senha); //SHA1 deixa a senha do usuario com 40 caracteres
                    $query = "INSERT INTO usuarios(nome, email, senha) 
                              VALUES ('$nome','$email','$senha')";
                    $executa = mysqli_query($conexao,$query);

                    if($executa==0){
                        echo "<script>alert('não foi possivel adicionar os dados, tente novamente!')</script>";
                    }else{
                        echo "<script>alert('Dados inseridos com sucesso!')
                                 location.href = 'login.php';
                              </script>";

                    }
                }
         }
    }

?>