import ClaimKeyController from './ClaimKeyController'
import SubmitKeyFeedbackController from './SubmitKeyFeedbackController'
import ListClaimedKeysController from './ListClaimedKeysController'
import ListSharedKeysController from './ListSharedKeysController'
import KeyController from './KeyController'

const Keys = {
    ClaimKeyController: Object.assign(ClaimKeyController, ClaimKeyController),
    SubmitKeyFeedbackController: Object.assign(SubmitKeyFeedbackController, SubmitKeyFeedbackController),
    ListClaimedKeysController: Object.assign(ListClaimedKeysController, ListClaimedKeysController),
    ListSharedKeysController: Object.assign(ListSharedKeysController, ListSharedKeysController),
    KeyController: Object.assign(KeyController, KeyController),
}

export default Keys