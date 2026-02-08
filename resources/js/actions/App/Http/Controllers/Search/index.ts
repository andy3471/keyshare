import SearchController from './SearchController'
import AutocompleteSearchController from './AutocompleteSearchController'

const Search = {
    SearchController: Object.assign(SearchController, SearchController),
    AutocompleteSearchController: Object.assign(AutocompleteSearchController, AutocompleteSearchController),
}

export default Search