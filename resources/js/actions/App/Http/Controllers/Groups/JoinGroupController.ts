import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Groups\JoinGroupController::__invoke
* @see app/Http/Controllers/Groups/JoinGroupController.php:13
* @route '/groups/{group}/join'
*/
const JoinGroupController = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: JoinGroupController.url(args, options),
    method: 'post',
})

JoinGroupController.definition = {
    methods: ["post"],
    url: '/groups/{group}/join',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Groups\JoinGroupController::__invoke
* @see app/Http/Controllers/Groups/JoinGroupController.php:13
* @route '/groups/{group}/join'
*/
JoinGroupController.url = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
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

    return JoinGroupController.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\JoinGroupController::__invoke
* @see app/Http/Controllers/Groups/JoinGroupController.php:13
* @route '/groups/{group}/join'
*/
JoinGroupController.post = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: JoinGroupController.url(args, options),
    method: 'post',
})

export default JoinGroupController