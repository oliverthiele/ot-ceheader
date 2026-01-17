# TYPO3 Extension: CE Header (ot_ceheader)

Enhanced header content element for TYPO3 with RTE support, preheader (eyebrow), icons, and responsive line breaks.

## Features

- **RTE-enabled headers**: Format parts of your header with bold, italic, or color highlights
- **Preheader/Eyebrow**: Optional badge-styled text above the main header
- **Icon support**: Add icons to headers via [ot-icons](https://github.com/oliverthiele/ot-icons)
- **Responsive line breaks**: Line breaks on desktop, spaces on mobile
- **Color highlighting**: Apply primary, secondary, or tertiary colors to text portions
- **Accessible**: Semantic HTML, proper heading hierarchy (h1-h6), ARIA attributes
- **Bootstrap 5 compatible**: Uses Bootstrap utility classes

## Requirements

- TYPO3 13.4 LTS
- PHP 8.2+
- [oliverthiele/ot-icons](https://packagist.org/packages/oliverthiele/ot-icons) ^1.0

## Installation

### Composer (recommended)

```bash
composer require oliverthiele/ot-ceheader
```

### Activation

1. Activate the extension in the TYPO3 Extension Manager
2. Include the Site Set "CE Header" in your site configuration

## Usage

### New fields in tt_content

The extension adds three fields to the "headers" palette:

| Field | Description |
|-------|-------------|
| `preheader` | Eyebrow text displayed above the header |
| `header_rte` | Rich-text header (alternative to standard header) |
| `icon_identifier` | Icon identifier for ot-icons |

### RTE formatting options

The header RTE provides a minimal toolbar:

- **Bold** / **Italic**
- **Style dropdown**: Primary, Secondary, Tertiary color
- **Soft hyphen**: For controlled word breaks
- **Source editing**: For advanced users

### Responsive line breaks

Use `<br>` in the RTE for line breaks that:
- Display as **line breaks** on desktop (≥768px)
- Display as **spaces** on mobile (<768px)

This allows multi-line headers on desktop while maintaining readability on mobile.

### Example output

```html
<header class="text-center">
    <div class="ot-ceheader-preheader">
        <i class="fa-solid fa-star"></i>
        New Feature
    </div>
    <h2 id="header-u123" class="ot-ceheader-h">
        <span class="ot-ceheader-text">
            <a href="/link">
                <span class="header-line">Welcome to</span>
                <span class="header-line">Our <span class="text-primary">Website</span></span>
            </a>
            <span class="ot-ceheader-subheader" role="doc-subtitle">
                Your tagline here
            </span>
        </span>
    </h2>
</header>
```

## Configuration

### TypoScript

The extension registers partial paths automatically. To customize, override:

```typoscript
lib.contentElement {
    partialRootPaths {
        20 = EXT:your_sitepackage/Resources/Private/Partials/
    }
}
```

### RTE preset

The extension registers an RTE preset `otCeheader`. To customize, create your own YAML configuration and reference it in `page.tsconfig`:

```typoscript
RTE.config.tt_content.header_rte.preset = yourCustomPreset
```

## Styling

### Required CSS

The extension includes minimal required CSS via `f:asset.css`. For custom styling, target these classes:

```css
.ot-ceheader-h { }           /* Header element (flex container) */
.ot-ceheader-text { }        /* Text wrapper */
.ot-ceheader-preheader { }   /* Eyebrow badge */
.ot-ceheader-subheader { }   /* Subheader text */
.ot-ceheader-br { }          /* Responsive line break */
.header-line { }             /* Individual header lines */
```

### Color classes

Define these CSS custom properties or classes in your theme:

```css
.text-primary { color: var(--bs-primary); }
.text-secondary { color: var(--bs-secondary); }
.text-tertiary { color: var(--your-tertiary-color); }
```

## Accessibility

- Semantic heading elements (h1-h6) based on backend configuration
- `role="doc-subtitle"` for subheaders
- `aria-hidden="true"` for decorative icons
- Unique IDs for anchor linking (`header-u{uid}`)
- Responsive line breaks hidden from screen readers

## Sponsor

Development of this extension was sponsored by [WWE Media](https://www.wwe-media.de/).

## License

GPL-2.0-or-later

## Author

Oliver Thiele
[https://www.oliver-thiele.de](https://www.oliver-thiele.de)