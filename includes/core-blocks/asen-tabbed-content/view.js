// Tabs: buttons or a <select> switch panels; the active tab is mirrored to ?tab= for deep links.
document.querySelectorAll('.asen-tabbed-content').forEach((block) => {
  const tabs = Array.from(block.querySelectorAll('[role="tab"]'));
  const panels = Array.from(block.querySelectorAll('[role="tabpanel"]'));
  const select = block.querySelector('.tab-selector');

  const activate = (slug, updateUrl) => {
    if (!panels.some((panel) => panel.dataset.tab === slug)) return;
    panels.forEach((panel) => { panel.hidden = panel.dataset.tab !== slug; });
    tabs.forEach((tab) => tab.setAttribute('aria-selected', String(tab.dataset.tab === slug)));
    if (select) select.value = slug;
    if (updateUrl) {
      const url = new URL(window.location.href);
      url.searchParams.set('tab', slug);
      window.history.replaceState(null, '', url);
    }
  };

  tabs.forEach((tab) => tab.addEventListener('click', () => activate(tab.dataset.tab, true)));
  if (select) select.addEventListener('change', () => activate(select.value, true));

  const fromUrl = new URLSearchParams(window.location.search).get('tab');
  if (fromUrl) activate(fromUrl, false);
});
