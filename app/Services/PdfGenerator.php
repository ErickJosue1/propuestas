<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;


use FPDF;

class PdfGenerator extends FPDF
{
    public function generatePDF($dest, $name, $username, $description)
    {
        $this->AddPage();

        //user name

        $this->SetFont('Arial', 'B', 24);

        $w = $this->GetStringWidth($username);
        $this->SetY(($this->h - 5) / 2);
        $this->SetX(($this->w - $w) / 2);
        $this->SetTextColor(90, 90, 90);

        $this->Image('./' . 'GEX.jpeg', 0, 0, $this->w, $this->h);
        $this->Cell($w, 10, $username);

        // description

        $this->SetFont('Arial', 'B', 12);
        $description = wordwrap($description, 75, "\n");

        $this->SetY(($this->h + ($this->h * 0.15)) / 2);

        $w = $this->GetStringWidth($description);
        $this->SetX(($this->w * -2) + ($w * 0.17));

        $this->MultiCell($w, 10, $description, 0, 'C');

        //QR

        QrCode::size(200)->format('png')->color(90, 90, 90)->generate('dkjfbuhbfuhysdb', $dest . '/' . $name . 'QR' . '.png');

        $this->Image($dest . '/' . $name . 'QR' . '.png', 160, ($this->h / 2) + (($this->h / 2) * 0.5), 35, 35);

        $this->Output('F', $dest . '/' . $name . '.pdf');
    }
}
