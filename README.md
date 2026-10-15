# DOMPDF Starter

## Setup
# DOMPDF Starter

## Setup
1. Copy this folder into your web root. 
1. Copy address from the file explorer
1. Use the address as such address = where the dompdf folder is
Open the terminal and type: cd address
2. run `composer install`. Right after
3. Enable PHP extensions `mbstring`, `dom`, `gd`.
4. Open in your browser:
   - `hello.php` - minimal example
   - `starter.php` - full commented example
   - `starter.php?mode=download` - force download
   - `starter.php?mode=save` - save into `/output`

## Requirements
- PHP 7.1+ (8.x recommended)
- Extensions: `dom`, `mbstring` (required); `gd` (images); `opcache` (speed)
- Composer
- Libraries installed automatically by Composer: `dompdf/dompdf`, `php-font-lib`, `php-svg-lib`

## Troubleshooting
| Problem | Fix |
|---|---|
| `vendor/autoload.php` not found | Run `composer install` |
| Blank page / "headers already sent" | Make sure nothing is echoed before `stream()` and there is no space before `<?php` |
| Weird characters (?, boxes) | Use `DejaVu Sans` and `<meta charset="UTF-8">` |
| Image missing | Enable `gd`; use `isRemoteEnabled` for URLs; check `chroot` for local files |
| Layout broken | DOMPDF has no flexbox/grid - use tables or floats |

2. Open a terminal in the folder and run `composer install`.
3. Enable PHP extensions `mbstring`, `dom`, `gd`.
4. Open in your browser:
   - `hello.php` - minimal example
   - `starter.php` - full commented example
   - `starter.php?mode=download` - force download
   - `starter.php?mode=save` - save into `/output`

## Requirements
- PHP 7.1+ (8.x recommended)
- Extensions: `dom`, `mbstring` (required); `gd` (images); `opcache` (speed)
- Composer
- Libraries installed automatically by Composer: `dompdf/dompdf`, `php-font-lib`, `php-svg-lib`

## Troubleshooting
| Problem | Fix |
|---|---|
| `vendor/autoload.php` not found | Run `composer install` |
| Blank page / "headers already sent" | Make sure nothing is echoed before `stream()` and there is no space before `<?php` |
| Weird characters (?, boxes) | Use `DejaVu Sans` and `<meta charset="UTF-8">` |
| Image missing | Enable `gd`; use `isRemoteEnabled` for URLs; check `chroot` for local files |
| Layout broken | DOMPDF has no flexbox/grid - use tables or floats |
