<?php
   namespace App\Http\Middleware;
   
   use Closure;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;
   
   class ControlRoles
   {
       public function handle(Request $request, Closure $next, ...$roles)
       {
           if (!Auth::check()) {
               return redirect('/');
           }
   
           if (!in_array(Auth::user()->role, $roles)) {
               abort(403, 'Acceso no autorizado a este rol administrativo.');
           }
   
           return $next($request);
       }
   }