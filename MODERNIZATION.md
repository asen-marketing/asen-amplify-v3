# Amplify Lite Modernization Plan

Living document. Check items off as they ship and keep the "Roadmap status" lines in [AGENTS.md](AGENTS.md) in sync.

## Goals

1. Make the theme's design tokens (spacing, type scale, colors, widths, radius) the **default options inside Gutenberg** — core blocks, Kadence, and Asen blocks all read the same scale.
2. Make the editor **safe for clients**: palette/preset-only controls, curated inserter, content-only editing of layouts.
3. Stop generating CSS in PHP (`head-mods.php`, per-block `<style>` tags).
4. Give the theme an upgrade path between upstream and client forks.

## Starting point (Oct 2026)

- Classic theme, no `theme.json`, no editor styles, no editor palette.
- 30 ACF blocks: 29 via `acf_register_block()`, 1 (`asen-intro-block`) via `block.json` using the "Reusable - Asen Tokens" clone group. 14 block templates emit per-instance `<style>` with pixel values and hand-rolled breakpoint multipliers.
- Tokens in `scss/_tokens.scss`; brand colors per client in `scss/_colors.scss`. The `site_colors` / `site_max_width` option fields are deprecated.
- No SCSS color functions and no arithmetic on `$spacing-*` / `$font-size-*` anywhere → tokens can be aliased to CSS custom properties without breakage. Only `$site-overall-max-width - 200px` (2 places) needs `calc()`.
- Client forks diverge heavily: the George Ewart build changed ~70 upstream files (header/off-canvas/banner templates, typography, buttons, utility mixins) on top of adding 6 `ewart-*` blocks, 2 CPTs, and 3 options pages. There is currently no upgrade path.

## Open decisions

- [x] **Token source of truth → Option A.** `theme.json` is the source; `_tokens.scss` / `_colors.scss` become `var(--wp--preset--…)` / `var(--wp--custom--…)` aliases. (Option B — PHP reading the SCSS files — rejected: a parser to maintain for no gain.)
- [x] **Option-page color pickers → keep as overrides.** Builders Only color fields (Links & Buttons, Page Banners, header/off-canvas, floating CTA) stay. They layer on top of the theme.json/SCSS defaults: `head-mods.php` prints each one as a `:root` custom prop only when set, and SCSS consumes it with a token fallback (`var(--button-bg, var(--wp--preset--color--primary))`). Button *variants* are not option fields — they are classes in `_buttons.scss` (`.button.red`, `.button-knockout`, `.button-small`…), whose colors reference palette slugs.
- [x] **Distribution → parent/child.** Client repo holds only the child theme; the parent is installed from a GitHub release and updates itself on every site (mechanics in Phase 5).
- [x] **Kadence → core only for new builds.** Group/Columns/Grid/Media & Text are the layout containers. Kadence stays installed on older sites and ages out. Its one remaining use (video popup) is covered by the Asen Video Popup block or a `<dialog>`-based replacement in Phase 4.
- [x] **Minimum versions → WP 6.7, PHP 8.1.** Goes in `style.css` in Phase 0.
- [x] **Retire overlap blocks → yes, per the table in the Oct 2026 discussion.** Button, Buttons Group, Anchor, WYSIWYG, CTA, Copy + Image retire behind patterns/core; Featured Blogs stays (reworked: 3 recent or 3 hand-picked); Link Wrapper and all CPT-driven blocks stay.
- [ ] **Header/footer layout selector → proposed: remove.** Keep header layout 1 and the standard footer as the only built-ins; mailing list becomes a toggle; layouts 2–4 and the simple footers come out of upstream. "Custom from scratch" becomes a child-theme override of the header/footer template parts. Drops `site_header_layout` / `site_footer_layout` and their conditionals in `head-mods.php`, `acf-customizations.php`, `off-canvas.php`, `footer.php`.

## Phase 0 — Groundwork & hygiene (1–2 days)

- [ ] `block_categories` → `block_categories_all`; register `asen-core-blocks` (or point the intro block at `asen-blocks`).
- [ ] Remove `site_colors` + `site_max_width` from `acf-groups/group_5e221e162fc69.json`; delete the echo in `includes/head-mods.php:40-52`; fix `templates/front-page-banner.php:224`; drop the stale comment in `_custom.scss`.
- [ ] Fix `_block-globals.scss` spacing class names to `sm/md/lg` (keep `s/m/l` as aliases for one release); remove the duplicate declarations from `scss/blocks/core/_asen-intro-block.scss`.
- [ ] Fix CPT template filenames: `single-product.php`, `single-service.php`; remove or wire up the `archive-*.php` files; fix the `'products'` / `'services'` checks in `head-mods.php`.
- [ ] Move Leaflet (header.php) to the Location Map block; YouTube iframe API to the Video Popup block.
- [ ] Move `wp68_admin_editor_fix_styles()` / `acfe_modal_width()` CSS into `includes/css/backend-styles.css`.
- [ ] Delete `css/index_safe_save_*`; replace `.gitignore` with a theme-scoped one; fill `README.md`; add `Requires at least`, `Requires PHP`, `Text Domain` to `style.css`.
- [ ] `style.css`: `Requires at least: 6.7`, `Requires PHP: 8.1`.

