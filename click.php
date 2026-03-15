<?php

session_start();
require_once("createBoard.php");

$boardGame = $_SESSION["game"] ?? [];
$enemies = $_SESSION["enemies"] ?? [];
$enemyCounter = $_SESSION["enemyCounter"] ?? [];


$id = $_GET["id"];
$previousCardClicked = null;
if (isset($_SESSION["previousCard"]) && count($_SESSION["previousCard"]) > 0) {
  $previousCardClicked = $_SESSION["previousCard"][count($_SESSION["previousCard"]) - 1] ?? null;
}

$_SESSION["previousCard"][] = $id;

$actualEnemy = $enemies[$enemyCounter];

checkClic($boardGame, $id, $actualEnemy, $attacks);

function checkClic($boardGame, $id, $actualEnemy, $attacks)
{
  $_SESSION["cardSound"] = true;
  if ($boardGame[$id - 1]["element"]["infos"]["name"] === $actualEnemy["infos"]["name"]) {
    $_SESSION["cardSound"] = false;
    $_SESSION["sound"] = "enemy";
    $_SESSION["paire"] = [];
    $_SESSION["playerHealth"] = $_SESSION["playerHealth"] - $actualEnemy["infos"]["hit"];
    if ($_SESSION["playerHealth"] <= 0) {
      $_SESSION["playerHealth"] = 0;
      $_SESSION["gameStatus"] = "gameOver";
    }
    $boardGame[$id - 1]["selected"] = true;
  } else if ($id && count($_SESSION["paire"]) !== 2) {
    $_SESSION["paire"][] = $boardGame[$id - 1]["id"];
    $boardGame[$id - 1]["selected"] = true;

    if (count($_SESSION["paire"]) === 2) {
      $paire1 = $boardGame[$_SESSION["paire"][0] - 1];
      $paire2 = $boardGame[$_SESSION["paire"][1] - 1];

      if ($paire1["element"]["type"] === "heart" && $paire2["element"]["type"] === "heart") {
        $_SESSION["cardSound"] = false;
        $boardGame[$_SESSION["paire"][0] - 1]["found"] = true;
        $boardGame[$_SESSION["paire"][1] - 1]["found"] = true;
        $_SESSION["playerHealth"]++;

        if (count(explode('.', $_SESSION["playerHealth"])) > 1 && $_SESSION["playerHealth"] > 6) {
          $_SESSION["playerHealth"] = 6;
          $_SESSION["sound"] = "heart";
        } elseif ($_SESSION["playerHealth"] <= 6) {
          $_SESSION["sound"] = "heart";
        } else {
          $_SESSION["playerHealth"] = 6;
          $_SESSION["sound"] = "fullheart";
        }
      }

      if ($paire1["element"]["type"] === "torch" && $paire2["element"]["type"] === "torch") {
        $_SESSION["cardSound"] = false;
        $_SESSION["sound"] = "torch";
        $boardGame[$_SESSION["paire"][0] - 1]["found"] = true;
        $boardGame[$_SESSION["paire"][1] - 1]["found"] = true;
        for ($i = 0; $i < count($boardGame); $i++) {
          if ($boardGame[$i]["element"]["infos"]["name"] === "Normal") {
            $boardGame[$i]["element"] = $attacks["special"];
          }
        }
      }

      if ($paire1["element"]["type"] === "attack" && $paire2["element"]["type"] === "attack") {
        $_SESSION["cardSound"] = false;
        $boardGame[$_SESSION["paire"][0] - 1]["found"] = true;
        $boardGame[$_SESSION["paire"][1] - 1]["found"] = true;
        $_SESSION["enemyHealth"] = $_SESSION["enemyHealth"] - $paire1["element"]["infos"]["hit"];

        if ($_SESSION["enemyHealth"] <= 0) {
          $_SESSION["enemyHealth"] = 0;
        }
        if ($paire1["element"]["infos"]["name"] === "Normal") {
          $_SESSION["sound"] = "simple";
        } else {
          $_SESSION["sound"] = "special";
        }
      }
    }
  } else {
    foreach ($_SESSION["paire"] as $idPaire) {
      $boardGame[$idPaire - 1]["selected"] = false;
    }
    $_SESSION["paire"] = [];
    $_SESSION["paire"][] = $boardGame[$id - 1]["id"];
    $boardGame[$id - 1]["selected"] = true;
  }

  $_SESSION["game"] = $boardGame;

  
  header("Location: game.php");
}

?>