import WelcomeController from './WelcomeController'
import Auth from './Auth'
import Groups from './Groups'
import Onboarding from './Onboarding'
import Games from './Games'
import Search from './Search'
import Keys from './Keys'
import Users from './Users'

const Controllers = {
    WelcomeController: Object.assign(WelcomeController, WelcomeController),
    Auth: Object.assign(Auth, Auth),
    Groups: Object.assign(Groups, Groups),
    Onboarding: Object.assign(Onboarding, Onboarding),
    Games: Object.assign(Games, Games),
    Search: Object.assign(Search, Search),
    Keys: Object.assign(Keys, Keys),
    Users: Object.assign(Users, Users),
}

export default Controllers