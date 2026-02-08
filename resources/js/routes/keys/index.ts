import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
import claimed from './claimed'
import shared from './shared'
/**
* @see \App\Http\Controllers\Keys\ClaimKeyController::__invoke
* @see app/Http/Controllers/Keys/ClaimKeyController.php:14
* @route '/keys/{key}/claim'
*/
export const claim = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: claim.url(args, options),
    method: 'post',
})

claim.definition = {
    methods: ["post"],
    url: '/keys/{key}/claim',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Keys\ClaimKeyController::__invoke
* @see app/Http/Controllers/Keys/ClaimKeyController.php:14
* @route '/keys/{key}/claim'
*/
claim.url = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
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

    return claim.definition.url
            .replace('{key}', parsedArgs.key.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Keys\ClaimKeyController::__invoke
* @see app/Http/Controllers/Keys/ClaimKeyController.php:14
* @route '/keys/{key}/claim'
*/
claim.post = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: claim.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Keys\SubmitKeyFeedbackController::__invoke
* @see app/Http/Controllers/Keys/SubmitKeyFeedbackController.php:15
* @route '/keys/{key}/feedback'
*/
export const feedback = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: feedback.url(args, options),
    method: 'post',
})

feedback.definition = {
    methods: ["post"],
    url: '/keys/{key}/feedback',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Keys\SubmitKeyFeedbackController::__invoke
* @see app/Http/Controllers/Keys/SubmitKeyFeedbackController.php:15
* @route '/keys/{key}/feedback'
*/
feedback.url = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
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

    return feedback.definition.url
            .replace('{key}', parsedArgs.key.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Keys\SubmitKeyFeedbackController::__invoke
* @see app/Http/Controllers/Keys/SubmitKeyFeedbackController.php:15
* @route '/keys/{key}/feedback'
*/
feedback.post = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: feedback.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Keys\KeyController::create
* @see app/Http/Controllers/Keys/KeyController.php:26
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
* @see \App\Http\Controllers\Keys\KeyController::create
* @see app/Http/Controllers/Keys/KeyController.php:26
* @route '/keys/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Keys\KeyController::create
* @see app/Http/Controllers/Keys/KeyController.php:26
* @route '/keys/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Keys\KeyController::create
* @see app/Http/Controllers/Keys/KeyController.php:26
* @route '/keys/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Keys\KeyController::store
* @see app/Http/Controllers/Keys/KeyController.php:43
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
* @see \App\Http\Controllers\Keys\KeyController::store
* @see app/Http/Controllers/Keys/KeyController.php:43
* @route '/keys'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Keys\KeyController::store
* @see app/Http/Controllers/Keys/KeyController.php:43
* @route '/keys'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Keys\KeyController::show
* @see app/Http/Controllers/Keys/KeyController.php:68
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
* @see \App\Http\Controllers\Keys\KeyController::show
* @see app/Http/Controllers/Keys/KeyController.php:68
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
* @see \App\Http\Controllers\Keys\KeyController::show
* @see app/Http/Controllers/Keys/KeyController.php:68
* @route '/keys/{key}'
*/
show.get = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Keys\KeyController::show
* @see app/Http/Controllers/Keys/KeyController.php:68
* @route '/keys/{key}'
*/
show.head = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Keys\KeyController::destroy
* @see app/Http/Controllers/Keys/KeyController.php:80
* @route '/keys/{key}'
*/
export const destroy = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/keys/{key}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Keys\KeyController::destroy
* @see app/Http/Controllers/Keys/KeyController.php:80
* @route '/keys/{key}'
*/
destroy.url = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{key}', parsedArgs.key.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Keys\KeyController::destroy
* @see app/Http/Controllers/Keys/KeyController.php:80
* @route '/keys/{key}'
*/
destroy.delete = (args: { key: string | { id: string } } | [key: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const keys = {
    claim: Object.assign(claim, claim),
    feedback: Object.assign(feedback, feedback),
    claimed: Object.assign(claimed, claimed),
    shared: Object.assign(shared, shared),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    show: Object.assign(show, show),
    destroy: Object.assign(destroy, destroy),
}

export default keys