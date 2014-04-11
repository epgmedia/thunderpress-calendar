<?php
/*download sample.csv*/
$csvfilepath = get_option( 'siteurl' ) ."/wp-content/themes/".get_option( 'template' )."/sample_csv.csv";

header('Content-Description: File Transfer');

header('Content-Type: application/octet-stream');

header("Content-Type: image/png");

header("Content-type: application/force-download");

header('Content-Disposition: inline; filename="sample_csv.csv"');

header('Content-Transfer-Encoding: binary');

readfile($csvfilepath);

exit;

?>