import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Groups\SwitchGroupController::__invoke
* @see app/Http/Controllers/Groups/SwitchGroupController.php:14
* @route '/groups/switch'
*/
const SwitchGroupController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: SwitchGroupController.url(options),
    method: 'post',
})

SwitchGroupController.definition = {
    methods: ["post"],
    url: '/groups/switch',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Groups\SwitchGroupController::__invoke
* @see app/Http/Controllers/Groups/SwitchGroupController.php:14
* @route '/groups/switch'
*/
SwitchGroupController.url = (options?: RouteQueryOptions) => {
    return SwitchGroupController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\SwitchGroupController::__invoke
* @see app/Http/Controllers/Groups/SwitchGroupController.php:14
* @route '/groups/switch'
*/
SwitchGroupController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: SwitchGroupController.url(options),
    method: 'post',
})

export default SwitchGroupController