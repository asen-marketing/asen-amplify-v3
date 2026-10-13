# Changelog

Versions follow semver. A **major** bump means a child theme may need changes: renamed or removed blocks, field names,
template parts, SCSS variables / mixins, CSS custom properties, or filters. Note the migration under the version.

## 3.0.0 — unreleased

First release of v3, split from amplify-lite (which stays frozen for existing sites). Highlights:

- `theme.json` is the token source; SCSS variables alias its CSS custom properties. Cascade layers keep core and plugin CSS below the theme.
- All blocks are `block.json` with native spacing / color / alignment; structure-only SCSS; no inline styles or scripts. Overlapping and dead blocks removed; Asen - Banner replaces the page and front-page banner templates.
- Site Options are CSS variable overrides; one header and one footer layout.
- Client-safe editing: preset-only controls, inserter allowlist, locked page banner, section and button styles, page-starter patterns.
- Parent/child distribution with self-updates from GitHub releases; a child's compiled CSS rebuilds automatically when the parent's SCSS changes, one request at a time.
- Block bindings: `asen/site-option` puts Site Options contact info (phone, email, address, new Hours field) into core blocks; the Contact Page pattern uses it.
- No jQuery from the theme. Removed from amplify-lite: jquery-modal (`.modal`, `.blocker`, `rel="modal:open"`), the scroll-down CTA, the `asen-dom-loaded` / `asen-window-loaded` / `asen-time-to-relax` body classes, `data-useragent` on `<html>`, and the file-input wrapper markup (`.file-upload-wrapper`; native inputs are styled instead).
