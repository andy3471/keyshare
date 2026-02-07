import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Front\KeyController::index
* @see app/Http/Controllers/Front/KeyController.php:162
* @route '/my/shared-keys'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/my/shared-keys',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\KeyController::index
* @see app/Http/Controllers/Front/KeyController.php:162
* @route '/my/shared-keys'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\KeyController::index
* @see app/Http/Controllers/Front/KeyController.php:162
* @route '/my/shared-keys'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\KeyController::index
* @see app/Http/Controllers/Front/KeyController.php:162
* @route '/my/shared-keys'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const shared = {
    index: Object.assign(index, index),
}

export default shared