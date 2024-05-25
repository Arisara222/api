<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/fpdf.php'; // Include FPDF library file

class Report_time extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // No need to load the library here
        $this->load->model('Manage_time_model', 'mtm');
    }
    public function export_pdf()
    {
        $sa_id = 1; // Example user ID, replace with dynamic ID as needed
        $timesheetData = $this->mtm->show_timesheet_view($sa_id);

        // Initialize FPDF
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Title
        $pdf->Cell(0, 10, 'TIMESHEET - Mr. Natthawat Thanisornthaweesin', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 8);

        // Table header
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(10, 10, 'S.No', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'Date', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'Day', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'From', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'To', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'OT Hours', 1, 0, 'C', true);
        $pdf->Cell(25, 10, 'Total (Hours)',1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Remarks', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Late', 1, 1, 'C', true);

        // Table data
       // Table data
        // Table data
        // Table data
        $pdf->SetFont('Arial', '',8);
        $cellHeight = 6; // Set the desired height for each cell
        $serialNumber = 1;

        $totalOTHours = 0;
        $totalHours = 0;

        for ($day = 1; $day <= 31; $day++) {
            $date = date('Y-m-d', mktime(0, 0, 0, date('m'), $day, date('Y')));
            $dayOfWeek = date('l', strtotime($date));
            $dataExists = false;
        
            foreach ($timesheetData as $index => $row) {
                if (date('Y-m-d', strtotime($row->its_date)) === $date) {
                    $dataExists = true;
                    $fromTime = strtotime($row->its_time_in);
                    $standardTime = strtotime('08:00:00');
                    $lateTime = ($fromTime > $standardTime) ? round(($fromTime - $standardTime) / 60) : '';
                    
                    $pdf->Cell(10, $cellHeight, $serialNumber, 1, 0, 'C');
                    $pdf->Cell(20, $cellHeight, date('d/m/y', strtotime($row->its_date)), 1, 0, 'C');
                    $pdf->Cell(20, $cellHeight, $dayOfWeek, 1, 0, 'C');
                    $pdf->Cell(20, $cellHeight, $row->its_time_in, 1, 0, 'C');
                    $pdf->Cell(20, $cellHeight, $row->its_time_out, 1, 0, 'C');
                    $pdf->Cell(20, $cellHeight, $row->its_ot, 1, 0, 'C');
                    $pdf->Cell(25, $cellHeight, '8.00', 1, 0, 'C'); // Example static value for Total (Hours)
                    $pdf->Cell(30, $cellHeight, $row->its_remark, 1, 0, 'C');
                    $pdf->Cell(30, $cellHeight, $lateTime, 1, 1, 'C');

                    // Accumulate totals
                    $totalOTHours += floatval($row->its_ot);
                    $totalHours += 8; // Example static value for Total (Hours)
                
                    $serialNumber++;
                    break;
                }
            }
        
            if (!$dataExists) {
                // If no data exists for this day, output empty cells
                $pdf->Cell(10, $cellHeight, $serialNumber, 1, 0, 'C');
                $pdf->Cell(20, $cellHeight, date('d/m/y', strtotime($date)), 1, 0, 'C');
                $pdf->Cell(20, $cellHeight, $dayOfWeek, 1, 0, 'C');
                $pdf->Cell(20, $cellHeight, '', 1, 0, 'C');
                $pdf->Cell(20, $cellHeight, '', 1, 0, 'C');
                $pdf->Cell(20, $cellHeight, '', 1, 0, 'C');
                $pdf->Cell(25, $cellHeight, '', 1, 0, 'C');
                $pdf->Cell(30, $cellHeight, '', 1, 0, 'C');
                $pdf->Cell(30, $cellHeight, '', 1, 1, 'C');
                $serialNumber++;
            }
        }

        // Add a total row
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(90, $cellHeight, 'Total', 1, 0, 'C');
        $pdf->Cell(20, $cellHeight, number_format($totalOTHours, 2), 1, 0, 'C');
        $pdf->Cell(30, $cellHeight, number_format($totalHours, 2), 1, 0, 'C');
        $pdf->Cell(40, $cellHeight, '', 1, 1, 'C');

        // Output the PDF
    




        // Output the PDF
        $pdf->Output();
    }
}
