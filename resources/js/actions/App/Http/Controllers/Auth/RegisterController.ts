import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\RegisterController::showRegistrationForm
* @see app/Http/Controllers/Auth/RegisterController.php:27
* @route '/register'
*/
export const showRegistrationForm = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showRegistrationForm.url(options),
    method: 'get',
})

showRegistrationForm.definition = {
    methods: ["get","head"],
    url: '/register',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\RegisterController::showRegistrationForm
* @see app/Http/Controllers/Auth/RegisterController.php:27
* @route '/register'
*/
showRegistrationForm.url = (options?: RouteQueryOptions) => {
    return showRegistrationForm.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\RegisterController::showRegistrationForm
* @see app/Http/Controllers/Auth/RegisterController.php:27
* @route '/register'
*/
showRegistrationForm.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: showRegistrationForm.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\RegisterController::showRegistrationForm
* @see app/Http/Controllers/Auth/RegisterController.php:27
* @route '/register'
*/
showRegistrationForm.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: showRegistrationForm.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Auth\RegisterController::register
* @see app/Http/Controllers/Auth/RegisterController.php:30
* @route '/register'
*/
export const register = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: register.url(options),
    method: 'post',
})

register.definition = {
    methods: ["post"],
    url: '/register',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Auth\RegisterController::register
* @see app/Http/Controllers/Auth/RegisterController.php:30
* @route '/register'
*/
register.url = (options?: RouteQueryOptions) => {
    return register.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\RegisterController::register
* @see app/Http/Controllers/Auth/RegisterController.php:30
* @route '/register'
*/
register.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: register.url(options),
    method: 'post',
})

const RegisterController = { showRegistrationForm, register }

export default RegisterController