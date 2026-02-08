import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Groups\LeaveGroupController::__invoke
* @see app/Http/Controllers/Groups/LeaveGroupController.php:13
* @route '/groups/{group}/leave'
*/
const LeaveGroupController = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: LeaveGroupController.url(args, options),
    method: 'post',
})

LeaveGroupController.definition = {
    methods: ["post"],
    url: '/groups/{group}/leave',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Groups\LeaveGroupController::__invoke
* @see app/Http/Controllers/Groups/LeaveGroupController.php:13
* @route '/groups/{group}/leave'
*/
LeaveGroupController.url = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
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

    return LeaveGroupController.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\LeaveGroupController::__invoke
* @see app/Http/Controllers/Groups/LeaveGroupController.php:13
* @route '/groups/{group}/leave'
*/
LeaveGroupController.post = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: LeaveGroupController.url(args, options),
    method: 'post',
})

export default LeaveGroupController