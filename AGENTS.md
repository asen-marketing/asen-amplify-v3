# Asen Amplify (v3) — Agent Guide

Asen Marketing's WordPress theme for client sites, v3. Successor to `amplify-lite` (github.com/asen-marketing/amplify-lite), which is frozen for the sites already built on it. This repo is the **parent theme**; each client site is a child theme in its own repo (Phase 5 builds the scaffold and the self-update path). Clients get editor access after launch for minor text/image changes, so anything that reaches the editor must be safe for a non-developer to touch.

Keep this file current. When you add a convention, fix a known issue, or ship a roadmap phase, update the relevant section here. The detailed modernization plan lives in [MODERNIZATION.md](MODERNIZATION.md).

## Stack

- **Classic PHP theme with `theme.json`** (hybrid). `theme.json` holds every token — palette, spacing presets, font-size presets, heading scale, line heights, gaps, radii, container widths — and `_tokens.scss` / `_colors.scss` alias them as CSS custom properties. Edit `theme.json`, never the aliases. No block templates, no Site Editor.
- **ACF Pro + ACF Extended** define every field group, CPT, taxonomy, and options page. All of it is synced to `acf-groups/*.json` — commit the JSON, never hand-write `register_post_type` / `register_taxonomy` / `acf_add_local_field_group`. Edit groups in the ACF UI, or edit the JSON and use Custom Fields → Field Groups → Sync. **Never save or import a group from a script** (`acf_import_field_group()`, `acf_update_field_group()`): ACF Extended's `ACFE_AutoSync_Json` wraps ACF's JSON writer, and a scripted save created a duplicate DB group, wrote nothing, and deleted the existing JSON file. Local JSON takes priority at runtime, so a group that exists only as JSON still renders; the UI just shows "Sync available".
- **Gutenberg + ACF blocks** for page content; **core Group / Columns / Grid / Media & Text** are the layout containers (decided Oct 2026). **Kadence Blocks** is installed on older builds only — don't add Kadence dependencies or style against `.kt-*` selectors in upstream.
- **Gravity Forms**, **Yoast**, **Relevanssi**, **SVG Support**, **WP-PageNavi**, **Broken Link Checker** are assumed present.
- **CSS cascade layers.** `scss/index.scss` declares `@layer vendor, reset, base, components, blocks, utilities` and wraps each partial group; `includes/css-layers.php` pushes every WordPress and plugin stylesheet (links and inline) into `vendor`, so the theme always sits above core/plugin defaults. Unlayered CSS — `_custom.scss`, child-theme CSS, editor-set inline block styles, `core-block-supports` — beats all layers, which is the whole override story: no `!important`, no specificity wars. Handles that must stay unlayered go through the `asen/unlayered_style_handles` filter.
- **WP-SCSS** compiles every non-partial in `scss/` on page load: `index.scss` → `css/index.css` (front end) and `editor.scss` → `css/editor.css` (block editor, via `add_editor_style`). Compressed, inline sourcemap. `css/` is gitignored. Never edit or commit compiled CSS, never run a compiler yourself. On production, `always_recompile` must be off.
- **JS:** `js/main.js` (jQuery, off-canvas menu, modals, misc), `js/carousel.js` (mounts Splide carousels from the collection partial), block `view.js` files, `js/vendor/` with jquery-modal and Splide (+ auto-scroll extension). Splide is the only carousel library. No bundler; `node_modules/` is vestigial.
- **Fonts/icons:** Adobe Fonts + Font Awesome are injected via the "Font Snippets" field in Site Options → Builders Only.

## Directory map

