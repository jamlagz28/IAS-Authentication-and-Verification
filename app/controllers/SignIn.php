<?php

namespace App\Controllers;

use App\Models\User;
use Valitron\Validator;
use Utils\Helper;

class SignIn
{

    public static function signIn()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Method Not Allowed";
            exit;
        };
        $token = $_POST['csrf_token'] ?? null;

        if (!Helper::verifyCsrfToken($token)) {
            http_response_code(403);
            die("CSRF validation failed!");
        }
        $v = new Validator($_POST);
        $v->rule('required', ['email', 'password'])->message('{field} is required');
        $v->rule('email', 'email')->message('Invalid email format');
        $v->rule('lengthMin', 'password', 6)->message('Password must be at least 6 characters');

        if (!$v->validate()) {
            $_SESSION['errors'] = $v->errors();
            $_SESSION['old'] = $_POST;
            Helper::redirect('sign-in');
            exit;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new User();
        $user = $user->findByEmail($email);
        if ($user) {
            if (password_verify($password, $user->password)) {
                $_SESSION['user'] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_encrypted' => Helper::encryptEmail($user->email),
                    'last_activity' => time(),

                ];
                if (!empty($_POST['remember_me'])) {
                    setcookie("remember_me", base64_encode($user->id), time() + (30 * 24 * 60 * 60), "/", "", true, true);
                }
                Helper::redirect("home");
            } else {

                self::showError('general', 'Wrong credentials supplied', 'sign-in');
            }
        } else {
            self::showError('email', "Email address not found", "sign-in");
        }
    }

    private static function showError(string $field, string $message, string $redirect)
    {
        $_SESSION['errors']["{$field}"][] = $message;
        $_SESSION['old'] = $_POST;
        Helper::redirect($redirect);
        exit;
    }
}
