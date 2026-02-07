import Auth from './Auth'
import HomeController from './HomeController'
import SearchController from './SearchController'
import GameController from './GameController'
import KeyController from './KeyController'
import UserController from './UserController'

const Controllers = {
    Auth: Object.assign(Auth, Auth),
    HomeController: Object.assign(HomeController, HomeController),
    SearchController: Object.assign(SearchController, SearchController),
    GameController: Object.assign(GameController, GameController),
    KeyController: Object.assign(KeyController, KeyController),
    UserController: Object.assign(UserController, UserController),
}

export default Controllers