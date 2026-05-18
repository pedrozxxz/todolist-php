<?php
require_once __DIR__ . '/../backend/models/Usuario.php';
require_once __DIR__ . '/../backend/models/Tarefa.php';

$usuarios = Usuario::listarTodos();
$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (Tarefa::criar($_POST['usuario_id'], $_POST['descricao'], $_POST['setor'], $_POST['prioridade'], date('Y-m-d'))) {
            $mensagem = 'Tarefa cadastrada com sucesso!';
        } else {
            $erro = 'Erro ao cadastrar tarefa';
        }
    } catch (Exception $e) {
        $erro = 'Erro: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Cadastro de Tarefa</title>
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
                <a href="cadastro_usuario.php" class="btn-nav">👤 Novo Usuário</a>
            </div>
        </div>

        <div class="form-container">
            <h2>Cadastro de Tarefa</h2>
            
            <?php if ($mensagem): ?>
                <div class="alert alert-success"><?php echo $mensagem; ?></div>
            <?php endif; ?>
            
            <?php if ($erro): ?>
                <div class="alert alert-error"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Usuário responsável *</label>
                    <select name="usuario_id" required>
                        <option value="">Selecione um usuário</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?php echo $u['id']; ?>">
                                <?php echo htmlspecialchars($u['nome']); ?> (<?php echo htmlspecialchars($u['setor']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Descrição da tarefa *</label>
                    <textarea name="descricao" required placeholder="Descreva a tarefa em detalhes..."></textarea>
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
                
                <div class="form-group">
                    <label>Prioridade *</label>
                    <select name="prioridade" required>
                        <option value="baixa">🔵 Baixa</option>
                        <option value="media">🟡 Média</option>
                        <option value="alta">🔴 Alta</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-submit">Cadastrar Tarefa</button>
            </form>
        </div>
    </div>
</body>
</html>