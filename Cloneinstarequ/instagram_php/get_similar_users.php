<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["text"])){
				
				 $text = $_GET["text"];
				 $new_text = $text.'%';
			
				 $stmt = $con->prepare("SELECT * FROM users WHERE username LIKE ?");
				 $stmt->bind_param("s",$new_text);
				 $stmt->execute();
				
				$users = array();
					$result = $stmt->get_result();
						while ($row = $result->fetch_array(MYSQLI_ASSOC))
						{
							$users[] = $row;
							
					
						}
						
                     $response['error'] = false;					 
					 $response['users'] = $users; 
					 $stmt->close();
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>