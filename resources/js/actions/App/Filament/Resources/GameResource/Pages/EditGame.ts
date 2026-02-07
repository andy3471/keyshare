import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\GameResource\Pages\EditGame::__invoke
* @see app/Filament/Resources/GameResource/Pages/EditGame.php:7
* @route '/admin/games/{record}/edit'
*/
const EditGame = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditGame.url(args, options),
    method: 'get',
})

EditGame.definition = {
    methods: ["get","head"],
    url: '/admin/games/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\GameResource\Pages\EditGame::__invoke
* @see app/Filament/Resources/GameResource/Pages/EditGame.php:7
* @route '/admin/games/{record}/edit'
*/
EditGame.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        record: args.record,
    }

    return EditGame.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\GameResource\Pages\EditGame::__invoke
* @see app/Filament/Resources/GameResource/Pages/EditGame.php:7
* @route '/admin/games/{record}/edit'
*/
EditGame.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditGame.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\GameResource\Pages\EditGame::__invoke
* @see app/Filament/Resources/GameResource/Pages/EditGame.php:7
* @route '/admin/games/{record}/edit'
*/
EditGame.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditGame.url(args, options),
    method: 'head',
})

export default EditGame