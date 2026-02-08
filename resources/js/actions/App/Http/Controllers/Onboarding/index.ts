import OnboardingCredentialsController from './OnboardingCredentialsController'
import ShowOnboardingGroupController from './ShowOnboardingGroupController'
import SkipOnboardingGroupController from './SkipOnboardingGroupController'

const Onboarding = {
    OnboardingCredentialsController: Object.assign(OnboardingCredentialsController, OnboardingCredentialsController),
    ShowOnboardingGroupController: Object.assign(ShowOnboardingGroupController, ShowOnboardingGroupController),
    SkipOnboardingGroupController: Object.assign(SkipOnboardingGroupController, SkipOnboardingGroupController),
}

export default Onboarding