<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["following_ids"]) && isset($_GET["limit"]) && isset($_GET["offset"])){
				
				 $ids = $_GET["following_ids"];
				$limit = $_GET['limit'];
				$offset = $_GET['offset'];
	 
	             $all_ids = join("','",$ids);
				 $stmt = $con->prepare("SELECT * FROM stories WHERE user_id in ($all_ids) limit $limit offset $offset");
				 $stmt->execute();
				
				$stories = array();
					$result = $stmt->get_result();
						while ($row = $result->fetch_array(MYSQLI_ASSOC))
						{
							$stories[] = $row;
							
					
						}
						
                     $response['error'] = false;						
					 $response['stories'] = $stories ; 
					 $stmt->close();
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>