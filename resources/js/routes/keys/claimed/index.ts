import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\KeyController::index
* @see app/Http/Controllers/KeyController.php:104
* @route '/keys/claimed'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/keys/claimed',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KeyController::index
* @see app/Http/Controllers/KeyController.php:104
* @route '/keys/claimed'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KeyController::index
* @see app/Http/Controllers/KeyController.php:104
* @route '/keys/claimed'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KeyController::index
* @see app/Http/Controllers/KeyController.php:104
* @route '/keys/claimed'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const claimed = {
    index: Object.assign(index, index),
}

export default claimed