<?php

namespace Core;


class Middleware
{
    /**
     * Check if the user is authenticated.
     * Redirect to sign-in page if not logged in.
     */
    public static function requireAuth()
    {
        if (!isset($_SESSION['user'])) {
            // $_SESSION['errors']['auth'][] = "You must be signed in to access this page.";
            header("Location: sign-in");
            exit;
        }

        // Auto logout if inactive for too long
        self::checkSessionTimeout();
    }

    /**
     * Ensure a guest (unauthenticated user) is accessing certain pages.
     * Redirect logged-in users away from sign-in/sign-up pages.
     */
    public static function guestOnly()
    {
        if (isset($_SESSION['user'])) {
            header("Location: home");
            exit;
        }
    }

    /**
     * Auto logout inactive users.
     */
    private static function checkSessionTimeout()
    {
        $timeout_duration = 900; // 15 minutes
        if (
            isset($_SESSION['user']['last_activity']) &&
            (time() - $_SESSION['user']['last_activity']) > $timeout_duration
        ) {
            session_unset();
            session_destroy();
            header("Location: sign-in");
            exit;
        }

        $_SESSION['user']['last_activity'] = time();
    }
    public static function logout()
    {
        session_unset();
        session_destroy();
        setcookie("remember_me", "", time() - 3600, "/", "", true, true);
        header("Location: sign-in");
        exit;
    }
}
