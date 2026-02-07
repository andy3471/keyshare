import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Front\HomeController::notApproved
* @see app/Http/Controllers/Front/HomeController.php:33
* @route '/not-approved'
*/
export const notApproved = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: notApproved.url(options),
    method: 'get',
})

notApproved.definition = {
    methods: ["get","head"],
    url: '/not-approved',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\HomeController::notApproved
* @see app/Http/Controllers/Front/HomeController.php:33
* @route '/not-approved'
*/
notApproved.url = (options?: RouteQueryOptions) => {
    return notApproved.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\HomeController::notApproved
* @see app/Http/Controllers/Front/HomeController.php:33
* @route '/not-approved'
*/
notApproved.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: notApproved.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\HomeController::notApproved
* @see app/Http/Controllers/Front/HomeController.php:33
* @route '/not-approved'
*/
notApproved.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: notApproved.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Front\HomeController::demo
* @see app/Http/Controllers/Front/HomeController.php:38
* @route '/demo'
*/
export const demo = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: demo.url(options),
    method: 'get',
})

demo.definition = {
    methods: ["get","head"],
    url: '/demo',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\HomeController::demo
* @see app/Http/Controllers/Front/HomeController.php:38
* @route '/demo'
*/
demo.url = (options?: RouteQueryOptions) => {
    return demo.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\HomeController::demo
* @see app/Http/Controllers/Front/HomeController.php:38
* @route '/demo'
*/
demo.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: demo.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\HomeController::demo
* @see app/Http/Controllers/Front/HomeController.php:38
* @route '/demo'
*/
demo.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: demo.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Front\HomeController::index
* @see app/Http/Controllers/Front/HomeController.php:24
* @route '/'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\HomeController::index
* @see app/Http/Controllers/Front/HomeController.php:24
* @route '/'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\HomeController::index
* @see app/Http/Controllers/Front/HomeController.php:24
* @route '/'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\HomeController::index
* @see app/Http/Controllers/Front/HomeController.php:24
* @route '/'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const HomeController = { notApproved, demo, index }

export default HomeController