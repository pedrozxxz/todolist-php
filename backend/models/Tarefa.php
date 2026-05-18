<?php
require_once __DIR__ . '/../config/database.php';

class Tarefa {
    
    public static function criar($usuario_id, $descricao, $setor, $prioridade, $data_cadastro) {
        global $pdo;
        $sql = "INSERT INTO tarefas (usuario_id, descricao, setor, prioridade, data_cadastro, status) 
                VALUES (:usuario_id, :descricao, :setor, :prioridade, :data_cadastro, 'a_fazer')";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':descricao' => $descricao,
            ':setor' => $setor,
            ':prioridade' => $prioridade,
            ':data_cadastro' => $data_cadastro
        ]);
    }
    
    public static function listarPorStatus() {
        global $pdo;
        $sql = "SELECT t.*, u.nome as usuario_nome, u.setor as usuario_setor 
                FROM tarefas t 
                JOIN usuarios u ON t.usuario_id = u.id 
                ORDER BY t.data_cadastro DESC";
        
        $todas = $pdo->query($sql)->fetchAll();
        $porStatus = [
            'a_fazer' => [],
            'fazendo' => [],
            'concluido' => []
        ];
        
        foreach ($todas as $tarefa) {
            $porStatus[$tarefa['status']][] = $tarefa;
        }
        return $porStatus;
    }
    
    public static function atualizarStatus($id, $novoStatus) {
        global $pdo;
        $sql = "UPDATE tarefas SET status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':status' => $novoStatus,
            ':id' => $id
        ]);
    }
    
    public static function excluir($id) {
        global $pdo;
        $sql = "DELETE FROM tarefas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
    public static function buscarPorId($id) {
        global $pdo;
        $sql = "SELECT t.*, u.nome as usuario_nome 
                FROM tarefas t 
                JOIN usuarios u ON t.usuario_id = u.id 
                WHERE t.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    public static function editar($id, $descricao, $setor, $prioridade) {
        global $pdo;
        $sql = "UPDATE tarefas SET descricao = :descricao, setor = :setor, prioridade = :prioridade WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':descricao' => $descricao,
            ':setor' => $setor,
            ':prioridade' => $prioridade,
            ':id' => $id
        ]);
    }
}
?>