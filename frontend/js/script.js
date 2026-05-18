// Função para confirmar exclusão
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
        window.location.href = 'gerenciamento_tarefas.php?excluir=' + id;
    }
}

// Função para alterar status
function alterarStatus(id, novoStatus) {
    window.location.href = 'gerenciamento_tarefas.php?status=' + id + '&novo_status=' + novoStatus;
}

// Animação para os cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.task-card');
    cards.forEach((card, index) => {
        card.style.animation = `fadeInUp 0.3s ease forwards ${index * 0.05}s`;
        card.style.opacity = '0';
    });
});

// Estilo para animação
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);