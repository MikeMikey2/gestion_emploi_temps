<?php
// Pas de session_start() ici, pas d'include qui affiche quoi que ce soit
require_once "../dompdf/autoload.inc.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Arial');

$dompdf = new Dompdf($options);
$dompdf->loadHtml('<h1>Bonjour, ceci est un PDF généré par Dompdf !</h1>');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Force le téléchargement
$dompdf->stream("document.pdf", ["Attachment" => true]);
exit;
?>
```

---

**À vérifier aussi — structure des dossiers :**
```
projet/
├── ADMIN/
│   └── con_dbb.php
├── dompdf/
│   └── autoload.inc.php   ← doit exister ici
└── Teachers/
    └── genpdf.php