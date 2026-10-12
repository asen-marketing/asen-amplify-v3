// Mounts the Splide carousels the theme renders (collection partial, banner slideshow); options come from each element's data-splide JSON.
document.querySelectorAll('.splide[data-splide]').forEach((el) => {
  if (!el.classList.contains('is-initialized')) new Splide(el).mount();
});
