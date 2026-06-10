<?php
require_once(__DIR__ . '/tcpdf/tcpdf.php');
require 'vendor/autoload.php';

// Database connection via Supabase PDO
require_once(__DIR__ . '/../../supabaseConn.php');

// Fetch all attendance data for this teacher's students
$newtable = $dbUser.'d';
$stmt = $pdo->prepare("SELECT * FROM \"$newtable\" ORDER BY \"rollno\" ASC");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch subject name for this teacher
$stmt2 = $pdo->prepare("SELECT * FROM \"allTeacher\" WHERE \"username\" = ?");
$stmt2->execute([$dbUser]);
$teacherRow = $stmt2->fetch(PDO::FETCH_ASSOC);
$subjectName = $teacherRow ? $teacherRow['teacherSub'] : '';

// Create PDF
$pdf = new TCPDF();
$pdf->AddPage();

// Fetch teacher division list for PDF sections
$teacherDivisions = [];
if ($teacherRow && isset($teacherRow['division'])) {
    $teacherDivisions = array_map('trim', explode(',', $teacherRow['division']));
}


date_default_timezone_set('Asia/Kolkata');
$currentDateTime = new DateTime();
$date = $currentDateTime->format('Y-m-d');
$time = $currentDateTime->format('h:i:s A');

// Add PVG COE heading
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'PUNE VIDYARTHI GRIHA\'S COLLEGE OF ENGINEERING NASHIK', 0, 1, 'C');
$pdf->Cell(0, 10, 'ONLINE ATTENDANCE', 0, 1, 'C');
$pdf->SetFont('times', '', 14);
$pdf->Cell(0, 10, 'Date : ' . $date, 0, 1, 'L');
$pdf->Cell(0, 10, 'Time : ' . $time, 0, 1, 'L');
$pdf->Cell(0, 10, 'Subject : ' . $subjectName, 0, 1, 'L');
$pdf->Cell(0, 10, 'Total Student Present : ' . count($rows), 0, 1, 'L');
$pdf->Cell(0, 15, '', 0, 1);

// Loop through each division and generate its section
if (!empty($teacherDivisions)) {
    foreach ($teacherDivisions as $div) {
        // Division header
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, "Division: $div", 0, 1, 'L');
        // Table headers
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(30, 10, 'Roll No', 1, 0, 'C', 1);
        $pdf->Cell(60, 10, 'Student Name', 1, 1, 'C', 1);
        // Table rows (same attendance list for each selected division)
        $pdf->SetFont('helvetica', '', 10);
        foreach ($rows as $row) {
            $pdf->Cell(30, 10, $row['rollno'], 1, 0, 'C');
            $pdf->Cell(60, 10, $row['studentName'], 1, 1, 'C');
        }
        // Add a spacer after each division section
        $pdf->Ln(5);
    }
} else {
    // Fallback: single table without division sections
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(30, 10, 'Roll No', 1, 0, 'C', 1);
    $pdf->Cell(60, 10, 'Student Name', 1, 1, 'C', 1);
    $pdf->SetFont('helvetica', '', 10);
    foreach ($rows as $row) {
        $pdf->Cell(30, 10, $row['rollno'], 1, 0, 'C');
        $pdf->Cell(60, 10, $row['studentName'], 1, 1, 'C');
    }
}

// Save PDF
$pdfFilename = $dbUser . '.pdf';
$pdfPath = __DIR__ . '/PDF/' . $pdfFilename;
$pdf->Output($pdfPath, 'F');
?>

