<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["story_ids"])){
				
				 $ids = $_GET["story_ids"];
				
	 
	             $all_ids = join("','",$ids);
				 $stmt = $con->prepare("SELECT * FROM stories WHERE id in ($all_ids)");
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