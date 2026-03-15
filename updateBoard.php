<?php
session_start();
require_once("createBoard.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data["action"] === "updateBoard") {
        // Redéfinir $boardGame
        $boardGame = attachId(randomizeArray(createArrayBoard($_SESSION["enemies"], $_SESSION["attacks"], $_SESSION["items"], $_SESSION["enemyCounter"])));
        $_SESSION["paire"] = [];
        $_SESSION["game"] = $boardGame;

        // Répondre avec succès
        echo json_encode(["status" => "success"]);
        exit;
    }
}
http_response_code(400);
echo json_encode(["status" => "error"]);
?>