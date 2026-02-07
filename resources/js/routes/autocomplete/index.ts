import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Front\SearchController::games
* @see app/Http/Controllers/Front/SearchController.php:99
* @route '/autocomplete/games'
*/
export const games = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: games.url(options),
    method: 'get',
})

games.definition = {
    methods: ["get","head"],
    url: '/autocomplete/games',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\SearchController::games
* @see app/Http/Controllers/Front/SearchController.php:99
* @route '/autocomplete/games'
*/
games.url = (options?: RouteQueryOptions) => {
    return games.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\SearchController::games
* @see app/Http/Controllers/Front/SearchController.php:99
* @route '/autocomplete/games'
*/
games.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: games.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\SearchController::games
* @see app/Http/Controllers/Front/SearchController.php:99
* @route '/autocomplete/games'
*/
games.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: games.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Front\SearchController::dlc
* @see app/Http/Controllers/Front/SearchController.php:113
* @route '/autocomplete/dlc/{gamename}'
*/
export const dlc = (args: { gamename: string | number } | [gamename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dlc.url(args, options),
    method: 'get',
})

dlc.definition = {
    methods: ["get","head"],
    url: '/autocomplete/dlc/{gamename}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Front\SearchController::dlc
* @see app/Http/Controllers/Front/SearchController.php:113
* @route '/autocomplete/dlc/{gamename}'
*/
dlc.url = (args: { gamename: string | number } | [gamename: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { gamename: args }
    }

    if (Array.isArray(args)) {
        args = {
            gamename: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        gamename: args.gamename,
    }

    return dlc.definition.url
            .replace('{gamename}', parsedArgs.gamename.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Front\SearchController::dlc
* @see app/Http/Controllers/Front/SearchController.php:113
* @route '/autocomplete/dlc/{gamename}'
*/
dlc.get = (args: { gamename: string | number } | [gamename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dlc.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Front\SearchController::dlc
* @see app/Http/Controllers/Front/SearchController.php:113
* @route '/autocomplete/dlc/{gamename}'
*/
dlc.head = (args: { gamename: string | number } | [gamename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dlc.url(args, options),
    method: 'head',
})

const autocomplete = {
    games: Object.assign(games, games),
    dlc: Object.assign(dlc, dlc),
}

export default autocomplete