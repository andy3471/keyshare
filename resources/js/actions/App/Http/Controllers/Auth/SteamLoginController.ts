import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\SteamLoginController::redirect
* @see app/Http/Controllers/Auth/SteamLoginController.php:13
* @route '/login/steam'
*/
export const redirect = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: redirect.url(options),
    method: 'get',
})

redirect.definition = {
    methods: ["get","head"],
    url: '/login/steam',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\SteamLoginController::redirect
* @see app/Http/Controllers/Auth/SteamLoginController.php:13
* @route '/login/steam'
*/
redirect.url = (options?: RouteQueryOptions) => {
    return redirect.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\SteamLoginController::redirect
* @see app/Http/Controllers/Auth/SteamLoginController.php:13
* @route '/login/steam'
*/
redirect.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: redirect.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\SteamLoginController::redirect
* @see app/Http/Controllers/Auth/SteamLoginController.php:13
* @route '/login/steam'
*/
redirect.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: redirect.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Auth\SteamLoginController::callback
* @see app/Http/Controllers/Auth/SteamLoginController.php:19
* @route '/login/steam/callback'
*/
export const callback = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: callback.url(options),
    method: 'get',
})

callback.definition = {
    methods: ["get","head"],
    url: '/login/steam/callback',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\SteamLoginController::callback
* @see app/Http/Controllers/Auth/SteamLoginController.php:19
* @route '/login/steam/callback'
*/
callback.url = (options?: RouteQueryOptions) => {
    return callback.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\SteamLoginController::callback
* @see app/Http/Controllers/Auth/SteamLoginController.php:19
* @route '/login/steam/callback'
*/
callback.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: callback.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\SteamLoginController::callback
* @see app/Http/Controllers/Auth/SteamLoginController.php:19
* @route '/login/steam/callback'
*/
callback.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: callback.url(options),
    method: 'head',
})

const SteamLoginController = { redirect, callback }

export default SteamLoginController