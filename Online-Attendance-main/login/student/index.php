<?php
session_start();
?>

<html lang="en">

<head>
    <script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('sw.js')
        .then(reg => console.log('SW registered', reg.scope))
        .catch(err => console.error('SW registration failed', err));
    });
  }
</script>
    <meta name="theme-color" content="#4481eb">
    <link rel="icon" type="image/svg+xml" href="img/smartattend_logo.svg?v=4">
    <link rel="manifest" href="manifest.json">
    <link rel="icon" type="image/svg+xml" href="../../img/smartattend_logo.svg?v=4">
    
    
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Student | Home Page</title>

    <style>
.redTick{
    display : none;
}
.combo {
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
}
.combo:after {
    content: '\25BC';
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
}
.combo option {
    padding: 10px;
    font-size: 14px;
    background-color: #fff;
    color: #333;
}
.combo option:hover {
    background-color: #f5f5f5;
}

.img-tick{
    height:100%;
    width:100%;
    border-radius: 300px 300px 300px 300px;
}
.green-tick-div{
    height: 35px;
    width: 35px;
    border-radius: 300px 300px 300px 300px;
    margin-top: 0px;
}
    </style>

</head>

<body>

    <div class="container" id="container">

    <?php 
    require_once '../supabaseConn.php';

    $rollno = $_SESSION['username'];

    $stmt = $pdo->prepare("SELECT * FROM \"allStudent\" WHERE \"rollno\" = ?");
    $stmt->execute([$rollno]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $rollno = $row['rollno'];
        $studentName = $row['studentName'];
    } else {
        $error_message = "Invalid roll number or password. Please try again.";
    }
    ?>
        
            <form action="" method="POST">
                <h1>Hello <?php echo htmlspecialchars($studentName);?>  </h1>
                <br>
                
                <input type="text" name="otp" onClick="startTimerAndPerformAction()" placeholder="OTP" style="width: auto; height: auto;" >
                
                <div><h1 id="timer" style="color: red; font-size: 200%;">00:10</h1></div>

<script>
    let timer;
    let timerDisplay = document.getElementById('timer');
    let timerValue;

    function startTimer(duration) {
        timerValue = 10;
        updateTimerDisplay();
        timer = setInterval(function () {
            timerValue--;
            updateTimerDisplay();
            if (timerValue <= 0) {
                clearInterval(timer);
                window.location.href = 'login.php';
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        let minutes = Math.floor(timerValue / 60);
        let seconds = timerValue % 60;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        timerDisplay.textContent = minutes + ":" + seconds;
    }

    function startTimerAndPerformAction() {
        timerValue = 10;
        startTimer(timerValue);
    }
</script>
                
                <script>
          function logout() {
            fetch('logout.php', {
                    method: 'GET',
                })
                .then(response => response.text())
                .then(data => {
                    window.location.href = 'login.php';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        </script>

               
                <button type="submit"">Present</button>
                
                <button onclick="logout()" type="submit" style="background-color: red;">Log Out</button>
                
                <h1><?php 
                
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp'])) {
                    $enteredOTP = trim($_POST['otp']);

                    // Reject empty or trivially short OTP
                    if (empty($enteredOTP)) {
                        ?>
                        <img class="img-tick green-tick-div redTick" id="red-tick" src="Wrong-tick.png" alt="not found">
                        <h3 class="redTick" style="color: red" id="red-tick">Please enter an OTP.</h3>
                        <?php
                    } else {
                    // Find teacher with matching OTP
                    $stmtOtp = $pdo->prepare("SELECT * FROM \"allTeacher\" WHERE \"otp\" = ? AND \"otp\" IS NOT NULL AND \"otp\" != ''");
                    $stmtOtp->execute([$enteredOTP]);
                    $otpRow = $stmtOtp->fetch(PDO::FETCH_ASSOC);

                    if ($otpRow) {
                        $storedOTP = $otpRow['otp'];
                        $teach = $otpRow['username'];
                        $teacherName = $otpRow['username'].'d';

                        if ($enteredOTP == $storedOTP) {
                            // Insert student into attendance table
                            try {
                                $stmtInsert = $pdo->prepare("INSERT INTO \"$teacherName\" (\"rollno\", \"studentName\") VALUES (?, ?)");
                                $stmtInsert->execute([$rollno, $studentName]);
                                ?>
                                <img class="img-tick green-tick-div" src="Tick-icon.jpg" alt="not found">
                                <h3 style="color: green"><?php
                                    // Get subject
                                    $stmtSub = $pdo->prepare("SELECT \"teacherSub\" FROM \"allTeacher\" WHERE \"username\" = ?");
                                    $stmtSub->execute([$teach]);
                                    $subRow = $stmtSub->fetch(PDO::FETCH_ASSOC);
                                    if ($subRow) {
                                        echo "You are Present in " . htmlspecialchars($subRow['teacherSub']) . " Subject";
                                    }
                                ?></h3>
                                <?php
                            } catch (PDOException $e) {
                                ?>
                                <img class="img-tick green-tick-div redTick" id="red-tick" src="Wrong-tick.png" alt="not found">
                                <h3 class="redTick" style="color: red" id="red-tick">Already marked or error occurred.</h3>
                                <?php
                            }
                        }
                    } else {
                        ?>
                        <img class="img-tick green-tick-div redTick" id="red-tick" src="Wrong-tick.png" alt="not found">
                        <h3 class="redTick" style="color: red" id="red-tick">Invalid OTP. Please try again.</h3>
                        <?php
                    }
                    } // end of else (non-empty OTP)
                }
                ?></h1>

            </form>
      
    </div>
   
    
</body>

</html>
