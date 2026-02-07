import LoginController from './LoginController'
import RegisterController from './RegisterController'
import ForgotPasswordController from './ForgotPasswordController'
import ResetPasswordController from './ResetPasswordController'
import SteamLoginController from './SteamLoginController'

const Auth = {
    LoginController: Object.assign(LoginController, LoginController),
    RegisterController: Object.assign(RegisterController, RegisterController),
    ForgotPasswordController: Object.assign(ForgotPasswordController, ForgotPasswordController),
    ResetPasswordController: Object.assign(ResetPasswordController, ResetPasswordController),
    SteamLoginController: Object.assign(SteamLoginController, SteamLoginController),
}

export default Auth