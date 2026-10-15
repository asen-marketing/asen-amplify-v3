# Changelog

Versions follow semver. A **major** bump means a child theme may need changes: renamed or removed blocks, field names,
template parts, SCSS variables / mixins, CSS custom properties, or filters. Note the migration under the version.

## Unreleased

- Footer Options colors are palette-only swatches from theme.json and save the palette variable (`--wp--preset--color--{slug}`), so they follow palette changes. The hard-coded `#999999` / `#000000` / `#FFFFFF` defaults are gone; empty falls back to `_component-vars.scss`.
- Footer Options font sizes (footer, bottom bar, mailing-list title / subtitle, social icons) are theme.json font-size selects (title also offers the heading scale) instead of pixel inputs. Previously saved pixel values still print until the option is re-saved.
- The same for the rest of Site Options: Header, Off-Canvas (including the button repeater), Builders Only links / buttons / page banner (and the Text Properties clone behind the banner eyebrow / title / subtitle), the floating CTA and Page Options' header background are palette-only swatches; the `#000000` / `#FFFFFF` / `#999999` / `#495057` defaults are gone. Off-canvas menu font sizes are heading-scale + font-size selects; off-canvas copyright and button font sizes are font-size selects (the 40 / 30 / 18px field defaults are gone too). Heights, max width, paddings and the breakpoint stay pixel inputs. Previously saved hex and pixel values still print.

## 3.0.1 — 2026-10-14

- Logged-in toolbars render correctly again: the admin bar, plugins' admin-bar items (Yoast) and Query Monitor stay out of the `vendor` cascade layer, where the theme's element rules were beating their ID-scoped rules and pushing admin-bar links out of the bar.

## 3.0.0 — 2026-10-13

First release of v3, split from amplify-lite (which stays frozen for existing sites). Highlights:

- `theme.json` is the token source; SCSS variables alias its CSS custom properties. Cascade layers keep core and plugin CSS below the theme.
- All blocks are `block.json` with native spacing / color / alignment; structure-only SCSS; no inline styles or scripts. Overlapping and dead blocks removed; Asen - Banner replaces the page and front-page banner templates.
- Site Options are CSS variable overrides; one header and one footer layout.
- Client-safe editing: preset-only controls, inserter allowlist, locked page banner, section and button styles, page-starter patterns.
- Parent/child distribution with self-updates from GitHub releases; a child's compiled CSS rebuilds automatically when the parent's SCSS changes, one request at a time.
- Block bindings: `asen/site-option` puts Site Options contact info (phone, email, address, new Hours field) into core blocks; the Contact Page pattern uses it.
- No jQuery from the theme. Removed from amplify-lite: jquery-modal (`.modal`, `.blocker`, `rel="modal:open"`), the scroll-down CTA, the `asen-dom-loaded` / `asen-window-loaded` / `asen-time-to-relax` body classes, `data-useragent` on `<html>`, and the file-input wrapper markup (`.file-upload-wrapper`; native inputs are styled instead).
