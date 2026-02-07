import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Front\DlcController::show
* @see app/Http/Controllers/Front/DlcController.php:23
* @route '/dlc/{dlc}'
*/
export const show = (args: { dlc: string | number | { id: string | number } } | [dlc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/dlc/{dlc}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\DlcController::show
* @see app/Http/Controllers/Front/DlcController.php:23
* @route '/dlc/{dlc}'
*/
show.url = (args: { dlc: string | number | { id: string | number } } | [dlc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { dlc: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { dlc: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            dlc: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        dlc: typeof args.dlc === 'object'
        ? args.dlc.id
        : args.dlc,
    }

    return show.definition.url
            .replace('{dlc}', parsedArgs.dlc.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\DlcController::show
* @see app/Http/Controllers/Front/DlcController.php:23
* @route '/dlc/{dlc}'
*/
show.get = (args: { dlc: string | number | { id: string | number } } | [dlc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\DlcController::show
* @see app/Http/Controllers/Front/DlcController.php:23
* @route '/dlc/{dlc}'
*/
show.head = (args: { dlc: string | number | { id: string | number } } | [dlc: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const DlcController = { show }

export default DlcController