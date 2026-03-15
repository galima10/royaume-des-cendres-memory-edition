<?php
session_start();
require_once("createBoard.php");
?>

<link rel="stylesheet" href="./styles.css">

<?php

if (!isset($_SESSION["gameStatus"])) {
  header("Location: start.php");
}

$boardGame = $_SESSION["game"] ?? [];
$enemies = $_SESSION["enemies"] ?? [];
$enemyCounter = $_SESSION["enemyCounter"] ?? [];

$actualEnemy = $enemies[$enemyCounter];

if ($_SESSION["sound"] === "enemy") {
  $sound = $actualEnemy["infos"]["sound"];
  echo '<script>
          window.parent.postMessage({ 
            target: "sfx",
            audioSource: "' . $sound . '" ,
            loop: false
          }, "*");
        </script>';
  $_SESSION["sound"] = "";
} elseif ($_SESSION["sound"] === "simple") {
  echo '<script>
          window.parent.postMessage({ 
            target: "sfx",
            audioSource: "./assets/audios/sounds/simple.mp3" ,
            loop: false
          }, "*");
        </script>';
  $_SESSION["sound"] = "";
} elseif ($_SESSION["sound"] === "special") {
  echo '<script>
          window.parent.postMessage({ 
            target: "sfx",
            audioSource: "./assets/audios/sounds/special.mp3" ,
            loop: false
          }, "*");
        </script>';
  $_SESSION["sound"] = "";
} elseif ($_SESSION["sound"] === "torch") {
  echo '<script>
          window.parent.postMessage({ 
            target: "sfx",
            audioSource: "./assets/audios/sounds/torch.mp3" ,
            loop: false
          }, "*");
        </script>';
  $_SESSION["sound"] = "";
} elseif ($_SESSION["sound"] === "heart") {
  echo '<script>
          window.parent.postMessage({ 
            target: "sfx",
            audioSource: "./assets/audios/sounds/heart.mp3" ,
            loop: false
          }, "*");
        </script>';
  $_SESSION["sound"] = "";
} elseif ($_SESSION["sound"] === "fullheart") {
  echo '<script>
          window.parent.postMessage({ 
            target: "sfx",
            audioSource: "./assets/audios/sounds/fullheart.mp3" ,
            loop: false
          }, "*");
        </script>';
  $_SESSION["sound"] = "";
} elseif ($_SESSION["cardSound"]) {
  echo '<script>
          window.parent.postMessage({ 
            target: "card",
            audioSource: "./assets/audios/sounds/card.mp3" ,
            loop: false
          }, "*");
        </script>';
  $_SESSION["cardSound"] = false;
}

$playerHealth = $_SESSION["playerHealth"] ?? [];
$enemyHealth = $_SESSION["enemyHealth"] ?? [];

$attackCounter = 0;

foreach ($boardGame as $card) {
  if ($card["found"] && $card["element"]["type"] === "attack") $attackCounter++;
}

function displayBoard($arrayBoard)
{
?>
  <ul class="tableau">
    <?php
    foreach ($arrayBoard as $card) {
    ?>
      <li>
        <button onclick="
          document.querySelector('.tableau').style.pointerEvents = 'none';
          this.classList.add('local-selected'); 
          setTimeout(() => { 
            window.location.href = 'click.php?id=<?= $card['id'] ?>'; 
          }, 500)
          " class="card <?php if ($card["selected"]) echo "selected" ?> <?php if ($card["found"]) echo "found" ?>">
          <div class="card-inner">
            <div class="card-front">
              <img class="card-image" src="<?= $card["element"]["infos"]["img"] ?>" alt="">
              <p class="card-name">
                <?= $card["element"]["infos"]["name"] ?>
              </p>
            </div>
            <div class="card-back"></div>
          </div>
        </button>
      </li>
    <?php
    }
    ?>
  </ul>
<?php
}

function displayHUD($playerHealth, $actualEnemy, $enemyHealth, $boardGame)
{
?>
  <div class="hud">
    <div class="menu">
      <button id="reset" class="button">Recommencer</button>
      <button id="back" class="button">Retour au menu</button>
    </div>
    <div class="player-hud">
      <p class="player-title">Informations du joueur</p>
      <div class="health-container">
        <p class="health-number">PV : <?= $playerHealth ?> / 6</p>
        <ul class="health-bar">
          <?php
          if ($playerHealth > 0) {
            for ($i = 0; $i < explode('.', $playerHealth)[0]; $i++) {
          ?>
              <li>
                <img src="./assets/images/items/fullheart.png" alt="">
              </li>
            <?php
            }
          }

          if (isset(explode('.', $playerHealth)[1])) {
            ?>
            <li>
              <img src="./assets/images/items/halfheart.png" alt="">
            </li>
          <?php
          }
          ?>
        </ul>
      </div>
      <?php
      foreach ($boardGame as $card) {
        if ($card["element"]["type"] === "attack" && $card["element"]["infos"]["name"] === "Spécial") {
      ?>
          <div class="special-info">
            <p>Attaque spéciale activée !</p>
            <img src="./assets/images/items/special.png" alt="">
          </div>
      <?php
          break;
        }
      }
      ?>

    </div>
    <div class="enemy-hud">
      <div class="enemy-preview">
        <p><?= $actualEnemy["infos"]["name"] ?></p>
        <img src="./assets/images/<?= $actualEnemy["infos"]["label"] ?>/normal.png" alt="">
      </div>
      <div class="health-container">
        <p class="health-number">PV : <?= $enemyHealth ?> / <?= $actualEnemy["infos"]["health"] ?></p>
        <ul class="health-bar">
          <?php
          if ($enemyHealth > 0) {
            for ($i = 0; $i < explode('.', $enemyHealth)[0]; $i++) {
          ?>
              <li>
                <img src="./assets/images/items/fullheart.png" alt="">
              </li>
            <?php
            }
          }

          if (isset(explode('.', $enemyHealth)[1])) {
            ?>
            <li>
              <img src="./assets/images/items/halfheart.png" alt="">
            </li>
          <?php
          }
          ?>
        </ul>
      </div>

    </div>
  </div>
<?php
}

