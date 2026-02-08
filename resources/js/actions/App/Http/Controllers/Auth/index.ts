import LoginController from './LoginController'
import RegisterController from './RegisterController'
import ForgotPasswordController from './ForgotPasswordController'
import ResetPasswordController from './ResetPasswordController'
import RedirectToSteamController from './RedirectToSteamController'
import HandleSteamCallbackController from './HandleSteamCallbackController'

const Auth = {
    LoginController: Object.assign(LoginController, LoginController),
    RegisterController: Object.assign(RegisterController, RegisterController),
    ForgotPasswordController: Object.assign(ForgotPasswordController, ForgotPasswordController),
    ResetPasswordController: Object.assign(ResetPasswordController, ResetPasswordController),
    RedirectToSteamController: Object.assign(RedirectToSteamController, RedirectToSteamController),
    HandleSteamCallbackController: Object.assign(HandleSteamCallbackController, HandleSteamCallbackController),
}

export default Auth