import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Onboarding\SkipOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/SkipOnboardingGroupController.php:13
* @route '/onboarding/group/skip'
*/
const SkipOnboardingGroupController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: SkipOnboardingGroupController.url(options),
    method: 'post',
})

SkipOnboardingGroupController.definition = {
    methods: ["post"],
    url: '/onboarding/group/skip',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Onboarding\SkipOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/SkipOnboardingGroupController.php:13
* @route '/onboarding/group/skip'
*/
SkipOnboardingGroupController.url = (options?: RouteQueryOptions) => {
    return SkipOnboardingGroupController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Onboarding\SkipOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/SkipOnboardingGroupController.php:13
* @route '/onboarding/group/skip'
*/
SkipOnboardingGroupController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: SkipOnboardingGroupController.url(options),
    method: 'post',
})

export default SkipOnboardingGroupController