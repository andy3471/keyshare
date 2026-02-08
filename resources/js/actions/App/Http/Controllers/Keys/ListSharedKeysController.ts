import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Keys\ListSharedKeysController::__invoke
* @see app/Http/Controllers/Keys/ListSharedKeysController.php:14
* @route '/keys/shared'
*/
const ListSharedKeysController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSharedKeysController.url(options),
    method: 'get',
})

ListSharedKeysController.definition = {
    methods: ["get","head"],
    url: '/keys/shared',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Keys\ListSharedKeysController::__invoke
* @see app/Http/Controllers/Keys/ListSharedKeysController.php:14
* @route '/keys/shared'
*/
ListSharedKeysController.url = (options?: RouteQueryOptions) => {
    return ListSharedKeysController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Keys\ListSharedKeysController::__invoke
* @see app/Http/Controllers/Keys/ListSharedKeysController.php:14
* @route '/keys/shared'
*/
ListSharedKeysController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSharedKeysController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Keys\ListSharedKeysController::__invoke
* @see app/Http/Controllers/Keys/ListSharedKeysController.php:14
* @route '/keys/shared'
*/
ListSharedKeysController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListSharedKeysController.url(options),
    method: 'head',
})

export default ListSharedKeysController