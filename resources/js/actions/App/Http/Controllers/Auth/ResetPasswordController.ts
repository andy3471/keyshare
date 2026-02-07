import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::showResetForm
* @see app/Http/Controllers/Auth/ResetPasswordController.php:27
* @route '/password/reset/{token}'
*/
export const showResetForm = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showResetForm.url(args, options),
    method: 'get',
})

showResetForm.definition = {
    methods: ["get","head"],
    url: '/password/reset/{token}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::showResetForm
* @see app/Http/Controllers/Auth/ResetPasswordController.php:27
* @route '/password/reset/{token}'
*/
showResetForm.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return showResetForm.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::showResetForm
* @see app/Http/Controllers/Auth/ResetPasswordController.php:27
* @route '/password/reset/{token}'
*/
showResetForm.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showResetForm.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::showResetForm
* @see app/Http/Controllers/Auth/ResetPasswordController.php:27
* @route '/password/reset/{token}'
*/
showResetForm.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showResetForm.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::reset
* @see app/Http/Controllers/Auth/ResetPasswordController.php:42
* @route '/password/reset'
*/
export const reset = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reset.url(options),
    method: 'post',
})

reset.definition = {
    methods: ["post"],
    url: '/password/reset',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::reset
* @see app/Http/Controllers/Auth/ResetPasswordController.php:42
* @route '/password/reset'
*/
reset.url = (options?: RouteQueryOptions) => {
    return reset.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\ResetPasswordController::reset
* @see app/Http/Controllers/Auth/ResetPasswordController.php:42
* @route '/password/reset'
*/
reset.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reset.url(options),
    method: 'post',
})

const ResetPasswordController = { showResetForm, reset }

export default ResetPasswordController