import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:18
* @route '/search'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:18
* @route '/search'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:18
* @route '/search'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:18
* @route '/search'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const search = {
    index: Object.assign(index, index),
}

export default search