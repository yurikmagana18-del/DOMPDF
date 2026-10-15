<?php
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'DejaVu Sans');
$options->set('isRemoteEnabled', true);
$options->setChroot(__DIR__);

$dompdf = new Dompdf($options);

$title    = 'Student Report';
$date     = date('F j, Y');
$students = [
    ['id' => 1, 'name' => 'Maria Santos',  'grade' => 92],
    ['id' => 2, 'name' => 'John Reyes',    'grade' => 85],
    ['id' => 3, 'name' => 'Ana Dela Cruz', 'grade' => 78],
];

$rows = '';
foreach ($students as $s) {
    $rows .= '<tr>'
           . '<td>' . (int) $s['id'] . '</td>'
           . '<td>' . htmlspecialchars($s['name']) . '</td>'
           . '<td class="right">' . (int) $s['grade'] . '</td>'
           . '</tr>';
}

$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 30mm 20mm; }

        body   { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #222; }
        h1     { color: #1a5276; border-bottom: 2px solid #1a5276; padding-bottom: 6px; }
        .meta  { color: #666; margin-bottom: 20px; }

        table  { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th     { background: #1a5276; color: #fff; }
        .right { text-align: right; }

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

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$mode = $_GET['mode'] ?? 'view';

switch ($mode) {

    case 'download':
        $dompdf->stream('student-report.pdf', ['Attachment' => true]);
        break;

    case 'save':
        $folder = __DIR__ . '/output';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        file_put_contents($folder . '/student-report.pdf', $dompdf->output());
        echo 'PDF saved to: ' . htmlspecialchars($folder . '/student-report.pdf');
        break;

    case 'view':
    default:
        $dompdf->stream('student-report.pdf', ['Attachment' => false]);
        break;
}
?>
