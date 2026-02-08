import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::showLinkRequestForm
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:23
* @route '/password/reset'
*/
export const showLinkRequestForm = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showLinkRequestForm.url(options),
    method: 'get',
})

showLinkRequestForm.definition = {
    methods: ["get","head"],
    url: '/password/reset',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::showLinkRequestForm
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:23
* @route '/password/reset'
*/
showLinkRequestForm.url = (options?: RouteQueryOptions) => {
    return showLinkRequestForm.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::showLinkRequestForm
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:23
* @route '/password/reset'
*/
showLinkRequestForm.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showLinkRequestForm.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::showLinkRequestForm
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:23
* @route '/password/reset'
*/
showLinkRequestForm.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showLinkRequestForm.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::sendResetLinkEmail
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:28
* @route '/password/email'
*/
export const sendResetLinkEmail = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendResetLinkEmail.url(options),
    method: 'post',
})

sendResetLinkEmail.definition = {
    methods: ["post"],
    url: '/password/email',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::sendResetLinkEmail
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:28
* @route '/password/email'
*/
sendResetLinkEmail.url = (options?: RouteQueryOptions) => {
    return sendResetLinkEmail.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\ForgotPasswordController::sendResetLinkEmail
* @see app/Http/Controllers/Auth/ForgotPasswordController.php:28
* @route '/password/email'
*/
sendResetLinkEmail.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendResetLinkEmail.url(options),
    method: 'post',
})

const ForgotPasswordController = { showLinkRequestForm, sendResetLinkEmail }

export default ForgotPasswordController