<?php
$dbHost='localhost';
$dbUsername='root';
$dbPassword='alunolab';
$dbName='papelaria1';
$conexao=new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

if ($conexao->connect_errno) {
    die("Erro na conexão: " . $conexao->connect_error);
}

if (isset($_POST['submit'])) {

    $nomep = $_POST['nomep'];
    $fabricante = $_POST['fabricante'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
   
    $sql = "INSERT INTO produtos
            (nomep,fabricante,preco,estoque)
            VALUES
            ('$nomep','$fabricante',$preco,$estoque)";

    $result = mysqli_query($conexao, $sql);  
    if ($result) {
        echo "<script>
                    alert('Produto registrado com sucesso!')
                </script>";
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}

/* VOLTAR*/
if (isset($_POST["voltar"])) {
    $id = $_POST["idproduto"];
    if ($id == "") {
        $sql = "SELECT * FROM produtos ORDER BY idproduto DESC LIMIT 1";
    } else {
        $sql = "SELECT * FROM produtos WHERE idproduto < $id ORDER BY idproduto DESC LIMIT 1";
    }
        $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {
        $produto = $resultado->fetch_assoc();
        $idproduto = $produto["idproduto"];
        $nomep = $produto["nomep"];
        $fabricante = $produto["fabricante"];
        $preco = $produto["preco"];
        $estoque = $produto["estoque"];

    } else {
    echo "<script>
                alert('Não existe produto anterior.')
            </script>";
        }}

/*  AVANÇAR */ 
if (isset($_POST["avancar"])) {
    $id = $_POST["idproduto"];
    if ($id == "") {

        $sql = "SELECT * FROM produtos ORDER BY idproduto LIMIT 1";
    } else {
    $sql = "SELECT * FROM produtos WHERE idproduto > $id ORDER BY idproduto LIMIT 1"; }

    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {
    $produto = $resultado->fetch_assoc();
    $idproduto = $produto["idproduto"];
    $nomep = $produto["nomep"];
    $fabricante = $produto["fabricante"];
    $preco = $produto["preco"];
    $estoque = $produto["estoque"];
       
    } else {
        echo "<script>
                alert('Não existe próximo produto.')
            </script>";
    }
}

/* PRIMEIRO ACESSO */
if (!isset($idproduto)) {
    $idproduto = "";
    $nomep = "";
    $fabricante = "";
    $preco = "";
    $estoque = "";
}


/* EXCLUIR */
if (isset($_POST["excluir"])) { 
    $id = $_POST["idproduto"]; 
    if ($id != "") { 
        $sql = "DELETE FROM produtos WHERE idproduto = $id"; 
        $resultado = $conexao->query($sql); 
        if ($resultado) {
            echo "<script>
                    alert('Produto excluído com sucesso!')
                </script>"; 
            $idproduto = ""; 
            $nomep = ""; 
            $fabricante = ""; 
            $preco = ""; 
            $estoque = ""; 
        } else { 
            echo "Erro ao excluir produto: " . $conexao->error; 
        }
    } else { 
        echo "<script>
                alert('Nenhum produto selecionado para excluir.')
            </script>"; 
    } 
}

/* ALTERAR */
if (isset($_POST["alterar"])) {
    $id = $_POST["idproduto"];
    $nomep = $_POST["nomep"];
    $fabricante = $_POST["fabricante"];
    $preco = $_POST["preco"];
    $estoque = $_POST["estoque"];

    if ($id != "") {
        $sql = "UPDATE produtos SET
                nomep = '$nomep',
                fabricante = '$fabricante',
                preco = $preco,
                estoque = $estoque
                WHERE idproduto = $id";
        $resultado = $conexao->query($sql);

        if ($resultado) {
            echo "<script>
                    alert('Produto alterado com sucesso!')
                </script>";
        } else {
            echo "Erro ao alterar produto: " . $conexao->error;
        }
    } else {
        echo "<script>
                    alert('Nenhum produto selecionado para alterar.')
                </script>";
    }
}

/* CONSULTAR */
if (isset($_POST["consultar"])) {
    $id = $_POST["idconsulta"];
    if ($id != "") {
        $sql = "SELECT * FROM produtos WHERE idproduto = $id";
        $resultado = $conexao->query($sql);
        if ($resultado->num_rows > 0) {
            $produto = $resultado->fetch_assoc();
            $idproduto = $produto["idproduto"];
            $nomep = $produto["nomep"];
            $fabricante = $produto["fabricante"];
            $preco = $produto["preco"];
            $estoque = $produto["estoque"];
        } else {
            echo "<script>
                alert('Produto não encontrado.')
            </script>";
        }
    } else {
        echo "<script>
                alert('Informe o ID do produto.')
            </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="produtos.css">
    <meta name="viewport" content="width=], initial-scale=1.0">
    <title>Produtos</title>
</head>
<body>
    <div id="geral">
        <a href="index.html"> ⬅ Voltar a página inicial</a>
        <h1>Cadastro de produtos</h1>
        <form action="produtos.php" method="post">

            <input type="hidden" name="idproduto" value="<?php echo $idproduto; ?>">

            <label for="nomep">Nome do produto</label>
            <input type="text" name="nomep" id="txtnomep" placeholder="Ex.: Lápis" value="<?php echo $nomep; ?>">

            <label for="fabricante">Fabricante</label>
            <input type="text" name="fabricante" id="txtfabricante" placeholder="Ex.: Fabercastel" value="<?php echo $fabricante; ?>">

            <label for="preco">Preço</label>
            <input type="decimal" name="preco" id="txtpreco" placeholder="Ex.: 2" value="<?php echo $preco; ?>">

            <label for="estoque">Quantidade no estoque</label>
            <input type="number" name="estoque" id="txtestoque" placeholder="Ex.: 100" value="<?php echo $estoque; ?>">

            <label for="idconsulta">ID a ser consultado</label>
            <input type="number" name="idconsulta" id="txtconsulta" placeholder="Ex.: 1">

            <input type="submit" name="submit" value="Cadastrar">
            <button type="submit" name="voltar">Voltar</button>
            <button type="submit" name="avancar">Avançar</button>
            <button type="reset">Limpar</button>
            <button type="submit" name="excluir">Excluir</button>
            <button type="submit" name="alterar">Alterar</button>
            <button type="submit" name="consultar">Consultar</button>
        </form>
    </div>
</body>
</html>

<?php
$conexao->close();
?>