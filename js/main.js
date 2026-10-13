// Off-canvas menu: the hamburgers toggle it; the overlay, Escape and same-page links close it.
(function () {
  "use strict";

  const container = document.querySelector(".off-canvas-menu-container");
  if (!container) return;

  const overlay = document.querySelector(".off-canvas-menu-backing-overlay");
  const hamburgerContainers = document.querySelectorAll(".off-canvas-menu-hamburger");
  const hamburgers = document.querySelectorAll(".off-canvas-menu-hamburger .hamburger");
  const headerHamburger = [...hamburgers].find((button) => !container.contains(button));
  const closeButton = [...hamburgers].find((button) => container.contains(button));
  const inside = container.querySelector(".inside");
  const column = container.querySelector(".column-container");
  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

  function isOpen() {
    return container.classList.contains("is-active");
  }

  function setOpen(open) {
    const focusWasInside = container.contains(document.activeElement);
    [overlay, container, ...hamburgerContainers, ...hamburgers].forEach((el) => el && el.classList.toggle("is-active", open));
    hamburgers.forEach((button) => button.setAttribute("aria-expanded", open));
    container.inert = !open;

    // The header hamburger fades out while the menu is open, so focus follows the toggle.
    const focusTarget = open ? closeButton : focusWasInside && headerHamburger;
    if (focusTarget) focusTarget.focus({ preventScroll: true });
  }

  hamburgers.forEach((button) => button.addEventListener("click", () => setOpen(!isOpen())));
  if (overlay) overlay.addEventListener("click", () => setOpen(false));
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && isOpen()) setOpen(false);
  });

  // Lock the menu's current top so submenus expand downward instead of pushing it up.
  function pin() {
    if (inside.classList.contains("is-pinned")) return;
    const first = column.firstElementChild;
    const restingTop = first.getBoundingClientRect().top;
    const padding = parseFloat(getComputedStyle(column).paddingTop);
    inside.classList.add("is-pinned");
    column.style.paddingTop = padding + restingTop - first.getBoundingClientRect().top + "px";
  }

  function unpinIfIdle() {
    if (!container.querySelector(".menu-item-has-children.is-active")) {
      inside.classList.remove("is-pinned");
      column.style.paddingTop = "";
    }
  }

  // Height slide; a slide that's still running reverses from wherever it is.
  function slide(submenu, open) {
    const from = submenu.getBoundingClientRect().height;
    submenu.getAnimations().forEach((animation) => animation.cancel());
    submenu.style.display = "block";
    const to = open ? submenu.scrollHeight : 0;
    const animation = submenu.animate(
      [
        { height: from + "px", overflow: "hidden" },
        { height: to + "px", overflow: "hidden" },
      ],
      { duration: reducedMotion.matches ? 0 : 400, easing: "ease-in-out" },
    );
    animation.onfinish = () => {
      if (!open) submenu.style.display = "";
      unpinIfIdle();
    };
  }

  const submenuToggles = new Set();
  container.querySelectorAll(".menu-item-has-children").forEach((item) => {
    const link = item.querySelector(":scope > a");
    const submenu = item.querySelector(":scope > .sub-menu");
    if (!link || !submenu) return;

    submenuToggles.add(link);
    link.setAttribute("aria-expanded", "false");
    link.addEventListener("click", (event) => {
      event.preventDefault();
      item.parentElement.querySelectorAll(":scope > .menu-item-has-children.is-active").forEach((other) => {
        if (other === item) return;
        other.classList.remove("is-active");
        other.querySelector(":scope > a").setAttribute("aria-expanded", "false");
        slide(other.querySelector(":scope > .sub-menu"), false);
      });

      const open = item.classList.toggle("is-active");
      link.setAttribute("aria-expanded", open);
      if (open) pin();
      slide(submenu, open);
    });
  });

  container.addEventListener("click", (event) => {
    const link = event.target.closest("a");
    if (link && !submenuToggles.has(link) && link.pathname === window.location.pathname) {
      setOpen(false);
    }
  });
})();
