<?php 

        include('connection.php');
        $fname = $_POST['firstname'];
		$lname = $_POST['lastname'];
		$email = $_POST['email'];

           // Insert User Detail

           $sql = "INSERT INTO users (firstname,lastname,email,created,modified) VALUES ('$fname','$lname','$email',NOW(),NOW())";  
           $insert = mysqli_query($conn,$sql);
           

           if($insert)
            {
                // When Insert user detail then update image tabel 
                
                $update = "UPDATE images SET status = 1 WHERE status <> '1' ORDER BY RAND() LIMIT 1 ";  
                $class = mysqli_query($conn,$update);
                if($class)
                {
                    $response = array("message"=>"success");
                    echo json_encode($response);
                }
                else
                {
                    echo "Error: " . $update . "<br>" . mysqli_error($conn);
                    exit;       
                }   
                
            }
            else
            {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              exit;
            }    
        // }    




		
	// }
?>    