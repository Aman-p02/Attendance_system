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
    
    
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          
        <form action="#" class="sign-in-form">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" for = "username" id="username" name="username" placeholder="Username" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" for = "passwords" id="passwords" name="passwords" placeholder="Password" />
            </div>
            <input type="button" value="Login" class="btn solid" onclick="checkCredentials()" />
                    <script>
                        function checkCredentials() {
    var username = document.querySelector(".sign-in-form input[name='username']").value;
    var password = document.querySelector(".sign-in-form input[name='passwords']").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "check_credentials.php", true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var response = xhr.responseText;

                if (response.trim() === "success") {
                    // Redirect to index.php and pass username as a parameter
                    window.location.href = "index.php?username=" + username;
                } else {
                    handleLoginError("Wrong username or password");
                }
            } else {
                handleLoginError("Error communicating with the server");
            }
        }
    };

    // Send both username and password in the request
    xhr.send("username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password));
}

function handleLoginError(errorMessage) {
    var errorElement = document.querySelector(".error-message");

    if (!errorElement) {
        errorElement = document.createElement("p");
        errorElement.className = "error-message";
        errorElement.style.color = "red";
        document.querySelector(".sign-in-form").appendChild(errorElement);
    }

    errorElement.innerHTML = errorMessage;
}

                    </script>
          </form>
          
          
          <form action="#" class="sign-up-form">
            <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" for = "teacherName" id="teacherName" name="teacherName" placeholder="Name" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" for = "username" id="username" name="username" placeholder="Username" required/>
            </div>

            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" for = "teacherSub" id="teacherSub" name="teacherSub" placeholder="Subject" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" for = "teacherSub1" id="teacherSub1" name="teacherSub1" placeholder="One More Subject(Optional)"/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" pfor = "passwords" id="passwords" name="passwords" placeholder="Create Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />
            </div>
            <div class="input-field">
              <i class="fas fa-key"></i>
              <input type="password" for="secretCode" id="secretCode" name="secretCode" placeholder="Secret Code" required />
            </div>
            <input type="submit" class="btn" onclick="createData(event)" value="Sign up" />
<script>
    function createData(event) {
        event.preventDefault();  // Prevent the form from submitting

        var teacherName = document.querySelector(".sign-up-form input[name='teacherName']").value;
        var username = document.querySelector(".sign-up-form input[name='username']").value;

        var teacherSub = document.querySelector(".sign-up-form input[name='teacherSub']").value;
        var teacherSub1 = document.querySelector(".sign-up-form input[name='teacherSub1']").value;
        var passwords = document.querySelector(".sign-up-form input[name='passwords']").value;
        var secretCode = document.querySelector(".sign-up-form input[name='secretCode']").value;

        // Validate secret code on client side
        if (secretCode !== '016') {
            var existing = document.querySelector(".sign-up-form .error-message");
            if (existing) existing.remove();
            var errorMessage = document.createElement("p");
            errorMessage.className = "error-message";
            errorMessage.innerHTML = "Invalid Secret Code! Contact admin for the correct code.";
            errorMessage.style.color = "red";
            document.querySelector(".sign-up-form").appendChild(errorMessage);
            return;
        }

        var xhr1 = new XMLHttpRequest();
        xhr1.open("POST", "register.php", true);

        xhr1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr1.onreadystatechange = function () {
            if (xhr1.readyState == 4) {
                if (xhr1.status == 200) {
                    var response = xhr1.responseText;

                    if (response.trim() === "success") {
                        var successMessage = document.createElement("p");
                        successMessage.innerHTML = "Created Successfully";
                        successMessage.style.color = "green";
                        document.querySelector(".sign-up-form").appendChild(successMessage);
                    } else if (response.trim() === "invalid_secret") {
                        var errorMessage = document.createElement("p");
                        errorMessage.innerHTML = "Invalid Secret Code!";
                        errorMessage.style.color = "red";
                        document.querySelector(".sign-up-form").appendChild(errorMessage);
                    } else {
                        var errorMessage = document.createElement("p");
                        errorMessage.innerHTML = "Failed to create user";
                        errorMessage.style.color = "red";
                        document.querySelector(".sign-up-form").appendChild(errorMessage);
                    }
                } else {
                    console.error("Error: " + xhr1.status);
                }
            }
        };

        // Send data including secret code
        xhr1.send("teacherName=" + teacherName + "&username=" + username + "&teacherSub=" + teacherSub + "&teacherSub1=" + teacherSub1 + "&passwords=" + passwords + "&secretCode=" + secretCode);

    }
</script>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
            Unlocking knowledge, one login at a time. Welcome to the gateway of education for our new teachers! 
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="img/log.png" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
            Step into the world of education with a click. Sign in to your teaching journey and empower minds!
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="img/register.png" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="app.js"></script>
  </body>
</html>
