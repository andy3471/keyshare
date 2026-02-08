import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\HandleSteamCallbackController::__invoke
* @see app/Http/Controllers/Auth/HandleSteamCallbackController.php:17
* @route '/login/steam/callback'
*/
const HandleSteamCallbackController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HandleSteamCallbackController.url(options),
    method: 'get',
})

HandleSteamCallbackController.definition = {
    methods: ["get","head"],
    url: '/login/steam/callback',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\HandleSteamCallbackController::__invoke
* @see app/Http/Controllers/Auth/HandleSteamCallbackController.php:17
* @route '/login/steam/callback'
*/
HandleSteamCallbackController.url = (options?: RouteQueryOptions) => {
    return HandleSteamCallbackController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\HandleSteamCallbackController::__invoke
* @see app/Http/Controllers/Auth/HandleSteamCallbackController.php:17
* @route '/login/steam/callback'
*/
HandleSteamCallbackController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HandleSteamCallbackController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\HandleSteamCallbackController::__invoke
* @see app/Http/Controllers/Auth/HandleSteamCallbackController.php:17
* @route '/login/steam/callback'
*/
HandleSteamCallbackController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: HandleSteamCallbackController.url(options),
    method: 'head',
})

export default HandleSteamCallbackController