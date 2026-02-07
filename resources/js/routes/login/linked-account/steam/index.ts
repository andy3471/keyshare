import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
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

const steam = {
    callback: Object.assign(callback, callback),
}

export default steam