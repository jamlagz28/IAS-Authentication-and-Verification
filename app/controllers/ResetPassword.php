<?php

namespace App\Controllers;

use Core\MailService;
use Utils\Helper;
use App\Models\User;
use Carbon\Carbon;
use Valitron\Validator;

class ResetPassword
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
            Helper::redirect('reset-password');
            return;
        }

        $token = $_POST['csrf_token'] ?? null;

        if (!Helper::verifyCsrfToken($token)) {
            http_response_code(403);
            die("CSRF validation failed!");
        }

        $email = Helper::sanitize($_POST['email'] ?? null, 'email');
        $code = Helper::sanitize($_POST['code'] ?? null, 'string');
        $password = $_POST['password'] ?? null;
        $identifier = $_POST['identifier'] ?? null;

        // Validate Input
        $v = new Validator($_POST);
        if ($password) {
            $v->rule('lengthMin', 'password', 6)->message('Password must be at least 6 characters');
            $v->rule('equals', 'password', 'confirm_password')->message('Passwords do not match');
        } elseif ($code) {
            $v->rule('length', 'code', 6)->message('Verification code must be exactly 6 digits.');
            $v->rule('numeric', 'code')->message('Code should be numeric');
        } else {
            $v->rule('email', 'email')->message('Something went wrong');
        }

        if (!$v->validate()) {
            foreach ($v->errors() as $key => $messages) {
                foreach ($messages as $message) {
                    $this->setSessionError($key, $message);
                }
            }
            Helper::redirect('reset-password');
            return;
        }

        // Handle Password Reset
        if ($password) {
            $isEmailCorrect = Helper::decryptEmail($identifier);
            if (!$isEmailCorrect) {
                $this->setSessionError('general', "Something went wrong");
                Helper::redirect('reset-password');
                return;
            }

            $email = $isEmailCorrect;
            $response = $this->updatePassword($email, $password);

            if ($response['status'] === 'error') {
                $this->setSessionError('general', $response['message']);
                $_SESSION['old'] = $_POST;
                Helper::redirect('reset-password');
            } else {
                $_SESSION['success'] = $response['message'];
                Helper::redirect('sign-in');
            }
            return;
        }

        // Handle Code Verification
        if ($code) {
            $response = $this->verifyEmail($email, $code);
            if ($response['status'] === 'error') {
                $this->setSessionError('general', $response['message']);
                $_SESSION['old'] = $_POST;
                Helper::redirect('email-confirmation');
            } else {
                $_SESSION['success'] = $response['message'];
                $_SESSION['email_verified'] = true;
                $_SESSION['email'] = Helper::encryptEmail($email);
                Helper::redirect('reset-password');
            }
            return;
        }

        // Handle New Code Request
        $user = (new User())->findByEmail($email);
        if ($user) {
            $response = $this->requestNewCode($email);
            if ($response['status'] === 'error') {
                $this->setSessionError('general', $response['message']);
                $_SESSION['old'] = $_POST;
                Helper::redirect('reset-password');
            } else {
                $_SESSION['success'] = $response['message'];
                $_SESSION['verification_email'] = $email;
                Helper::redirect('email-confirmation');
            }
        } else {
            $this->setSessionError('general', "Email not found");
            Helper::redirect('reset-password');
        }
    }
    private function verifyEmail($email, $code)
    {
        $user = (new User())->findByEmail($email);

        if (!$user) {
            return ['status' => 'error', 'message' => 'User not found.'];
        }

        if ($user->verification_code != $code) {
            $this->setSessionError('general', 'Wrong code');
            return ['status' => 'error', 'message' => 'Wrong verification code.'];
        }

        (new User())->updateUser($user->id, [
            'verification_status' => 'verified',
            'verification_code' => null,
            'request_attempts' => 0
        ]);

        return ['status' => 'success', 'message' => 'Email verified successfully.'];
    }

    private function requestNewCode($email)
    {
        $user = (new User())->findByEmail($email);

        if (!$user) return ['status' => 'error', 'message' => 'User not found.'];
        if ($user->is_verified) return ['status' => 'error', 'message' => 'Email is already verified.'];

        if ($this->hasReachedMaxAttempts($user)) {
            return ['status' => 'error', 'message' => 'Maximum attempts reached.'];
        }

        if (!$this->canRequestNewCode($user)) {
            return ['status' => 'error', 'message' => 'Please wait before requesting again.'];
        }

        $newCode = rand(100000, 999999);
        $emailTemplate = file_get_contents(__DIR__ . '/../../pages/email_template/verify.php');
        $emailBody = str_replace('{{VERIFICATION_CODE}}', $newCode, $emailTemplate);

        if (!$this->mailService->sendEmail($email, "Your Verification Code", $emailBody)) {
            return ['status' => 'error', 'message' => 'Failed to send email.'];
        }

        (new User())->updateUser($user->id, [
            'verification_code' => $newCode,
            'verification_requested_at' => Carbon::now()->toDateTimeString(),
            'request_attempts' => $user->request_attempts + 1
        ]);

        return ['status' => 'success', 'message' => 'Your verification code was sent.'];
    }

    private function updatePassword($email, $password)
    {
        $user = (new User())->findByEmail($email);

        if (!$user) {
            return ['status' => 'error', 'message' => 'User not found.'];
        }

        (new User())->updateUser($user->id, ["password" => password_hash($password, PASSWORD_BCRYPT)]);

        return ['status' => 'success', 'message' => 'Password updated successfully.'];
    }

    private function setSessionError($key, $message)
    {
        $_SESSION['errors'][$key] = $message;
    }

    private function hasReachedMaxAttempts($user)
    {
        return ($user->request_attempts ?? 0) >= 5;
    }

    private function canRequestNewCode($user)
    {
        $waitTimes = [1, 2, 3, 4, 5]; // Minutes per attempt
        $attempts = $user->request_attempts ?? 0;

        if (!isset($waitTimes[$attempts])) {
            return false;
        }

        $waitTime = $waitTimes[$attempts] * 60; // Convert to seconds
        $lastRequestTime = strtotime($user->verification_requested_at);

        return !$lastRequestTime || (time() - $lastRequestTime) >= $waitTime;
    }
}