?>


<div class="game-container">
  <div class="game" style="background-image: url(./assets/images/decors/<?= strtolower($enemies[$enemyCounter]["infos"]["label"]) ?>.png);">
    <?php
    displayBoard($boardGame);
    displayHUD($playerHealth, $actualEnemy, $enemyHealth, $boardGame);
    ?>
    <div class="transition <?php if ($_SESSION["transitionStatus"] === "toOpen") {
                              echo "transition-close";
                            } else {
                              echo "transition-open";
                            } ?>"></div>
  </div>
</div>

<script>
  document.getElementById("reset").addEventListener("click", () => {
    const newAudioSource = "./assets/audios/music/alcoolique.mp3";
    window.parent.postMessage({
      target: "music",
      audioSource: newAudioSource,
      loop: true
    }, "*");
    window.location.href = "start.php";
  })
  document.getElementById("back").addEventListener("click", () => {
    const newAudioSource = "./assets/audios/music/home.mp3";
    window.parent.postMessage({
      target: "music",
      audioSource: newAudioSource,
      loop: true
    }, "*");
    window.location.href = "home.php";
  })

  let progress = 0,
    animationActive = false;

  function easeInOutCubic(e) {
    return e < 0.5 ? 4 * e * e * e : 1 - Math.pow(-2 * e + 2, 3) / 2;
  }

  function animationFiltre() {
    const transitionDiv = document.querySelector(".transition");
    if (!transitionDiv) return;

    let tauxAnimationFiltreHeader = 0;

    function animate() {
      if (tauxAnimationFiltreHeader < 100) {
        progress += 0.03;
        tauxAnimationFiltreHeader = 100 * easeInOutCubic(progress);
        transitionDiv.style.background = `radial-gradient(circle, rgba(0, 0, 0, 0) ${tauxAnimationFiltreHeader}%, rgba(0, 0, 0, 1) ${tauxAnimationFiltreHeader + 15}%)`;
        requestAnimationFrame(animate);
      } else {
        animationActive = false;
        progress = 0;


        fetch("transitionStatus.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            transitionStatus: "opened"
          }),
        });
      }
    }

    if (!animationActive) {
      animationActive = true;
      animate();
    }
  }

  function animationFiltreClose() {
    return new Promise((resolve) => {
      const transitionDiv = document.querySelector(".transition");
      if (!transitionDiv) return;

      let tauxAnimationFiltreHeader = 100;

      function animate() {
        if (tauxAnimationFiltreHeader > 0) {
          progress += 0.03;
          tauxAnimationFiltreHeader = Math.max(0, 100 - 100 * easeInOutCubic(progress));
          transitionDiv.style.background = `radial-gradient(circle, rgba(0, 0, 0, 0) ${tauxAnimationFiltreHeader}%, rgba(0, 0, 0, 1) ${tauxAnimationFiltreHeader + 15}%)`;
          requestAnimationFrame(animate);
        } else {
          animationActive = false;
          progress = 0;

          // Envoyer une requête pour mettre à jour le statut
          fetch("transitionStatus.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              transitionStatus: "closed",
            }),
          }).then(() => {
            resolve(); // Résoudre la promesse une fois que le statut est mis à jour
          });
        }
      }

      if (!animationActive) {
        animationActive = true;
        animate();
      }
    });
  }

  const transitionStatus = "<?php echo $_SESSION['transitionStatus'] ?? ''; ?>";

  window.onload = async function() {
    if (transitionStatus === "toOpen") {
      setTimeout(() => {
        animationFiltre();
      }, 1000);
    } else if (transitionStatus === "toClose") {
      await animationFiltreClose(); // Attendre que l'animation se termine
      window.location.href = "game.php";
    }
  };
</script>

<?php

if ($_SESSION["gameStatus"] === "gameOver") {
  echo '<script>
          document.querySelector(".tableau").style.pointerEvents = "none";
            setTimeout(function() {
              const newAudioSource = "./assets/audios/music/gameOver.mp3";
              window.parent.postMessage({
                target: "music",
                audioSource: newAudioSource,
                loop: false
              }, "*");
              window.location.href = "finish.php";
            }, 2000);
          </script>';
}

