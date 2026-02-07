import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
import steam87c916 from './steam'
/**
* @see \App\Http\Controllers\Auth\SteamLoginController::steam
* @see app/Http/Controllers/Auth/SteamLoginController.php:13
* @route '/login/steam'
*/
export const steam = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: steam.url(options),
    method: 'get',
})

steam.definition = {
    methods: ["get","head"],
    url: '/login/steam',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\SteamLoginController::steam
* @see app/Http/Controllers/Auth/SteamLoginController.php:13
* @route '/login/steam'
*/
steam.url = (options?: RouteQueryOptions) => {
    return steam.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\SteamLoginController::steam
* @see app/Http/Controllers/Auth/SteamLoginController.php:13
* @route '/login/steam'
*/
steam.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: steam.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\SteamLoginController::steam
* @see app/Http/Controllers/Auth/SteamLoginController.php:13
* @route '/login/steam'
*/
steam.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: steam.url(options),
    method: 'head',
})

const linkedAccount = {
    steam: Object.assign(steam, steam87c916),
}

export default linkedAccount