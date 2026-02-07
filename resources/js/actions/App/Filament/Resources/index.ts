import GameResource from './GameResource'
import UserResource from './UserResource'

const Resources = {
    GameResource: Object.assign(GameResource, GameResource),
    UserResource: Object.assign(UserResource, UserResource),
}

export default Resources