```
theme.json                 the token source of truth (settings only so far; styles.elements still live in SCSS)
functions.php              requires includes/*.php in order; tiny WP fixes only
includes/
  theme.php                enqueues, theme supports, image sizes, asen_enqueue_splide()/glide(), block.json loader
  gutenberg.php            legacy acf_register_block() calls + block category + render callback
  patterns.php             registers the "Asen" pattern category
  css-layers.php           moves core/plugin stylesheets into the `vendor` cascade layer
  theme-json.php           editor styles + preset-only editor settings for non-Asen users (asen_user_is_builder())
  core-blocks/{slug}/block.json   new-style block registration (auto-loaded by asen_register_acf_blocks)
  acf-customizations.php   ACF JSON paths, options pages, "asen_domain" location rule, GF form dropdown populator
  head-mods.php            <head> output: font snippets, script snippets, inline CSS generated from option fields
  backend-mods.php         admin menu curation, editor hiding for custom templates, admin CSS
  helpers.php              asen_acf_image_url(), asen_clean_phone_number(), asen_geocode_address() (cached Nominatim), primary-category helpers
  menus.php, footer-mods.php, woocommerce.php, yoast.php, body-class-mods.php, cmp-gravity-patch.php
  css/backend-styles.css   admin-only styles
templates/
  block/{slug}.php         ACF block render templates (legacy location)
  block/core-blocks/{slug}.php    render templates for block.json blocks
  block/partials/          collection.php (shared grid / alternating / Splide carousel for the CPT hubs) + one {type}-item.php per CPT
  header/header.php, footer/footer.php, menu/   the one header and footer; a child theme overrides these files for a custom build
  front-page-banner.php, interior-banner.php, blog/, archive/, social/
patterns/{slug}.php        block patterns, auto-registered from file headers (category: asen)
scss/
  index.scss               import order matters: vendor → variables/mixins → semantic partials → blocks → custom
  _tokens.scss             aliases of theme.json spacing/font-size presets and custom vars (do not edit values here)
  _colors.scss             aliases of the theme.json palette ($color-primary, $gray-700…)
  editor.scss              block-editor stylesheet entry (tokens, type, buttons, blocks)
  _measurements.scss       breakpoints, gutters, responsive mixins
  _utility.scss            helper classes + shared mixins
  _block-globals.scss      .block-width-* and .spacing-top/bottom-* utility classes for block wrappers
  blocks/_{slug}.scss      one partial per block, imported in blocks/index.scss
  blocks/core/             partials for block.json blocks
  _custom.scss             client-specific overrides (last import)
acf-groups/                ACF JSON sync folder (field groups, post types, taxonomies, options pages)
page.php, single-*.php, archive-*.php, custom-*.php   template hierarchy + named page templates
```

## Naming conventions

| Thing | Upstream | Client fork (e.g. George Ewart) |
|---|---|---|
| Block slug | `asen-intro-block` | `ewart-footer-cta` |
| Block title | `Asen - Intro Block` (new) / `Asen Intro Block` (existing) | `Ewart - Footer CTA` |
| Render template | `templates/block/core-blocks/asen-intro-block.php` | `templates/block/ewart-footer-cta.php` |
| SCSS partial | `scss/blocks/core/_asen-intro-block.scss` | `scss/blocks/_ewart-footer-cta.scss` |
| ACF group title | `Core - Asen Intro Block` / `Gutenberg - Asen CTA` | `Gutenberg - Ewart Footer CTA` |
| CPT field group | `Single - Team` | `Ewart Single - Project` |
| Options group | `Asen Header Options` | `Ewart Options - Projects Hub` |
| Template-part folder | `templates/blog/` | `templates/ewart-projects/` |
| Page template | `custom-contact.php` → `Template Name: Contact` | `custom-project-hub.php` → `Ewart Project Hub` |
| PHP functions | `asen_*` / `site_*` | `asen_*` is fine; avoid generic names |
| SCSS variables | `$spacing-md`, `$gray-700` | `$ewart-red`, `$ewart-charcoal` |

Pick the client prefix once (short, lowercase, one word) and use it everywhere. Block titles use `{Prefix} - {Name}` for new blocks; older blocks without the dash are left alone.

## Block conventions

Every ACF block render template follows this shape:

```php
<?php
/**
 * Block Name: Asen - Example
 */
if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . esc_html( $block['title'] ) . '</h3>';
}
$classes = [ 'asen-example', 'asen-example-' . $block['id'], $block['className'] ?? '' ];
?>
<section class="<?php echo esc_attr( implode( ' ', array_filter( $classes ) ) ); ?>"
    id="<?php echo esc_attr( $block['anchor'] ?? '' ); ?>">
    <div class="inside">
        …
    </div>
</section>
```

