import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Groups\RemoveGroupMemberController::__invoke
* @see app/Http/Controllers/Groups/RemoveGroupMemberController.php:14
* @route '/groups/{group}/members/{user}'
*/
const RemoveGroupMemberController = (args: { group: string | { id: string }, user: string | { id: string } } | [group: string | { id: string }, user: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: RemoveGroupMemberController.url(args, options),
    method: 'delete',
})

RemoveGroupMemberController.definition = {
    methods: ["delete"],
    url: '/groups/{group}/members/{user}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Groups\RemoveGroupMemberController::__invoke
* @see app/Http/Controllers/Groups/RemoveGroupMemberController.php:14
* @route '/groups/{group}/members/{user}'
*/
RemoveGroupMemberController.url = (args: { group: string | { id: string }, user: string | { id: string } } | [group: string | { id: string }, user: string | { id: string } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            group: args[0],
            user: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        group: typeof args.group === 'object'
        ? args.group.id
        : args.group,
        user: typeof args.user === 'object'
        ? args.user.id
        : args.user,
    }

    return RemoveGroupMemberController.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\RemoveGroupMemberController::__invoke
* @see app/Http/Controllers/Groups/RemoveGroupMemberController.php:14
* @route '/groups/{group}/members/{user}'
*/
RemoveGroupMemberController.delete = (args: { group: string | { id: string }, user: string | { id: string } } | [group: string | { id: string }, user: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: RemoveGroupMemberController.url(args, options),
    method: 'delete',
})

export default RemoveGroupMemberController