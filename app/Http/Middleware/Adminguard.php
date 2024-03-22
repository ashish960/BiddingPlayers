<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Adminguard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->id == '121' && $request->name == 'Ashish' && $request->task =='addteam'){
         // return redirect('api/Admin/addteam')->with($request);
            $redirectRoute = route('add.team',$request );
            return new RedirectResponse($redirectRoute);
           // return $next( $request);
        }
        elseif($request->id == '121' && $request->name == 'Ashish' && $request->task =='addplayer'){
         return redirect('api/Admin/addplayer')->with($request);
        }
        //   return $next( $request);
     else {
     return redirect('api/no-access');
     }

    //return $next($request);
 }
}
