import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Front\GameController::index
* @see app/Http/Controllers/Front/GameController.php:20
* @route '/games'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/games',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\GameController::index
* @see app/Http/Controllers/Front/GameController.php:20
* @route '/games'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\GameController::index
* @see app/Http/Controllers/Front/GameController.php:20
* @route '/games'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\GameController::index
* @see app/Http/Controllers/Front/GameController.php:20
* @route '/games'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Front\GameController::show
* @see app/Http/Controllers/Front/GameController.php:38
* @route '/games/{game}'
*/
export const show = (args: { game: string | number | { id: string | number } } | [game: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/games/{game}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\GameController::show
* @see app/Http/Controllers/Front/GameController.php:38
* @route '/games/{game}'
*/
show.url = (args: { game: string | number | { id: string | number } } | [game: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { game: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { game: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            game: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        game: typeof args.game === 'object'
        ? args.game.id
        : args.game,
    }

    return show.definition.url
            .replace('{game}', parsedArgs.game.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\GameController::show
* @see app/Http/Controllers/Front/GameController.php:38
* @route '/games/{game}'
*/
show.get = (args: { game: string | number | { id: string | number } } | [game: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\GameController::show
* @see app/Http/Controllers/Front/GameController.php:38
* @route '/games/{game}'
*/
show.head = (args: { game: string | number | { id: string | number } } | [game: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const games = {
    index: Object.assign(index, index),
    show: Object.assign(show, show),
}

export default games