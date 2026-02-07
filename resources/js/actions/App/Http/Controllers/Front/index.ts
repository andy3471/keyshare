import HomeController from './HomeController'
import SearchController from './SearchController'
import GameController from './GameController'
import KeyController from './KeyController'
import UserController from './UserController'
import PlatformController from './PlatformController'
import DlcController from './DlcController'

const Front = {
    HomeController: Object.assign(HomeController, HomeController),
    SearchController: Object.assign(SearchController, SearchController),
    GameController: Object.assign(GameController, GameController),
    KeyController: Object.assign(KeyController, KeyController),
    UserController: Object.assign(UserController, UserController),
    PlatformController: Object.assign(PlatformController, PlatformController),
    DlcController: Object.assign(DlcController, DlcController),
}

export default Front