<?php
class PDF extends FPDF
{
    private $customer_name = null;
    private $job_req_no = null;
    // Page header
    public function __construct(){
        parent:: __construct();
       
    }
    public function Header(){
        $this->Image(base_url().'assets/img/logo.jpg',10,6,30);
        $this->SetFont('Arial','B',9);       
        $this->Cell(33);
        $this->Cell(10,10,'Think Repair');
        $this->Cell(130);
        $this->Cell(10,15,date("d-M-y"));          
        $this->Ln(7);
        $this->Cell(33);
        $this->MultiCell(40,4,'PO Box 25582 Wellington 6146 www.thinkrepair.co.nz' ,'0','L');                
        $this->Ln(5);
        $this->Line(11, 33, 220-20, 33);
        $this->Ln(3); 
    }  
    public function JRN(){
        $this->Ln(3); 
        $this->SetXY(170,20);
        $this->Cell(10);
        $this->Cell(10,10,'JRN : '.$this->job_req_no);
    }
    public function Title(){
        $this->SetTitle($this->job_req_no.'-'.$this->customer_name);
    }    
    public function File(){
        $this->Output('I',''.$this->job_req_no.'-'.$this->customer_name.'.pdf');
    }
    public function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }  
    function check_if($entry){
        if($entry !== '') {
            $this->Ln(5);
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->Cell(10,8,$entry);
        } 
    }
    function customer_details($data){

        foreach($data as $row){
            $this->setFillColor(230,230,230); 
            $this->SetFont('Arial','B',12);
            $this->Cell(0,8,'I. CUSTOMER DETAILS',0,1,'L',1); //your cell
            $this->SetFont('Arial','',10);
            $this->Cell(75);
            $this->Ln(0);
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->Cell(10,8,$row['name']);
            $this->check_if($row['company']);
            $this->check_if($row['contact']);
            $customer_name = $row['name'];
            $job_req_no = $row['jobReqNo'];
        }   
        $this->customer_name = $customer_name;  
        $this->job_req_no = $job_req_no;  
    }

    function job_details($data){
         foreach($data as $row){
            $this->setFillColor(230,230,230); 
            $this->SetFont('Arial','B',12);
            $this->Ln(2);
            $this->Cell(0,8,'II. JOB DETAILS',0,1,'L',1); //your cell
            $this->Ln(4);
            $this->SetFont('Arial','B',10);  
            $this->Cell(12,3,'ITEM :');
            $this->Cell(1);
            $this->SetFont('Arial','',10);
            $this->MultiCell(110,3,$row['product_item']);
            $this->Ln(4);
            $this->SetFont('Arial','B',10);
            $this->Cell(12,3,'BRAND :');
            $this->Cell(5);            
            $this->SetFont('Arial','',10);
            $this->MultiCell(110,3,$row['product']); 
            $this->Ln(4);           
            $this->SetFont('Arial','B',10);
            $this->Cell(12,3,'MODEL :');
            $this->Cell(5);
            $this->SetFont('Arial','',10);
            $this->MultiCell(110,3,$row['model']);
            $this->Ln(3);
            $this->SetFont('Arial','B',10);
            $this->Cell(13,5,'FAULTS :');
            $this->Cell(5);
            $this->SetFont('Arial','',10);
            $this->MultiCell(160,5, $row['fault']);
            $this->Ln(3);           
            $this->SetFont('Arial','B',12);  
            $this->Ln(0);
            $this->SetFont('Arial','B',10);
            $this->Cell(13,3,'COST :');
            $this->SetFont('Arial','',10);
            $this->MultiCell(110,3, '$'.$row['cost']);            
            $received = $row['full_name'];
         }
         $this->Ln(20);
         $this->SetFont('Arial','',10);
         $this->Cell(135);
         $this->Cell(3,5,'Received by : ' .$received);
    }
}
// Instanciation of inherited class
$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->customer_details($result);
$pdf->Ln(6);
$pdf->job_details($result);
$pdf->Title();
$pdf->JRN();
$pdf->File();
?>