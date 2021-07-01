<?php 
 
 require_once 'connection.php';
 
 $response = array();
 $path = 'story_images/';
 
 
 if(isset($_POST['image_name']) && isset($_POST['image_encoded'])  && isset($_POST['user_id']) 
	   && isset($_POST['title'])  && isset($_POST['time']) 
     && isset($_POST['username'])  && isset($_POST['profile_image'])){
	 
	 $image_encoded = $_POST['image_encoded'];
	 $image_name = $_POST['image_name']; 
	 $user_id = $_POST['user_id'];
	 $title = $_POST['title'];
	 $time = $_POST['time'];
	 $username = $_POST['username'];
	 $profile_image =$_POST['profile_image'];
	 
	 
	 //move image to server folder
	 file_put_contents($path.$image_name.".jpg",base64_decode($image_encoded));
	 
	 //form image url
	 $image_url = "http://mifo.000webhostapp.com/story_images/".$image_name.".jpg";
	 
	 
	 //prepering two queries
	 $query1 = $con->prepare("INSERT into images (image_name,image_url,user_id)  VALUES (?,?,?)");
	 $query2 = $con->prepare("INSERT into stories (user_id,image_url,title,time,username,profile_image,image_name)  VALUES (?,?,?,?,?,?,?)");
	
	
	//binding parameters to two queries
	$query1->bind_param("ssi",$title,$image_url,$user_id);
	$query2->bind_param("issssss",$user_id,$image_url,$title,$time,$username,$profile_image,$image_name);
			
			//first query execution
						if($query1->execute()){
							
							$response['error'] = false;
							$response['message'] = 'Image uploaded Successfully';
							
						
						//second query execution
								if($query2->execute()){
									$response['error'] = false;
									$response['message'] = 'Story Published Successfully';
									
									
								}else{
									
										$response['error'] = true;
						             	$response['message'] = 'Failed to add to stories database';
									
								}

						
						}else{
							$response['error'] = true;
							$response['message'] = 'Failed to add to images database';
							
						}
	 
	 
	 
 }else{
	 
	 $response['error'] = true;
     $response['message']= 'not all parameters are set'; 
	 
 }
 
 echo json_encode($response);
 
 
 
 ?>