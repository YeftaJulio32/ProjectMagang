<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    // Validation constants
    private const VALIDATION_RULES = [
        'name' => ['required', 'string', 'max:255', 'min:2'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'max:255'],
    ];

    private const VALIDATION_MESSAGES = [
        'name.required' => 'Nama lengkap diperlukan.',
        'name.min' => 'Nama harus memiliki minimal 2 karakter.',
        'name.max' => 'Nama terlalu panjang.',
        'email.required' => 'Email diperlukan.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah terdaftar.',
        'email.max' => 'Email terlalu panjang.',
        'password.required' => 'Password diperlukan.',
        'password.min' => 'Password harus memiliki minimal 8 karakter.',
        'password.max' => 'Password terlalu panjang.',
    ];

    // Success and error messages
    private const SUCCESS_REGISTRATION = 'Akun berhasil dibuat! Silakan login.';
    private const ERROR_GENERAL = 'Gagal membuat akun. Silakan coba lagi.';

    /**
     * Show the registration form.
     *
     * @return View
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        try {
            // Validate registration data
            $validatedData = $this->validateRegistration($request);

            // Create new user
            $user = $this->createUser($validatedData);

            // Log successful registration
            $this->logRegistrationSuccess($user, $request);

            return redirect()->route('login')->with('success', self::SUCCESS_REGISTRATION);

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            $this->logRegistrationError($request, $e);
            return back()->withErrors(['email' => self::ERROR_GENERAL])->withInput();
        }
    }

    /**
     * Validate registration request data.
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    private function validateRegistration(Request $request): array
    {
        return $request->validate(self::VALIDATION_RULES, self::VALIDATION_MESSAGES);
    }

    /**
     * Create a new user account.
     *
     * @param array $data
     * @return User
     * @throws \Exception
     */
    private function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            return User::create([
                'name' => trim($data['name']),
                'email' => strtolower(trim($data['email'])),
                'password' => Hash::make($data['password']),
                'joined_at' => now(),
                'role' => 'user', // Default role
            ]);
        });
    }

    /**
     * Log successful user registration.
     *
     * @param User $user
     * @param Request $request
     * @return void
     */
    private function logRegistrationSuccess(User $user, Request $request): void
    {
        Log::info('User registered successfully', [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Log registration errors.
     *
     * @param Request $request
     * @param \Exception $exception
     * @return void
     */
    private function logRegistrationError(Request $request, \Exception $exception): void
    {
        Log::error('User registration failed', [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'error' => $exception->getMessage(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
