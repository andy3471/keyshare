import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::create
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:19
* @route '/onboarding/credentials'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/onboarding/credentials',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::create
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:19
* @route '/onboarding/credentials'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::create
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:19
* @route '/onboarding/credentials'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::create
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:19
* @route '/onboarding/credentials'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::store
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:33
* @route '/onboarding/credentials'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/onboarding/credentials',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::store
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:33
* @route '/onboarding/credentials'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::store
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:33
* @route '/onboarding/credentials'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const OnboardingCredentialsController = { create, store }

export default OnboardingCredentialsController