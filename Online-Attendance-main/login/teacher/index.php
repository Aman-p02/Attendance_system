

<!DOCTYPE html>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <title>Teacher | Dashboard</title>
    <link rel="stylesheet" href="indexCSS.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>

    <div class="container" id="container">
    <?php

    require_once '../supabaseConn.php';

    $tearcherUser = $_GET['username'];

    $stmt = $pdo->prepare("SELECT * FROM \"allTeacher\" WHERE \"username\" = ?");
    $stmt->execute([$tearcherUser]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $teacherName = $row['teacherName'];
    } else {
        $error_message = "Invalid username.";
    }

    $dbName = $_GET['username'];
    ?>
        <div class="wrapper" style="text-align: center;">
            <header>Hello <?php echo $teacherName; ?></header><br>

            <div style="margin-top: 50px;">

            <header style="color: green; font-size:300%;" id="generatedOtp"></header><br>
            <select id="subject" name="subject" style="border-radius: 8px; height:40px; width:200px;">
        <?php
            // Fetch subjects for this teacher from their personal table
            $stmtSub = $pdo->prepare("SELECT \"teacherSub\" FROM \"$dbName\"");
            $stmtSub->execute();
            while ($subRow = $stmtSub->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($subRow['teacherSub'])) {
                    echo "<option value='" . htmlspecialchars($subRow['teacherSub']) . "'>" . htmlspecialchars($subRow['teacherSub']) . "</option>";
                }
            }
        ?>
    </select><br>
                <button onclick="generateAndSend('<?php echo $dbName; ?>'); startTimerAndPerformAction('<?php echo $dbName; ?>');" >Generate OTP</button>
                <script>
function generateAndSend(dbName) {
    var randomNo = Math.floor(1000 + Math.random() * 9000);
    var selectedOption = document.getElementById("subject").value;

    fetch('update.php?dbName=' + dbName, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'randomNo=' + randomNo + '&subject=' + encodeURIComponent(selectedOption),
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        document.getElementById('generatedOtp').innerText = randomNo;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
               
                    <div style="text-align: center;">
                        
                        <div ><h1 id="timer" style="color: red; font-size: 200%;">00:15</h1></div>

                        <script>
                          let timer;
        let timerDisplay = document.getElementById('timer');
        let timerValue;

        function startTimer(duration,dbName) {
            timerValue = duration;
            updateTimerDisplay();
            timer = setInterval(function() {
                timerValue--;
                updateTimerDisplay();
                if (timerValue <= 0) {
                    clearInterval(timer);
                    performAction(dbName);
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

        function startTimerAndPerformAction(dbName) {
            timerValue = 15;
            startTimer(timerValue,dbName);
        }

        function performAction(dbName) {
    var randomNo1 = '';
    location.reload();
    var db = dbName;
    fetch('updateOTP.php?dbName=' + db, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'randomNo=' + randomNo1,
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

</script>
<h2 style="color:green">
<?php
    // Count present students from the attendance table
    $attendTable = $tearcherUser.'d';
    try {
        $stmtCount = $pdo->prepare("SELECT COUNT(*) as total_rows FROM \"$attendTable\"");
        $stmtCount->execute();
        $countRow = $stmtCount->fetch(PDO::FETCH_ASSOC);
        $totalStud = $countRow['total_rows'];
        echo "Present Student " . $totalStud;
    } catch (PDOException $e) {
        // Table may not have any rows yet
    }
?>
</h2>
               

                    <?php 
                  error_reporting(E_ALL);
                  ini_set('display_errors', 1);
                  $dbUser = $_GET['username'];
                 
                  include 'generatepdf/submit.php';

                  $pdfFilename = $dbUser . '.pdf';

                  include 'deleterows.php'; 
                ?>
                    <button type="submit" onclick="logout()" style="background-color: red;"">Log Out</button>
                        
                    <button
            class="btn btn-color-2" 
            onclick=" window.open('./generatepdf/PDF/<?php echo $pdfFilename; ?>'); deleteAllRows(<?php echo $dbName.'d';?>);">
            Download PDF
          </button>

         

          

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

        function deleteAllRows(dbName) {
            window.location.href = 'deleterows.php?id=' + dbName;
        }

        </script>
        <script>
    console.log('<?php echo $dbName.'d';?>');
</script>


          </div>
          

          </div>
        
        
    </div>

    <script src="js/script.js"></script>
</body>

</html>