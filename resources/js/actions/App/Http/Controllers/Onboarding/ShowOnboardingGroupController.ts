import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Onboarding\ShowOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/ShowOnboardingGroupController.php:17
* @route '/onboarding/group'
*/
const ShowOnboardingGroupController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ShowOnboardingGroupController.url(options),
    method: 'get',
})

ShowOnboardingGroupController.definition = {
    methods: ["get","head"],
    url: '/onboarding/group',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Onboarding\ShowOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/ShowOnboardingGroupController.php:17
* @route '/onboarding/group'
*/
ShowOnboardingGroupController.url = (options?: RouteQueryOptions) => {
    return ShowOnboardingGroupController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Onboarding\ShowOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/ShowOnboardingGroupController.php:17
* @route '/onboarding/group'
*/
ShowOnboardingGroupController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ShowOnboardingGroupController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Onboarding\ShowOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/ShowOnboardingGroupController.php:17
* @route '/onboarding/group'
*/
ShowOnboardingGroupController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ShowOnboardingGroupController.url(options),
    method: 'head',
})

export default ShowOnboardingGroupController