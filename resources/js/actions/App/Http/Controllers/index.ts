import WelcomeController from './WelcomeController'
import Auth from './Auth'
import GameController from './GameController'
import SearchController from './SearchController'
import KeyController from './KeyController'
import UserController from './UserController'
import GroupController from './GroupController'

const Controllers = {
    WelcomeController: Object.assign(WelcomeController, WelcomeController),
    Auth: Object.assign(Auth, Auth),
    GameController: Object.assign(GameController, GameController),
    SearchController: Object.assign(SearchController, SearchController),
    KeyController: Object.assign(KeyController, KeyController),
    UserController: Object.assign(UserController, UserController),
    GroupController: Object.assign(GroupController, GroupController),
}

export default Controllers