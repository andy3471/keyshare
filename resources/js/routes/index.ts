import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../wayfinder'
/**
* @see vendor/marcreichel/igdb-laravel/routes/web.php:14
* @route '/igdb-webhook/handle/f9f4bbea/{model}/{method}'
*/
export const handleIgdbWebhook = (args: { model: string | number, method: string | number } | [model: string | number, method: string | number ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handleIgdbWebhook.url(args, options),
    method: 'post',
})

handleIgdbWebhook.definition = {
    methods: ["post"],
    url: '/igdb-webhook/handle/f9f4bbea/{model}/{method}',
} satisfies RouteDefinition<["post"]>

/**
* @see vendor/marcreichel/igdb-laravel/routes/web.php:14
* @route '/igdb-webhook/handle/f9f4bbea/{model}/{method}'
*/
handleIgdbWebhook.url = (args: { model: string | number, method: string | number } | [model: string | number, method: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            model: args[0],
            method: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        model: args.model,
        method: args.method,
    }

    return handleIgdbWebhook.definition.url
            .replace('{model}', parsedArgs.model.toString())
            .replace('{method}', parsedArgs.method.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see vendor/marcreichel/igdb-laravel/routes/web.php:14
* @route '/igdb-webhook/handle/f9f4bbea/{model}/{method}'
*/
handleIgdbWebhook.post = (args: { model: string | number, method: string | number } | [model: string | number, method: string | number ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handleIgdbWebhook.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Auth\LoginController::login
* @see app/Http/Controllers/Auth/LoginController.php:23
* @route '/login'
*/
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\LoginController::login
* @see app/Http/Controllers/Auth/LoginController.php:23
* @route '/login'
*/
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\LoginController::login
* @see app/Http/Controllers/Auth/LoginController.php:23
* @route '/login'
*/
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\LoginController::login
* @see app/Http/Controllers/Auth/LoginController.php:23
* @route '/login'
*/
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Auth\LoginController::logout
* @see app/Http/Controllers/Auth/LoginController.php:166
* @route '/logout'
*/
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Auth\LoginController::logout
* @see app/Http/Controllers/Auth/LoginController.php:166
* @route '/logout'
*/
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\LoginController::logout
* @see app/Http/Controllers/Auth/LoginController.php:166
* @route '/logout'
*/
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Auth\RegisterController::register
* @see app/Http/Controllers/Auth/RegisterController.php:26
* @route '/register'
*/
export const register = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})

register.definition = {
    methods: ["get","head"],
    url: '/register',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\RegisterController::register
* @see app/Http/Controllers/Auth/RegisterController.php:26
* @route '/register'
*/
register.url = (options?: RouteQueryOptions) => {
    return register.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\RegisterController::register
* @see app/Http/Controllers/Auth/RegisterController.php:26
* @route '/register'
*/
register.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\RegisterController::register
* @see app/Http/Controllers/Auth/RegisterController.php:26
* @route '/register'
*/
register.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: register.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\HomeController::index
* @see app/Http/Controllers/HomeController.php:23
* @route '/'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\HomeController::index
* @see app/Http/Controllers/HomeController.php:23
* @route '/'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\HomeController::index
* @see app/Http/Controllers/HomeController.php:23
* @route '/'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\HomeController::index
* @see app/Http/Controllers/HomeController.php:23
* @route '/'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