## Phase 1 — `theme.json` as token layer (2–3 days)

- [ ] `theme.json` (v3) with:
  - `settings.color.palette` — fixed slugs: `primary`, `secondary`, `accent`, `dark`, `light`, `white`, `black`, plus `gray-100…900`. Per-client values are edited here (or in the child theme).
  - `settings.spacing.spacingSizes` — `xs/sm/md/lg/xl` from `_tokens.scss`, as `clamp()` so the 0.8/0.7/0.55 breakpoint mixins become unnecessary. `defaultSpacingSizes: false`, `customSpacingSize: false`, `padding/margin/blockGap: true`, `units: ["px","rem","%","vw"]`.
  - `settings.typography.fontSizes` (fluid) from `$font-size-*`; `fontFamilies` for the site font; `customFontSize: false`.
  - `settings.layout.contentSize` / `wideSize` from container widths; `useRootPaddingAwareAlignments: true`.
  - `settings.custom.*` for heading sizes, line heights, gaps, border radii, container widths → `--wp--custom--…`.
  - `styles.elements` for `h1–h6`, `link`, and the *base* `button` only. Variant classes (`.button.red` etc.) stay in `_buttons.scss` and reference palette vars so a client fork changes only `theme.json`.
  - `settings.appearanceTools: true`.
- [ ] Override layering (defaults → variants → options): `theme.json` sets the token; `_buttons.scss` / `_typography.scss` consume `var(--button-bg, var(--wp--preset--color--primary))`-style fallbacks; `head-mods.php` prints `--button-bg`, `--link-color`, `--banner-title-color`… **only when the Builders Only field is set**. Kills every `color: ;` from empty fields and keeps the option pickers as true overrides.
- [ ] Optional: register the button variant classes as block styles on `core/button` (`is-style-red`) so clients pick from a dropdown instead of typing class names; SCSS targets both selectors.
- [ ] `includes/theme-json.php`: `wp_theme_json_data_theme` filter that, for users **without** an `@asenmarketing.com` email, sets `color.custom`, `color.customGradient`, `spacing.customSpacingSize`, `typography.customFontSize` to `false`. Builders keep full control.
- [ ] Rewrite `_tokens.scss` and `_colors.scss` as aliases (`$spacing-md: var(--wp--preset--spacing--md);` etc.). Replace `$site-overall-max-width` (14 refs) with `var(--wp--style--global--wide-size)`; `calc()` the two subtraction sites. Delete `_site-option-styles.scss`.
- [ ] Editor parity: `add_theme_support('editor-styles')`, new `scss/editor.scss` → `css/editor.css` (tokens, typography, buttons, blocks only), `add_editor_style('css/editor.css')`.
- [ ] `head-mods.php`: emit option values as `:root` custom props (`--header-height`, `--header-max-width`, `--off-canvas-breakpoint`, `--logo-height`…) and move the static rules into SCSS. Guard every `the_field()` echo so empty fields don't print `color: ;`.
- [ ] Verify Kadence color pickers show the theme palette.

## Phase 2 — ACF blocks → `block.json` + native supports (3–5 days, one block at a time)

- [ ] Per block: create `includes/core-blocks/{slug}/block.json` with `apiVersion: 3`, same `name` (`acf/{slug}`), `acf.renderTemplate`, `supports: { color: {background,text}, spacing: {padding,margin}, typography: {fontSize}, align: false, anchor: true }`, `example` for inserter preview, `viewScript`/`style` where the block has assets.
- [ ] Per template: `get_block_wrapper_attributes()` on the `<section>`; delete the per-instance `<style>`; delete padding/margin/font-size/color fields from the field group. Keep `__container_width`, `__gap`, `__heading_size`, `__border_radius` as ACF selects (no native equivalent).
- [ ] Keep legacy field keys registered-but-hidden for one release so existing values still render through a fallback; optional one-shot migration mapping old px → nearest spacing preset into the block's `style` attribute.
- [ ] Remove the matching `acf_register_block()` call from `gutenberg.php` once each block is on `block.json`.
- [ ] Order: `asen-intro-block` (finish), then the 14 inline-style blocks, then the rest.
- [ ] Move the theme's admin `<style>` hacks into editor styles so the iframed (apiVersion 3) editor still looks right.

