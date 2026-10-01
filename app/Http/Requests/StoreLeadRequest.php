<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'service_interested' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:5000'],
            'g-recaptcha-response' => [$this->recaptchaConfigured() ? 'required' : 'nullable', function ($attribute, $value, $fail) {
                if ($this->recaptchaConfigured() && ! $this->recaptchaPasses($value)) {
                    $fail('Please confirm you are not a robot.');
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please tell us your name.',
            'g-recaptcha-response.required' => 'Please confirm you are not a robot.',
        ];
    }

    protected function recaptchaConfigured(): bool
    {
        return filled(config('services.recaptcha.site_key')) && filled(config('services.recaptcha.secret_key'));
    }

    protected function recaptchaPasses(?string $response): bool
    {
        if (blank($response)) {
            return false;
        }

        $result = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $response,
            'remoteip' => $this->ip(),
        ]);

        return (bool) $result->json('success');
    }
}
