<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

$host = "mysql50-114.wc2.dfw1.stabletransit.com"; //database location
$user = "646900_biker"; //database username
$pass = "3gmas3g3rEbre"; //database password
$db_name = "646900_biker"; //database name

//database connection
$link = mysql_connect($host, $user, $pass);
mysql_select_db($db_name);

//sets encoding to utf8
mysql_query("SET NAMES utf8");


function csvfriendly($text) {
	$text = str_ireplace('"','""',$text);
	return $text;
}


$sql="
SELECT id,wp_terms.name,post_title,post_date,post_modified,post_content,post_excerpt,(select guid from wp_posts where post_parent=wpp.id limit 0,1) as post_image
	FROM wp_posts wpp
	LEFT JOIN wp_term_relationships
	ON (wpp.ID = wp_term_relationships.object_id)
	LEFT JOIN wp_term_taxonomy
	ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
	LEFT JOIN wp_terms
	ON (wp_term_taxonomy.term_id = wp_terms.term_id)
where post_type='event' and post_parent=0 
GROUP BY wpp.id
ORDER BY wpp.id
";

echo $sql."<br><br>";

$sqlexec = mysql_query($sql);

$currentline="id,category,post_title,post_image,post_date,post_modified,post_content,post_excerpt,address1,address2,city,state,zip,contact,email,website,twitter,facebook,timing,alive_dates,special_offer";
$csvoutput = $currentline . "\r\n";
echo $currentline.'<br>';

if (mysql_numrows($sqlexec) != 0) {
	while ($row = mysql_fetch_array($sqlexec)) {
	
	$ID = $row['id'];
	$category = csvfriendly($row['name']);
	$post_title = csvfriendly($row['post_title']);
	$post_image = csvfriendly($row['post_image']);
	$post_date = $row['post_date'];
	$post_modified = $row['post_modified'];
	$post_content = csvfriendly($row['post_content']);
	$post_content = strip_tags($post_content);
	$post_excerpt = csvfriendly($row['post_excerpt']);

	$sql2="SELECT * FROM wp_postmeta where post_id=".$row['id'];
	$sqlexec2 = mysql_query($sql2);
	
	$geo_address='';
	$contact='';
	$email='';
	$website='';
	$twitter='';
	$facebook='';
	$timing='';
	$alive_days='';
	$special_offer='';
	
	if (mysql_numrows($sqlexec2) != 0) {
		while ($row2 = mysql_fetch_array($sqlexec2)) {
			if ($row2['meta_key']=='geo_address') {
				$geo_address = csvfriendly($row2['meta_value']);
			} elseif ($row2['meta_key']=='contact') {
				$contact = csvfriendly($row2['meta_value']);
			} elseif ($row2['meta_key']=='email') {
				$email = csvfriendly($row2['meta_value']);
			} elseif ($row2['meta_key']=='website') {
				$website = csvfriendly($row2['meta_value']);
			} elseif ($row2['meta_key']=='twitter') {
				$twitter = csvfriendly($row2['meta_value']);
			} elseif ($row2['meta_key']=='facebook') {
				$facebook = csvfriendly($row2['meta_value']);
			} elseif ($row2['meta_key']=='timing') {
				$timing = csvfriendly($row2['meta_value']);
			} elseif ($row2['meta_key']=='alive_days') {
				$alive_days = csvfriendly($row2['meta_value']);
			} elseif ($row2['meta_key']=='proprty_feature') {
				$special_offer = csvfriendly($row2['meta_value']);
			}
		}
	} 	
	
	
	$address1='';
	$address2='';
	$city='';
	$state='';
	$zip='';
	
	$addressChunks = explode(",", $geo_address);
	
	if (!empty($addressChunks[2])) {
		$address1=trim($addressChunks[0]);
		
		if(empty($addressChunks[3])) { /* No address2 */
			$city=trim($addressChunks[1]);
			$statezip=trim($addressChunks[2]);
			$statezipChunk = explode(" ", $statezip);
			if(!empty($statezipChunk[0])) {
				$state = trim($statezipChunk[0]);
			}
			if(!empty($statezipChunk[1])) {
				$zip = trim($statezipChunk[1]);
			}
		} else { /* With address2 */
			$address2=trim($addressChunks[1]);
			$city=trim($addressChunks[2]);
			$statezip=trim($addressChunks[3]);
			$statezipChunk = explode(" ", $statezip);
			if(!empty($statezipChunk[0])) {
				$state = trim($statezipChunk[0]);
			}
			if(!empty($statezipChunk[1])) {
				$zip = trim($statezipChunk[1]);
			}
		}
	} else {
		$address1 = $geo_address;
	}
	

	
	
/*
	
	$sql3="SELECT name FROM wp_term_relationships INNER JOIN wp_terms ON wp_term_relationships.term_taxonomy_id = wp_terms.term_id WHERE object_id=".$row['ID'];
	$sqlexec3 = mysql_query($sql3);
	$category="";
	if (mysql_numrows($sqlexec3) != 0) {
		$catcount=1;
		while ($row3 = mysql_fetch_array($sqlexec3)) {
			if($catcount!=1) {
				$category.="|";
			}
			$catcount++;
			$category .= $row3['name'];
		}
	} 
*/
	
	$currentline = "$ID,\"$category\",\"$post_title\",\"$post_image\",\"$post_date\",\"$post_modified\",\"$post_content\",\"$post_excerpt\",\"$address1\",\"$address2\",\"$city\",\"$state\",\"$zip\",\"$contact\",\"$email\",\"$website\",\"$twitter\",\"$facebook\",\"$timing\",\"$alive_days\",\"$special_offer\"";
	
	$currentline = preg_replace(array('/\r/', '/\n/'), '', $currentline);
	$csvoutput .= $currentline . "\r\n";
	echo $currentline.'<br>';
	}
}
$myFile = "calendarexport.csv";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, $csvoutput);
fclose($fh);

?>

Download File: <?php echo '<a href="calendarexport.csv">calendarexport.csv</a>'; ?>
<br><br>
Right click on filename above and "Save Link As..."

