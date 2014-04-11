<?php




$username = "646900_calendar";
$password = "zumaha3rEbre";
$hostname = "mysql50-114.wc2.dfw1.stabletransit.com"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
 or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("646900_calendar",$dbhandle) 
  or die("Could not select examples");

//execute the SQL query and return records
$result = mysql_query("
select meta_id,post_id,meta_value 
from wp_postmeta 
where	meta_key = 'st_time' AND meta_value <> '' and meta_value <> '?' and 
		post_id in (select post_id from wp_postmeta where meta_key = 'event_type' AND meta_value = ' Recurring event')
order by post_id
");

//fetch tha data from the database 
while ($row = mysql_fetch_array($result)) {
   $meta_id = $row['meta_id'];
   $post_id = $row['post_id'];
   $meta_value = $row['meta_value'];

   $timeChunks = explode(":", $meta_value);
   $hour = $timeChunks[0];

   if (is_numeric($hour)) {
	   $hour = $hour + 3;
	   if ($hour <= 9) {
		   $hour = "0" . $hour;
	   }
	   $newtime = $hour . ':' . $timeChunks[1] . ':' . $timeChunks[2];
   }
   
   echo "meta_id: $meta_id<br>";
   echo "post_id: $post_id<br>";
   echo "meta_value: $meta_value<br>";
   echo "new hour: $hour<br>";
   echo "new time: $newtime<br>";
	   

   $result2 = mysql_query("select meta_id,post_id,meta_value from wp_postmeta where meta_key = 'end_time' and post_id=$post_id");

   if (mysql_num_rows($result2)>0) {
	   
	   while ($row2 = mysql_fetch_array($result2)) {
		   $meta_id2 = $row2['meta_id'];
		   $meta_value2 = $row2['meta_value'];
		   
		   if(empty($meta_value2)) {
			   $sql = "update wp_postmeta set meta_value='$newtime' where meta_id=$meta_id2";
			   $result3 = mysql_query($sql);
			   echo "$sql<hr>";
			   }
		   
	   }
	   
	} else {
		$sql = "insert into wp_postmeta (post_id,meta_key,meta_value) values ('$post_id','end_time','$newtime')";
		$result3 = mysql_query($sql);
		echo "$sql<hr>";
		
		
	}
   


   
      
}
//close the connection
mysql_close($dbhandle);

?>