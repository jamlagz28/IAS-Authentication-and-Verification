<?php

namespace App\Controllers;

use Utils\Helper;
use App\Models\User;
use Core\Middleware;
use Valitron\Validator;


class UpdateProfile
{
    public static function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            self::setSessionError('general', 'Invalid request method.');
            Helper::redirect('reset-password');
            return;
        };
        $token = $_POST['csrf_token'] ?? null;

        if (!Helper::verifyCsrfToken($token)) {
            http_response_code(403);
            die("CSRF validation failed!");
        }

        $confirm_email = Helper::decryptEmail($_SESSION['user']['email_encrypted']);
        $email = $_SESSION['user']['email'];

        if ($confirm_email !== $email) {
            $_SESSION['errors']['general'][] = "Something went wrong!";
            Helper::redirect('profile');
            return;;
        }

        $user = (new User())->findByEmail($email);
        if ($user) {
            $v = new Validator($_POST);

            if (isset($_POST['update-profile'])) {
                $name = Helper::sanitize($_POST['name'] ?? null, 'string');
                $v->rule('required', 'name')->message('Name is required');
                $v->rule('regex', 'name', '/^[A-Za-z\s]+$/')->message('Full name must contain only letters and spaces');
                if (!$v->validate()) {
                    $_SESSION['errors'] = $v->errors();
                    $_SESSION['old'] = $_POST;
                    Helper::redirect('profile');
                    exit;
                }

                (new User())->updateUser($user->id, [
                    'name' => $name,
                ]);

                $_SESSION['user']['name'] = $name;
                $_SESSION['success']['update-profile'] = 'Profile name updated';
                Helper::redirect('profile');
                exit;
            } elseif (isset($_POST['update-password'])) {
                $v->rule('lengthMin', ['password', 'current-password', 'confirm-password'], 6)->message('Password must be at least 6 characters');
                $v->rule('required', ['current-password', 'password', 'confirm-password',])->message('{field} is required');
                $v->rule('equals', 'password', 'confirm-password')->message('Passwords do not match');

                if (!$v->validate()) {
                    $_SESSION['errors'] = $v->errors();
                    $_SESSION['old'] = $_POST;
                    Helper::redirect('profile');
                    exit;
                }
                $currentPassword = $_POST['current-password'];
                $newPassword = $_POST['password'];
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);


                if (password_verify($currentPassword, $user->password)) {
                    (new User())->updateUser($user->id, [
                        'password' => $hashedPassword,
                    ]);
                    $_SESSION['success']['update-password'] = 'Password updated';
                    Helper::redirect('profile');
                    exit;
                } else {
                    $_SESSION['errors']['update-password'] = 'You supplied wrong current password';
                    Helper::redirect('profile');
                    exit;
                }
            } elseif (isset($_POST['delete'])) {
                (new User())->deleteuser($user->id);
                Middleware::logout();
            } else {
                return;
            }
        }
    }
    private static function setSessionError($key, $message)
    {
        $_SESSION['errors'][$key] = $message;
    }
};
