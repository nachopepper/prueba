<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DolarController extends Controller
{
    public function show(Request $request)
    {
        try {
            $month = $request->input('month');
            $client = new Client();
            $response = $client->get('https://api.sbif.cl/api-sbifv3/recursos_api/dolar/2010/' . $month . '?apikey=d8093171162117c0c6e8da895b00978d4e2b6a0e&formato=json');
            $dataResponse = json_decode($response->getBody(), true);
            return response()->json([
                'ok' => true,
                'response' => $dataResponse
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function downloadExcel(Request $request)
    {
        try {
            $month = $request->input('month');
            $client = new Client();
            $response = $client->get('https://api.sbif.cl/api-sbifv3/recursos_api/dolar/2010/' . $month . '?apikey=d8093171162117c0c6e8da895b00978d4e2b6a0e&formato=json');
            $dataResponse = json_decode($response->getBody(), true);


            $spreadsheet = new Spreadsheet();
            $active_sheet = $spreadsheet->getActiveSheet();
            $active_sheet->setCellValue('A1', 'Valor');
            $active_sheet->setCellValue('B1', 'Fecha');


            foreach ($dataResponse['Dolares'] as $key => $d) {
                $active_sheet->setCellValue('A' . $key + 2, $d['Valor']);
                $active_sheet->setCellValue('B' . $key + 2, $d['Fecha']);
            }


            $writer = new Xlsx($spreadsheet);


            // header('Content-Type: application/vnd.ms-excel');
            // header('Content-Disposition: attachment;filename="myfile.xlsx"');
            // header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
        } catch (Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
