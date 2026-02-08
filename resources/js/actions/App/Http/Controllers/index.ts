import WelcomeController from './WelcomeController'
import Auth from './Auth'
import Games from './Games'
import Search from './Search'
import Keys from './Keys'
import Users from './Users'
import Groups from './Groups'

const Controllers = {
    WelcomeController: Object.assign(WelcomeController, WelcomeController),
    Auth: Object.assign(Auth, Auth),
    Games: Object.assign(Games, Games),
    Search: Object.assign(Search, Search),
    Keys: Object.assign(Keys, Keys),
    Users: Object.assign(Users, Users),
    Groups: Object.assign(Groups, Groups),
}

export default Controllers