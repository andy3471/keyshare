import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Groups\RegenerateGroupInviteCodeController::__invoke
* @see app/Http/Controllers/Groups/RegenerateGroupInviteCodeController.php:13
* @route '/groups/{group}/regenerate-invite-code'
*/
const RegenerateGroupInviteCodeController = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RegenerateGroupInviteCodeController.url(args, options),
    method: 'post',
})

RegenerateGroupInviteCodeController.definition = {
    methods: ["post"],
    url: '/groups/{group}/regenerate-invite-code',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Groups\RegenerateGroupInviteCodeController::__invoke
* @see app/Http/Controllers/Groups/RegenerateGroupInviteCodeController.php:13
* @route '/groups/{group}/regenerate-invite-code'
*/
RegenerateGroupInviteCodeController.url = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { group: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { group: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            group: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        group: typeof args.group === 'object'
        ? args.group.id
        : args.group,
    }

    return RegenerateGroupInviteCodeController.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\RegenerateGroupInviteCodeController::__invoke
* @see app/Http/Controllers/Groups/RegenerateGroupInviteCodeController.php:13
* @route '/groups/{group}/regenerate-invite-code'
*/
RegenerateGroupInviteCodeController.post = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RegenerateGroupInviteCodeController.url(args, options),
    method: 'post',
})

export default RegenerateGroupInviteCodeController