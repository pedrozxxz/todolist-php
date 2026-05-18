<?php
require_once __DIR__ . '/../backend/models/Tarefa.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: gerenciamento_tarefas.php');
    exit;
}

$tarefa = Tarefa::buscarPorId($id);
if (!$tarefa) {
    header('Location: gerenciamento_tarefas.php');
    exit;
}

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (Tarefa::editar($id, $_POST['descricao'], $_POST['setor'], $_POST['prioridade'])) {
        $mensagem = 'Tarefa editada com sucesso!';
        $tarefa = Tarefa::buscarPorId($id);
    } else {
        $erro = 'Erro ao editar tarefa';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Editar Tarefa</title>
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
                <a href="gerenciamento_tarefas.php" class="btn-nav">📊 Voltar</a>
            </div>
        </div>

        <div class="form-container">
            <h2>Editar Tarefa</h2>
            
            <?php if ($mensagem): ?>
                <div class="alert alert-success"><?php echo $mensagem; ?></div>
            <?php endif; ?>
            
            <?php if ($erro): ?>
                <div class="alert alert-error"><?php echo $erro; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Descrição da tarefa *</label>
                    <textarea name="descricao" required><?php echo htmlspecialchars($tarefa['descricao']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Setor *</label>
                    <select name="setor" required>
                        <option value="Desenvolvimento" <?php echo $tarefa['setor'] == 'Desenvolvimento' ? 'selected' : ''; ?>>Desenvolvimento</option>
                        <option value="Design" <?php echo $tarefa['setor'] == 'Design' ? 'selected' : ''; ?>>Design</option>
                        <option value="Marketing" <?php echo $tarefa['setor'] == 'Marketing' ? 'selected' : ''; ?>>Marketing</option>
                        <option value="Vendas" <?php echo $tarefa['setor'] == 'Vendas' ? 'selected' : ''; ?>>Vendas</option>
                        <option value="RH" <?php echo $tarefa['setor'] == 'RH' ? 'selected' : ''; ?>>RH</option>
                        <option value="Financeiro" <?php echo $tarefa['setor'] == 'Financeiro' ? 'selected' : ''; ?>>Financeiro</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Prioridade *</label>
                    <select name="prioridade" required>
                        <option value="baixa" <?php echo $tarefa['prioridade'] == 'baixa' ? 'selected' : ''; ?>>🔵 Baixa</option>
                        <option value="media" <?php echo $tarefa['prioridade'] == 'media' ? 'selected' : ''; ?>>🟡 Média</option>
                        <option value="alta" <?php echo $tarefa['prioridade'] == 'alta' ? 'selected' : ''; ?>>🔴 Alta</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-submit">Salvar Alterações</button>
            </form>
        </div>
    </div>
</body>
</html>