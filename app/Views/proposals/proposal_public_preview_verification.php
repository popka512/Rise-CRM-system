<!DOCTYPE html>
<html lang="en">
<head>
<?php echo view('includes/head'); ?>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    
   
</head>
<body>

    <h1>Phone Verification</h1>

    <!-- Phone number form -->
    <div id="phone_form">
        <input type="text" id="phone" placeholder="Enter your phone number" required>
        <!-- <button onclick="sendOTP()">Send OTP</button> -->
        <?php echo modal_anchor(get_uri("phoneverification/send_otp"), "<i data-feather='check-circle' class='icon-16'></i> " . app_lang('accept'), array("class" => "btn btn-success mr5", "title" => app_lang('accept_proposal'))); ?>
    </div>

    <!-- OTP verification form -->
    <div id="otp_form" style="display:none;">
        <input type="text" id="otp" placeholder="Enter the OTP" required>
        <button onclick="verifyOTP()">Verify OTP</button>
    </div>
    <script>
        function sendOTP() {
            var phone = document.getElementById('phone').value;
            console.log(phone)
            fetch('/phoneverification/send_otp', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ phone_number: phone })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    alert(data.message);
                    document.getElementById('otp_form').style.display = 'block';
                } else {
                    alert(data.message);
                }
            });
        }

        function verifyOTP() {
            var otp = document.getElementById('otp').value;

            fetch('/phoneverification/verify_otp', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ otp: otp })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status) {
                    // Redirect to proposal page
                    window.location.href = "/proposal-page";
                }
            });
        }
    </script>

</body>
</html>