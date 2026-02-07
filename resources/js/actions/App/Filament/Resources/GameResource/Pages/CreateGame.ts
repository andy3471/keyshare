import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\GameResource\Pages\CreateGame::__invoke
* @see app/Filament/Resources/GameResource/Pages/CreateGame.php:7
* @route '/admin/games/create'
*/
const CreateGame = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateGame.url(options),
    method: 'get',
})

CreateGame.definition = {
    methods: ["get","head"],
    url: '/admin/games/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\GameResource\Pages\CreateGame::__invoke
* @see app/Filament/Resources/GameResource/Pages/CreateGame.php:7
* @route '/admin/games/create'
*/
CreateGame.url = (options?: RouteQueryOptions) => {
    return CreateGame.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\GameResource\Pages\CreateGame::__invoke
* @see app/Filament/Resources/GameResource/Pages/CreateGame.php:7
* @route '/admin/games/create'
*/
CreateGame.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateGame.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\GameResource\Pages\CreateGame::__invoke
* @see app/Filament/Resources/GameResource/Pages/CreateGame.php:7
* @route '/admin/games/create'
*/
CreateGame.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateGame.url(options),
    method: 'head',
})

export default CreateGame