import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\UnlinkAccountController::__invoke
* @see app/Http/Controllers/Auth/UnlinkAccountController.php:14
* @route '/linked-accounts/{provider}'
*/
const UnlinkAccountController = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: UnlinkAccountController.url(args, options),
    method: 'delete',
})

UnlinkAccountController.definition = {
    methods: ["delete"],
    url: '/linked-accounts/{provider}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Auth\UnlinkAccountController::__invoke
* @see app/Http/Controllers/Auth/UnlinkAccountController.php:14
* @route '/linked-accounts/{provider}'
*/
UnlinkAccountController.url = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return UnlinkAccountController.definition.url
            .replace('{provider}', parsedArgs.provider.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\UnlinkAccountController::__invoke
* @see app/Http/Controllers/Auth/UnlinkAccountController.php:14
* @route '/linked-accounts/{provider}'
*/
UnlinkAccountController.delete = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: UnlinkAccountController.url(args, options),
    method: 'delete',
})

export default UnlinkAccountController