- `<section>` wrapper with the slug as the base class; `.inside` is the max-width container. Horizontal gutters come from `$site-overall-gutter` + `@include site-overall-gutter-small`; the width comes from `block-width-{sm|md|lg|xl|xxl|full}` (`_block-globals.scss`, driven by the `__container_width` select) — the template always emits one, with a sensible fallback (`?: 'lg'`).
- **Block partials are structure only.** Layout, gaps, widths, alignment, positioning, token-driven modifiers (text scale, container width). No colors, backgrounds, font weights/styles/families, text transforms, line heights, borders, shadows, hover decoration, or hard-coded pixel sizes by default — type comes from base typography and the tokens, color from native supports or modifier classes, everything else from the child theme. Flat selectors (`.asen-x .item`, never `section.asen-x .inside .items .item a`). If a block needs an opinion to function (an overlay's position, a carousel slide width, an icon at `2em`), that's structure; if it's taste, it's out.
- **Padding, margin, background and text color are native block supports** (`block.json` `supports.spacing` / `supports.color`), rendered by `get_block_wrapper_attributes()` on the `<section>`; the editor offers the theme.json presets. Set sensible defaults in `block.json` `attributes.style.default`. The **"Reusable - Asen Tokens"** clone group covers what core has no preset control for: `__container_width`, `__gap`, `__heading_size`, `__line_height`, `__border_radius`, and `__font_size` (a text *scale* for multi-element blocks). Clone seamlessly; read as `get_field('text_spacing')['__gap']`. Never add pixel inputs or per-instance `<style>` blocks. `asen-intro-block` is the reference implementation.
- **New blocks are registered with `block.json`** in `includes/core-blocks/{slug}/`, not with `acf_register_block()` in `gutenberg.php`. Set `acf.renderTemplate`, `category`, `supports.anchor: true`, `supports.align: false`.
- **Block JS is a `viewScript`:** `includes/core-blocks/{slug}/view.js` (vanilla, no jQuery, scoped with `document.querySelectorAll('.{slug}')`) plus `view.asset.php` for dependencies and version. WordPress enqueues it only when the block renders, front end only. Third-party libraries are *registered* in `theme.php` (`asen_register_block_dependencies()`) and referenced as dependencies / `viewStyle` handles — never enqueued globally. No inline `<script>` in templates; pass data to JS through `data-` attributes. Anything that needs the network at render time (geocoding) happens in PHP with a transient, not in every visitor's browser.
- Block names are `acf/{slug}`; the render callback resolves `templates/block/{slug}.php`. Never rename a block slug that has shipped — content in client databases references it.
- Adding a field to a shipped block: ACF does **not** apply `default_value` to keys missing from a block's saved data, so existing instances read the new field as `null`. Make the absent state the old behavior — name toggles `hide_x` (default off) rather than `show_x` (default on), and `?:` a sensible default for selects.
- If a block's layout is reused by a page template, keep the block template thin and put the markup in a shared template part called with `get_template_part( 'templates/…', null, $args )`. See the Ewart footer CTA pattern.
- Blocks that render a CPT (Team Hub, Services Hub, Testimonials, FAQs, Products Showcase) are gated by the content-type toggles in Site Options → Builders Only.
- **CPT hubs share one layout partial:** `get_template_part( 'templates/block/partials/collection', null, [ items, item_template, layout => grid|alternating|carousel, columns, label, splide, item_args ] )`. Item templates use the shared anatomy `.item-media` / `.item-copy` / `.item-title` / `.item-meta` / `.item-link`, so `scss/blocks/core/_collection.scss` lays out every hub; per-block partials only add the block shell and genuinely different bits (testimonials' masonry). Carousel layout enqueues `asen-carousel` + `splide` itself; Splide options go in `data-splide`. A new CPT hub is a block template + an item template, no new layout CSS.
- **Alignment is native:** `supports.typography.textAlign` gives the toolbar alignment control and a `has-text-align-*` class. Use it instead of an ACF alignment radio. (Intro block, special copy blurb and icon + copy grid still carry their old `align_center` fields — retrofit pending.)
- **Patterns** live in `patterns/{prefix}-{slug}.php` with headers `Title: {Prefix} - {Name}`, `Slug: amplify/{prefix}-{slug}`, `Categories: asen`. Core blocks only. Give the outer Group the retired block's class (e.g. `asen-copy-image`) and keep the pattern's rules in that block's SCSS partial, scoped to `.{slug}.wp-block-group`.
- **Retiring blocks.** v3 has no shipped client sites yet, so a block retired before the first v3 release is **deleted outright** — registration, template, field group JSON, legacy SCSS. Once the first v3 client ships, retiring a shipped block means `'inserter' => false` and keeping everything so existing content renders. Deleted so far: Asen Copy + Image (replacement: `patterns/asen-copy-image.php`, styled in `scss/blocks/_asen-copy-image.scss`).

## Adding a block (checklist)

1. Create the field group in ACF UI: title `Gutenberg - {Prefix} - {Name}`, location Block = `acf/{prefix}-{slug}`, clone "Reusable - Asen Tokens" fields for spacing/width/size. Confirm `acf-groups/group_*.json` was written.
2. `includes/core-blocks/{prefix}-{slug}/block.json` (copy `asen-intro-block` as the starting point).
3. `templates/block/core-blocks/{prefix}-{slug}.php` following the shape above. Escape everything that came from a field.
4. `scss/blocks/core/_{prefix}-{slug}.scss`, imported from `scss/blocks/core/_index.scss`. Use tokens and the responsive mixins; no raw breakpoint pixel values when a mixin exists.
5. If it needs JS: Splide, not Glide. Enqueue only for that block.
6. Load a page with the block, confirm WP-SCSS compiled without errors (errors print for logged-in users), check the editor preview too.

## Adding a CPT

1. ACF → Post Types (and Taxonomies) in the UI. Confirm `acf-groups/post_type_*.json` exists. `show_in_rest` on if it needs the block editor.
2. Field group `{Prefix} Single - {CPT}` located on the post type.
3. `single-{post_type}.php` using the **registered slug** (singular — e.g. `single-project.php`). Only add `archive-{post_type}.php` if `has_archive` is on.
4. If the CPT is optional per site, add a toggle in "Asen Builders Only" and gate the admin menu in `backend-mods.php` like the existing ones.

## SCSS rules

- 2-space indent. One partial per concern; import it from the right index file in the right order.
- Values come from `_tokens.scss` / `_colors.scss` (theme.json aliases) and `_measurements.scss`. Token variables are `var()`s: no SCSS math or color functions on them (`calc()` / `color-mix()` instead), and never pass them to `responsive-heading()` / `responsive-paragraph()` — the presets are already fluid, so `font-size: $heading-h3;` is the whole job. The responsive mixins stay for one-off pixel values; `site-overall-gutter-small` is still the horizontal gutter.
- Client-specific: brand colors go in `_colors.scss` under a prefixed name; page/section overrides go in `_custom.scss` or new `_{prefix}-*.scss` partials. **Do not bake client values into shared partials or mixin defaults** (a mixin whose default color is `$ewart-charcoal` is the anti-pattern — pass it as an argument).
- Button variants are **classes in `_buttons.scss`** (`.button.red`, `.button-knockout`, `.button-small`, `.button-wide`), applied via the block's class field or "Additional CSS class". Don't add option fields or ACF color pickers for button variants. Variant colors reference palette slugs, not raw hex, once Phase 1 lands.
- `!important` is a smell; it usually means a specificity fight with Kadence or `head-mods.php` inline CSS. Fix the selector or move the rule.
- `$site-overall-max-width` is `var(--wp--style--global--wide-size)` — theme.json `settings.layout.wideSize`.

## PHP rules

- Match the indentation of the file you're in (upstream is mostly 4 spaces). Never submit reformat-only diffs.
- Escape output from fields: `esc_html`, `esc_url`, `esc_attr`. Clients type into these fields.
- Prefer hooks and `get_template_part( …, $args )` over editing `header.php` / `footer.php` / `page.php`.
- Client-specific PHP (query mods, search tweaks, taxonomy UI) goes in a dedicated `includes/{prefix}-*.php` required from `functions.php`, not inline in `functions.php`.
- No runtime filesystem writes, no `error_log()` debugging left in, no hard-coded CDN tags in `header.php` — enqueue per block.
- `asen_debug_print()` in `includes/development.php` is the sanctioned dump helper; remove calls before commit.

## Site Options (ACF option pages)

`Site Options` (slug `custom-options`), `Header Options`, `Off-Canvas Options`, `Footer Options`, `Blog → Archive Options`. There is **one header layout and one footer layout** (the v2 layout selectors were removed in v3); the footer mailing-list column is a toggle in Footer Options. A design that needs something else overrides `templates/header/header.php` / `templates/footer/footer.php` in the child theme. The **"Asen Builders Only"** group is only shown to users with an `@asenmarketing.com` email (custom `asen_domain` location rule in `acf-customizations.php`); same rule hides the ACF admin and the Kadence menu from clients. Put anything a client shouldn't touch there.

**Builders Only color fields are overrides, not the source.** Links & Buttons, Page Banners, header/off-canvas and floating CTA colors stay as option fields; defaults come from `theme.json` (Phase 1) and SCSS, and an option value only wins when set. Output them as `:root` custom props with a token fallback in the SCSS — never print a rule for an empty field.

**Removed in v3:** the `site_colors` repeater and `site_max_width` fields. Colors are the theme.json palette (`_colors.scss` aliases it); max width is theme.json `layout.wideSize`. The `includes/scss-mods.php` + `_global-variables.scss` approach seen in older client forks (options → rewrite an SCSS file on `wp_head`) is dead and must not be copied forward.

## Working in a client fork

Decided Oct 2026: client sites move to a **child theme** once the Phase 5 scaffold exists. Until then, forks continue under these rules:

- Change the client prefix once; add to, don't rewrite, shared files. Shared partials (`_header.scss`, `_typography.scss`, `front-page-banner.php`, `off-canvas.php`…) do get client edits in practice, but every edit there is one more thing that can't be pulled from upstream. Prefer an override in `_custom.scss` or a new partial.
- Keep the upstream ACF group JSON files; add client groups alongside with the prefixed titles.
- Remove upstream blocks a client will never use by unregistering, not deleting, so an upstream merge stays clean.

## Dev environment

- Sites run in **Local** (`*.local`). Theme path: `app/public/wp-content/themes/asen-amplify-v3/`.
- WP-SCSS recompiles on each page load while `always_recompile` is on; compile errors show for logged-in users. Check `css/index.css` mtime if styles look stale.
- Some locals expose a **Novamira MCP** server (REST-first WP control). It can run PHP/WP-CLI, read/write theme files, and inspect options — use it for "what is this option set to" questions instead of guessing. Native Gutenberg content writes through it require the Block Editor Queue admin page to be open in a browser.
- Query Monitor is active locally; keep an eye on it after adding queries.
- Keep a page at `/asen-v3-test/` on the dev site with one instance of every converted block plus core paragraph/button and the patterns; it's the visual regression check (not in the repo — content lives in that site's DB).
- WP caches the theme's `patterns/` file list (and `theme.json`). A new pattern file won't register until the cache clears — set `define( 'WP_DEVELOPMENT_MODE', 'theme' );` in the local `wp-config.php`, or run `wp_get_theme()->delete_pattern_cache()` once. Production clears it on theme update.

## Known issues (fix opportunistically, track in MODERNIZATION.md)

- `templates/block/` still holds four never-registered templates (`asen-blockquote`, `asen-blockquote-random`, `asen-blockquote-rotator` — which still references Glide — and `asen-fancy-list`) plus their SCSS/field groups. Dead code; delete in batch 4.
- `head-mods.php` still prints option values as a large inline `<style>`; Phase 1 leftover (→ `:root` custom props with token fallbacks).
- The YouTube API is enqueued only when `has_block()` finds the Video Popup block in post content (a block rendered from a page template won't trigger it); goes away when that block converts to a `viewScript`.
- Template output is largely unescaped.

## Roadmap status

See [MODERNIZATION.md](MODERNIZATION.md). Update this line as phases land.

- Phase 0 (hygiene + deprecated field removal): done
- Phase 1 (`theme.json` tokens, editor styles, head-mods → custom props): done except `head-mods.php` → custom props
- Phase 2 (ACF blocks → `block.json` + native supports, structure-only SCSS): 13 converted, 12 legacy left (none print `<style>` any more). Testimonial Carousel deleted (folded into Testimonials). Glide removed.
- Phase 3 (client-safe editing: role-gated inserter, patterns, section styles, bindings): not started
- Phase 4 (block library rationalization): in progress — Copy + Image retired behind a pattern; Featured Blogs reworked (3 recent or hand-picked posts, optional CTA tile)
- Phase 5 (distribution model): decided — parent/child with a self-updating parent via GitHub releases; not built yet
