// Mounts the Splide carousels rendered by templates/block/partials/collection.php; options come from each element's data-splide JSON.
document.querySelectorAll('.collection-carousel.splide').forEach((el) => {
  if (!el.classList.contains('is-initialized')) new Splide(el).mount();
});
