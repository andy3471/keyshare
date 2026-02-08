import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
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

const credentials = {
    store: Object.assign(store, store),
}

export default credentials