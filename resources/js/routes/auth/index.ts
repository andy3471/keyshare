import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
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
* @see \App\Http\Controllers\Front\HomeController::demoMode
* @see app/Http/Controllers/Front/HomeController.php:38
* @route '/demo'
*/
export const demoMode = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: demoMode.url(options),
    method: 'get',
})

demoMode.definition = {
    methods: ["get","head"],
    url: '/demo',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\HomeController::demoMode
* @see app/Http/Controllers/Front/HomeController.php:38
* @route '/demo'
*/
demoMode.url = (options?: RouteQueryOptions) => {
    return demoMode.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\HomeController::demoMode
* @see app/Http/Controllers/Front/HomeController.php:38
* @route '/demo'
*/
demoMode.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: demoMode.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\HomeController::demoMode
* @see app/Http/Controllers/Front/HomeController.php:38
* @route '/demo'
*/
demoMode.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: demoMode.url(options),
    method: 'head',
})

const auth = {
    notApproved: Object.assign(notApproved, notApproved),
    demoMode: Object.assign(demoMode, demoMode),
}

export default auth