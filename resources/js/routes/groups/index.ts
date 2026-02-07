import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
import members from './members'
/**
* @see \App\Http\Controllers\GroupController::index
* @see app/Http/Controllers/GroupController.php:21
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
* @see \App\Http\Controllers\GroupController::index
* @see app/Http/Controllers/GroupController.php:21
* @route '/groups'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\GroupController::index
* @see app/Http/Controllers/GroupController.php:21
* @route '/groups'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GroupController::index
* @see app/Http/Controllers/GroupController.php:21
* @route '/groups'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GroupController::create
* @see app/Http/Controllers/GroupController.php:41
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
* @see \App\Http\Controllers\GroupController::create
* @see app/Http/Controllers/GroupController.php:41
* @route '/groups/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\GroupController::create
* @see app/Http/Controllers/GroupController.php:41
* @route '/groups/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GroupController::create
* @see app/Http/Controllers/GroupController.php:41
* @route '/groups/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GroupController::store
* @see app/Http/Controllers/GroupController.php:48
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
* @see \App\Http\Controllers\GroupController::store
* @see app/Http/Controllers/GroupController.php:48
* @route '/groups'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\GroupController::store
* @see app/Http/Controllers/GroupController.php:48
* @route '/groups'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GroupController::show
* @see app/Http/Controllers/GroupController.php:72
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
* @see \App\Http\Controllers\GroupController::show
* @see app/Http/Controllers/GroupController.php:72
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
* @see \App\Http\Controllers\GroupController::show
* @see app/Http/Controllers/GroupController.php:72
* @route '/groups/{group}'
*/
show.get = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GroupController::show
* @see app/Http/Controllers/GroupController.php:72
* @route '/groups/{group}'
*/
show.head = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GroupController::edit
* @see app/Http/Controllers/GroupController.php:88
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
* @see \App\Http\Controllers\GroupController::edit
* @see app/Http/Controllers/GroupController.php:88
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
* @see \App\Http\Controllers\GroupController::edit
* @see app/Http/Controllers/GroupController.php:88
* @route '/groups/{group}/edit'
*/
edit.get = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GroupController::edit
* @see app/Http/Controllers/GroupController.php:88
* @route '/groups/{group}/edit'
*/
edit.head = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\GroupController::update
* @see app/Http/Controllers/GroupController.php:97
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
* @see \App\Http\Controllers\GroupController::update
* @see app/Http/Controllers/GroupController.php:97
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
* @see \App\Http\Controllers\GroupController::update
* @see app/Http/Controllers/GroupController.php:97
* @route '/groups/{group}'
*/
update.put = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\GroupController::update
* @see app/Http/Controllers/GroupController.php:97
* @route '/groups/{group}'
*/
update.patch = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\GroupController::destroy
* @see app/Http/Controllers/GroupController.php:112
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
* @see \App\Http\Controllers\GroupController::destroy
* @see app/Http/Controllers/GroupController.php:112
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
* @see \App\Http\Controllers\GroupController::destroy
* @see app/Http/Controllers/GroupController.php:112
* @route '/groups/{group}'
*/
destroy.delete = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\GroupController::join
* @see app/Http/Controllers/GroupController.php:126
* @route '/groups/{group}/join'
*/
export const join = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: join.url(args, options),
    method: 'post',
})

join.definition = {
    methods: ["post"],
    url: '/groups/{group}/join',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\GroupController::join
* @see app/Http/Controllers/GroupController.php:126
* @route '/groups/{group}/join'
*/
join.url = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
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

    return join.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GroupController::join
* @see app/Http/Controllers/GroupController.php:126
* @route '/groups/{group}/join'
*/
join.post = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: join.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GroupController::leave
* @see app/Http/Controllers/GroupController.php:166
* @route '/groups/{group}/leave'
*/
export const leave = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: leave.url(args, options),
    method: 'post',
})

leave.definition = {
    methods: ["post"],
    url: '/groups/{group}/leave',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\GroupController::leave
* @see app/Http/Controllers/GroupController.php:166
* @route '/groups/{group}/leave'
*/
leave.url = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
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

    return leave.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GroupController::leave
* @see app/Http/Controllers/GroupController.php:166
* @route '/groups/{group}/leave'
*/
leave.post = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: leave.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GroupController::regenerateInviteCode
* @see app/Http/Controllers/GroupController.php:208
* @route '/groups/{group}/regenerate-invite-code'
*/
export const regenerateInviteCode = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: regenerateInviteCode.url(args, options),
    method: 'post',
})

regenerateInviteCode.definition = {
    methods: ["post"],
    url: '/groups/{group}/regenerate-invite-code',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\GroupController::regenerateInviteCode
* @see app/Http/Controllers/GroupController.php:208
* @route '/groups/{group}/regenerate-invite-code'
*/
regenerateInviteCode.url = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions) => {
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

    return regenerateInviteCode.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GroupController::regenerateInviteCode
* @see app/Http/Controllers/GroupController.php:208
* @route '/groups/{group}/regenerate-invite-code'
*/
regenerateInviteCode.post = (args: { group: string | { id: string } } | [group: string | { id: string } ] | string | { id: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: regenerateInviteCode.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GroupController::switchMethod
* @see app/Http/Controllers/GroupController.php:193
* @route '/groups/switch'
*/
export const switchMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: switchMethod.url(options),
    method: 'post',
})

switchMethod.definition = {
    methods: ["post"],
    url: '/groups/switch',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\GroupController::switchMethod
* @see app/Http/Controllers/GroupController.php:193
* @route '/groups/switch'
*/
switchMethod.url = (options?: RouteQueryOptions) => {
    return switchMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\GroupController::switchMethod
* @see app/Http/Controllers/GroupController.php:193
* @route '/groups/switch'
*/
switchMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: switchMethod.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\GroupController::joinViaCode
* @see app/Http/Controllers/GroupController.php:146
* @route '/invite/{code}'
*/
export const joinViaCode = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: joinViaCode.url(args, options),
    method: 'get',
})

joinViaCode.definition = {
    methods: ["get","head"],
    url: '/invite/{code}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\GroupController::joinViaCode
* @see app/Http/Controllers/GroupController.php:146
* @route '/invite/{code}'
*/
joinViaCode.url = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { code: args }
    }

    if (Array.isArray(args)) {
        args = {
            code: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        code: args.code,
    }

    return joinViaCode.definition.url
            .replace('{code}', parsedArgs.code.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\GroupController::joinViaCode
* @see app/Http/Controllers/GroupController.php:146
* @route '/invite/{code}'
*/
joinViaCode.get = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: joinViaCode.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\GroupController::joinViaCode
* @see app/Http/Controllers/GroupController.php:146
* @route '/invite/{code}'
*/
joinViaCode.head = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: joinViaCode.url(args, options),
    method: 'head',
})

const groups = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    show: Object.assign(show, show),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
    join: Object.assign(join, join),
    leave: Object.assign(leave, leave),
    members: Object.assign(members, members),
    regenerateInviteCode: Object.assign(regenerateInviteCode, regenerateInviteCode),
    switch: Object.assign(switchMethod, switchMethod),
    joinViaCode: Object.assign(joinViaCode, joinViaCode),
}

export default groups