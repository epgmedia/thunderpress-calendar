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
$result = mysql_query("select meta_id,meta_value from wp_postmeta where (meta_key = 'st_date' AND meta_value <> '') OR (meta_key = 'end_date' AND meta_value <> '')");

//fetch tha data from the database 
while ($row = mysql_fetch_array($result)) {
   $meta_id = $row['meta_id'];
   $meta_value = $row['meta_value'];
   
   $old_date_timestamp = strtotime($meta_value);
   $new_date = date('Y-m-d', $old_date_timestamp); 
   
   $sql = "update wp_postmeta set meta_value='$new_date' where meta_id=$meta_id";
   
   $result2 = mysql_query($sql);
   
   echo "$sql<br>";
   
}
//close the connection
mysql_close($dbhandle);

?>