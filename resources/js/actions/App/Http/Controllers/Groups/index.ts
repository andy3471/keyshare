import AcceptGroupInviteController from './AcceptGroupInviteController'
import GroupController from './GroupController'
import JoinGroupController from './JoinGroupController'
import LeaveGroupController from './LeaveGroupController'
import RemoveGroupMemberController from './RemoveGroupMemberController'
import RegenerateGroupInviteCodeController from './RegenerateGroupInviteCodeController'
import SwitchGroupController from './SwitchGroupController'

const Groups = {
    AcceptGroupInviteController: Object.assign(AcceptGroupInviteController, AcceptGroupInviteController),
    GroupController: Object.assign(GroupController, GroupController),
    JoinGroupController: Object.assign(JoinGroupController, JoinGroupController),
    LeaveGroupController: Object.assign(LeaveGroupController, LeaveGroupController),
    RemoveGroupMemberController: Object.assign(RemoveGroupMemberController, RemoveGroupMemberController),
    RegenerateGroupInviteCodeController: Object.assign(RegenerateGroupInviteCodeController, RegenerateGroupInviteCodeController),
    SwitchGroupController: Object.assign(SwitchGroupController, SwitchGroupController),
}

export default Groups