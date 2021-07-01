<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["story_id"])){
				
				 $story_id = $_GET["story_id"];
				
	 
				 $stmt = $con->prepare("SELECT * FROM comments WHERE story_id = ?");
				 $stmt->bind_param("i", $story_id);
				 $stmt->execute();
				
				$comments = array();
					$result = $stmt->get_result();
						while ($row = $result->fetch_array(MYSQLI_ASSOC))
						{
							$comments[] = $row;
							
					
						}
						
                     $response['error'] = false;						
					 $response['comments'] = $comments ; 
					 $stmt->close();
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>