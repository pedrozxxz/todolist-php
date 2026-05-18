<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    
    public static function criar($nome, $email, $setor) {
        global $pdo;
        $sql = "INSERT INTO usuarios (nome, email, setor) VALUES (:nome, :email, :setor)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':setor' => $setor
        ]);
    }
    
    public static function listarTodos() {
        global $pdo;
        $sql = "SELECT * FROM usuarios ORDER BY nome ASC";
        return $pdo->query($sql)->fetchAll();
    }
    
    public static function buscarPorId($id) {
        global $pdo;
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
?>