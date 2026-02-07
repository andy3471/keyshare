import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\KeyController::create
* @see app/Http/Controllers/KeyController.php:24
* @route '/keys/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/keys/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KeyController::create
* @see app/Http/Controllers/KeyController.php:24
* @route '/keys/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KeyController::create
* @see app/Http/Controllers/KeyController.php:24
* @route '/keys/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KeyController::create
* @see app/Http/Controllers/KeyController.php:24
* @route '/keys/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\KeyController::store
* @see app/Http/Controllers/KeyController.php:33
* @route '/keys'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/keys',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\KeyController::store
* @see app/Http/Controllers/KeyController.php:33
* @route '/keys'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KeyController::store
* @see app/Http/Controllers/KeyController.php:33
* @route '/keys'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\KeyController::show
* @see app/Http/Controllers/KeyController.php:56
* @route '/keys/{key}'
*/
export const show = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/keys/{key}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KeyController::show
* @see app/Http/Controllers/KeyController.php:56
* @route '/keys/{key}'
*/
show.url = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { key: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { key: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            key: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        key: typeof args.key === 'object'
        ? args.key.id
        : args.key,
    }

    return show.definition.url
            .replace('{key}', parsedArgs.key.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\KeyController::show
* @see app/Http/Controllers/KeyController.php:56
* @route '/keys/{key}'
*/
show.get = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KeyController::show
* @see app/Http/Controllers/KeyController.php:56
* @route '/keys/{key}'
*/
show.head = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\KeyController::claim
* @see app/Http/Controllers/KeyController.php:66
* @route '/keys/claim'
*/
export const claim = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: claim.url(options),
    method: 'post',
})

claim.definition = {
    methods: ["post"],
    url: '/keys/claim',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\KeyController::claim
* @see app/Http/Controllers/KeyController.php:66
* @route '/keys/claim'
*/
claim.url = (options?: RouteQueryOptions) => {
    return claim.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KeyController::claim
* @see app/Http/Controllers/KeyController.php:66
* @route '/keys/claim'
*/
claim.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: claim.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\KeyController::claimed
* @see app/Http/Controllers/KeyController.php:78
* @route '/keys/claimed'
*/
export const claimed = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: claimed.url(options),
    method: 'get',
})

claimed.definition = {
    methods: ["get","head"],
    url: '/keys/claimed',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KeyController::claimed
* @see app/Http/Controllers/KeyController.php:78
* @route '/keys/claimed'
*/
claimed.url = (options?: RouteQueryOptions) => {
    return claimed.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KeyController::claimed
* @see app/Http/Controllers/KeyController.php:78
* @route '/keys/claimed'
*/
claimed.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: claimed.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KeyController::claimed
* @see app/Http/Controllers/KeyController.php:78
* @route '/keys/claimed'
*/
claimed.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: claimed.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\KeyController::shared
* @see app/Http/Controllers/KeyController.php:90
* @route '/keys/shared'
*/
export const shared = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: shared.url(options),
    method: 'get',
})

shared.definition = {
    methods: ["get","head"],
    url: '/keys/shared',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KeyController::shared
* @see app/Http/Controllers/KeyController.php:90
* @route '/keys/shared'
*/
shared.url = (options?: RouteQueryOptions) => {
    return shared.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KeyController::shared
* @see app/Http/Controllers/KeyController.php:90
* @route '/keys/shared'
*/
shared.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: shared.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KeyController::shared
* @see app/Http/Controllers/KeyController.php:90
* @route '/keys/shared'
*/
shared.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: shared.url(options),
    method: 'head',
})

const KeyController = { create, store, show, claim, claimed, shared }

export default KeyController