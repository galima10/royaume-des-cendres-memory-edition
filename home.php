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
    gap: 64px;
  }

  h1 {
    font-size: 88px;
    width: 800px;
    color: #864946;
    text-align: center;
    height: fit-content;
    position: relative;
    line-height: 64px;

    span {
      display: block;
      font-family: "Enchanted-Land";
      position: absolute;
      bottom: 0;
      right: 24px;
      transform: rotate(25deg);
    }

    img {
      width: 65%;
    }
  }

  .start-button {
    padding: 8px 48px;
  }
</style>

<h1>
  <img src="./assets/images/logo.png" alt="">
  <span>Memory<br />édition</span>
</h1>
<button id="start-button" class="button start-button">Jouer</button>

<script>
  document.querySelector("#start-button").addEventListener("click", () => {
    const newAudioSource = "./assets/audios/music/alcoolique.mp3";
    window.parent.postMessage({
      target: "music",
      audioSource: newAudioSource,
      loop: true
    }, "*");
    window.location.href = "start.php";
  })
</script>