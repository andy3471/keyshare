import games from './games'
import users from './users'

const resources = {
    games: Object.assign(games, games),
    users: Object.assign(users, users),
}

export default resources