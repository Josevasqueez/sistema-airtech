<?php

namespace App\Http\Middleware;

use Closure;

class CheckRol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $rol)
    {
        if ($request->user()->rol != $rol && $request->user()->rol != 'Developer') {

            if($rol == 'Mecanico' && $request->user()->rol == 'Gerente'){
                return $next($request);
            }
            return redirect('/');
        }
        return $next($request);
    }
}
