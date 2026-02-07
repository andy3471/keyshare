import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Games\Pages\ListGames::__invoke
* @see app/Filament/Resources/Games/Pages/ListGames.php:7
* @route '/admin/games'
*/
const ListGames = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListGames.url(options),
    method: 'get',
})

ListGames.definition = {
    methods: ["get","head"],
    url: '/admin/games',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Games\Pages\ListGames::__invoke
* @see app/Filament/Resources/Games/Pages/ListGames.php:7
* @route '/admin/games'
*/
ListGames.url = (options?: RouteQueryOptions) => {
    return ListGames.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Games\Pages\ListGames::__invoke
* @see app/Filament/Resources/Games/Pages/ListGames.php:7
* @route '/admin/games'
*/
ListGames.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListGames.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Games\Pages\ListGames::__invoke
* @see app/Filament/Resources/Games/Pages/ListGames.php:7
* @route '/admin/games'
*/
ListGames.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListGames.url(options),
    method: 'head',
})

export default ListGames