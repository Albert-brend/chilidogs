<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Ventas.php';

class DescargarController {
    private $ventas;

    public function __construct() {
        $this->ventas = new Ventas();
    }

    // Página con el botón de descarga
    public function index() {
        $totalFilas = count($this->ventas->cronogramaParaExcel());
        require_once __DIR__ . '/../views/descargar.php';
    }

    // Genera y descarga el .xlsx
    public function excel() {
        // Protege la descarga (requerirRol vive en header.php, así que se carga sin mostrar su HTML)
        ob_start();
        require_once __DIR__ . '/../../includes/header.php';
        requerirRol("admin");
        ob_end_clean();

        $filas = $this->ventas->cronogramaParaExcel();

        $encabezados = ['Fecha', 'Año', 'Especialidad', 'Sección'];
        $datos = [$encabezados];
        foreach ($filas as $f) {
            $datos[] = [$f['fecha'], $f['anio'], $f['especialidad'], $f['seccion']];
        }

        $archivo = $this->construirXlsx($datos);
        if ($archivo === false) {
            http_response_code(500);
            echo 'No se pudo generar el archivo Excel.';
            exit;
        }

        $nombre = 'cronograma_secciones_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $nombre . '"');
        header('Content-Length: ' . filesize($archivo));
        header('Cache-Control: no-store');
        readfile($archivo);
        unlink($archivo);
        exit;
    }

    private function celda($col, $fila, $valor, $estilo = 0) {
        $ref = chr(65 + $col) . $fila;
        $txt = htmlspecialchars((string) $valor, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        return '<c r="' . $ref . '" t="inlineStr" s="' . $estilo . '"><is><t>' . $txt . '</t></is></c>';
    }

    private function construirXlsx(array $datos) {
        if (!class_exists('ZipArchive')) {
            return false;
        }

        $filasXml = '';
        foreach ($datos as $i => $fila) {
            $n = $i + 1;
            $celdas = '';
            foreach ($fila as $c => $valor) {
                $celdas .= $this->celda($c, $n, $valor, $i === 0 ? 1 : 0);
            }
            $filasXml .= '<row r="' . $n . '">' . $celdas . '</row>';
        }

        $hoja = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<cols>'
            . '<col min="1" max="1" width="14" customWidth="1"/>'
            . '<col min="2" max="2" width="12" customWidth="1"/>'
            . '<col min="3" max="3" width="32" customWidth="1"/>'
            . '<col min="4" max="4" width="10" customWidth="1"/>'
            . '</cols>'
            . '<sheetData>' . $filasXml . '</sheetData></worksheet>';

        $estilos = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="2"><font><sz val="11"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><name val="Calibri"/></font></fonts>'
            . '<fills count="2"><fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill></fills>'
            . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="2">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1"/>'
            . '</cellXfs></styleSheet>';

        $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>';

        $relsRaiz = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';

        $libro = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Cronograma" sheetId="1" r:id="rId1"/></sheets></workbook>';

        $relsLibro = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';

        $tmp = tempnam(sys_get_temp_dir(), 'xlsx');
        $zip = new ZipArchive();
        if ($zip->open($tmp, ZipArchive::OVERWRITE) !== true) {
            return false;
        }
        $zip->addFromString('[Content_Types].xml', $contentTypes);
        $zip->addFromString('_rels/.rels', $relsRaiz);
        $zip->addFromString('xl/workbook.xml', $libro);
        $zip->addFromString('xl/_rels/workbook.xml.rels', $relsLibro);
        $zip->addFromString('xl/styles.xml', $estilos);
        $zip->addFromString('xl/worksheets/sheet1.xml', $hoja);
        $zip->close();

        return $tmp;
    }
}