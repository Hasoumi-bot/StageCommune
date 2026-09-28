<?php

require_once 'DB.php';

header('Content-Type: application/json');

$methode = $_SERVER['REQUEST_METHOD'];


// ========================================
// GET : récupérer toutes les tâches
// ========================================

if ($methode === 'GET') {

    $stmt = $pdo->query(
        'SELECT * FROM public."Taches" ORDER BY id'
    );

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
}


// ========================================
// POST : ajouter une tâche
// ========================================

elseif ($methode === 'POST') {

    $donnees = json_decode(
        file_get_contents('php://input'),
        true
    );

    $tache = $donnees['tache'];

    $stmt = $pdo->prepare(
        'INSERT INTO public."Taches" (tache, "idUser")
         VALUES (:tache, :idUser)'
    );

    $stmt->execute([
        ':tache' => $tache,
        ':idUser' => 1
    ]);

    echo json_encode([
        'message' => 'Tache ajoutee'
    ]);
}


// ========================================
// PUT : modifier une tâche
// ========================================

elseif ($methode === 'PUT') {

    $id = $_GET['id'];

    $donnees = json_decode(
        file_get_contents('php://input'),
        true
    );

    $tache = $donnees['tache'];

    $stmt = $pdo->prepare(
        'UPDATE public."Taches"
         SET tache = :tache
         WHERE id = :id'
    );

    $stmt->execute([
        ':tache' => $tache,
        ':id' => $id
    ]);

    echo json_encode([
        'message' => 'Tache modifiee'
    ]);
}


// ========================================
// DELETE : supprimer une tâche
// ========================================

elseif ($methode === 'DELETE') {

    $id = $_GET['id'];

    $stmt = $pdo->prepare(
        'DELETE FROM public."Taches"
         WHERE id = :id'
    );

    $stmt->execute([
        ':id' => $id
    ]);

    echo json_encode([
        'message' => 'Tache supprimee'
    ]);
}

?>