<?php

namespace Utils;

class Helper
{
    /**
     * Generate a random numeric code of a given length.
     *
     * @param int $length The length of the code (default is 6)
     * @return string
     */
    public static function generateCode($length = 6)
    {
        return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }

    /**
     * Sanitize user input to prevent XSS attacks.
     *
     * @param string $input
     * @return string
     */
    public static function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Redirect to a given URL.
     *
     * @param string $url
     */
    public static function redirect($url)
    {
        header("Location: " . $url);
        exit;
    }

    /**
     * Show validation error for a specific field.
     *
     * @param string $field The field name
     * @return void
     */
    public static function showError($field)
    {
        if (!empty($_SESSION['errors'][$field])) {
            if (is_array($_SESSION['errors'][$field])) {
                echo '<p class="error">' . implode('<br>', $_SESSION['errors'][$field]) . '</p>';
            } else {
                echo '<p class="error">' . '<br>', $_SESSION['errors'][$field] . '</p>';
            };
        }
    }


    /**
     * Retrieve the old input value from the session or return a default placeholder.
     *
     * This function is useful for retaining user input after form submission errors.
     * If the field exists in the session (from a previous form submission), it returns the sanitized value.
     * Otherwise, it returns the specified placeholder text.
     *
     * @param string $field The name of the form field to retrieve the old value for.
     * @param string $placeholder The default placeholder text if no old value exists.
     * @return string The old input value (if available) or the placeholder text.
     */
    public static function oldValue($field, $placeholder = '')
    {
        if (isset($_SESSION['old'][$field])) {
            return 'value="' . htmlspecialchars($_SESSION['old'][$field]) . '"';
        } else {
            return 'placeholder="' . htmlspecialchars($placeholder) . '"';
        }
    }


    /**
     * Encrypts an email address for secure transmission.
     *
     * @param string $email The email to encrypt.
     * @return string The encrypted email (Base64 encoded).
     */
    public static function encryptEmail($email)
    {
        $key = 'a3f1d5c9b7e8a2f4c6d9e1b8a4c7e3f2';
        $hmacKey = 'd8e7c5f2b3a4e9d1c6f8b7a2d5e3c4f1';
        $iv = openssl_random_pseudo_bytes(16);

        // Encrypt the email
        $encrypted = openssl_encrypt($email, 'AES-256-CBC', $key, 0, $iv);

        if ($encrypted === false) {
            return false; // Encryption failed
        }

        // Generate binary HMAC
        $hmac = hash_hmac('sha256', $encrypted, $hmacKey, true);

        // Combine IV, encrypted data, and HMAC, then encode it in Base64
        return base64_encode($iv . $encrypted . $hmac);
    }


    /**
     * Decrypts an encrypted email and verifies integrity using HMAC.
     *
     * @param string $encryptedEmail The encrypted email (Base64 encoded).
     * @return string|false The decrypted email if valid, or false if tampered.
     */
    public static function decryptEmail($encryptedEmail)
    {
        $key = 'a3f1d5c9b7e8a2f4c6d9e1b8a4c7e3f2';
        $hmacKey = 'd8e7c5f2b3a4e9d1c6f8b7a2d5e3c4f1';
        $data = base64_decode($encryptedEmail);

        if ($data === false || strlen($data) < 48) { // 16 IV + min 1 byte encrypted data + 32 HMAC
            return false;
        }

        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16, -32);
        $hmac = substr($data, -32); // Correct HMAC length (32 bytes for SHA-256 in binary)

        // Calculate expected HMAC (binary output)
        $calculatedHmac = hash_hmac('sha256', $encrypted, $hmacKey, true);

        if (!hash_equals($calculatedHmac, $hmac)) {
            return false; // Integrity check failed
        }

        return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
    }




    public static function sanitize($input, $type = 'string')
    {
        if (!isset($input)) return null;

        $input = trim($input);

        switch ($type) {
            case 'email':
                return filter_var($input, FILTER_SANITIZE_EMAIL);
            case 'string':
                return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            case 'int':
                return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
            case 'url':
                return filter_var($input, FILTER_SANITIZE_URL);
            default:
                return $input;
        }
    }

   
    /**
     * Generate a CSRF token and store it in the session.
     *
     * @return string The generated CSRF token.
     */
    public static function generateCsrfToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Generate a random token
        $token = bin2hex(random_bytes(32));

        // Store it in session
        $_SESSION['csrf_token'] = $token;

        return $token;
    }

    /**
     * Verify the CSRF token submitted with the form.
     *
     * @param string|null $token The CSRF token submitted by the user.
     * @return bool True if the token is valid, false otherwise.
     */
    public static function verifyCsrfToken(?string $token): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }


}
