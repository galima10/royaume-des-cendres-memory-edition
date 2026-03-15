<link rel="stylesheet" href="./styles.css">

<style>
  body {
    background-image: url(./assets/images/decors/basic.png);
    background-size: 110%;
    background-position: center;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 48px;
  }

  h1 {
    font-size: 128px;
    width: 800px;
    color: #F5F0E7;
    text-align: center;
    height: fit-content;
    position: relative;
    line-height: 64px;
    font-family: "Enchanted-Land";

  }

  .game-over-img {
    width: 50%;
    height: 250px;
  }
  .end-img {
    width: 35%;
    height: 130px;
  }
</style>

<?php

session_start();


?>

<h1>
  <?php
  if ($_SESSION["gameStatus"] === "gameOver") {
  ?>
    <img class="game-over-img" src="./assets/images/gameOver.png" alt="">
  <?php
  } else {
  ?>
    <img class="end-img" src="./assets/images/end.png" alt="">
  <?php
  }
  ?>
</h1>

<?php

$_SESSION["gameStatus"] = null;
?>

<button id="reset" class="button">Recommencer</button>
<button id="back" class="button">Retour au menu</button>

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
</script>