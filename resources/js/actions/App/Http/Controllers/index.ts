import Auth from './Auth'
import Front from './Front'

const Controllers = {
    Auth: Object.assign(Auth, Auth),
    Front: Object.assign(Front, Front),
}

export default Controllers