## Phase 3 — Client-safe editing (2–3 days)

- [ ] `allowed_block_types_all` by role/email domain: clients get Asen blocks + paragraph/heading/list/image/buttons/group/columns; builders get everything including Kadence.
- [ ] `patterns/` directory: section patterns and page starters (`Block Types: core/post-content`, `Post Types: page`) so new pages open with a pattern picker. Core blocks only — never Kadence. Wrap sections in `templateLock: "contentOnly"`; `lock` structural blocks. (`patterns/asen-copy-image.php` and the `asen` category exist as the first example.)
- [ ] Section styles via `register_block_style()` with `style_data` (light / dark / brand) on Group and Asen blocks; retire per-block `background_style` / `white-text` fields.
- [ ] Block bindings: `asen/site-option` source for phone/email/address/hours; ACF `acf/field` source for CPT meta in patterns.
- [ ] `inserter: false` on builder-only blocks.

## Phase 4 — Rationalize the block library (ongoing)

- [x] Copy + Image: `inserter: false`; replaced by `patterns/asen-copy-image.php` (Group + two Media & Text rows). Pattern SCSS lives in the same partial as the legacy block.
- [x] Featured Blogs: reworked to 3 posts, "most recent" or "hand-picked" (relationship field, max 3, falls back to recent), optional CTA tile (default on; makes the row 4-up via `.has-cta-tile`).
- [ ] `inserter: false` + replacement pattern/block style for: Button, Buttons Group (→ `core/buttons` + variant block styles), Anchor (→ HTML anchor field), WYSIWYG (→ core text blocks), CTA (→ pattern).
- [ ] Video popup: confirm the Asen Video Popup block covers what Kadence's was used for; otherwise a `<dialog>`-based replacement.
- [ ] Drop Glide; drop jquery-modal in favor of `<dialog>`; evaluate removing jQuery from `main.js`.

## Phase 5 — Distribution: parent/child with a self-updating parent (2–3 days)

Client repo contains **only the child theme**. The parent is installed once from a GitHub release and updates itself through WordPress's normal theme-update path, so WP Engine sites pick up releases without per-site deploys.

- [ ] Parent self-update: vendor `yahnis-elsts/plugin-update-checker` into `includes/vendor/`, point it at the GitHub repo with release assets enabled, add `Update URI:` to `style.css`, and `add_filter( 'auto_update_theme', … )` → true for `amplifylite` only. Private repo → GitHub token read from a `wp-config.php` constant set per site (never committed).
- [ ] Release workflow (GitHub Action on tag): zip the theme with `amplifylite/` as the top-level folder, attach to the release, write the CHANGELOG entry. Sites see "Update available" in Appearance → Themes within ~12h via WP cron and auto-apply; "Update now" for immediate.
- [ ] Staging soak (GitHub Action on push to `main`): `wpengine/github-action-wpe-site-deploy` rsyncs the theme to one WPE staging environment (`REMOTE_PATH: wp-content/themes/amplifylite/`). Tag only after it's been checked there.
- [ ] Emergency push-to-all: the same deploy Action with a `matrix` of WPE environment names, run manually. Needs the agency SSH Gateway key as a repo secret.
- [ ] Parent code changes: enqueue CSS/JS from `get_stylesheet_directory_uri()`; ACF `load_json` includes parent **and** child `acf-groups/`; block.json loader scans both `core-blocks/` dirs; WP-SCSS compiles from the child (`@import "../../amplifylite/scss/index"` then client partials).
- [ ] Child scaffold repo (`amplifylite-child-starter`): `style.css` (`Template: amplifylite`), `theme.json`, `functions.php`, `includes/`, `scss/index.scss` + `_custom.scss`, `acf-groups/`, `patterns/`, `templates/` for overrides.
- [ ] `CHANGELOG.md` + semver tags. Renamed mixins/classes/field names/template parts = major bump + migration note.
- [ ] Verify on one WPE site: theme auto-update runs under WPE's cron; ACF renders from the updated local JSON without a manual Sync; the child's compiled CSS survives a parent update.

## Risks

- Aliasing tokens to `var()` breaks any future SCSS math/color functions on them — use `calc()` / `color-mix()` instead and say so in AGENTS.md.
- Role-gated `theme.json` settings must only touch `settings`, never `styles`, so the generated CSS is identical for every user.
- apiVersion 3 iframes the editor only when every registered block is v3; the theme's admin CSS must not depend on the non-iframed layout.
- Never rename a shipped block slug; client databases reference `acf/{slug}`.
- Removing ACF fields does not delete stored values, but templates must stop reading them or fall back gracefully.
