<?php
require_once __DIR__ . '/../backend/models/Tarefa.php';

// Processar ações
if (isset($_GET['excluir'])) {
    Tarefa::excluir($_GET['excluir']);
    header('Location: gerenciamento_tarefas.php');
    exit;
}

if (isset($_GET['status']) && isset($_GET['novo_status'])) {
    Tarefa::atualizarStatus($_GET['status'], $_GET['novo_status']);
    header('Location: gerenciamento_tarefas.php');
    exit;
}

$tarefasPorStatus = Tarefa::listarPorStatus();

// Mapeamento de status para português
$statusNomes = [
    'a_fazer' => '📋 A Fazer',
    'fazendo' => '⚙️ Em Andamento',
    'concluido' => '✅ Concluído'
];

$statusIcones = [
    'a_fazer' => '⏳',
    'fazendo' => '🔄',
    'concluido' => '🎉'
];

$statusProximo = [
    'a_fazer' => 'fazendo',
    'fazendo' => 'concluido',
    'concluido' => 'concluido'
];

$statusTextoProximo = [
    'a_fazer' => 'Iniciar',
    'fazendo' => 'Concluir',
    'concluido' => 'Concluído'
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Gerenciamento de Tarefas</title>
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
                <a href="cadastro_usuario.php" class="btn-nav">👤 Novo Usuário</a>
                <a href="cadastro_tarefa.php" class="btn-nav">➕ Nova Tarefa</a>
            </div>
        </div>

        <div class="kanban-board">
            <?php foreach ($tarefasPorStatus as $status => $tarefas): ?>
                <div class="kanban-column">
                    <div class="column-header">
                        <h3>
                            <?php echo $statusIcones[$status]; ?> <?php echo $statusNomes[$status]; ?>
                            <span class="count"><?php echo count($tarefas); ?></span>
                        </h3>
                    </div>
                    <div class="tasks-list">
                        <?php foreach ($tarefas as $tarefa): ?>
                            <div class="task-card prioridade-<?php echo $tarefa['prioridade']; ?>">
                                <div class="task-descricao">
                                    <?php echo htmlspecialchars($tarefa['descricao']); ?>
                                </div>
                                <div class="task-info">
                                    <span class="task-usuario">👤 <?php echo htmlspecialchars($tarefa['usuario_nome']); ?></span><br>
                                    <span class="task-setor">🏢 <?php echo htmlspecialchars($tarefa['setor']); ?></span>
                                    <span class="task-prioridade prioridade-<?php echo $tarefa['prioridade']; ?>-text">
                                        <?php 
                                            $prioridades = ['baixa' => '🔵 Baixa', 'media' => '🟡 Média', 'alta' => '🔴 Alta'];
                                            echo $prioridades[$tarefa['prioridade']];
                                        ?>
                                    </span><br>
                                    <span>📅 Cadastro: <?php echo date('d/m/Y', strtotime($tarefa['data_cadastro'])); ?></span>
                                </div>
                                <div class="task-actions">
                                    <a href="editar_tarefa.php?id=<?php echo $tarefa['id']; ?>" class="btn-action btn-edit">✏️ Editar</a>
                                    <button onclick="confirmarExclusao(<?php echo $tarefa['id']; ?>)" class="btn-action btn-delete">🗑️ Excluir</button>
                                    <?php if ($tarefa['status'] != 'concluido'): ?>
                                        <button onclick="alterarStatus(<?php echo $tarefa['id']; ?>, '<?php echo $statusProximo[$tarefa['status']]; ?>')" class="btn-action btn-status">
                                            ▶️ <?php echo $statusTextoProximo[$tarefa['status']]; ?>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (count($tarefas) == 0): ?>
                            <div style="text-align: center; padding: 40px; color: #999;">
                                Nenhuma tarefa nesta coluna
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>