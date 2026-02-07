import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:18
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
* @see app/Http/Controllers/SearchController.php:18
* @route '/search'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:18
* @route '/search'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SearchController::index
* @see app/Http/Controllers/SearchController.php:18
* @route '/search'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\SearchController::autoComplete
* @see app/Http/Controllers/SearchController.php:63
* @route '/autocomplete'
*/
export const autoComplete = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: autoComplete.url(options),
    method: 'get',
})

autoComplete.definition = {
    methods: ["get","head"],
    url: '/autocomplete',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SearchController::autoComplete
* @see app/Http/Controllers/SearchController.php:63
* @route '/autocomplete'
*/
autoComplete.url = (options?: RouteQueryOptions) => {
    return autoComplete.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SearchController::autoComplete
* @see app/Http/Controllers/SearchController.php:63
* @route '/autocomplete'
*/
autoComplete.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: autoComplete.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SearchController::autoComplete
* @see app/Http/Controllers/SearchController.php:63
* @route '/autocomplete'
*/
autoComplete.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: autoComplete.url(options),
    method: 'head',
})

const SearchController = { index, autoComplete }

export default SearchController