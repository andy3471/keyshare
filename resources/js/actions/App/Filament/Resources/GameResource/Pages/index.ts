import ListGames from './ListGames'
import CreateGame from './CreateGame'
import EditGame from './EditGame'

const Pages = {
    ListGames: Object.assign(ListGames, ListGames),
    CreateGame: Object.assign(CreateGame, CreateGame),
    EditGame: Object.assign(EditGame, EditGame),
}

export default Pages