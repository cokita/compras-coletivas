<?php

namespace App\Http\Middleware;
// First copy this file into your middleware directoy
use Closure;

class CheckProfile{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get the required roles from the route
        $roles = $this->getRequiredRoleForRoute($request->route());
        // Check if a role is required for the route, and
        // if so, ensure that the user has that role.
        if($request->user()->hasProfile($roles) || !$roles)
        {
            return $next($request);
        }

        throw new \Exception('Desculpe, mas você não tem privilégios suficientes para essa ação.', 401);

    }
    private function getRequiredRoleForRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}