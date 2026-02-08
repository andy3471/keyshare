import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Search\AutocompleteSearchController::__invoke
* @see app/Http/Controllers/Search/AutocompleteSearchController.php:16
* @route '/autocomplete'
*/
const AutocompleteSearchController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AutocompleteSearchController.url(options),
    method: 'get',
})

AutocompleteSearchController.definition = {
    methods: ["get","head"],
    url: '/autocomplete',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Search\AutocompleteSearchController::__invoke
* @see app/Http/Controllers/Search/AutocompleteSearchController.php:16
* @route '/autocomplete'
*/
AutocompleteSearchController.url = (options?: RouteQueryOptions) => {
    return AutocompleteSearchController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Search\AutocompleteSearchController::__invoke
* @see app/Http/Controllers/Search/AutocompleteSearchController.php:16
* @route '/autocomplete'
*/
AutocompleteSearchController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AutocompleteSearchController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Search\AutocompleteSearchController::__invoke
* @see app/Http/Controllers/Search/AutocompleteSearchController.php:16
* @route '/autocomplete'
*/
AutocompleteSearchController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: AutocompleteSearchController.url(options),
    method: 'head',
})

export default AutocompleteSearchController