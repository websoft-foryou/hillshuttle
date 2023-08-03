<?php

        

include('db_connect.php');



  $row = $_POST['dataval']; 

  

 

require_once 'Classes/PHPExcel.php';



// Create new PHPExcel object

$objPHPExcel = new PHPExcel();



// Set properties

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")

							 ->setLastModifiedBy("Maarten Balliauw")

							 ->setTitle("Office 2007 XLSX Test Document")

							 ->setSubject("Office 2007 XLSX Test Document")

							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")

							 ->setKeywords("office 2007 openxml php")

							 ->setCategory("Test result file");





 if(count($row)>0) {

     

                    $perminfo = $objPHPExcel->getActiveSheet()->setTitle('Daysheet');                 

     

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);

$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);

$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0); 



$pageMargins = $perminfo->getPageMargins();

//$pageMargins->setTop('.2.5');

//$pageMargins->setBottom('.1');

$pageMargins->setLeft('.2');

$pageMargins->setRight('.2');



                     $perminfo ->getDefaultStyle()->getFont()->setName('Arial');

                     $perminfo ->getDefaultStyle()->getFont()->setSize(15);

                     $perminfo ->getDefaultStyle()->getFont()->setBold(true);

                     $perminfo ->getColumnDimension('A')->setWidth(5);

                     $perminfo ->getColumnDimension('B')->setWidth(6);

                     $perminfo ->getColumnDimension('C')->setWidth(6);

                     $perminfo ->getColumnDimension('D')->setWidth(10);

                     $perminfo ->getColumnDimension('E')->setWidth(9);

                     $perminfo ->getColumnDimension('F')->setWidth(30);

                     $perminfo ->getColumnDimension('G')->setWidth(30);

                     $perminfo ->getColumnDimension('H')->setWidth(6);

                     $perminfo ->getColumnDimension('I')->setWidth(4);

                     $perminfo ->getColumnDimension('J')->setWidth(8);

                     $perminfo ->getColumnDimension('K')->setWidth(7);

                     $perminfo ->getColumnDimension('L')->setWidth(20);

                     $perminfo ->getColumnDimension('M')->setWidth(11);

                     $perminfo ->getColumnDimension('N')->setWidth(15);

                     $perminfo ->getColumnDimension('O')->setWidth(30);

                     $perminfo ->getColumnDimension('P')->setWidth(13);

                     $perminfo ->getColumnDimension('Q')->setWidth(15);

                     

                     $perminfo ->setShowGridlines(false);

                     

                     $perminfo ->getDefaultRowDimension()->setRowHeight(23);
					 
					 
					 
                     $perminfo ->getStyle('A3:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                     $perminfo ->getStyle('A3:Q3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('A3:Q3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle('A3:Q3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                                $perminfo->setCellValue('A1','Un-Allocated Bookings')

                                ->setCellValue('A3','Conf')        

                                ->setCellValue('B3','Batch')

                                ->setCellValue('C3','B.No')        

                                ->setCellValue('D3','Date')

                                ->setCellValue('E3','P/up Time')

                                ->setCellValue('F3','P/up Address')        

                                ->setCellValue('G3','Drop of Address')

                                ->setCellValue('H3','Pax')

                                ->setCellValue('I3','BSR')        

                                ->setCellValue('J3','Amt')

                                ->setCellValue('K3','Flt Time')

                                ->setCellValue('L3','Client Name')

                                ->setCellValue('M3','Number')                    

                                ->setCellValue('N3','Driver')

                                ->setCellValue('O3','Comments')

                                ->setCellValue('P3','C Payment')        

                                ->setCellValue('Q3','Last Modified by');

                                

     $num=4;

            $total_est = 0;

            $total_passengers = 0;

            $store_batch = '';

     

     // un-allocated bookings

            $k = 0;

            $flag = 'line';

            $depbatchval = '';

            

        for ($r=0; $r < count($row); $r++ ) {

            

                            if($row[$r]['book_confirmed']==1) $bkconfirmed = 'Yes';

                            else $bkconfirmed = 'No';

                     

                     $paid_status = '';

                     $paymethod = '';

                     $depdateval = '';

                     $arrdateval = '';

                     $dep_comments = '';

                     $dep_pickup = '';

                     $arr_pickup = '';

                     $paidstatus = '';

                          

                     $perminfo ->getStyle("A".$num.":Q".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                     

                     $perminfo ->getStyle("A".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("B".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("C".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("D".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("E".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("F".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("G".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("H".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("I".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("J".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("K".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("L".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("M".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("N".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("O".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("P".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("Q".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle("F".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("G".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("L".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("N".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("O".$num)->getAlignment()->setWrapText(true);

                     

                     $perminfo ->getStyle("J".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                     $perminfo ->getStyle("J".$num)->getNumberFormat()->setFormatCode('$#,##0.00## ;[Red]-#,##0.## $');

                     

                     $perminfo ->getRowDimension($num)->setRowHeight(-1);

                     

                    // batch order with space

                       if((($row[$r]['type']=='Departure' && $row[$r]['cancelbook']!=1)) || (($row[$r]['type']=='Arrival' && $row[$r]['cancelbook']!=2))) {

            

                        if((($row[$r]['ptime']==':' || $row[$r]['ptime']=='') || $row[$r]['driverval']=='0') || (($row[$r]['ptime']==':' || $row[$r]['ptime']=='') || $row[$r]['driverval']=='0')) {



                            if($flag=='line') {

                                

                                $flag = 'unline';

                            }

                            

                            $depbatchval = $row[$r]['batchval'];

                            

                            if($store_batch!=$depbatchval) {

                                

                                if($k!=0) {

                                    $perminfo->setCellValue("A".$num, '');        

                                    $num = $num+1;

                                }

                             

                                $flag = 'line';

                                $store_batch = $row[$r]['batchval'];

                            } 

                            

                           }

                        } 

                        // batch order with space end

                     

                     $perminfo ->getStyle("A".$num.":Q".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                     

                     $perminfo ->getStyle("A".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("B".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("C".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("D".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("E".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("F".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("G".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("H".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("I".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("J".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("K".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("L".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("M".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("N".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("O".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("P".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("Q".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle("F".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("G".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("L".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("N".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("O".$num)->getAlignment()->setWrapText(true);

                     

                     $perminfo ->getStyle("J".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                     $perminfo ->getStyle("J".$num)->getNumberFormat()->setFormatCode('$#,##0.00## ;[Red]-#,##0.## $');

                     

                     $perminfo ->getRowDimension($num)->setRowHeight(-1);



                     

                       if(($row[$r]['type']=='Departure' && $row[$r]['cancelbook']!=1)) {

            

                        if(($row[$r]['ptime']==':' || $row[$r]['ptime']=='') || $row[$r]['driverval']=='0') {

                     

                        $depdateval = strtotime($row[$r]['exdepdate']);

                        $arrdateval = strtotime($row[$r]['exarrdate']);

                        $arrcancel = $row[$r]['cancelbook'];



                        $dep_comments = $row[$r]['comments'];

                        

                        $dep_pickup = $row[$r]['exdeppickup'];

                        $arr_pickup = $row[$r]['exarrpickup'];

                        

                        $book_type = $row[$r]['hbooktype'];

                        

                   $depflag = false;

                    if(($depdateval<$arrdateval) && $arrcancel!=2) {

                        $depflag = true;

                        

                    }

                    else if(($depdateval==$arrdateval) && $arrcancel!=2 && ($dep_pickup<$arr_pickup)) {

                        $depflag = true;

                    }

                        

                    if($row[$r]['bookdir'] == 'both') {

                        if($depflag==true) {

                           if($book_type=='AP') $dep_comments .= " Ret ".date('d/m/Y',strtotime($row[$r]['exdate']))." ".$row[$r]['exflight']." ".$row[$r]['exourtime']." ".$row[$r]['exestfare'];

                           else $dep_comments .= " Ret ".date('d/m/Y',strtotime($row[$r]['exdate']))." ".$row[$r]['exestfare'];

                        }

                    }

                            if($row[$r]['paid_status']==1) $paidstatus = 'Prepaid'; // office

                            else if($row[$r]['paid_status']==2) $paidstatus = 'Yes'; // driver

                            else $paidstatus = '';

                            

                                if($row[$r]['payment_method']=='credit card') $paymethod = 'CC';

                                else if($row[$r]['payment_method']=='cash') $paymethod = 'Cash';
								else if($row[$r]['payment_method']=='direct debit') $paymethod = 'DD'; //ACorr DD

                                else $paymethod = '';

                            

                                if($paidstatus!='' || $paymethod!='') $paid_status = $paidstatus.' / '.$paymethod;

                        

                            $total_passengers += $row[$r]['totalpassengers'];

                            $total_est += $row[$r]['totalestfare'];

                            

                            $depbatchval = '';

                            if($row[$r]['batchval']!='empty') $depbatchval = $row[$r]['batchval'];

                            

                        $perminfo->setCellValue("A".$num, $bkconfirmed);        

                        $perminfo->setCellValue("B".$num, $depbatchval);

                        $perminfo->setCellValue("C".$num, $row[$r]['auto']);

                        $perminfo->setCellValue("D".$num, $row[$r]['date']);

                        $perminfo->setCellValue("E".$num, $row[$r]['ptime']);

                        $perminfo->setCellValue("F".$num, str_replace('<br/>',' ',$row[$r]['pickupaddress']));

                        $perminfo->setCellValue("G".$num, str_replace('<br/>',' ',$row[$r]['dropaddress']));

                        $perminfo->setCellValue("H".$num, $row[$r]['passengers']);

                        $perminfo->setCellValue("I".$num, $row[$r]['babyseats']);

                        $perminfo->setCellValue("J".$num, $row[$r]['totalestfare']);

                        $perminfo->setCellValue("K".$num, $row[$r]['fltime']);

                        $perminfo->setCellValue("L".$num, getClient($row[$r]['client'],'name'));

                        $perminfo->setCellValue("M".$num, "'".getClient($row[$r]['client'],'phone')."'");

                        $perminfo->setCellValue("N".$num, getDriver($row[$r]['driverval']));

                        $perminfo->setCellValue("O".$num, $dep_comments);

                        $perminfo->setCellValue("P".$num, $paid_status);

                        $perminfo->setCellValue("Q".$num, $row[$r]['updatedby']);

                        

                         $num++;

                        }

                       }

                     else if(($row[$r]['type']=='Arrival' && $row[$r]['cancelbook']!=2)) {

            

                        if(($row[$r]['ptime']==':' || $row[$r]['ptime']=='') || $row[$r]['driverval']=='0') {



                        $depdateval = strtotime($row[$r]['exdepdate']);

                        $arrdateval = strtotime($row[$r]['exarrdate']);

                        $depcancel = $row[$r]['cancelbook'];

                            

                        $arr_comments = $row[$r]['comments'];

                        

                        $dep_pickup = $row[$r]['exdeppickup'];

                        $arr_pickup = $row[$r]['exarrpickup'];

                        

                        $book_type = $row[$r]['hbooktype'];

                        

                   $arrflag = false;

                    if(($depdateval>$arrdateval) && $depcancel!=1) {

                        $arrflag = true;

                        

                    }

                    else if(($depdateval==$arrdateval) && $depcancel!=1 && ($dep_pickup>$arr_pickup)) {

                        $arrflag = true;

                    }

                        

                    if($row[$r]['bookdir'] == 'both') {

                        if($arrflag==true) {

                            if($book_type=='AP') $arr_comments .= " ".date('d/m/Y',strtotime($row[$r]['exdate']))." ".$row[$r]['exflight']." ".$row[$r]['exourtime']." ".$row[$r]['exestfare'];

                            else $arr_comments .= " ".date('d/m/Y',strtotime($row[$r]['exdate']))." ".$row[$r]['exestfare'];

                        }

                    }

                    

                            if($row[$r]['paid_status']==1) $paidstatus = 'Prepaid'; // office

                            else if($row[$r]['paid_status']==2) $paidstatus = 'Yes'; // driver

                            else $paidstatus = '';

                            

                                if($row[$r]['payment_method']=='credit card') $paymethod = 'CC';

                                else if($row[$r]['payment_method']=='cash') $paymethod = 'Cash';
								
								else if($row[$r]['payment_method']=='direct debit') $paymethod = 'DD'; //ACorr DD

                                else $paymethod = '';

                            

                                if($paidstatus!='' || $paymethod!='') $paid_status = $paidstatus.' / '.$paymethod;

                        

                            $total_passengers += $row[$r]['totalpassengers'];

                            $total_est += $row[$r]['totalestfare'];

                                

                            $arrbatchval = '';

                            if($row[$r]['batchval']!='empty') $arrbatchval = $row[$r]['batchval'];

                            

                        $perminfo->setCellValue("A".$num, $bkconfirmed);        

                        $perminfo->setCellValue("B".$num, $arrbatchval);

                        $perminfo->setCellValue("C".$num, $row[$r]['auto']);

                        $perminfo->setCellValue("D".$num, $row[$r]['date']);

                        $perminfo->setCellValue("E".$num, $row[$r]['ptime']);

                        $perminfo->setCellValue("F".$num, str_replace('<br/>',' ',$row[$r]['pickupaddress']));

                        $perminfo->setCellValue("G".$num, str_replace('<br/>',' ',$row[$r]['dropaddress']));

                        $perminfo->setCellValue("H".$num, $row[$r]['passengers']);

                        $perminfo->setCellValue("I".$num, $row[$r]['babyseats']);

                        $perminfo->setCellValue("J".$num, $row[$r]['totalestfare']);

                        $perminfo->setCellValue("K".$num, $row[$r]['fltime']);

                        $perminfo->setCellValue("L".$num, getClient($row[$r]['client'],'name'));

                        $perminfo->setCellValue("M".$num, "'".getClient($row[$r]['client'],'phone')."'");

                        $perminfo->setCellValue("N".$num, getDriver($row[$r]['driverval']));

                        $perminfo->setCellValue("O".$num, $arr_comments);

                        $perminfo->setCellValue("P".$num, $paid_status);

                        $perminfo->setCellValue("Q".$num, $row[$r]['updatedby']);

                        

                         $num++;

                            

                        }   

                     }

           $k++;

           

        }

        // un-allocated end


        

        $num = $num+1;

                                $perminfo->setCellValue('A'.$num,'Allocated Bookings');

                                

                                $num = $num+2;

                               //ACORR Set heading to red
					 			$perminfo ->getStyle("A".$num.":Q".$num)->getFont()->getColor()->applyFromArray( array('rgb' => 'FF0000') );
                                $perminfo ->getStyle('A'.$num.':Q'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $perminfo ->getStyle('A'.$num.':Q'.$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                $perminfo ->getStyle('A'.$num.':Q'.$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                $perminfo ->getStyle('A'.$num.':Q'.$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                

                                

                                $perminfo->setCellValue('A'.$num,'Conf')        

                                ->setCellValue('B'.$num,'Batch')

                                ->setCellValue('C'.$num,'B.No')        

                                ->setCellValue('D'.$num,'Date')

                                ->setCellValue('E'.$num,'P/up Time')

                                ->setCellValue('F'.$num,'P/up Address')        

                                ->setCellValue('G'.$num,'Drop of Address')

                                ->setCellValue('H'.$num,'Pax')

                                ->setCellValue('I'.$num,'BSR')        

                                ->setCellValue('J'.$num,'Amt')

                                ->setCellValue('K'.$num,'Flt Time')

                                ->setCellValue('L'.$num,'Client Name')

                                ->setCellValue('M'.$num,'Number')                    

                                ->setCellValue('N'.$num,'Driver')

                                ->setCellValue('O'.$num,'Comments')

                                ->setCellValue('P'.$num,'C Payment')        

                                ->setCellValue('Q'.$num,'Last Modified by');

        

        $num = $num+1;

     // ALLOCATED BOOKINGS

        

        $j = 0;

        $allocate_flag = 'line';

        $alloc_store_batch = '';

        

        for ($r=0; $r < count($row); $r++ ) {

            

                     $perminfo ->getStyle("A".$num.":Q".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                     

                     $perminfo ->getStyle("A".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("B".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("C".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("D".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("E".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("F".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("G".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("H".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("I".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("J".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("K".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("L".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("M".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("N".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("O".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("P".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("Q".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle("F".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("G".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("L".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("N".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("O".$num)->getAlignment()->setWrapText(true);

                     

                     $perminfo ->getRowDimension($num)->setRowHeight(-1);

                     

                     $perminfo ->getStyle("J".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                     $perminfo ->getStyle("J".$num)->getNumberFormat()->setFormatCode('$#,##0.00## ;[Red]-#,##0.## $');



                     

                            if($row[$r]['book_confirmed']==1) $bkconfirmed = 'Yes';

                            else $bkconfirmed = 'No';

                     

                            $paid_status = '';

                            $paymethod = '';

                            

                    // batch order with space

                       if((($row[$r]['type']=='Departure' && $row[$r]['cancelbook']!=1)) || (($row[$r]['type']=='Arrival' && $row[$r]['cancelbook']!=2))) {

            

                        if((($row[$r]['ptime']!=':' && $row[$r]['ptime']!='') && $row[$r]['driverval']!='0') || (($row[$r]['ptime']!=':' && $row[$r]['ptime']!='') && $row[$r]['driverval']!='0')) {



                            if($allocate_flag=='line') {

                                

                                $allocate_flag = 'unline';

                            }

                            

                            $alloc_batchval = $row[$r]['batchval'];

                            

                            if($alloc_store_batch!=$alloc_batchval) {

                                

                                if($j!=0) {

                                    

                                    $perminfo->setCellValue("A".$num, '');        

                                    $num = $num+1;

                                    

                                }

                             

                                $allocate_flag = 'line';

                                $alloc_store_batch = $row[$r]['batchval'];

                            } 

                            

                           }

                        } 

                        // batch order with space end

                            

                     $perminfo ->getStyle("A".$num.":Q".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                     $perminfo ->getStyle("A".$num)->getFont()->getColor()->applyFromArray( array('rgb' => 'FF0000') ); //ACORR  Red

                     $perminfo ->getStyle("A".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("A".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("B".$num)->getFont()->getColor()->applyFromArray( array('rgb' => 'FF0000') ); //ACORR  Red
					 $perminfo ->getStyle("B".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("B".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


					 $perminfo ->getStyle("C".$num)->getFont()->getColor()->applyFromArray( array('rgb' => 'FF0000') ); //ACORR  Red
                     $perminfo ->getStyle("C".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("C".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("D".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("D".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("E".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("E".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("F".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("F".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("G".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("G".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("H".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("H".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("I".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("I".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("J".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("J".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("K".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("K".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("L".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("L".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("M".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("M".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("N".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("N".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("O".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("O".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


					 $perminfo ->getStyle("P".$num)->getFont()->getColor()->applyFromArray( array('rgb' => 'FF0000') ); //ACORR  Red
					 
                     $perminfo ->getStyle("P".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("P".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



                     $perminfo ->getStyle("Q".$num)->getFont()->getColor()->applyFromArray( array('rgb' => 'FF0000') ); //ACORR  Red
					 
					 $perminfo ->getStyle("Q".$num)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     $perminfo ->getStyle("Q".$num)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                     

                     $perminfo ->getStyle("F".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("G".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("L".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("N".$num)->getAlignment()->setWrapText(true);

                     $perminfo ->getStyle("O".$num)->getAlignment()->setWrapText(true);

                     

                     $perminfo ->getRowDimension($num)->setRowHeight(-1);

                     

                     $perminfo ->getStyle("J".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                     $perminfo ->getStyle("J".$num)->getNumberFormat()->setFormatCode('$#,##0.00## ;[Red]-#,##0.## $');



                     

                      if(($row[$r]['type']=='Departure' && $row[$r]['cancelbook']!=1)) {

                          

                        if(($row[$r]['ptime']!=':' && $row[$r]['ptime']!='') && $row[$r]['driverval']!='0') {

                     

                        $depdateval = strtotime($row[$r]['exdepdate']);

                        $arrdateval = strtotime($row[$r]['exarrdate']);

                        $arrcancel = $row[$r]['cancelbook'];



                        $dep_comments = $row[$r]['comments'];

                        

                        $dep_pickup = $row[$r]['exdeppickup'];

                        $arr_pickup = $row[$r]['exarrpickup'];

                        

                        $book_type = $row[$r]['hbooktype'];

                        

                   $depflag = false;

                    if(($depdateval<$arrdateval) && $arrcancel!=2) {

                        $depflag = true;

                        

                    }

                    else if(($depdateval==$arrdateval) && $arrcancel!=2 && ($dep_pickup<$arr_pickup)) {

                        $depflag = true;

                    }

                        

                    if($row[$r]['bookdir'] == 'both') {

                        if($depflag==true) {

                           if($book_type=='AP') $dep_comments .= " Ret ".date('d/m/Y',strtotime($row[$r]['exdate']))." ".$row[$r]['exflight']." ".$row[$r]['exourtime']." ".$row[$r]['exestfare'];

                           else $dep_comments .= " Ret ".date('d/m/Y',strtotime($row[$r]['exdate']))." ".$row[$r]['exestfare'];

                        }

                    }

                    

                            if($row[$r]['paid_status']==1) $paidstatus = 'Prepaid'; // office

                            else if($row[$r]['paid_status']==2) $paidstatus = 'Yes'; // driver

                            else $paidstatus = '';

                            

                                if($row[$r]['payment_method']=='credit card') $paymethod = 'CC';

                                else if($row[$r]['payment_method']=='cash') $paymethod = 'Cash';
								else if($row[$r]['payment_method']=='direct debit') $paymethod = 'DD'; //ACorr DD

                                else $paymethod = '';

                            

                                if($paidstatus!='' || $paymethod!='') $paid_status = $paidstatus.' / '.$paymethod;

                        

                            $total_passengers += $row[$r]['totalpassengers'];

                            $total_est += $row[$r]['totalestfare'];

                                

                            $alldepbatchval = '';

                            if($row[$r]['batchval']!='empty') $alldepbatchval = $row[$r]['batchval'];

                            

                        $perminfo->setCellValue("A".$num, $bkconfirmed);        

                        $perminfo->setCellValue("B".$num, $alldepbatchval);

                        $perminfo->setCellValue("C".$num, $row[$r]['auto']);

                        $perminfo->setCellValue("D".$num, $row[$r]['date']);

                        $perminfo->setCellValue("E".$num, $row[$r]['ptime']);

                        $perminfo->setCellValue("F".$num, str_replace('<br/>',' ',$row[$r]['pickupaddress']));

                        $perminfo->setCellValue("G".$num, str_replace('<br/>',' ',$row[$r]['dropaddress']));

                        $perminfo->setCellValue("H".$num, $row[$r]['passengers']);

                        $perminfo->setCellValue("I".$num, $row[$r]['babyseats']);

                        $perminfo->setCellValue("J".$num, $row[$r]['totalestfare']);

                        $perminfo->setCellValue("K".$num, $row[$r]['fltime']);

                        $perminfo->setCellValue("L".$num, getClient($row[$r]['client'],'name'));

                        $perminfo->setCellValue("M".$num, "'".getClient($row[$r]['client'],'phone')."'");

                        $perminfo->setCellValue("N".$num, getDriver($row[$r]['driverval']));

                        $perminfo->setCellValue("O".$num, $dep_comments);

                        $perminfo->setCellValue("P".$num, $paid_status);

                        $perminfo->setCellValue("Q".$num, $row[$r]['updatedby']);

                        

                         $num++;

                        }

                       }

                      else if(($row[$r]['type']=='Arrival' && $row[$r]['cancelbook']!=2)) {

                          

                        if(($row[$r]['ptime']!=':' && $row[$r]['ptime']!='') && $row[$r]['driverval']!='0') {



                        $depdateval = strtotime($row[$r]['exdepdate']);

                        $arrdateval = strtotime($row[$r]['exarrdate']);

                        $depcancel = $row[$r]['cancelbook'];

                            

                        $arr_comments = $row[$r]['comments'];

                        

                        $dep_pickup = $row[$r]['exdeppickup'];

                        $arr_pickup = $row[$r]['exarrpickup'];

                        

                        $book_type = $row[$r]['hbooktype'];

                        

                   $arrflag = false;

                    if(($depdateval>$arrdateval) && $depcancel!=1) {

                        $arrflag = true;

                        

                    }

                    else if(($depdateval==$arrdateval) && $depcancel!=1 && ($dep_pickup>$arr_pickup)) {

                        $arrflag = true;

                    }

                        

                    if($row[$r]['bookdir'] == 'both') {

                        if($arrflag==true) {

                            if($book_type=='AP') $arr_comments .= " ".date('d/m/Y',strtotime($row[$r]['exdate']))." ".$row[$r]['exflight']." ".$row[$r]['exourtime']." ".$row[$r]['exestfare'];

                            else $arr_comments .= " ".date('d/m/Y',strtotime($row[$r]['exdate']))." ".$row[$r]['exestfare'];

                        }

                    }

                    

                            if($row[$r]['paid_status']==1) $paidstatus = 'Prepaid'; // office

                            else if($row[$r]['paid_status']==2) $paidstatus = 'Yes'; // driver

                            else $paidstatus = '';

                            

                                if($row[$r]['payment_method']=='credit card') $paymethod = 'CC';

                                else if($row[$r]['payment_method']=='cash') $paymethod = 'Cash';
								else if($row[$r]['payment_method']=='direct debit') $paymethod = 'DD'; //ACorr DD

                                else $paymethod = '';

                            

                                if($paidstatus!='' || $paymethod!='') $paid_status = $paidstatus.' / '.$paymethod;

                        

                            $total_passengers += $row[$r]['totalpassengers'];

                            $total_est += $row[$r]['totalestfare'];

                                

                            $allarrbatchval = '';

                            if($row[$r]['batchval']!='empty') $allarrbatchval = $row[$r]['batchval'];

                            

                        $perminfo->setCellValue("A".$num, $bkconfirmed);        

                        $perminfo->setCellValue("B".$num, $allarrbatchval);

                        $perminfo->setCellValue("C".$num, $row[$r]['auto']);

                        $perminfo->setCellValue("D".$num, $row[$r]['date']);

                        $perminfo->setCellValue("E".$num, $row[$r]['ptime']);

                        $perminfo->setCellValue("F".$num, str_replace('<br/>',' ',$row[$r]['pickupaddress']));

                        $perminfo->setCellValue("G".$num, str_replace('<br/>',' ',$row[$r]['dropaddress']));

                        $perminfo->setCellValue("H".$num, $row[$r]['passengers']);

                        $perminfo->setCellValue("I".$num, $row[$r]['babyseats']);

                        $perminfo->setCellValue("J".$num, $row[$r]['totalestfare']);

                        $perminfo->setCellValue("K".$num, $row[$r]['fltime']);

                        $perminfo->setCellValue("L".$num, getClient($row[$r]['client'],'name'));

                        $perminfo->setCellValue("M".$num, "'".getClient($row[$r]['client'],'phone')."'");

                        $perminfo->setCellValue("N".$num, getDriver($row[$r]['driverval']));

                        $perminfo->setCellValue("O".$num, $arr_comments);

                        $perminfo->setCellValue("P".$num, $paid_status);

                        $perminfo->setCellValue("Q".$num, $row[$r]['updatedby']);

                        

                         $num++;

                            

                        }   

                     }

           $j++;

        }

        // allocated end  

        $passengers_count = 'Total Passengers: '.$total_passengers;

        $est_count = 'Total Amount: $'.number_format(round((float)$total_est,2),2);

     

     $num = $num+1;

     $perminfo->setCellValue("A".$num, $passengers_count);

     $num = $num+1;

     $perminfo->setCellValue("A".$num, $est_count);

     

 }

 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet

$objPHPExcel->setActiveSheetIndex(0);



$date_time = date('d-m-Y-H-i-s');

$filename  = "daysheet_".$date_time.".xls";



$path = "daysheet_excel/".$filename;

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save($path);



echo $filename;



function getClient($val,$type) {

    

    $qry = 'select first_name,last_name,mobile,phone from clients where id='.$val;

    $result = @mysql_query($qry);

    $num = @mysql_fetch_array($result);

    if($type=='name') return $num['first_name']." ".$num['last_name']; 

	elseif ($num['phone']!="") return $num['mobile']." - ".$num['phone']; //ACorr
	
	else return $num['mobile'];

}



function getDriver($val) {

    

    $qry = 'select first_name,last_name from drivers where id='.$val;

    $result = @mysql_query($qry);

    $num = @mysql_fetch_array($result);

    return $num['first_name']." ".$num['last_name'];

}





?>