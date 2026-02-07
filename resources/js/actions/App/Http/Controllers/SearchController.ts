import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:20
* @route '/search'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:20
* @route '/search'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:20
* @route '/search'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:20
* @route '/search'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\SearchController::autoCompleteGames
* @see app/Http/Controllers/SearchController.php:63
* @route '/autocomplete/games'
*/
export const autoCompleteGames = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: autoCompleteGames.url(options),
    method: 'get',
})

autoCompleteGames.definition = {
    methods: ["get","head"],
    url: '/autocomplete/games',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SearchController::autoCompleteGames
* @see app/Http/Controllers/SearchController.php:63
* @route '/autocomplete/games'
*/
autoCompleteGames.url = (options?: RouteQueryOptions) => {
    return autoCompleteGames.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SearchController::autoCompleteGames
* @see app/Http/Controllers/SearchController.php:63
* @route '/autocomplete/games'
*/
autoCompleteGames.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: autoCompleteGames.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SearchController::autoCompleteGames
* @see app/Http/Controllers/SearchController.php:63
* @route '/autocomplete/games'
*/
autoCompleteGames.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: autoCompleteGames.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\SearchController::autoCompleteDlc
* @see app/Http/Controllers/SearchController.php:0
* @route '/autocomplete/dlc/{gamename}'
*/
export const autoCompleteDlc = (args: { gamename: string | number } | [gamename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: autoCompleteDlc.url(args, options),
    method: 'get',
})

autoCompleteDlc.definition = {
    methods: ["get","head"],
    url: '/autocomplete/dlc/{gamename}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SearchController::autoCompleteDlc
* @see app/Http/Controllers/SearchController.php:0
* @route '/autocomplete/dlc/{gamename}'
*/
autoCompleteDlc.url = (args: { gamename: string | number } | [gamename: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return autoCompleteDlc.definition.url
            .replace('{gamename}', parsedArgs.gamename.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\SearchController::autoCompleteDlc
* @see app/Http/Controllers/SearchController.php:0
* @route '/autocomplete/dlc/{gamename}'
*/
autoCompleteDlc.get = (args: { gamename: string | number } | [gamename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: autoCompleteDlc.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SearchController::autoCompleteDlc
* @see app/Http/Controllers/SearchController.php:0
* @route '/autocomplete/dlc/{gamename}'
*/
autoCompleteDlc.head = (args: { gamename: string | number } | [gamename: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: autoCompleteDlc.url(args, options),
    method: 'head',
})

const SearchController = { index, autoCompleteGames, autoCompleteDlc }

export default SearchController