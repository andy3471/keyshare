import exports from './exports'
import imports from './imports'

const filament = {
    exports: Object.assign(exports, exports),
    imports: Object.assign(imports, imports),
}

export default filament