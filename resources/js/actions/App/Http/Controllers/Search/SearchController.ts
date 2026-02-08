import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Search\SearchController::__invoke
* @see app/Http/Controllers/Search/SearchController.php:18
* @route '/search'
*/
const SearchController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SearchController.url(options),
    method: 'get',
})

SearchController.definition = {
    methods: ["get","head"],
    url: '/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Search\SearchController::__invoke
* @see app/Http/Controllers/Search/SearchController.php:18
* @route '/search'
*/
SearchController.url = (options?: RouteQueryOptions) => {
    return SearchController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Search\SearchController::__invoke
* @see app/Http/Controllers/Search/SearchController.php:18
* @route '/search'
*/
SearchController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SearchController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Search\SearchController::__invoke
* @see app/Http/Controllers/Search/SearchController.php:18
* @route '/search'
*/
SearchController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SearchController.url(options),
    method: 'head',
})

export default SearchController