<?php 
 
 require_once 'connection.php';
 
 $response = array();
 
 if(isset($_GET["user_id"])){
				
				 $id = $_GET["user_id"];
				
	 
				 $stmt = $con->prepare("SELECT other_user_id FROM following WHERE user_id = ? ");
				 $stmt->bind_param("i", $id);
				 $stmt->execute();
				
				$ids = array();
					$result = $stmt->get_result();
						while ($row = $result->fetch_array(MYSQLI_NUM))
						{
							foreach ($row as $r)
							{
								$ids[] = $r;
							}
					
						}
						
                     $response['error'] = false;						
					 $response['ids'] = $ids ; 
					 $stmt->close();
	
 
 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
 }
 
 
 
  
 echo json_encode($response);
 

 
 
 ?>