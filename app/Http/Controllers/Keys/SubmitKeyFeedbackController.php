<?php

declare(strict_types=1);

namespace App\Http\Controllers\Keys;

use App\Enums\KeyFeedback;
use App\Http\Controllers\Controller;
use App\Http\Requests\KeyFeedbackRequest;
use App\Models\Key;
use Illuminate\Http\RedirectResponse;

class SubmitKeyFeedbackController extends Controller
{
    public function __invoke(KeyFeedbackRequest $request, Key $key): RedirectResponse
    {
        $this->authorize('feedback', $key);

        $key->update(['feedback' => KeyFeedback::from($request->validated('feedback'))]);

        return back()->with('message', __('keys.feedback_submitted'));
    }
}
