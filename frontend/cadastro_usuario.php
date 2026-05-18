<?php
require_once __DIR__ . '/../backend/models/Usuario.php';

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (Usuario::criar($_POST['nome'], $_POST['email'], $_POST['setor'])) {
            $mensagem = 'Usuário cadastrado com sucesso!';
        } else {
            $erro = 'Erro ao cadastrar usuário';
        }
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            $erro = 'Email já cadastrado!';
        } else {
            $erro = 'Erro: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Cadastro de Usuário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <h1>📋 TaskSync</h1>
                <p>Gerencie suas tarefas com eficiência</p>
            </div>
            <div class="nav-buttons">
                <a href="gerenciamento_tarefas.php" class="btn-nav">📊 Tarefas</a>
                <a href="cadastro_tarefa.php" class="btn-nav">➕ Nova Tarefa</a>
            </div>
        </div>

        <div class="form-container">
            <h2>Cadastro de Usuário</h2>
            
            <?php if ($mensagem): ?>
                <div class="alert alert-success"><?php echo $mensagem; ?></div>
            <?php endif; ?>
            
            <?php if ($erro): ?>
                <div class="alert alert-error"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Nome completo *</label>
                    <input type="text" name="nome" required>
                </div>
                
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Setor *</label>
                    <select name="setor" required>
                        <option value="">Selecione</option>
                        <option value="Desenvolvimento">Desenvolvimento</option>
                        <option value="Design">Design</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Vendas">Vendas</option>
                        <option value="RH">RH</option>
                        <option value="Financeiro">Financeiro</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-submit">Cadastrar Usuário</button>
            </form>
        </div>
    </div>
</body>
</html>