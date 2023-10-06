<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-container {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
            overflow: auto;
        }

        .popup-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            width: 80%;
            max-width: 400px;
            border-radius: 5px;
            position: relative;
        }

        .close-popup {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <form id="registrationForm">
        <h2>Registration Form</h2>
        <div class="input-container">
            <input type="text" id="fullname" name="fullname" placeholder="Full Name">
        </div>
        <div class="input-container">
            <input type="text" id="username" name="username" placeholder="Username">
        </div>
        <div class="input-container">
            <input type="text" id="mobile" name="mobile" placeholder="Mobile Number">
        </div>
        <div class="input-container">
            <input type="email" id="email" name="email" placeholder="Email">
        </div>
        <div class="input-container">
            <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <div class="input-container">
            <button type="submit" id="registerButton">Register</button>
        </div>
    </form>

    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close-popup" id="closePopup">&times;</span>
            <div id="popupMessage"></div>
        </div>
    </div>

    
    <script>
        $(document).ready(function() {
            // Function to show the popup with a message
            function showPopup(message) {
                $("#popupMessage").html(message);
                $("#popup").css("display", "block");
            }

            // Close the popup when the close button is clicked
            $("#closePopup").click(function() {
                $("#popup").css("display", "none");
            });

            // Registration form validation
            $("#registerButton").click(function() {
                var fullname = $("#fullname").val();
                var username = $("#username").val();
                var mobile = $("#mobile").val();
                var email = $("#email").val();
                var password = $("#password").val();

                // Check for empty fields
                if (!fullname || !username || !mobile || !email || !password) {
                    showPopup("Please fill in all fields.");
                    return;
                }

                // Validate fullname
                if (!/\s/.test(fullname)) {
                    showPopup("Full name must contain at least one space.");
                    return;
                }
                if (/\d|\W/.test(fullname)) {
                    showPopup("Full name must not contain digits or special characters.");
                    return;
                }

                // Validate username
                if (/[A-Z]/.test(username)) {
                    showPopup("Username must not contain capital letters.");
                    return;
                }
                if (username.length < 5) {
                    showPopup("Username must contain at least 5 characters.");
                    return;
                }

                // Validate mobile number
                if (!/^\d{10}$/.test(mobile)) {
                    showPopup("Mobile number must contain exactly 10 digits.");
                    return;
                }
                if (/^[0-5]/.test(mobile)) {
                    showPopup("Invalid mobile number format.");
                    return;
                }

                // Validate email
                if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email) || /[A-Z]/.test(email)) {
                    showPopup("Invalid email format.");
                    return;
                }

                // Validate password
                if (password.length <= 5) {
                    showPopup("Password must contain at least 5 characters.");
                    return;
                }
                if (!/[A-Z]/.test(password)) {
                    showPopup("Password must contain at least one capital letter.");
                    return;
                }
                // if (!/[!@#$%^&*()_+{}\[\]:;<>,.?~\\-=|]/.test(password)) {
                //     showPopup("Password must contain at least one special character.");
                //     return;
                // }
                if (!/\d/.test(password)) {
                    showPopup("Password must contain at least one digit.");
                    return;
                }

                // If all validations pass, you can submit the form here
                //$("#registrationForm").submit();

                // For demonstration purposes, we'll just show a success message
                showPopup("Registration successful!");
            });
        });
    </script>
</body>

</html>