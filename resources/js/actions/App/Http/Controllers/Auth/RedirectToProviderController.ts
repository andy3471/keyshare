import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\RedirectToProviderController::__invoke
* @see app/Http/Controllers/Auth/RedirectToProviderController.php:15
* @route '/auth/{provider}/redirect'
*/
const RedirectToProviderController = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectToProviderController.url(args, options),
    method: 'get',
})

RedirectToProviderController.definition = {
    methods: ["get","head"],
    url: '/auth/{provider}/redirect',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\RedirectToProviderController::__invoke
* @see app/Http/Controllers/Auth/RedirectToProviderController.php:15
* @route '/auth/{provider}/redirect'
*/
RedirectToProviderController.url = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return RedirectToProviderController.definition.url
            .replace('{provider}', parsedArgs.provider.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\RedirectToProviderController::__invoke
* @see app/Http/Controllers/Auth/RedirectToProviderController.php:15
* @route '/auth/{provider}/redirect'
*/
RedirectToProviderController.get = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectToProviderController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\RedirectToProviderController::__invoke
* @see app/Http/Controllers/Auth/RedirectToProviderController.php:15
* @route '/auth/{provider}/redirect'
*/
RedirectToProviderController.head = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RedirectToProviderController.url(args, options),
    method: 'head',
})

export default RedirectToProviderController