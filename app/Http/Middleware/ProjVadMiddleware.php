<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class ProjVadMiddleware extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }
        if (!$user->projVaditajs) {
            return redirect(RouteServiceProvider::HOME)->with('error', 'Nav piekļuves');
        }
        return parent::handle($request, $next, $guards);
    }
}
