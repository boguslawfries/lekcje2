<?php
        function transform($code) 
        {

                $xslDoc = new DOMDocument();
                $xslDoc->load($code);
                $xmlDoc = new DOMDocument();
                $xmlDoc->load('data/inputXML.xml');
                $proc = new XSLTProcessor();
                $proc->importStylesheet($xslDoc);
        $path = 'data/';
        $filename = 'fb.xml';
        $outputxml = $path . $filename;   
        $fp = fopen($outputxml, 'w');
        fwrite($fp, $proc->transformToXML($xmlDoc));
         fclose($fp);
header('Content-Description: File Transfer'); 
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($outputxml));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($outputxml));

        $fp = fopen("$outputxml", "r");
        fpassthru($fp);
       fclose($fp);
	}
 

ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
$target_file = $_FILES["inputXML"]["tmp_name"];;
$r = move_uploaded_file($target_file, 'data/inputXML.xml' );
$code = $_POST["code"];
$code = "data/" . $code  . ".xsl";
transform( $code);
echo('done');
?>
