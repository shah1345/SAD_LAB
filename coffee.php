<?php


include "../../config.php";


    	$sql = "SELECT * FROM `Coffee` WHERE `Name`=''";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		
		$UUID = $row['UUID'];
		
	
		
	}

if($_SERVER["REQUEST_METHOD"] == "POST") {

	$Name = $_POST['Name'];
	$Phone = $_POST['Phone'];
	$UUID = $_POST['uiuId'];
	
	
	$Type = $_POST['flexRadioDefault'];
	
		$sql = 	"UPDATE `Coffee` SET `Name`='$Name',`Phone`='$Phone',`Type`='$Type' WHERE UUID = '$UUID'";

	  


if ($conn->query($sql) === TRUE) {
	//echo "Success";
        
   	echo "<script>alert('Success.')</script>";
    
	} else {
		echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
	}
}





?>



<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SHAH X Coffee</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

        <style>
            body {
                background-image: url(bg.jpg);
                background-repeat: no-repeat;
                background-size: cover;
            }

            #totalContainer {
                height: 100vh;
                width: 100%;
                background-color: rgba(255, 255, 255, 0.226);
            }

            #form {
                width: 30%;
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);

                color: white;
                padding: 1rem;
                background-color: rgba(128, 128, 128, 0.811);
                border-radius: 8px;
                box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.466);
            }

            @media (max-width: 640px) {
                #form {
                    width: 90%;
                }
            }
        </style>
    </head>

    <body>
        <section id="totalContainer">
            <form method="POST" action="" id="form">
                <div class="mb-3">
                    <label for="inputName" class="form-label">Your Name</label>
                    <input type="text" class="form-control" name="Name" id="inputName" aria-describedby="">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Phone number</label>
                    <input type="number" class="form-control" id="Phone" name="Phone" aria-describedby="">
                </div>

                <div class="mb-3">
                    <label for="uiuId" class="form-label">Your UIU ID</label>
                    <input type="number" class="form-control" id="uiuId" name="uiuId" aria-describedby=""  value = <?php echo $UUID;?> readonly>
                </div>

                <div>
                    <label for="">Choose Your Accocunt type</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="Faculty" type="radio" name="flexRadioDefault"  id="flexRadioDefault1" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Faculty
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Student" name="flexRadioDefault" id="flexRadioDefault2">
                    <label class="form-check-label" for="flexRadioDefault2">
                        Student
                    </label>
                </div>
                <div style="width: fit-content; margin: 0.5rem auto;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>
    </body>

</html>
