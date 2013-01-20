<?php

// Helper para classe de excel
//* @author Felipe <felipe@wadtecnologia.com.br>

require_once 'plugins/phpexcel/Classes/PHPExcel.php';

$PHPExcel = new PHPExcel();

function  read_excel($inputFileName = ''){
	
    if(file_exists($inputFileName)) {
        
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        //$objReader->setReadDataOnly(true);
        
		$objPHPExcel    = $objReader->load($inputFileName);
        $total_sheets   = $objPHPExcel->getSheetCount(); // here 4  
        $allSheetName   = $objPHPExcel->getSheetNames(); // array ([0]=>'student',[1]=>'teacher',[2]=>'school',[3]=>'college')  
        $objWorksheet   = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow     = $objWorksheet->getHighestRow();
        $highestColumn  = $objWorksheet->getHighestColumn();
        
        $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
        
		$headingsArray = $headingsArray[1];
		
        $r = -1;
        $namedDataArray = array();
        for($row = 2; $row <= $highestRow; ++$row) {
            
            $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
			
            if((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] != '')) {
                ++$r;
				
                foreach($headingsArray as $columnKey => $columnHeading) {
                    $namedDataArray[$r][utf8_decode($columnHeading)] = utf8_decode($dataRow[$row][$columnKey]);
                }
            }
            
        }
        
		return $namedDataArray;
		
    }
    
    return false;
}
?>