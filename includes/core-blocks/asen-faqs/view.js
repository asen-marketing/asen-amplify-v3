// FAQ accordion: one answer open at a time, driven by aria-expanded.
document.querySelectorAll('.asen-faqs').forEach((block) => {
  const questions = block.querySelectorAll('.question');
  questions.forEach((question) => {
    question.addEventListener('click', () => {
      const wasOpen = question.getAttribute('aria-expanded') === 'true';
      questions.forEach((other) => {
        other.setAttribute('aria-expanded', 'false');
        other.closest('.faq').classList.remove('is-open');
      });
      if (!wasOpen) {
        question.setAttribute('aria-expanded', 'true');
        question.closest('.faq').classList.add('is-open');
      }
    });
  });
});
