<?php
require __DIR__ . '/vendor/autoload.php';
 
use Dompdf\Dompdf;
 
$dompdf = new Dompdf();
 
$dompdf->loadHtml('<h1>Hello, DOMPDF!</h1><p>My first PDF generated with PHP.</p>');
 
$dompdf->setPaper('A4', 'portrait');
 
$dompdf->render();
 
$dompdf->stream('hello.pdf', ['Attachment' => false]);
 
?>
