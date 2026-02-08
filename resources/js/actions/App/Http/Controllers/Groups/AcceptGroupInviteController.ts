import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Groups\AcceptGroupInviteController::__invoke
* @see app/Http/Controllers/Groups/AcceptGroupInviteController.php:14
* @route '/invite/{code}'
*/
const AcceptGroupInviteController = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AcceptGroupInviteController.url(args, options),
    method: 'get',
})

AcceptGroupInviteController.definition = {
    methods: ["get","head"],
    url: '/invite/{code}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Groups\AcceptGroupInviteController::__invoke
* @see app/Http/Controllers/Groups/AcceptGroupInviteController.php:14
* @route '/invite/{code}'
*/
AcceptGroupInviteController.url = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { code: args }
    }

    if (Array.isArray(args)) {
        args = {
            code: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        code: args.code,
    }

    return AcceptGroupInviteController.definition.url
            .replace('{code}', parsedArgs.code.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\AcceptGroupInviteController::__invoke
* @see app/Http/Controllers/Groups/AcceptGroupInviteController.php:14
* @route '/invite/{code}'
*/
AcceptGroupInviteController.get = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AcceptGroupInviteController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Groups\AcceptGroupInviteController::__invoke
* @see app/Http/Controllers/Groups/AcceptGroupInviteController.php:14
* @route '/invite/{code}'
*/
AcceptGroupInviteController.head = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: AcceptGroupInviteController.url(args, options),
    method: 'head',
})

export default AcceptGroupInviteController