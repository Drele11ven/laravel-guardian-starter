<?php
namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(string $action = null)
    {
        try {
            // Get the referring URL (previous page)
            $refererUrl = request()->headers->get('referer');

            $route = request()->route();

            // Get the controller@method (e.g. UserController@show)
            $controllerAction = $route?->getActionName();
            if ($controllerAction && strpos($controllerAction, '@') !== false) {
                $controllerAction = class_basename(strtok($controllerAction, '@')) . '@' . collect(explode('@', $controllerAction))->last();
            }

            // Get the route name (if named)
            $routeName = $route?->getName();

            // Get route parameters (e.g. /user/12 -> ['id' => 12])
            $routeParams = $route?->parameters() ?? [];

            // Get request input (from POST/PUT forms or JSON body), excluding sensitive fields
            $input = request()->except(['password', 'password_confirmation', '_token', '_method', 'g-recaptcha-response']);

           // Merge route and input parameters
            $allParams = array_merge($routeParams, $input);

           // Convert parameters to a string
            $paramsString = collect($allParams)
                ->map(fn($value, $key) => "$key=" . json_encode($value))
                ->implode(', ');

           // Compose the final action string
            $finalActionParts = [];

            if ($controllerAction) $finalActionParts[] = $controllerAction;
            if ($routeName) $finalActionParts[] = "Route: $routeName";
            if ($paramsString) $finalActionParts[] = "Params: $paramsString";
            if ($action) $finalActionParts[] = "Custom: $action";

            $finalAction = implode(' | ', $finalActionParts);
            
            // Save the activity log
            ActivityLog::create([
                'user_id' => Auth::id(),
                'method' => request()->method(),
                'url' => request()->fullUrl(),
                'referer_url' => $refererUrl,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'action' => $finalAction,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }
}
