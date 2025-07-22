<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Rate limiting constants
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const DECAY_MINUTES = 15;

    // Validation constants
    private const VALIDATION_RULES = [
        'email' => ['required', 'email', 'max:255'],
        'password' => ['required', 'string', 'max:255'],
    ];

    private const VALIDATION_MESSAGES = [
        'email.required' => 'Email diperlukan.',
        'email.email' => 'Format email tidak valid.',
        'email.max' => 'Email terlalu panjang.',
        'password.required' => 'Password diperlukan.',
        'password.max' => 'Password terlalu panjang.',
    ];

    // Error messages
    private const ERROR_INVALID_CREDENTIALS = 'Email atau password salah.';
    private const ERROR_RATE_LIMIT = 'Terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.';
    private const ERROR_GENERAL = 'Gagal melakukan login. Silakan coba lagi.';

    /**
     * Show the login form.
     *
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle user login.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        try {
            // Check rate limiting first
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->logRateLimitExceeded($request);
                return back()->withErrors(['email' => self::ERROR_RATE_LIMIT]);
            }

            // Validate login credentials
            $credentials = $this->validateLogin($request);

            // Increment rate limiter attempts
            $this->incrementLoginAttempts($request);

            // Attempt login
            if ($this->attemptLogin($credentials, $request)) {
                return $this->handleSuccessfulLogin($request);
            }

            // Log failed login attempt
            $this->logFailedLogin($credentials['email'], $request);

            return back()->withErrors([
                'email' => self::ERROR_INVALID_CREDENTIALS,
            ])->onlyInput('email');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            $this->logLoginError($request, $e);
            return back()->withErrors(['email' => self::ERROR_GENERAL])->withInput();
        }
    }

    /**
     * Handle user logout.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Log logout activity
        $this->logLogout($user, $request);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah berhasil logout.');
    }

    /**
     * Validate login credentials.
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    private function validateLogin(Request $request): array
    {
        return $request->validate(self::VALIDATION_RULES, self::VALIDATION_MESSAGES);
    }

    /**
     * Attempt to authenticate the user.
     *
     * @param array $credentials
     * @param Request $request
     * @return bool
     */
    private function attemptLogin(array $credentials, Request $request): bool
    {
        // Normalize email to lowercase
        $credentials['email'] = strtolower(trim($credentials['email']));

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return true;
        }

        return false;
    }

    /**
     * Handle successful login.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    private function handleSuccessfulLogin(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Clear rate limiter on successful login
        $this->clearLoginAttempts($request);

        // Log successful login
        $this->logSuccessfulLogin($user, $request);

        // Redirect based on user role
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Redirect user based on their role.
     *
     * @param $user
     * @return RedirectResponse
     */
    private function redirectBasedOnRole($user): RedirectResponse
    {
        return match($user->role) {
            'admin' => redirect()->intended(route('admin.dashboard')),
            'user' => redirect()->intended(route('news.index')),
            default => redirect()->intended(route('news.index')),
        };
    }

    /**
     * Check if the request has too many login attempts.
     *
     * @param Request $request
     * @return bool
     */
    private function hasTooManyLoginAttempts(Request $request): bool
    {
        $key = $this->getLoginRateLimitKey($request);

        return RateLimiter::tooManyAttempts($key, self::MAX_LOGIN_ATTEMPTS);
    }

    /**
     * Increment the login attempts for rate limiting.
     *
     * @param Request $request
     * @return void
     */
    private function incrementLoginAttempts(Request $request): void
    {
        $key = $this->getLoginRateLimitKey($request);

        RateLimiter::hit($key, self::DECAY_MINUTES * 60);
    }

    /**
     * Clear login attempts after successful login.
     *
     * @param Request $request
     * @return void
     */
    private function clearLoginAttempts(Request $request): void
    {
        $key = $this->getLoginRateLimitKey($request);

        RateLimiter::clear($key);
    }

    /**
     * Get the rate limiting key for login attempts.
     *
     * @param Request $request
     * @return string
     */
    private function getLoginRateLimitKey(Request $request): string
    {
        return 'login_attempts_' . $request->ip();
    }

    /**
     * Log successful login.
     *
     * @param $user
     * @param Request $request
     * @return void
     */
    private function logSuccessfulLogin($user, Request $request): void
    {
        Log::info('User logged in successfully', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Log failed login attempt.
     *
     * @param string $email
     * @param Request $request
     * @return void
     */
    private function logFailedLogin(string $email, Request $request): void
    {
        Log::warning('Failed login attempt', [
            'email' => $email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Log logout activity.
     *
     * @param $user
     * @param Request $request
     * @return void
     */
    private function logLogout($user, Request $request): void
    {
        Log::info('User logged out', [
            'user_id' => $user?->id ?? 'unknown',
            'email' => $user?->email ?? 'unknown',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Log rate limit exceeded.
     *
     * @param Request $request
     * @return void
     */
    private function logRateLimitExceeded(Request $request): void
    {
        Log::warning('Login rate limit exceeded', [
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'email' => $request->input('email'),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Log login errors.
     *
     * @param Request $request
     * @param \Exception $exception
     * @return void
     */
    private function logLoginError(Request $request, \Exception $exception): void
    {
        Log::error('Login error occurred', [
            'email' => $request->input('email'),
            'error' => $exception->getMessage(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
