<?php

namespace Illuminate\Contracts\Auth;

use Closure;

interface PasswordBroker
{
    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    const RESET_LINK_SENT = 'Passwords link sent successfully';


    /**
     * Constant representing a successfully reset password.
     *
     * @var string
     */
    const PASSWORD_RESET = 'Passwords reset successfully';

    /**
     * Constant representing the user not found response.
     *
     * @var string
     */
    const INVALID_USER = 'Invalid user';
    const INVALID_USER_STATUS = 422;

    /**
     * Constant representing an invalid token.
     *
     * @var string
     */
    const INVALID_TOKEN = 'Invalid token';
    const INVALID_TOKEN_STATUS = 422;

    /**
     * Constant representing a throttled reset attempt.
     *
     * @var string
     */
    const RESET_THROTTLED = 'Too many request, try after 1 minute';
    const RESET_THROTTLED_STATUS = 429;

    /**
     * Send a password reset link to a user.
     *
     * @param  array  $credentials
     * @param  \Closure|null  $callback
     * @return string
     */
    public function sendResetLink(array $credentials, Closure $callback = null);

    /**
     * Reset the password for the given token.
     *
     * @param  array  $credentials
     * @param  \Closure  $callback
     * @return mixed
     */
    public function reset(array $credentials, Closure $callback);
}
