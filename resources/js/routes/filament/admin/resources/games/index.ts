import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Games\Pages\ListGames::__invoke
* @see app/Filament/Resources/Games/Pages/ListGames.php:7
* @route '/admin/games'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/games',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Games\Pages\ListGames::__invoke
* @see app/Filament/Resources/Games/Pages/ListGames.php:7
* @route '/admin/games'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Games\Pages\ListGames::__invoke
* @see app/Filament/Resources/Games/Pages/ListGames.php:7
* @route '/admin/games'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Games\Pages\ListGames::__invoke
* @see app/Filament/Resources/Games/Pages/ListGames.php:7
* @route '/admin/games'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const games = {
    index: Object.assign(index, index),
}

export default games