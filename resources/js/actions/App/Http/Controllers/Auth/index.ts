import LoginController from './LoginController'
import RegisterController from './RegisterController'
import ForgotPasswordController from './ForgotPasswordController'
import ResetPasswordController from './ResetPasswordController'
import RedirectToProviderController from './RedirectToProviderController'
import HandleProviderCallbackController from './HandleProviderCallbackController'
import UnlinkAccountController from './UnlinkAccountController'

const Auth = {
    LoginController: Object.assign(LoginController, LoginController),
    RegisterController: Object.assign(RegisterController, RegisterController),
    ForgotPasswordController: Object.assign(ForgotPasswordController, ForgotPasswordController),
    ResetPasswordController: Object.assign(ResetPasswordController, ResetPasswordController),
    RedirectToProviderController: Object.assign(RedirectToProviderController, RedirectToProviderController),
    HandleProviderCallbackController: Object.assign(HandleProviderCallbackController, HandleProviderCallbackController),
    UnlinkAccountController: Object.assign(UnlinkAccountController, UnlinkAccountController),
}

export default Auth