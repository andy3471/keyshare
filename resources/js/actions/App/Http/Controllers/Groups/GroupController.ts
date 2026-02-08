import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Groups\GroupController::index
* @see app/Http/Controllers/Groups/GroupController.php:22
* @route '/groups'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/groups',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Groups\GroupController::index
* @see app/Http/Controllers/Groups/GroupController.php:22
* @route '/groups'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\GroupController::index
* @see app/Http/Controllers/Groups/GroupController.php:22
* @route '/groups'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::index
* @see app/Http/Controllers/Groups/GroupController.php:22
* @route '/groups'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::create
* @see app/Http/Controllers/Groups/GroupController.php:51
* @route '/groups/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/groups/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Groups\GroupController::create
* @see app/Http/Controllers/Groups/GroupController.php:51
* @route '/groups/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\GroupController::create
* @see app/Http/Controllers/Groups/GroupController.php:51
* @route '/groups/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::create
* @see app/Http/Controllers/Groups/GroupController.php:51
* @route '/groups/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::store
* @see app/Http/Controllers/Groups/GroupController.php:58
* @route '/groups'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/groups',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Groups\GroupController::store
* @see app/Http/Controllers/Groups/GroupController.php:58
* @route '/groups'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\GroupController::store
* @see app/Http/Controllers/Groups/GroupController.php:58
* @route '/groups'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::show
* @see app/Http/Controllers/Groups/GroupController.php:82
* @route '/groups/{group}'
*/
export const show = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/groups/{group}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Groups\GroupController::show
* @see app/Http/Controllers/Groups/GroupController.php:82
* @route '/groups/{group}'
*/
show.url = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { group: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { group: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            group: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        group: typeof args.group === 'object'
        ? args.group.id
        : args.group,
    }

    return show.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\GroupController::show
* @see app/Http/Controllers/Groups/GroupController.php:82
* @route '/groups/{group}'
*/
show.get = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::show
* @see app/Http/Controllers/Groups/GroupController.php:82
* @route '/groups/{group}'
*/
show.head = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::edit
* @see app/Http/Controllers/Groups/GroupController.php:102
* @route '/groups/{group}/edit'
*/
export const edit = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/groups/{group}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Groups\GroupController::edit
* @see app/Http/Controllers/Groups/GroupController.php:102
* @route '/groups/{group}/edit'
*/
edit.url = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { group: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { group: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            group: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        group: typeof args.group === 'object'
        ? args.group.id
        : args.group,
    }

    return edit.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\GroupController::edit
* @see app/Http/Controllers/Groups/GroupController.php:102
* @route '/groups/{group}/edit'
*/
edit.get = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::edit
* @see app/Http/Controllers/Groups/GroupController.php:102
* @route '/groups/{group}/edit'
*/
edit.head = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::update
* @see app/Http/Controllers/Groups/GroupController.php:114
* @route '/groups/{group}'
*/
export const update = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/groups/{group}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Groups\GroupController::update
* @see app/Http/Controllers/Groups/GroupController.php:114
* @route '/groups/{group}'
*/
update.url = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { group: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { group: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            group: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        group: typeof args.group === 'object'
        ? args.group.id
        : args.group,
    }

    return update.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\GroupController::update
* @see app/Http/Controllers/Groups/GroupController.php:114
* @route '/groups/{group}'
*/
update.put = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::update
* @see app/Http/Controllers/Groups/GroupController.php:114
* @route '/groups/{group}'
*/
update.patch = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Groups\GroupController::destroy
* @see app/Http/Controllers/Groups/GroupController.php:129
* @route '/groups/{group}'
*/
export const destroy = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/groups/{group}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Groups\GroupController::destroy
* @see app/Http/Controllers/Groups/GroupController.php:129
* @route '/groups/{group}'
*/
destroy.url = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { group: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { group: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            group: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        group: typeof args.group === 'object'
        ? args.group.id
        : args.group,
    }

    return destroy.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Groups\GroupController::destroy
* @see app/Http/Controllers/Groups/GroupController.php:129
* @route '/groups/{group}'
*/
destroy.delete = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const GroupController = { index, create, store, show, edit, update, destroy }

export default GroupController