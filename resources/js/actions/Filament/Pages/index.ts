import Auth from './Auth'
import Dashboard from './Dashboard'

const Pages = {
    Auth: Object.assign(Auth, Auth),
    Dashboard: Object.assign(Dashboard, Dashboard),
}

export default Pages