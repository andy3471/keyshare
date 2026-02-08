import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Keys\SubmitKeyFeedbackController::__invoke
* @see app/Http/Controllers/Keys/SubmitKeyFeedbackController.php:15
* @route '/keys/{key}/feedback'
*/
const SubmitKeyFeedbackController = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: SubmitKeyFeedbackController.url(args, options),
    method: 'post',
})

SubmitKeyFeedbackController.definition = {
    methods: ["post"],
    url: '/keys/{key}/feedback',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Keys\SubmitKeyFeedbackController::__invoke
* @see app/Http/Controllers/Keys/SubmitKeyFeedbackController.php:15
* @route '/keys/{key}/feedback'
*/
SubmitKeyFeedbackController.url = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
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

    return SubmitKeyFeedbackController.definition.url
            .replace('{key}', parsedArgs.key.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Keys\SubmitKeyFeedbackController::__invoke
* @see app/Http/Controllers/Keys/SubmitKeyFeedbackController.php:15
* @route '/keys/{key}/feedback'
*/
SubmitKeyFeedbackController.post = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: SubmitKeyFeedbackController.url(args, options),
    method: 'post',
})

export default SubmitKeyFeedbackController