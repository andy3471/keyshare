import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Keys\ClaimKeyController::__invoke
* @see app/Http/Controllers/Keys/ClaimKeyController.php:14
* @route '/keys/{key}/claim'
*/
const ClaimKeyController = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ClaimKeyController.url(args, options),
    method: 'post',
})

ClaimKeyController.definition = {
    methods: ["post"],
    url: '/keys/{key}/claim',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Keys\ClaimKeyController::__invoke
* @see app/Http/Controllers/Keys/ClaimKeyController.php:14
* @route '/keys/{key}/claim'
*/
ClaimKeyController.url = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { key: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { key: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            key: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        key: typeof args.key === 'object'
        ? args.key.id
        : args.key,
    }

    return ClaimKeyController.definition.url
            .replace('{key}', parsedArgs.key.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Keys\ClaimKeyController::__invoke
* @see app/Http/Controllers/Keys/ClaimKeyController.php:14
* @route '/keys/{key}/claim'
*/
ClaimKeyController.post = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ClaimKeyController.url(args, options),
    method: 'post',
})

export default ClaimKeyController