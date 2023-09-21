<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticateService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->passes($request)) {
            return $next($request);
        }

        return response()->json(
            [
                'status' => false,
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized !!!',
                'data' => (object) null,
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function passes(Request $request)
    {
        $services = $this->getServicesInformation();
        $serviceId = $request->header('service-id');
        $serviceKey = $request->header('service-key');

        // check service id, service secret and permission for intended route
        if (
            (in_array($serviceId, array_keys($services)))
            && ($services[$serviceId]['secret'] === $serviceKey)
            && $this->intendedRouteIsValid($request, $services[$serviceId]['routes'])
        ) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    private function getServicesInformation()
    {
        return [
            config('apigw.service_id') => [
                'secret' => config('apigw.service_key'),
                'routes' => [
                    'api/v1/ip/store',
                ],
            ],
        ];
    }

    /**
     * Determine if the intended route is allowed for that service
     *
     * @param Request $request
     * @param array $routes
     *
     * @return bool
     */
    private function intendedRouteIsValid(Request $request, array $routes)
    {
        $path = $request->path();

        foreach ($routes as $route) {
            // we will check if there is something between {}, that will be our dynamic part(s) of the request
            if (!preg_match_all('/(\{.*?\})/', $route, $matches)) {
                // handle request without dynamic route
                if ($path === $route) {
                    return true;
                }
            } else {
                // we will compare full url without dynamic part(s)
                $pathSegments = explode('/', $path);
                $routeSegments = explode('/', $route);
                foreach ($matches[1] as $match) {
                    $index = array_search($match, $routeSegments);
                    unset($pathSegments[$index], $routeSegments[$index]);
                }

                if ($pathSegments === $routeSegments) {
                    return true;
                }
            }
        }

        return false;
    }
}
