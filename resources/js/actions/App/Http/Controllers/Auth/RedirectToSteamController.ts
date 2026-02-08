import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\RedirectToSteamController::__invoke
* @see app/Http/Controllers/Auth/RedirectToSteamController.php:14
* @route '/login/steam'
*/
const RedirectToSteamController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectToSteamController.url(options),
    method: 'get',
})

RedirectToSteamController.definition = {
    methods: ["get","head"],
    url: '/login/steam',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\RedirectToSteamController::__invoke
* @see app/Http/Controllers/Auth/RedirectToSteamController.php:14
* @route '/login/steam'
*/
RedirectToSteamController.url = (options?: RouteQueryOptions) => {
    return RedirectToSteamController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\RedirectToSteamController::__invoke
* @see app/Http/Controllers/Auth/RedirectToSteamController.php:14
* @route '/login/steam'
*/
RedirectToSteamController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectToSteamController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\RedirectToSteamController::__invoke
* @see app/Http/Controllers/Auth/RedirectToSteamController.php:14
* @route '/login/steam'
*/
RedirectToSteamController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RedirectToSteamController.url(options),
    method: 'head',
})

export default RedirectToSteamController