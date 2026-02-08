export type LengthAwarePaginator<TKey, TValue> = {
data: TKey extends string ? Record<TKey, TValue> : TValue[]
links: {
url: string | null
label: string
active: boolean
}[]
meta: {
total: number
current_page: number
first_page_url: string
from: number | null
last_page: number
last_page_url: string
next_page_url: string | null
path: string
per_page: number
prev_page_url: string | null
to: number | null
}
};
export type LengthAwarePaginatorInterface<T> = LengthAwarePaginator<T>;
export type CursorPaginator<TKey, TValue> = {
data: TKey extends string ? Record<TKey, TValue> : TValue[]
links: {
url: string | null
label: string
active: boolean
}[]
meta: {
path: string
per_page: number
next_cursor: string | null
next_page_url: string | null
prev_cursor: string | null
prev_page_url: string | null
}
};
export type CursorPaginatorInterface<T> = CursorPaginator<T>;
export type PaginatedDataCollection<TKey, TValue> = LengthAwarePaginator<TKey, TValue>;
export type CursorPaginatedDataCollection<TKey, TValue> = CursorPaginator<TKey, TValue>;
export type GameData = {
id: string
name: string
genres?: GenreData[] | undefined
screenshots?: ScreenshotData[] | undefined
aggregated_rating?: number
aggregated_rating_count?: number
description: string | null
image: string | null
keyCount?: number
platforms?: PlatformData[]
};
export type GameShowData = {
game: GameData
keys: KeyData[]
dlcCount: number | null
dlcUrl: string | null
genres: GenreData[] | null
screenshots: ScreenshotData[] | null
};
export type GenreData = {
id: number
name: string
};
export type ScreenshotData = {
id: number
image_id: string
};
export type KeyData = {
id: string
key: string | null
message: string | null
feedback: KeyFeedback | null
platform: PlatformData | null
createdUser: UserData | null
claimedUser: UserData | null
game: GameData | null
can: KeyCanData | null
group: GroupData | null
};
export type KeyCanData = {
view: boolean
claim: boolean
feedback: boolean
claimDeniedReason: ClaimDeniedReason | null
cooldownEndsAt: string | null
};
export type PlatformData = {
id: string
name: string
icon: string
};
export type UserData = {
id: string
name: string
email: string | null
avatar: string | null
bio: string | null
karma: number | null
karma_colour: string | null
is_admin: boolean | null
};
export type AutocompleteGameData = {
id: string
name: string
};
export type GroupMemberData = {
id: string
name: string
avatar: string | null
role: string
joined_at: string | null
};
export type GroupCanData = {
update: boolean
delete: boolean
leave: boolean
manageMembers: boolean
invite: boolean
};
export type GroupData = {
id: string
name: string
slug: string
description: string | null
owner_id: string | null
is_public: boolean | null
invite_code: string | null
member_count: number | null
role: string | null
avatar: string | null
discord_webhook_url: string | null
min_karma: number | null
claim_cooldown_minutes: number | null
can: GroupCanData | null
};
export type GroupRole = "owner" | "admin" | "member";
export type KeyFeedback = "worked" | "did_not_work";
export type LinkedAccountProvider = "steam" | "twitch" | "discord" | "xbox";
export type OnboardingStep = "set_credentials" | "join_group" | "complete";
export type ClaimDeniedReason = "already_claimed" | "own_key" | "not_in_group" | "karma_too_low" | "cooldown_active";
