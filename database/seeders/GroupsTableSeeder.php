<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\GroupRole;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->count() < 2) {
            $this->command->warn('Skipping group seeding: Need at least 2 users.');

            return;
        }

        $groups = [
            ['name' => 'PC Gamers', 'is_public' => true],
            ['name' => 'Console Crew', 'is_public' => true],
            ['name' => 'Indie Lovers', 'is_public' => false],
            ['name' => 'RPG Guild', 'is_public' => false],
            ['name' => 'FPS Squad', 'is_public' => true],
        ];

        foreach ($groups as $groupData) {
            $owner = $users->random();

            $group = Group::factory()->create([
                'name'      => $groupData['name'],
                'owner_id'  => $owner->id,
                'is_public' => $groupData['is_public'],
            ]);

            $group->addMember($owner, GroupRole::Owner);

            // Add 3–8 random members to each group
            $memberCount = min(rand(3, 8), $users->count() - 1);
            $members     = $users->except($owner->id)->random($memberCount);

            foreach ($members as $member) {
                $role = fake()->randomElement([GroupRole::Admin, GroupRole::Member, GroupRole::Member, GroupRole::Member]);
                $group->addMember($member, $role);
            }
        }

        $this->command->info('Seeded '.count($groups).' groups with members.');
    }
}
