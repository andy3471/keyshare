<?php

declare(strict_types=1);

namespace App\Http\Requests\Groups;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'                   => ['sometimes', 'string', 'max:50', 'regex:/^[^<>]*$/'],
            'description'            => ['nullable', 'string', 'max:1000', 'regex:/^[^<>]*$/s'],
            'is_public'              => ['boolean'],
            'avatar'                 => ['nullable', 'image', 'max:2048'],
            'discord_webhook_url'    => ['nullable', 'url:https', 'starts_with:https://discord.com/api/webhooks/,https://discordapp.com/api/webhooks/'],
            'min_karma'              => ['nullable', 'integer', 'min:-100', 'max:1000'],
            'claim_cooldown_minutes' => ['nullable', 'integer', 'min:1', 'max:525600'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex'        => 'The group name must not contain < or > characters.',
            'description.regex' => 'The description must not contain < or > characters.',
        ];
    }
}
