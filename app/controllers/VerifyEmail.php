<?php

namespace App\Controllers;

use Core\MailService;
use Utils\Helper;
use App\Models\User;
use Carbon\Carbon;
use Valitron\Validator;

class VerifyEmail
{
    private $mailService;

    public function __construct()
    {
        $this->mailService = new MailService();
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setSessionError('general', 'Invalid request method.');
            Helper::redirect('verify-email');
            return;
        }

        $token = $_POST['csrf_token'] ?? null;

        if (!Helper::verifyCsrfToken($token)) {
            http_response_code(403);
            echo $token;
            die("$token");
        }


        $v = new Validator($_POST);
        $v->rule('email', 'email')->message('Something went wrong');
        $v->rule('numeric', 'code')->message('Code should be numeric');


        $email = $_POST['email'] ?? null;
        $code = $_POST['code'] ?? null;

        if ($code) {
            $v->rule('length', 'code', 6)->message('Verification code must be exactly 6 digits.');
        }
        if (!$v->validate()) {
            foreach ($v->errors() as $key => $messages) {

                foreach ($messages as $message) {
                    $this->setSessionError($key, $message);
                }
            }
            Helper::redirect('verify-email');
        }


        if (!$email) {
            $this->setSessionError('general', 'Something went wrong.');
            Helper::redirect('verify-email');
            return;
        }

        if ($code) {
            $response = $this->verifyEmail($email, $code);
        } else {
            $response = $this->requestNewCode($email);
        }

        if ($response['status'] === 'error') {
            $this->setSessionError('general', $response['message']);
            $_SESSION['old'] = $_POST;
            Helper::redirect('verify-email');
        } else {
            $_SESSION['success'] = $response['message'];
            Helper::redirect('verify-email');
        }
    }

    private function verifyEmail($email, $code)
    {
        $userInstance = new User();
        $user = $userInstance->findByEmail($email);

        if (!$user) return ['status' => 'error', 'message' => 'User not found.'];
        if ($user->verification_status == "verified") return Helper::redirect('home');
        if ($user->verification_code != $code) return ['status' => 'error', 'message' => 'Invalid verification code.'];

        $userInstance->updateUser($user->id, [
            'verification_status' => "verified",
            'verification_code' => null,
            'request_attempts' => 0
        ]);

        Helper::redirect('home');
        exit;
    }

    private function requestNewCode($email)
    {
        $userInstance = new User();
        $user = $userInstance->findByEmail($email);

        if (!$user) return ['status' => 'error', 'message' => 'User not found.'];
        if ($user->is_verified) return ['status' => 'error', 'message' => 'Email is already verified.'];

        $waitTimes = [1, 2, 3, 4, 5];
        $attempts = $user->request_attempts ?? 0;
        if ($attempts >= 5) return ['status' => 'error', 'message' => 'Maximum attempts reached.'];

        $waitTime = $waitTimes[$attempts] * 60;
        $lastRequestTime = strtotime($user->verification_requested_at);

        if ($lastRequestTime && (time() - $lastRequestTime) < $waitTime) {
            return ['status' => 'error', 'message' => 'Please wait before requesting again.'];
        }

        $newCode = rand(100000, 999999);
        $emailTemplate = file_get_contents(__DIR__ . '/../../pages/email_template/verify.php');

        $emailBody = str_replace('{{VERIFICATION_CODE}}', $newCode, $emailTemplate);

        if ($this->mailService->sendEmail($email, "Your Verification Code", $emailBody)) {

            $currentTime = Carbon::now()->toDateTimeString();
            $userInstance->updateUser($user->id, [
                'verification_code' => $newCode,
                'verification_requested_at' => $currentTime,
                'request_attempts' => $attempts + 1
            ]);
            return ['status' => 'success', 'message' => 'verification code has been sent.'];
        }

        return ['status' => 'error', 'message' => 'Failed to send email.'];
    }

    private function setSessionError($key, $message)
    {
        $_SESSION['errors'][$key] = $message;
    }
}
