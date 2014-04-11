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
$result = mysql_query("select * from wp_postmeta where meta_key='end_time' and (meta_value like '%PM:%' or meta_value like '%AM:%')");

//fetch tha data from the database 
while ($row = mysql_fetch_array($result)) {
   $meta_id = $row['meta_id'];
   $post_id = $row['post_id'];
   $meta_value = $row['meta_value'];
   $oldtime = $meta_value;
   $oldtime = str_ireplace("AM:", "AM", $oldtime);
   $oldtime = str_ireplace("PM:", "PM", $oldtime);
   $newtime = ( date("H:i:s", strtotime($oldtime)) );
   
   
   echo "meta_id: $meta_id<br>";
   echo "post_id: $post_id<br>";
   echo "oldtime: $oldtime<br>";
   echo "new time: $newtime<br>";

   $sql = "update wp_postmeta set meta_value='$newtime' where meta_id=$meta_id";
   $result3 = mysql_query($sql);
   echo "$sql<hr>";
  
	    


   
      
}
//close the connection
mysql_close($dbhandle);

?>