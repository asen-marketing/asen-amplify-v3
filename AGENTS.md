# Asen Amplify Lite — Agent Guide

Asen Marketing's upstream WordPress theme for small client sites. This repo is the **template**; each client site is a fork of it. Clients get editor access after launch for minor text/image changes, so anything that reaches the editor must be safe for a non-developer to touch.

Keep this file current. When you add a convention, fix a known issue, or ship a roadmap phase, update the relevant section here. The detailed modernization plan lives in [MODERNIZATION.md](MODERNIZATION.md).

## Stack

- **Classic PHP theme.** No `theme.json` yet (see roadmap). No block templates, no Site Editor.
- **ACF Pro + ACF Extended** define every field group, CPT, taxonomy, and options page. All of it is synced to `acf-groups/*.json` — commit the JSON, never hand-write `register_post_type` / `register_taxonomy` / `acf_add_local_field_group`. Edit groups in the ACF UI, or edit the JSON and use Custom Fields → Field Groups → Sync. **Never save or import a group from a script** (`acf_import_field_group()`, `acf_update_field_group()`): ACF Extended's `ACFE_AutoSync_Json` wraps ACF's JSON writer, and a scripted save created a duplicate DB group, wrote nothing, and deleted the existing JSON file. Local JSON takes priority at runtime, so a group that exists only as JSON still renders; the UI just shows "Sync available".
- **Gutenberg + ACF blocks** for page content; **core Group / Columns / Grid / Media & Text** are the layout containers (decided Oct 2026). **Kadence Blocks** is installed on older builds only — don't add Kadence dependencies or style against `.kt-*` selectors in upstream.
- **Gravity Forms**, **Yoast**, **Relevanssi**, **SVG Support**, **WP-PageNavi**, **Broken Link Checker** are assumed present.
- **WP-SCSS** compiles `scss/index.scss` → `css/index.css` on page load (compressed, inline sourcemap). `css/` is gitignored. Never edit or commit compiled CSS, never run a compiler yourself. On production, `always_recompile` must be off.
- **JS:** `js/main.js` (jQuery, off-canvas menu, modals, misc), `js/vendor/` has jquery-modal, Glide (legacy carousels), Splide (preferred carousel, with auto-scroll extension). No bundler; `node_modules/` is vestigial.
- **Fonts/icons:** Adobe Fonts + Font Awesome are injected via the "Font Snippets" field in Site Options → Builders Only.

## Directory map

