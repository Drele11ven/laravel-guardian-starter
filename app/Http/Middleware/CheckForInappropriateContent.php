<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckForInappropriateContent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // List of fields to exclude from the bad word check
        $excludedFields = ['password', 'password_confirmation', '_token', '_method', 'g-recaptcha-response'];

        // Read the bad words list from the file
        $badWords = file(storage_path('app/badwords.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $badWords = array_map('trim', $badWords);

        $detected = [];

        // Flatten all inputs to check
        $flatInputs = $this->flattenArray($request->all());

        foreach ($flatInputs as $key => $value) {
            // Skip excluded fields
            if (in_array($key, $excludedFields)) {
                continue;
            }

            // Check for bad words in the value
            foreach ($badWords as $badWord) {
                if (stripos($value, $badWord) !== false) {
                    $detected[] = $badWord;
                }
            }
        }

        if (!empty($detected)) {
            $message = 'ورودی شما حاوی کلمات نامناسب است: ' . implode(', ', array_unique($detected));

            // Get user details (if logged in)
            $userId = auth()->check() ? auth()->id() : null;
            $userName = auth()->check() ? auth()->user()->name : 'Guest';

            // Log the event with a timestamp
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/custom.log'),
            ])->info('Bad words detected', [
                'user_id' => $userId,
                'user_name' => $userName,
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'inputs' => $request->except($excludedFields),
                'detected_words' => array_unique($detected),
                'timestamp' => now(), // Log the current timestamp
            ]);

            // Flash message to the session to notify the user
            session()->flash('message', $message);

            // Redirect back with input
            return redirect()->back()->withInput();
        }

        // Continue the request if no bad words detected
        return $next($request);
    }

    /**
     * Flatten nested arrays into a single level array.
     */
    private function flattenArray(array $array): array
    {
        $result = [];
        array_walk_recursive($array, function($a) use (&$result) {
            $result[] = $a;
        });
        return $result;
    }
}