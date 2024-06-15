<?php
$id = $_GET['id'];

$xml = new DOMDocument();
$xml->load('produse.xml');

// Folosim Xpath pentru a găsi înregistrarea cu ID-ul specificat și pentru a o șterge
$xpath = new DOMXPath($xml);
foreach ($xpath->query("/products/product[id='$id']") as $node) {
    $node->parentNode->removeChild($node);
}

$xml->formatOutput = true;
$xml->save('produse.xml');

// Redirectăm către pagina records.php după ștergerea înregistrării
header('Location: products_admin.php');
exit; // Oprim execuția scriptului după redirectare pentru a evita continuarea procesării
?>
