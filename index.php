<link rel="stylesheet" href="styles.css">

<audio id="background-music" src="assets/audios/music/home.mp3" autoplay loop muted></audio>
<audio id="background-sfx" src=""></audio>
<audio id="background-card" src=""></audio>

<!-- Iframe pour encapsuler le jeu -->
<iframe src="home.php" style="width: 100%; height: 100vh; border: none;"></iframe>

<!-- Boîte de dialogue pour demander l'autorisation -->
<div class="audio-permission" id="audio-permission">
  <p>Ce jeu nécessite l'activation de l'audio pour une meilleure expérience. Cliquez sur "Activer l'audio" pour continuer.</p>
  <button id="enable-audio" class="button">Activer l'audio</button>
</div>

<script>
  const audio = document.getElementById('background-music');
  const sfx = document.getElementById('background-sfx');
  const card = document.getElementById('background-card');
  const permissionDialog = document.getElementById('audio-permission');
  const enableAudioButton = document.getElementById('enable-audio');



  // Activer l'audio lorsque l'utilisateur clique sur le bouton
  enableAudioButton.addEventListener('click', () => {
    audio.muted = false;
    audio.volume = .05;
    sfx.muted = false;
    sfx.volume = .1;
    card.muted = false;
    card.volume = .5;
    audio.play().then(() => {
      // Masquer la boîte de dialogue après activation
      permissionDialog.style.display = 'none';
    }).catch(error => {
      console.error('Erreur lors de l\'activation de l\'audio :', error);
    });
  });

  window.addEventListener('message', (event) => {
    if (event.data && event.data.audioSource) {
      if (event.data.target === "music") {
        audio.src = event.data.audioSource;
        if (event.data.loop !== undefined) {
          audio.loop = event.data.loop;
        }
        audio.play().catch(error => {
          console.error("Erreur lors de la lecture de la musique :", error);
        });
      } else if (event.data.target === "sfx") {
        sfx.src = event.data.audioSource;

        sfx.play().catch(error => {
          console.error("Erreur lors de la lecture des effets sonores :", error);
        });
      } else if (event.data.target === "card") {
        card.src = event.data.audioSource;

        card.play().catch(error => {
          console.error("Erreur lors de la lecture des effets sonores :", error);
        });
      }
    }
  });
</script>