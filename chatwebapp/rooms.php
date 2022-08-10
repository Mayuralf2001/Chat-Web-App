<?php
//Get parameters
$roomname = $_GET['roomname'];

//Connecting to the database
include 'db_connect.php';

//Execute sql to check whether room exits
$sql = "SELECT * FROM `rooms` WHERE roomname = '$roomname'";

$result = mysqli_query($conn, $sql);
if($result)
    {
        //Check if room exits
        if(mysqli_num_rows($result) ==0)
        {
            $message = "This room does not exist. Try creating a new room.";
            echo '<script language="javascript">';
            echo 'alert("'.$message.'");';
            echo 'window.location="http://localhost:90/chatwebapp";';
            echo '</script>';
        }

    }
else
{
    echo "Error :". mysqli_error($conn);
}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap core CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<!-- Custom styles for this template -->
<link href="css/product.css" rel="stylesheet">
<style>
body {
  margin: 0 auto;
  max-width: 800px;
  padding: 0 20px;
}

.container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

.darker {
  border-color: #ccc;
  background-color: #ddd;
}

.container::after {
  content: "";
  clear: both;
  display: table;
}

.container img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

.container img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #aaa;
}

.time-left {
  float: left;
  color: #999;
}

.anyClass{
    height: 350px;
    overflow-y: scroll;
}
</style>
</head>
<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h5 class="my-0 mr-md-auto font-weight-normal">Chat Web App</h5>
        <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
        <a class="me-3 py-2 text-dark text-decoration-none" href="#">Home</a>
        <a class="me-3 py-2 text-dark text-decoration-none" href="#">About</a>
        <a class="me-3 py-2 text-dark text-decoration-none" href="#">Contact</a>
      </nav>
    </div>

<h2>Chat Messages - <?php echo $roomname; ?></h2>

<div class="container">
    <div class="anyClass"> 
    </div>
</div>

<input type="text" class="form-control" name="usermsg" id="usermsg" placeholder="Add message"><br>
<button class="btn btn-secondary" name="submitmsg" id="submitmsg">Send</button>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
//Check for new msg every one second
setInterval(runFunction, 1000);
function runFunction()
{
    $.post("htcont.php",{room: '<?php echo $roomname ?>'},
    function(data, status)
    {
        document.getElementsByClassName('anyClass')[0].innerHTML = data;

    }
    )
}
        // Using Enter key to submit
        var input = document.getElementById("usermsg");
        input.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                
                document.getElementById("submitmsg").click();
            }
        });

        //If user submits the form
        
        $("#submitmsg").click(function(){
            var clientmsg = $("#usermsg").val();
        $.post("postmsg.php", {text: clientmsg, room:'<?php echo $roomname ?>', ip:'<?php echo $_SERVER['REMOTE_ADDR'] ?>'}),
        function(data, status){
            document.getElementsByClassName('anyClass')[0].innerHTML = data;}
            $("#usermsg").val("");
        return false;
        });
    </script>
</body>
</html>