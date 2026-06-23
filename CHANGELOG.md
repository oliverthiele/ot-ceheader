# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [2.2.0] — 2026-06-23

### Added

- ContentBlock support: `header_rte`, `preheader`, and `icon_identifier` fields are now visible for ContentBlock CTypes
- Icon selector integration: `icon_identifier` field uses the visual `otIconSelector` renderType when `ot-iconselector` is installed
- `ot-iconselector` added as suggested composer dependency

---

## [2.1.1] — 2026-05-22

### Fixed

- Replace invalid `TCEFORM.default` with `TCAdefaults.tt_content.header_layout = 2` so that h2 is correctly applied as the default heading level for new content elements

---

## [2.1.0] — 2026-04-28

### Added

- Checkbox `header_rte_enable` to opt in to the formatted heading mode; `header_rte`, `preheader` and `icon_identifier` are hidden by default via `displayCond` and appear only when the toggle is active
- `onChange: reload` on `header_rte_enable` for immediate form refresh

### Changed

- Fix heading alignment: added `justify-content-center` / `justify-content-end` alongside Bootstrap text-alignment classes to correctly position flex children
- Remove "Standard" (0) from `header_layout` select and set default to `h2` via page TSconfig
- Default mode (checkbox off) renders `data.header` directly without span wrapper markup

---

## [2.0.1] — 2026-04-26

### Changed

- Raise `ot-icons` constraint to `^2.0.0`

---

## [2.0.0] — 2026-04-25

### Added

- TYPO3 v14.3 support (`^13.4||^14.3`)
- Extension icon (`Resources/Public/Icons/Extension.svg`)

### Changed

- Raise PHP minimum constraint to `>=8.3`

---

## [1.0.1] — 2026-02-01

### Fixed

- Remove extension from CType groups
- Add check for empty headerText

---

## [1.0.0] — 2025-11-01

### Added

- Initial release
- RTE-enabled header field (`header_rte`)
- Preheader/eyebrow field
- Icon support via `ot-icons`
- Responsive line breaks
- Bootstrap 5 compatible output

[Unreleased]: https://github.com/oliverthiele/ot-ceheader/compare/v2.2.0...HEAD
[2.2.0]: https://github.com/oliverthiele/ot-ceheader/compare/v2.1.1...v2.2.0
[2.1.1]: https://github.com/oliverthiele/ot-ceheader/compare/v2.1.0...v2.1.1
[2.1.0]: https://github.com/oliverthiele/ot-ceheader/compare/v2.0.1...v2.1.0
[2.0.1]: https://github.com/oliverthiele/ot-ceheader/compare/v2.0.0...v2.0.1
[2.0.0]: https://github.com/oliverthiele/ot-ceheader/compare/v1.0.1...v2.0.0
[1.0.1]: https://github.com/oliverthiele/ot-ceheader/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/oliverthiele/ot-ceheader/releases/tag/v1.0.0