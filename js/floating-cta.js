// Hide the floating contact button while the footer is on screen.
const floatingCta = document.querySelector('.fixed-contact-cta-button');
const siteFooter = document.querySelector('footer.site-footer');
if (floatingCta && siteFooter && 'IntersectionObserver' in window) {
  new IntersectionObserver(([entry]) => floatingCta.classList.toggle('is-hidden', entry.isIntersecting)).observe(siteFooter);
}
