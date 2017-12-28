<?php namespace App\Admin\Http\Middleware;

use Closure;

class Role {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $permissions = \Session::get('role.permissions');
        foreach($permissions as $url){
            if(strpos($request->path(),substr($url,1)) !== false){
                return $next($request);
            }
        }
        if(strpos($request->path(),'admin/users/'.\Session::get('user.id')) !== false){
            return $next($request);
        }
        return redirect('admin/dashboard');
	}

}
