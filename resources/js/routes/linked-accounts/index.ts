import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\UnlinkAccountController::__invoke
* @see app/Http/Controllers/Auth/UnlinkAccountController.php:14
* @route '/linked-accounts/{provider}'
*/
export const destroy = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/linked-accounts/{provider}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Auth\UnlinkAccountController::__invoke
* @see app/Http/Controllers/Auth/UnlinkAccountController.php:14
* @route '/linked-accounts/{provider}'
*/
destroy.url = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{provider}', parsedArgs.provider.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\UnlinkAccountController::__invoke
* @see app/Http/Controllers/Auth/UnlinkAccountController.php:14
* @route '/linked-accounts/{provider}'
*/
destroy.delete = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const linkedAccounts = {
    destroy: Object.assign(destroy, destroy),
}

export default linkedAccounts