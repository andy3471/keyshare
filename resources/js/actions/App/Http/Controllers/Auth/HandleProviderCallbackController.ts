import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\HandleProviderCallbackController::__invoke
* @see app/Http/Controllers/Auth/HandleProviderCallbackController.php:20
* @route '/auth/{provider}/callback'
*/
const HandleProviderCallbackController = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HandleProviderCallbackController.url(args, options),
    method: 'get',
})

HandleProviderCallbackController.definition = {
    methods: ["get","head"],
    url: '/auth/{provider}/callback',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\HandleProviderCallbackController::__invoke
* @see app/Http/Controllers/Auth/HandleProviderCallbackController.php:20
* @route '/auth/{provider}/callback'
*/
HandleProviderCallbackController.url = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { provider: args }
    }

    if (Array.isArray(args)) {
        args = {
            provider: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        provider: args.provider,
    }

    return HandleProviderCallbackController.definition.url
            .replace('{provider}', parsedArgs.provider.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\HandleProviderCallbackController::__invoke
* @see app/Http/Controllers/Auth/HandleProviderCallbackController.php:20
* @route '/auth/{provider}/callback'
*/
HandleProviderCallbackController.get = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HandleProviderCallbackController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\HandleProviderCallbackController::__invoke
* @see app/Http/Controllers/Auth/HandleProviderCallbackController.php:20
* @route '/auth/{provider}/callback'
*/
HandleProviderCallbackController.head = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: HandleProviderCallbackController.url(args, options),
    method: 'head',
})

export default HandleProviderCallbackController