<?php
session_start();

// Vérifier si une donnée est envoyée
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['transitionStatus'])) {
  $_SESSION['transitionStatus'] = $data['transitionStatus'];
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "message" => "Invalid data"]);
}