if ($attackCounter === 2) {
  if ($_SESSION["enemyHealth"] <= 0) {
    if ($_SESSION['transitionStatus'] === "opened") {
      $_SESSION['transitionStatus'] = "toClose";
      echo '<script>
            document.querySelector(".tableau").style.pointerEvents = "none";

            setTimeout(function() {
              window.location.href = "game.php";
            }, 2000);
          </script>';
    }
    if ($_SESSION['transitionStatus'] === "closed") {
      if ($_SESSION["enemyCounter"] < count($enemies) - 1) {
        $_SESSION["enemyCounter"]++;
        $newAudioSource = $enemies[$_SESSION["enemyCounter"]]["infos"]["music"]; // Générer la nouvelle source audio
        echo '<script>
                document.querySelector(".tableau").style.pointerEvents = "none";
                document.querySelector(".transition").classList.replace("transition-open", "transition-close");
                setTimeout(function() {
                  window.parent.postMessage({ 
                    target: "music",
                    audioSource: "' . $newAudioSource . '" ,
                    loop: true
                  }, "*");
                  window.location.href = "game.php";
                }, 500);
              </script>';
        $_SESSION["enemyHealth"] = $enemies[$_SESSION["enemyCounter"]]["infos"]["health"];
        $boardGame = attachId(randomizeArray(createArrayBoard($enemies, $attacks, $items, $_SESSION["enemyCounter"])));
        $_SESSION["paire"] = [];
        $_SESSION['transitionStatus'] = "toOpen";
        $_SESSION["game"] = $boardGame;
      } else {
        $_SESSION["gameStatus"] = "win";
        echo '<script>
            document.querySelector(".transition").classList.replace("transition-open", "transition-close");
            setTimeout(function() {
            const newAudioSource = "./assets/audios/music/home.mp3";
            window.parent.postMessage({
              target: "music",
              audioSource: newAudioSource,
              loop: true
            }, "*");
              window.location.href = "finish.php";
            }, 2000);
          </script>';
      }
    }
  } else {
    echo '<script>
            document.querySelector(".tableau").style.pointerEvents = "none";
            setTimeout(function() {
              document.querySelectorAll(".found").forEach(element => {
                element.classList.remove("found");
              });
              document.querySelectorAll(".selected").forEach(element => {
                element.classList.remove("selected");
              });
            }, 700);
            setTimeout(function() {
              window.location.href = "game.php";
            }, 900);
          </script>';
    $boardGame = attachId(randomizeArray(createArrayBoard($enemies, $attacks, $items, $_SESSION["enemyCounter"])));
    $_SESSION["paire"] = [];
    $_SESSION["game"] = $boardGame;
  }

  exit; // Arrête l'exécution du script après avoir envoyé la réponse
}


if (count($_SESSION["paire"]) === 2) {
  $paire1 = $_SESSION["paire"][0] - 1;
  $paire2 = $_SESSION["paire"][1] - 1;

  if ($boardGame[$paire1]["element"]["infos"]["name"] !== $boardGame[$paire2]["element"]["infos"]["name"] && $boardGame[$_SESSION["previousCard"][count($_SESSION["previousCard"]) - 1] - 1]["element"] !== $actualEnemy) {
    echo '<script>
          document.querySelector(".tableau").style.pointerEvents = "none";
          
          setTimeout(function() {
            document.querySelectorAll(".selected").forEach(element => {
              element.classList.remove("selected");
            });
          }, 400);
          setTimeout(function() {
            window.location.href = "game.php";
          }, 600);
        </script>';
    $boardGame[$paire1]["selected"] = false;
    $boardGame[$paire2]["selected"] = false;
    $_SESSION["game"] = $boardGame;
    $_SESSION["paire"] = [];
  }
}

if (isset($_SESSION["previousCard"][count($_SESSION["previousCard"]) - 1])) {
  if ($boardGame[$_SESSION["previousCard"][count($_SESSION["previousCard"]) - 1] - 1]["element"] === $actualEnemy && $boardGame[$_SESSION["previousCard"][count($_SESSION["previousCard"]) - 1] - 1]["selected"]) {
    echo '<script>
          document.querySelector(".tableau").style.pointerEvents = "none";
          function vibrateElement(element) {
            element.classList.add("vibrate");

            setTimeout(() => {
              element.classList.remove("vibrate");
            }, 300);
          }
          vibrateElement(document.querySelector(".game"));
          setTimeout(function() {
            document.querySelectorAll(".selected").forEach(element => {
              element.classList.remove("selected");
            });
          }, 700);
          setTimeout(function() {
            window.location.href = "game.php";
          }, 900);
        </script>';
    if ($boardGame[$_SESSION["previousCard"][count($_SESSION["previousCard"]) - 2] - 1]) {
      $boardGame[$_SESSION["previousCard"][count($_SESSION["previousCard"]) - 2] - 1]["selected"] = false;
    }
    $boardGame[$_SESSION["previousCard"][count($_SESSION["previousCard"]) - 1] - 1]["selected"] = false;
    $_SESSION["game"] = $boardGame;
  }
}

?>