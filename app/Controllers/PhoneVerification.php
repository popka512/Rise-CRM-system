<?php
namespace App\Controllers;


class PhoneVerification extends Security_Controller {

    // Load the Twilio library
    public function __construct() {
        parent::__construct(false);
        // $this->load->library('session');
        // $this->load->helper('url');
        // $this->load->model('User_model'); // Assuming you have a model for user management
    }

    // Step 1: Send OTP
    public function send_otp() {
        $phone = $this->input->post('phone_number');
        
        // Validate phone number format
        if (empty($phone)) {
            echo json_encode(['status' => false, 'message' => 'Phone number is required.']);
            return;
        }
        // echo json_encode(['status' => true, 'message' => 'OTP sent successfully.']);
        // Generate OTP (e.g., 6 digits)
        $otp = rand(100000, 999999);

        // Save OTP in session or database temporarily
        $this->session->set_userdata('otp', $otp);
        $this->session->set_userdata('phone_number', $phone);

        // Twilio API Configuration (assuming you have set these in config file)
        $sid = getenv('TWILIO_SID');
        $token = getenv('TWILIO_AUTH_TOKEN');
        $from = getenv('TWILIO_PHONE_NUMBER');
        
        $client = new Twilio\Rest\Client($sid, $token);
        
        try {
            // Send OTP via SMS
            $message = $client->messages->create(
                $phone, // User's phone number
                [
                    'from' => $from, // Your Twilio phone number
                    'body' => 'Your verification code is: ' . $otp
                ]
            );
            
            echo json_encode(['status' => true, 'message' => 'OTP sent successfully.']);
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    // Step 2: Verify OTP
    public function verify_otp() {
        $otp = $this->input->post('otp');
        $phone = $this->session->userdata('phone_number');
        $stored_otp = $this->session->userdata('otp');

        if ($otp === $stored_otp) {
            // OTP is correct, register user (or mark as verified)
            // You may want to create a new user in your database
            $this->User_model->register_user($phone);

            // Redirect to proposal page or show the proposal
            echo json_encode(['status' => true, 'message' => 'Phone verified. Proposal can now be viewed.']);
        } else {
            // OTP is incorrect
            echo json_encode(['status' => false, 'message' => 'Invalid OTP.']);
        }
    }
}
