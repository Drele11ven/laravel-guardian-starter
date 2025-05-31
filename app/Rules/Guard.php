<?php

namespace App\Rules;

use Closure;
use ReCaptcha\ReCaptcha;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Validation\ValidationRule;

class Guard implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        $data = $response->json();

        if (!($data['success'] ?? false)) {
            $fail('Failed Google reCAPTCHA verification.');
            return;
        }

        if (($data['score'] ?? 0) < 0.5) {
            $fail('Google reCAPTCHA score too low. Please try again.');
        }
    }
}
