import Games from './Games'
import Users from './Users'

const Resources = {
    Games: Object.assign(Games, Games),
    Users: Object.assign(Users, Users),
}

export default Resources