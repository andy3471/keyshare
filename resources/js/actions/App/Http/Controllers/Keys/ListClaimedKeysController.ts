import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Keys\ListClaimedKeysController::__invoke
* @see app/Http/Controllers/Keys/ListClaimedKeysController.php:14
* @route '/keys/claimed'
*/
const ListClaimedKeysController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListClaimedKeysController.url(options),
    method: 'get',
})

ListClaimedKeysController.definition = {
    methods: ["get","head"],
    url: '/keys/claimed',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Keys\ListClaimedKeysController::__invoke
* @see app/Http/Controllers/Keys/ListClaimedKeysController.php:14
* @route '/keys/claimed'
*/
ListClaimedKeysController.url = (options?: RouteQueryOptions) => {
    return ListClaimedKeysController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Keys\ListClaimedKeysController::__invoke
* @see app/Http/Controllers/Keys/ListClaimedKeysController.php:14
* @route '/keys/claimed'
*/
ListClaimedKeysController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListClaimedKeysController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Keys\ListClaimedKeysController::__invoke
* @see app/Http/Controllers/Keys/ListClaimedKeysController.php:14
* @route '/keys/claimed'
*/
ListClaimedKeysController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListClaimedKeysController.url(options),
    method: 'head',
})

export default ListClaimedKeysController