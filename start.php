<?php


session_start();
require_once("createBoard.php");

$_SESSION["enemyCounter"] = 0;

$boardGame = attachId(randomizeArray(createArrayBoard($enemies, $attacks, $items, $_SESSION["enemyCounter"])));


function launchGame($boardGame, $enemyCounter, $enemies)
{
  $_SESSION["game"] = [];
  $_SESSION["gameStatus"] = "started";
  $_SESSION["paire"] = [];
  $_SESSION["enemies"] = [];
  $_SESSION["playerHealth"] = [];
  $_SESSION["enemyHealth"] = [];
  $_SESSION["previousCard"] = [];
  $_SESSION["transitionStatus"] = "toOpen";
  $_SESSION["sound"] = "";
  $_SESSION["cardSound"] = "";
  
  $_SESSION["game"] = $boardGame;
  $_SESSION["enemies"] = $enemies;
  $_SESSION["playerHealth"] = 4.5;
  $_SESSION["enemyHealth"] = $enemies[$enemyCounter]["infos"]["health"];
  header("Location: game.php");
}

launchGame($boardGame, $_SESSION["enemyCounter"], $enemies);
