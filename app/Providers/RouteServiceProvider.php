<?php
// File: app/Providers/RouteServiceProvider.php
public function boot(): void
{
    RateLimiter::for('checkin', function (Request $request) {
        return Limit::perHour(10)->by($request->user()?->id ?? $request->ip());
    });

    RateLimiter::for('wallet', function (Request $request) {
        return Limit::perMinute(5)->by($request->ip());
    });
}