import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Front\KeyController::index
* @see app/Http/Controllers/Front/KeyController.php:145
* @route '/my/claimed-keys'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/my/claimed-keys',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\KeyController::index
* @see app/Http/Controllers/Front/KeyController.php:145
* @route '/my/claimed-keys'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\KeyController::index
* @see app/Http/Controllers/Front/KeyController.php:145
* @route '/my/claimed-keys'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\KeyController::index
* @see app/Http/Controllers/Front/KeyController.php:145
* @route '/my/claimed-keys'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const claimed = {
    index: Object.assign(index, index),
}

export default claimed