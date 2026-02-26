<?php
include_once "../ADMIN/con_dbb.php";
use Dompdf\Dompdf;
require_once "../dompdf/autoload.inc.php";
$dompdf = new Dompdf();
$dompdf->loadHtml('<h1>Bonjour, ceci est un PDF généré par Dompdf !</h1>');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream();
?>