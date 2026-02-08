import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Onboarding\SkipOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/SkipOnboardingGroupController.php:13
* @route '/onboarding/group/skip'
*/
export const skip = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: skip.url(options),
    method: 'post',
})

skip.definition = {
    methods: ["post"],
    url: '/onboarding/group/skip',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Onboarding\SkipOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/SkipOnboardingGroupController.php:13
* @route '/onboarding/group/skip'
*/
skip.url = (options?: RouteQueryOptions) => {
    return skip.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Onboarding\SkipOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/SkipOnboardingGroupController.php:13
* @route '/onboarding/group/skip'
*/
skip.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: skip.url(options),
    method: 'post',
})

const group = {
    skip: Object.assign(skip, skip),
}

export default group