import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
import credentials6d75f0 from './credentials'
import group277fb7 from './group'
/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::credentials
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:19
* @route '/onboarding/credentials'
*/
export const credentials = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: credentials.url(options),
    method: 'get',
})

credentials.definition = {
    methods: ["get","head"],
    url: '/onboarding/credentials',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::credentials
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:19
* @route '/onboarding/credentials'
*/
credentials.url = (options?: RouteQueryOptions) => {
    return credentials.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::credentials
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:19
* @route '/onboarding/credentials'
*/
credentials.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: credentials.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Onboarding\OnboardingCredentialsController::credentials
* @see app/Http/Controllers/Onboarding/OnboardingCredentialsController.php:19
* @route '/onboarding/credentials'
*/
credentials.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: credentials.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Onboarding\ShowOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/ShowOnboardingGroupController.php:17
* @route '/onboarding/group'
*/
export const group = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: group.url(options),
    method: 'get',
})

group.definition = {
    methods: ["get","head"],
    url: '/onboarding/group',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Onboarding\ShowOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/ShowOnboardingGroupController.php:17
* @route '/onboarding/group'
*/
group.url = (options?: RouteQueryOptions) => {
    return group.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Onboarding\ShowOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/ShowOnboardingGroupController.php:17
* @route '/onboarding/group'
*/
group.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: group.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Onboarding\ShowOnboardingGroupController::__invoke
* @see app/Http/Controllers/Onboarding/ShowOnboardingGroupController.php:17
* @route '/onboarding/group'
*/
group.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: group.url(options),
    method: 'head',
})

const onboarding = {
    credentials: Object.assign(credentials, credentials6d75f0),
    group: Object.assign(group, group277fb7),
}

export default onboarding