// Play button opens a <dialog> with a YouTube (privacy-enhanced) iframe or the uploaded video; closing removes it to stop playback.
document.querySelectorAll('.asen-video-popup').forEach((block) => {
  const button = block.querySelector('.play-button');
  const dialog = block.querySelector('.video-dialog');
  if (!button || !dialog) return;
  const frame = dialog.querySelector('.video-frame');
  const teaser = block.querySelector('.teaser video');

  button.addEventListener('click', () => {
    const { youtube, src } = button.dataset;
    let player;
    if (youtube) {
      player = document.createElement('iframe');
      player.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(youtube) + '?autoplay=1&rel=0';
      player.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen';
      player.allowFullscreen = true;
      player.title = button.getAttribute('aria-label');
    } else if (src) {
      player = document.createElement('video');
      player.src = src;
      player.controls = true;
      player.autoplay = true;
      player.playsInline = true;
    }
    if (!player) return;
    frame.replaceChildren(player);
    if (teaser) teaser.pause();
    dialog.showModal();
  });

  dialog.querySelector('.close').addEventListener('click', () => dialog.close());
  dialog.addEventListener('click', (event) => {
    if (event.target === dialog) dialog.close(); // backdrop
  });
  dialog.addEventListener('close', () => {
    frame.replaceChildren();
    if (teaser) teaser.play();
  });
});
