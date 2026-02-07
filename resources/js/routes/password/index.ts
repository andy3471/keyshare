import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
import reset0fffd7 from './reset'
/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::request
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:17
* @route '/password/reset'
*/
export const request = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: request.url(options),
    method: 'get',
})

request.definition = {
    methods: ["get","head"],
    url: '/password/reset',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::request
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:17
* @route '/password/reset'
*/
request.url = (options?: RouteQueryOptions) => {
    return request.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::request
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:17
* @route '/password/reset'
*/
request.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: request.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::request
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:17
* @route '/password/reset'
*/
request.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: request.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::email
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:28
* @route '/password/email'
*/
export const email = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: email.url(options),
    method: 'post',
})

email.definition = {
    methods: ["post"],
    url: '/password/email',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::email
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:28
* @route '/password/email'
*/
email.url = (options?: RouteQueryOptions) => {
    return email.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::email
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:28
* @route '/password/email'
*/
email.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: email.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::reset
* @see app/Http/Controllers/Auth/ResetPasswordController.php:27
* @route '/password/reset/{token}'
*/
export const reset = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reset.url(args, options),
    method: 'get',
})

reset.definition = {
    methods: ["get","head"],
    url: '/password/reset/{token}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::reset
* @see app/Http/Controllers/Auth/ResetPasswordController.php:27
* @route '/password/reset/{token}'
*/
reset.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { token: args }
    }

    if (Array.isArray(args)) {
        args = {
            token: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        token: args.token,
    }

    return reset.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::reset
* @see app/Http/Controllers/Auth/ResetPasswordController.php:27
* @route '/password/reset/{token}'
*/
reset.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reset.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::reset
* @see app/Http/Controllers/Auth/ResetPasswordController.php:27
* @route '/password/reset/{token}'
*/
reset.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reset.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::update
* @see app/Http/Controllers/Auth/ResetPasswordController.php:42
* @route '/password/reset'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/password/reset',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::update
* @see app/Http/Controllers/Auth/ResetPasswordController.php:42
* @route '/password/reset'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::update
* @see app/Http/Controllers/Auth/ResetPasswordController.php:42
* @route '/password/reset'
*/
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

const password = {
    request: Object.assign(request, request),
    email: Object.assign(email, email),
    reset: Object.assign(reset, reset0fffd7),
    update: Object.assign(update, update),
}

export default password