import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Front\UserController::request
* @see app/Http/Controllers/Front/UserController.php:63
* @route '/change-password'
*/
export const request = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: request.url(options),
    method: 'get',
})

request.definition = {
    methods: ["get","head"],
    url: '/change-password',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\UserController::request
* @see app/Http/Controllers/Front/UserController.php:63
* @route '/change-password'
*/
request.url = (options?: RouteQueryOptions) => {
    return request.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\UserController::request
* @see app/Http/Controllers/Front/UserController.php:63
* @route '/change-password'
*/
request.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: request.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\UserController::request
* @see app/Http/Controllers/Front/UserController.php:63
* @route '/change-password'
*/
request.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: request.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Front\UserController::save
* @see app/Http/Controllers/Front/UserController.php:71
* @route '/change-password'
*/
export const save = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: save.url(options),
    method: 'post',
})

save.definition = {
    methods: ["post"],
    url: '/change-password',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Front\UserController::save
* @see app/Http/Controllers/Front/UserController.php:71
* @route '/change-password'
*/
save.url = (options?: RouteQueryOptions) => {
    return save.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\UserController::save
* @see app/Http/Controllers/Front/UserController.php:71
* @route '/change-password'
*/
save.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: save.url(options),
    method: 'post',
})

const reset = {
    request: Object.assign(request, request),
    save: Object.assign(save, save),
}

export default reset