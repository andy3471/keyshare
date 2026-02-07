import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\GroupController::remove
* @see app/Http/Controllers/GroupController.php:180
* @route '/groups/{group}/members/{user}'
*/
export const remove = (args: { group: string | { id: string }, user: string | { id: string } } | [group: string | { id: string }, user: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: remove.url(args, options),
    method: 'delete',
})

remove.definition = {
    methods: ["delete"],
    url: '/groups/{group}/members/{user}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\GroupController::remove
* @see app/Http/Controllers/GroupController.php:180
* @route '/groups/{group}/members/{user}'
*/
remove.url = (args: { group: string | { id: string }, user: string | { id: string } } | [group: string | { id: string }, user: string | { id: string } ], options?: RouteQueryOptions) => {
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

    return remove.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GroupController::remove
* @see app/Http/Controllers/GroupController.php:180
* @route '/groups/{group}/members/{user}'
*/
remove.delete = (args: { group: string | { id: string }, user: string | { id: string } } | [group: string | { id: string }, user: string | { id: string } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: remove.url(args, options),
    method: 'delete',
})

const members = {
    remove: Object.assign(remove, remove),
}

export default members