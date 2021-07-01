<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["id"])){
				
				 $id = $_GET["id"];
				
			
				 $stmt = $con->prepare("SELECT * FROM images WHERE user_id = ?");
				 $stmt->bind_param("i",$id);
				 $stmt->execute();
				
				$images = array();
					$result = $stmt->get_result();
						while ($row = $result->fetch_array(MYSQLI_ASSOC))
						{
							$images[] = $row;
							
					
						}
						
                     $response['error'] = false;					 
					 $response['images'] = $images; 
					 $stmt->close();
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>