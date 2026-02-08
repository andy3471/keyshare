import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Games\GameController::index
* @see app/Http/Controllers/Games/GameController.php:23
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
* @see \App\Http\Controllers\Games\GameController::index
* @see app/Http/Controllers/Games/GameController.php:23
* @route '/games'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Games\GameController::index
* @see app/Http/Controllers/Games/GameController.php:23
* @route '/games'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Games\GameController::index
* @see app/Http/Controllers/Games/GameController.php:23
* @route '/games'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Games\GameController::show
* @see app/Http/Controllers/Games/GameController.php:62
* @route '/games/{igdb_id}'
*/
export const show = (args: { igdb_id: string | number } | [igdb_id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/games/{igdb_id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Games\GameController::show
* @see app/Http/Controllers/Games/GameController.php:62
* @route '/games/{igdb_id}'
*/
show.url = (args: { igdb_id: string | number } | [igdb_id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { igdb_id: args }
    }

    if (Array.isArray(args)) {
        args = {
            igdb_id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        igdb_id: args.igdb_id,
    }

    return show.definition.url
            .replace('{igdb_id}', parsedArgs.igdb_id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Games\GameController::show
* @see app/Http/Controllers/Games/GameController.php:62
* @route '/games/{igdb_id}'
*/
show.get = (args: { igdb_id: string | number } | [igdb_id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Games\GameController::show
* @see app/Http/Controllers/Games/GameController.php:62
* @route '/games/{igdb_id}'
*/
show.head = (args: { igdb_id: string | number } | [igdb_id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const games = {
    index: Object.assign(index, index),
    show: Object.assign(show, show),
}

export default games