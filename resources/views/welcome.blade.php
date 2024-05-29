<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="alert alert-danger" id="error" style="display: none;"></div>
    <div class="card">
        <div class="card-header">
            Enter Phone Number
        </div>
        <div class="card-body">
            <div class="alert alert-success" id="sentSuccess" style="display: none;"></div>
            <form>
                <label for="number">Phone Number:</label>
                <input type="text" id="number" class="form-control" placeholder="+91 9876543210"><br>
                <div id="recaptcha-container"></div><br>
                <button type="button" class="btn btn-success" onclick="sendCode();">Send Code</button>
            </form>
        </div>
    </div>

    <div class="card" style="margin-top: 10px">
        <div class="card-header">
            Enter Verification code
        </div>
        <div class="card-body">
            <div class="alert alert-success" id="successRegister" style="display: none;"></div>
            <form>
                <label for="verificationCode">Verification Code:</label>
                <input type="text" id="verificationCode" class="form-control" placeholder="Enter Verification Code"><br>
                <button type="button" class="btn btn-success" onclick="verifyCode();">Verify Code</button>
            </form>
        </div>
    </div>
</div>

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyDJNIRybUbppceXoAu-0fPp2k5yIFjvH5Y",
        authDomain: "roshosh-438ce.firebaseapp.com",
        databaseURL: "XXXX.firebaseio.com",
        projectId: "roshosh-438ce",
        storageBucket: "roshosh-438ce.appspot.com",
        messagingSenderId: "331295159296",
        appId: "1:331295159296:web:7331bcdd5d8dfd1a0714e5",
        measurementId: "G-D8BM66CWBZ"
    };

    firebase.initializeApp(firebaseConfig);

    window.onload = function () {
        render();
    };

    function render() {
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            'size': 'invisible',
            'callback': function (response) {
                // reCAPTCHA solved, allow sendCode
                sendCode();
            }
        });
        recaptchaVerifier.render();
    }

    function sendCode() {
        var number = $("#number").val();

        firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
            window.confirmationResult = confirmationResult;

            $("#sentSuccess").text("Message Sent Successfully.");
            $("#sentSuccess").show();
        }).catch(function (error) {
            $("#error").text(error.message);
            $("#error").show();
        });
    }

    function verifyCode() {
        var code = $("#verificationCode").val();

        window.confirmationResult.confirm(code).then(function (result) {
            var user = result.user;

            $("#successRegister").text("You Are Registered Successfully.");
            $("#successRegister").show();
        }).catch(function (error) {
            $("#error").text(error.message);
            $("#error").show();
        });
    }
</script>
</body>
</html>
