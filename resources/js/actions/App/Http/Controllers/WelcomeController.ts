import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\WelcomeController::__invoke
* @see app/Http/Controllers/WelcomeController.php:14
* @route '/'
*/
const WelcomeController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: WelcomeController.url(options),
    method: 'get',
})

WelcomeController.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\WelcomeController::__invoke
* @see app/Http/Controllers/WelcomeController.php:14
* @route '/'
*/
WelcomeController.url = (options?: RouteQueryOptions) => {
    return WelcomeController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\WelcomeController::__invoke
* @see app/Http/Controllers/WelcomeController.php:14
* @route '/'
*/
WelcomeController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: WelcomeController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\WelcomeController::__invoke
* @see app/Http/Controllers/WelcomeController.php:14
* @route '/'
*/
WelcomeController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: WelcomeController.url(options),
    method: 'head',
})

export default WelcomeController