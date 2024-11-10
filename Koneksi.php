<?php 

$serverName = "DESKTOP-L75SO4G"; //Nama server dapat dilihat di ssms.
$connectionInfo = array( "Database"=>"PBLBebasTanggungan");  
  
/* Connect using Windows Authentication. */  
$conn = sqlsrv_connect( $serverName, $connectionInfo);  
if( $conn === false )  
{  
     echo "Unable to connect.</br>";  
     die( print_r( sqlsrv_errors(), true));  
}  

?>