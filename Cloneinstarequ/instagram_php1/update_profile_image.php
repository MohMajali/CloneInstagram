<?php 
 
 require_once 'connection.php';
 
 $response = array();
 $path = 'users_images/';
 
 
 if(isset($_POST['image_name']) && isset($_POST['image_encoded'])  && isset($_POST['user_id'])){
	 
	 $image_encoded = $_POST['image_encoded'];
	 $image_name = $_POST['image_name'];
	 $user_id = $_POST['user_id'];
	
	 
	 
	 //move image to server folder
	 file_put_contents($path.$image_name.".jpg",base64_decode($image_encoded));
	 
	 //form image url
	 $image_url = "https://abulsamrie11.000webhostapp.com/users_images/".$image_name.".jpg";
	 
	 
	 $query = $con->prepare("UPDATE users SET image = ? WHERE id = ?");
	
	
	//binding parameters 
	$query->bind_param("si",$image_url,$user_id);
	
		
						if($query->execute()){
							
							$response['error'] = false;
							$response['message'] = 'Image uploaded Successfully';
							$response['image'] = $image_url;
							
						
						
						}else{
							$response['error'] = true;
							$response['message'] = 'Failed to upload image to database';
							
						}
	 
	 
	 
 }else{
	 
	 $response['error'] = true;
     $response['message']= 'not all parameters are set'; 
	 
 }
 
 echo json_encode($response);