// <details> handles open/close; this adds closing on outside click and Escape.
document.querySelectorAll('.asen-dropdown-links details').forEach((details) => {
  document.addEventListener('click', (event) => {
    if (details.open && !details.contains(event.target)) details.open = false;
  });
  details.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && details.open) {
      details.open = false;
      details.querySelector('summary').focus();
    }
  });
});
