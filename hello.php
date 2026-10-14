<?php
/**
 * hello.php - the SMALLEST possible DOMPDF program.
 *
 * Open in browser: http://localhost/dompdf-starter/hello.php
 * (or http://dompdf-starter.test/hello.php if using a Laragon auto virtual host)
 */

// 1. Load Composer's autoloader. This makes the Dompdf classes available.
require __DIR__ . '/vendor/autoload.php';

// 2. Import the class so we can write "Dompdf" instead of "\Dompdf\Dompdf".
use Dompdf\Dompdf;

// 3. Create a Dompdf object (the "PDF engine").
$dompdf = new Dompdf();

// 4. Give it some HTML. DOMPDF converts HTML + CSS into a PDF.
$dompdf->loadHtml('<h1>Hello, DOMPDF!</h1><p>My first PDF generated with PHP.</p>');

// 5. Choose paper size and orientation.
$dompdf->setPaper('A4', 'portrait');

// 6. Render: this is where the HTML is actually converted into PDF.
$dompdf->render();

// 7. Send the PDF to the browser.
//    'Attachment' => false  -> show in the browser tab
//    'Attachment' => true   -> force a download
$dompdf->stream('hello.pdf', ['Attachment' => false]);