```
functions.php              requires includes/*.php in order; tiny WP fixes only
includes/
  theme.php                enqueues, theme supports, image sizes, asen_enqueue_splide()/glide(), block.json loader
  gutenberg.php            legacy acf_register_block() calls + block category + render callback
  patterns.php             registers the "Asen" pattern category
  core-blocks/{slug}/block.json   new-style block registration (auto-loaded by asen_register_acf_blocks)
  acf-customizations.php   ACF JSON paths, options pages, "asen_domain" location rule, GF form dropdown populator
  head-mods.php            <head> output: font snippets, script snippets, inline CSS generated from option fields
  backend-mods.php         admin menu curation, editor hiding for custom templates, admin CSS
  helpers.php              asen_acf_image_url(), asen_clean_phone_number(), primary-category helpers
  menus.php, footer-mods.php, woocommerce.php, yoast.php, body-class-mods.php, cmp-gravity-patch.php
  css/backend-styles.css   admin-only styles
templates/
  block/{slug}.php         ACF block render templates (legacy location)
  block/core-blocks/{slug}.php    render templates for block.json blocks
  header/, footer/, menu/  layout variants chosen in Site Options
  front-page-banner.php, interior-banner.php, blog/, archive/, social/
patterns/{slug}.php        block patterns, auto-registered from file headers (category: asen)
scss/
  index.scss               import order matters: vendor → variables/mixins → semantic partials → blocks → custom
  _tokens.scss             spacing / font-size / heading / line-height / container-width / gap / radius scale
  _colors.scss             grays + placeholders (brand colors are added per client here)
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

- `<section>` wrapper with the slug as the base class; `.inside` is the max-width container. Horizontal gutters come from `$site-overall-gutter` + `@include site-overall-gutter-small`.
- Use `block-width-{sm|md|lg|xl|xxl|full}` and `spacing-top-{none|xs|sm|md|lg|xl}` / `spacing-bottom-*` classes from `_block-globals.scss` instead of hard-coding widths or padding. (Known drift: `_block-globals.scss` currently uses `s/m/l` while the token field uses `sm/md/lg` — see Known issues.)
- Shared styling controls come from the **"Reusable - Asen Tokens"** clone group (`__spacing`, `__font_size`, `__heading_size`, `__line_height`, `__gap`, `__container_width`, `__border_radius`). Clone it seamlessly into block field groups; read with `get_field('top_padding')['__spacing']`. Do **not** add new pixel-input padding/margin/font-size fields or emit per-instance `<style>` blocks — that is the legacy pattern being removed.
- **New blocks are registered with `block.json`** in `includes/core-blocks/{slug}/`, not with `acf_register_block()` in `gutenberg.php`. Set `acf.renderTemplate`, `category`, `supports.anchor: true`, `supports.align: false`. Per-block assets go through `enqueue_assets` (legacy) or `block.json` `viewScript`/`style`.
- Block names are `acf/{slug}`; the render callback resolves `templates/block/{slug}.php`. Never rename a block slug that has shipped — content in client databases references it.
- Adding a field to a shipped block: ACF does **not** apply `default_value` to keys missing from a block's saved data, so existing instances read the new field as `null`. Make the absent state the old behavior — name toggles `hide_x` (default off) rather than `show_x` (default on), and `?:` a sensible default for selects.
- If a block's layout is reused by a page template, keep the block template thin and put the markup in a shared template part called with `get_template_part( 'templates/…', null, $args )`. See the Ewart footer CTA pattern.
- Blocks that render a CPT (Team Hub, Services Hub, Testimonials, FAQs, Products Showcase) are gated by the content-type toggles in Site Options → Builders Only.
- **Patterns** live in `patterns/{prefix}-{slug}.php` with headers `Title: {Prefix} - {Name}`, `Slug: amplifylite/{prefix}-{slug}`, `Categories: asen`. Core blocks only. Give the outer Group the retired block's class (e.g. `asen-copy-image`) and keep the pattern's rules in that block's SCSS partial, scoped to `.{slug}.wp-block-group`.
- **Retired blocks** stay registered with `'inserter' => false` so existing content renders. Never delete a retired block's template, fields, or SCSS. Retired so far: Asen Copy + Image (→ `patterns/asen-copy-image.php`).

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
- Values come from `_tokens.scss` / `_colors.scss` / `_measurements.scss`. Use `@include site-vertical-padding-dynamic()`, `responsive-heading()`, `responsive-paragraph()`, `responsive-border-radius()`, `site-overall-gutter-small` rather than writing breakpoint ladders by hand.
- Client-specific: brand colors go in `_colors.scss` under a prefixed name; page/section overrides go in `_custom.scss` or new `_{prefix}-*.scss` partials. **Do not bake client values into shared partials or mixin defaults** (a mixin whose default color is `$ewart-charcoal` is the anti-pattern — pass it as an argument).
- Button variants are **classes in `_buttons.scss`** (`.button.red`, `.button-knockout`, `.button-small`, `.button-wide`), applied via the block's class field or "Additional CSS class". Don't add option fields or ACF color pickers for button variants. Variant colors reference palette slugs, not raw hex, once Phase 1 lands.
- `!important` is a smell; it usually means a specificity fight with Kadence or `head-mods.php` inline CSS. Fix the selector or move the rule.
- `$site-overall-max-width` (in `_site-option-styles.scss`) is the site-wide content max width. The `site_max_width` option field that used to feed it is **deprecated**.

## PHP rules

- Match the indentation of the file you're in (upstream is mostly 4 spaces). Never submit reformat-only diffs.
- Escape output from fields: `esc_html`, `esc_url`, `esc_attr`. Clients type into these fields.
- Prefer hooks and `get_template_part( …, $args )` over editing `header.php` / `footer.php` / `page.php`.
- Client-specific PHP (query mods, search tweaks, taxonomy UI) goes in a dedicated `includes/{prefix}-*.php` required from `functions.php`, not inline in `functions.php`.
- No runtime filesystem writes, no `error_log()` debugging left in, no hard-coded CDN tags in `header.php` — enqueue per block.
- `asen_debug_print()` in `includes/development.php` is the sanctioned dump helper; remove calls before commit.

## Site Options (ACF option pages)

`Site Options` (slug `custom-options`), `Header Options`, `Off-Canvas Options`, `Footer Options`, `Blog → Archive Options`. The **"Asen Builders Only"** group is only shown to users with an `@asenmarketing.com` email (custom `asen_domain` location rule in `acf-customizations.php`); same rule hides the ACF admin and the Kadence menu from clients. Put anything a client shouldn't touch there.

**Builders Only color fields are overrides, not the source.** Links & Buttons, Page Banners, header/off-canvas and floating CTA colors stay as option fields; defaults come from `theme.json` (Phase 1) and SCSS, and an option value only wins when set. Output them as `:root` custom props with a token fallback in the SCSS — never print a rule for an empty field.

**Deprecated, do not use:** `site_colors` repeater and `site_max_width`. Colors live in code (`_colors.scss` now, `theme.json` after Phase 1 of the roadmap — decided: theme.json is the source of truth, SCSS variables alias it). The `includes/scss-mods.php` + `_global-variables.scss` approach seen in older client forks (options → rewrite an SCSS file on `wp_head`) is dead and must not be copied forward.

## Working in a client fork

Decided Oct 2026: client sites move to a **child theme** once the Phase 5 scaffold exists. Until then, forks continue under these rules:

- Change the client prefix once; add to, don't rewrite, shared files. Shared partials (`_header.scss`, `_typography.scss`, `front-page-banner.php`, `off-canvas.php`…) do get client edits in practice, but every edit there is one more thing that can't be pulled from upstream. Prefer an override in `_custom.scss` or a new partial.
- Keep the upstream ACF group JSON files; add client groups alongside with the prefixed titles.
- Remove upstream blocks a client will never use by unregistering, not deleting, so an upstream merge stays clean.

## Dev environment

- Sites run in **Local** (`*.local`). Theme path: `app/public/wp-content/themes/amplifylite/`.
- WP-SCSS recompiles on each page load while `always_recompile` is on; compile errors show for logged-in users. Check `css/index.css` mtime if styles look stale.
- Some locals expose a **Novamira MCP** server (REST-first WP control). It can run PHP/WP-CLI, read/write theme files, and inspect options — use it for "what is this option set to" questions instead of guessing. Native Gutenberg content writes through it require the Block Editor Queue admin page to be open in a browser.
- Query Monitor is active locally; keep an eye on it after adding queries.
- WP caches the theme's `patterns/` file list (and `theme.json`). A new pattern file won't register until the cache clears — set `define( 'WP_DEVELOPMENT_MODE', 'theme' );` in the local `wp-config.php`, or run `wp_get_theme()->delete_pattern_cache()` once. Production clears it on theme update.

## Known issues (fix opportunistically, track in MODERNIZATION.md)

- `block_categories` filter in `gutenberg.php` is deprecated → `block_categories_all`.
- `asen-intro-block` block.json uses category `asen-core-blocks`, which is never registered; only `asen-blocks` is.
- `_block-globals.scss` spacing classes use `s/m/l`; the token select and the intro block use `sm/md/lg`, so the intro block re-declares the classes locally.
- ACF registers `product` and `service` (singular, `has_archive: false`), but the theme ships `single-products.php`, `single-services.php`, `archive-products.php`, `archive-services.php`, `archive-team.php` — none of these match the template hierarchy. `head-mods.php` also tests `get_post_type() == 'products'`.
- `header.php` hard-codes Leaflet CSS/JS from unpkg on every page; `theme.php` enqueues the YouTube iframe API globally. Both belong on their blocks.
- 14 of 30 block templates emit per-instance `<style>` tags with pixel values from "Reusable - Margin & Padding" / "Reusable - Spacing" fields. Legacy; being replaced by native block supports.
- Both Glide and Splide ship. New work uses Splide.
- `wp68_admin_editor_fix_styles()` and `acfe_modal_width()` echo `<style>` on every admin page; they belong in `includes/css/backend-styles.css`.
- `front-page-banner.php:224` still reads the deprecated `site_max_width` option.
- `css/index_safe_save_*.css` are junk. `.gitignore` is a WordPress-root template, not a theme one. `README.md` is empty.
- Template output is largely unescaped.

## Roadmap status

See [MODERNIZATION.md](MODERNIZATION.md). Update this line as phases land.

- Phase 0 (hygiene + deprecated field removal): not started
- Phase 1 (`theme.json` tokens, editor styles, head-mods → custom props): not started
- Phase 2 (ACF blocks → `block.json` + native supports): 1/30 blocks (`asen-intro-block`, partial)
- Phase 3 (client-safe editing: role-gated inserter, patterns, section styles, bindings): not started
- Phase 4 (block library rationalization): in progress — Copy + Image retired behind a pattern; Featured Blogs reworked (3 recent or hand-picked posts, optional CTA tile)
- Phase 5 (distribution model): decided — parent/child with a self-updating parent via GitHub releases; not built yet
