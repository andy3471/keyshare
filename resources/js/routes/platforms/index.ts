import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Front\PlatformController::show
* @see app/Http/Controllers/Front/PlatformController.php:17
* @route '/platforms/{platform}'
*/
export const show = (args: { platform: string | number | { id: string | number } } | [platform: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/platforms/{platform}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\PlatformController::show
* @see app/Http/Controllers/Front/PlatformController.php:17
* @route '/platforms/{platform}'
*/
show.url = (args: { platform: string | number | { id: string | number } } | [platform: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { platform: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { platform: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            platform: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        platform: typeof args.platform === 'object'
        ? args.platform.id
        : args.platform,
    }

    return show.definition.url
            .replace('{platform}', parsedArgs.platform.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\PlatformController::show
* @see app/Http/Controllers/Front/PlatformController.php:17
* @route '/platforms/{platform}'
*/
show.get = (args: { platform: string | number | { id: string | number } } | [platform: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\PlatformController::show
* @see app/Http/Controllers/Front/PlatformController.php:17
* @route '/platforms/{platform}'
*/
show.head = (args: { platform: string | number | { id: string | number } } | [platform: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const platforms = {
    show: Object.assign(show, show),
}

export default platforms