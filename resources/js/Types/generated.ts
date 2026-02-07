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
platform: PlatformData | null
createdUser: UserData | null
claimedUser: UserData | null
game: GameData | null
can: KeyCanData
};
export type KeyCanData = {
view: boolean
claim: boolean
};
export type PlatformData = {
id: string
name: string
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
is_approved: boolean | null
};
export type AutocompleteGameData = {
id: string
name: string
};
