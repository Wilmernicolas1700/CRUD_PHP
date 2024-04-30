<?php
namespace App\Http\Controllers;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;

class crudController extends Controller
{
    public function index(){
        $datos = Persona::all();
        return view('welcome', compact('datos'));
    }
    public function create(Request $request){

        try{
            $sql = DB::insert(" insert into personas(identificacion,nombre,apellido,correo)values(?,?,?,?) ",    [
                $request->txtidentificacion,
                $request->txtnombre,
                $request->txtapellido,
                $request->txtemail
            ]);
        } catch(\Throwable $th){
            $sql = 0;
        }
       
        if ($sql == true) {
            return back()->with("correcto","La persona se ha registrado  correctamente");
        } else {
            return back()->with("incorrecto","Error al registrar esta persona");
        }
        
    }

    public function update(Request $request){

        try{
            $sql = DB::update(" update personas set nombre=?, apellido=?, correo=? where identificacion=? ",[
                $request->txtnombre,
                $request->txtapellido,
                $request->txtemail,
                $request->txtidentificacion
            ]);
            if($sql==0){
                $sql = 1;
            }
        } catch(\Throwable $th){
            $sql = 0;
        }
       
        if ($sql == true) {
            return back()->with("correcto","La persona se ha modificado  correctamente");
        } else {
            return back()->with("incorrecto","Error al modificar esta persona");
        }
        
    }

    public function delete($id){
        try{
            $sql = DB::delete(" delete from personas where identificacion=$id ",    [
              
            ]);
        } catch(\Throwable $th){
            $sql = 0;
        }
       
        if ($sql == true) {
            return back()->with("correcto","La persona se ha eliminado  correctamente");
        } else {
            return back()->with("incorrecto","Error al eliminar esta persona");
        }
    }

    public function generatePDF()
    {
        $personas = Persona::all();

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Configura el encabezado y pie de página
        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, 'Registro de Personas', 'Generado el: ' . date('Y-m-d H:i:s'));
        $pdf->setFooterData([], [0, 64, 0], 'Registro de Personas', 'Página {PAGENO}', [0, 64, 128]);

        // Establece el formato de la página
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('helvetica', '', 11);

        // Agrega una página
        $pdf->AddPage();

        // Contenido del PDF
        $html = '<table border="1">';
        $html .= '<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Identificación</th><th>Correo</th></tr>';
        foreach ($personas as $persona) {
            $html .= '<tr>';
            $html .= '<td>' . $persona->id . '</td>';
            $html .= '<td>' . $persona->nombre . '</td>';
            $html .= '<td>' . $persona->apellido . '</td>';
            $html .= '<td>' . $persona->identificacion . '</td>';
            $html .= '<td>' . $persona->correo . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        // Escribir el contenido HTML en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Cierre y salida del PDF
        $pdf->Output('registro_personas.pdf', 'D');
    }

    public function generateExcel()
    {
        $personas = Persona::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Apellido');
        $sheet->setCellValue('D1', 'Identificación');
        $sheet->setCellValue('E1', 'Correo');

        $row = 2;
        foreach ($personas as $persona) {
            $sheet->setCellValue('A' . $row, $persona->id);
            $sheet->setCellValue('B' . $row, $persona->nombre);
            $sheet->setCellValue('C' . $row, $persona->apellido);
            $sheet->setCellValue('D' . $row, $persona->identificacion);
            $sheet->setCellValue('E' . $row, $persona->correo);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('registro_personas.xlsx');

        return response()->download('registro_personas.xlsx')->deleteFileAfterSend();
    }

}