import ListUsers from './ListUsers'
import CreateUser from './CreateUser'
import EditUser from './EditUser'

const Pages = {
    ListUsers: Object.assign(ListUsers, ListUsers),
    CreateUser: Object.assign(CreateUser, CreateUser),
    EditUser: Object.assign(EditUser, EditUser),
}

export default Pages