<?php
/**
 * starter.php - Elaborated DOMPDF starter
 * ============================================================================
 * Shows how to:
 *   1. Install / autoload DOMPDF
 *   2. Configure options (fonts, remote images, security)
 *   3. Build HTML + CSS for the PDF (with PHP variables and loops)
 *   4. Render the PDF
 *   5. Output it in three ways: view in browser, force download, save to disk
 *
 * SETUP (one time):
 *   1. Put this folder inside your web root
 *        Laragon : C:\laragon\www\dompdf-starter
 *   2. Open a terminal in this folder and run:
 *        composer install
 *      (or, in a brand new folder:  composer require dompdf/dompdf)
 *   3. Make sure these PHP extensions are enabled in php.ini:
 *        extension=mbstring
 *        extension=dom
 *        extension=gd        (needed for images)
 *      Laragon: Menu > PHP > Extensions
 *
 * USAGE (choose the output mode with a URL parameter):
 *   starter.php               -> view PDF in the browser
 *   starter.php?mode=download -> force the browser to download it
 *   starter.php?mode=save     -> save to the /output folder
 */

// ----------------------------------------------------------------------------
// STEP 1: Load Composer's autoloader
// ----------------------------------------------------------------------------
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// ----------------------------------------------------------------------------
// STEP 2: Configure DOMPDF using the Options class
// ----------------------------------------------------------------------------
$options = new Options();

// Default font. "DejaVu Sans" ships with DOMPDF and supports many Unicode
// characters (accents, symbols). The built-in "Helvetica" does NOT.
$options->set('defaultFont', 'DejaVu Sans');

// Allow DOMPDF to load images/CSS from http(s) URLs.
// Default is false for security. Only enable it if you trust your HTML.
$options->set('isRemoteEnabled', true);

// "chroot" limits which folders DOMPDF may read local files from.
// This protects against someone injecting <img src="C:/secret/file.png">.
$options->setChroot(__DIR__);

// Create the Dompdf object using our options.
$dompdf = new Dompdf($options);

// ----------------------------------------------------------------------------
// STEP 3: Prepare the data (in a real app this comes from a database)
// ----------------------------------------------------------------------------
$title    = 'Student Report';
$date     = date('F j, Y');
$students = [
    ['id' => 1, 'name' => 'Maria Santos',  'grade' => 92],
    ['id' => 2, 'name' => 'John Reyes',    'grade' => 85],
    ['id' => 3, 'name' => 'Ana Dela Cruz', 'grade' => 78],
];

// Build the table rows with a loop.
// htmlspecialchars() prevents HTML injection from user/database data.
$rows = '';
foreach ($students as $s) {
    $rows .= '<tr>'
           . '<td>' . (int) $s['id'] . '</td>'
           . '<td>' . htmlspecialchars($s['name']) . '</td>'
           . '<td class="right">' . (int) $s['grade'] . '</td>'
           . '</tr>';
}

// ----------------------------------------------------------------------------
// STEP 4: Write the HTML + CSS
//   - DOMPDF supports CSS 2.1 and some CSS3.
//   - It does NOT fully support flexbox or CSS grid. Use tables or floats.
//   - Put CSS in a <style> block inside the HTML (simplest and most reliable).
// ----------------------------------------------------------------------------
$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        /* @page controls the paper margins */
        @page { margin: 30mm 20mm; }

        body   { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #222; }
        h1     { color: #1a5276; border-bottom: 2px solid #1a5276; padding-bottom: 6px; }
        .meta  { color: #666; margin-bottom: 20px; }

        table  { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th     { background: #1a5276; color: #fff; }
        .right { text-align: right; }

        /* Force a page break before an element: page-break-before: always; */
        .footer { margin-top: 30px; font-size: 10px; color: #888; text-align: center; }
    </style>
</head>
<body>
    <h1>{$title}</h1>
    <div class="meta">Generated on {$date}</div>

    <table>
        <thead>
            <tr><th>ID</th><th>Name</th><th class="right">Grade</th></tr>
        </thead>
        <tbody>
            {$rows}
        </tbody>
    </table>

    <div class="footer">Created with DOMPDF</div>
</body>
</html>
HTML;

// ----------------------------------------------------------------------------
// STEP 5: Load the HTML, set paper, and render
// ----------------------------------------------------------------------------
$dompdf->loadHtml($html);

// Paper sizes: 'A4', 'Letter', 'Legal', ...   Orientation: 'portrait' | 'landscape'
$dompdf->setPaper('A4', 'portrait');

// Convert HTML to PDF. Nothing is sent to the browser yet.
$dompdf->render();

// ----------------------------------------------------------------------------
// STEP 6: Output the PDF (three options)
// ----------------------------------------------------------------------------
$mode = $_GET['mode'] ?? 'view';

switch ($mode) {

    case 'download':
        // Browser downloads the file.
        $dompdf->stream('student-report.pdf', ['Attachment' => true]);
        break;

    case 'save':
        // Save to disk (e.g. to email it later or keep a record).
        $folder = __DIR__ . '/output';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        // output() returns the raw PDF bytes as a string.
        file_put_contents($folder . '/student-report.pdf', $dompdf->output());
        echo 'PDF saved to: ' . htmlspecialchars($folder . '/student-report.pdf');
        break;

    case 'view':
    default:
        // Display inside the browser tab.
        $dompdf->stream('student-report.pdf', ['Attachment' => false]);
        break;
}
