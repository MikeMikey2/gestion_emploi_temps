<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Pas de session_start() ici, pas d'include qui affiche quoi que ce soit
require_once "../ADMIN/con_dbb.php"; // Assurez-vous que ce fichier existe et est correct

use Dompdf\Dompdf;
use Dompdf\Options;
ob_start(); // Démarre la temporisation de sortie pour éviter les problèmes d'en-têtes
require_once "pdf-content.php"; // Contenu HTML pour le PDF
$html=ob_get_contents(); // Récupère le contenu HTML et nettoie la temporisation
ob_end_clean(); // Nettoie la temporisation de sortie
require_once "../vendor/autoload.php";
$options = new Options();
$options->set('defaultFont', 'Courier');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$fichier = 'Mon pdf';
// Force le téléchargement
$dompdf->stream($fichier . ".pdf", ["Attachment" => true]);
exit;
?>