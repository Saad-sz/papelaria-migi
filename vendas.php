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

    $data_venda = $_POST['data_venda'];
    $nome_cliente = $_POST['nome_cliente'];
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
   
    $sql = "INSERT INTO vendas
            (data_venda,nome_cliente,produto,quantidade,valor)
            VALUES
            ('$data_venda','$nome_cliente','$produto',$quantidade,$valor)";

    $result = mysqli_query($conexao, $sql);  
    if ($result) {
        echo "<script>
                    alert('Venda registrada com sucesso!')
                </script>";
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}

/* VOLTAR*/
if (isset($_POST["voltar"])) {
    $id = $_POST["idvenda"];
    if ($id == "") {
        $sql = "SELECT * FROM vendas ORDER BY idvenda DESC LIMIT 1";
    } else {
        $sql = "SELECT * FROM vendas WHERE idvenda < $id ORDER BY idvenda DESC LIMIT 1";
    }
        $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {
        $venda = $resultado->fetch_assoc();
        $idvenda = $venda["idvenda"];
        $data_venda = $venda["data_venda"];
        $nome_cliente = $venda["nome_cliente"];
        $produto = $venda["produto"];
        $quantidade = $venda["quantidade"];
        $valor = $venda["valor"];

    } else {
    echo "<script>
                alert('Não existe venda anterior.')
            </script>";
        }}

/*  AVANÇAR */ 
if (isset($_POST["avancar"])) {
    $id = $_POST["idvenda"];
    if ($id == "") {

        $sql = "SELECT * FROM vendas ORDER BY idvenda LIMIT 1";
    } else {
    $sql = "SELECT * FROM vendas WHERE idvenda > $id ORDER BY idvenda LIMIT 1"; }

    $resultado = $conexao->query($sql);
    if ($resultado->num_rows > 0) {
    $venda = $resultado->fetch_assoc();
    $idvenda = $venda["idvenda"];
    $data_venda = $venda["data_venda"];
    $nome_cliente = $venda["nome_cliente"];
    $produto = $venda["produto"];
    $quantidade = $venda["quantidade"];
    $valor = $venda["valor"];
       
    } else {
        echo "<script>
                alert('Não existe próxima venda.')
            </script>";
    }
}

/* PRIMEIRO ACESSO */
if (!isset($idvenda)) {
    $idvenda = "";
    $data_venda = "";
    $nome_cliente = "";
    $produto = "";
    $quantidade = "";
    $valor = "";
}


/* EXCLUIR */
if (isset($_POST["excluir"])) { 
    $id = $_POST["idvenda"]; 
    if ($id != "") { 
        $sql = "DELETE FROM vendas WHERE idvenda = $id"; 
        $resultado = $conexao->query($sql); 
        if ($resultado) {
            echo "<script>
                    alert('Venda excluído com sucesso!')
                </script>"; 
            $idvenda = ""; 
            $data_venda = ""; 
            $nome_cliente = ""; 
            $produto = ""; 
            $quantidade = ""; 
            $valor = ""; 
        } else { 
            echo "Erro ao excluir venda: " . $conexao->error; 
        }
    } else { 
        echo "<script>
                alert('Nenhuma venda selecionada para excluir.')
            </script>"; 
    } 
}

/* ALTERAR */
if (isset($_POST["alterar"])) {
    $id = $_POST["idvenda"];
    $data_venda = $_POST["data_venda"];
    $nome_cliente = $_POST["nome_cliente"];
    $produto = $_POST["produto"];
    $quantidade = $_POST["quantidade"];
    $valor = $_POST["valor"];

    if ($id != "") {
        $sql = "UPDATE vendas SET
                data_venda = '$data_venda',
                nome_cliente = '$nome_cliente',
                produto = '$produto',
                quantidade = $quantidade,
                valor = $valor
                WHERE idvenda = $id";
        $resultado = $conexao->query($sql);

        if ($resultado) {
            echo "<script>
                    alert('Venda alterada com sucesso!')
                </script>";
        } else {
            echo "Erro ao alterar venda: " . $conexao->error;
        }
    } else {
        echo "<script>
                    alert('Nenhuma venda selecionado para alterar.')
                </script>";
    }
}

/* CONSULTAR */
if (isset($_POST["consultar"])) {
    $id = $_POST["idconsulta"];
    if ($id != "") {
        $sql = "SELECT * FROM vendas WHERE idvenda = $id";
        $resultado = $conexao->query($sql);
        if ($resultado->num_rows > 0) {
            $venda = $resultado->fetch_assoc();
            $idvenda = $venda["idvenda"];
            $data_venda = $venda["data_venda"];
            $nome_cliente = $venda["nome_cliente"];
            $produto = $venda["produto"];
            $quantidade = $venda["quantidade"];
            $valor = $venda["valor"];
        } else {
            echo "<script>
                alert('Venda não encontrada.')
            </script>";
        }
    } else {
        echo "<script>
                alert('Informe o ID da venda.')
            </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="vendas.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
</head>
<body>
    <div id="geral">
    <a href="index.html"> ⬅ Voltar a página inicial</a>
    <h1>Registro de Vendas</h1>
    <form method="post" action="vendas.php">

        <input type="hidden" name="idvenda" value="<?php echo $idvenda; ?>">

        <label for="data">Data da Venda</label>
        <input type="date" id="txtdata" name="data_venda" value="<?php echo $data_venda; ?>">
        
        <label for="nomec">Nome do Cliente</label>
        <input type="text" id="txtnomec" name="nome_cliente" placeholder="Informe o nome do cliente" value="<?php echo $nome_cliente; ?>">

        <label for="produto">Produto Vendido</label>
        <input type="text" id="txtproduto" name="produto" placeholder="Informe o produto vendido" value="<?php echo $produto; ?>">

        <label for="quantidade">Quantidade</label>
        <input type="number" id="txtquantidade" name="quantidade" placeholder="Informe a quantidade" value="<?php echo $quantidade; ?>">

        <label for="valor">Valor Unitário</label>
        <input type="decimal" id="txtvalor" name="valor" placeholder="Informe o valor unitário" value="<?php echo $valor; ?>">

        <label for="idconsulta">ID da venda para consultar</label>
        <input type="number" id="txtidconsulta" name="idconsulta" placeholder="Informe o ID da venda">

        <input type="submit" name="submit" value="Registrar">
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