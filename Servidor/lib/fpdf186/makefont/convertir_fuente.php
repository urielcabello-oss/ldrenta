<?php
require('../fpdf.php'); // Ruta correcta al archivo fpdf.php
require('makefont.php'); // Script de FPDF para conversión de fuentes

MakeFont('Cambria.ttf', 'cp1252'); // Convertir la fuente Cambria
?>
