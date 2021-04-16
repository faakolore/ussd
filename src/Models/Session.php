<?php

namespace TNM\USSD\Models;

use App\Models\OrderRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Session extends AbstractSession
{

    public static function recentSessionByPhone(string $phone): ?self
    {
        return Session::where('msisdn', $phone)
            ->where('updated_at', '>=', now()->subMinutes(config('ussd.session.last_activity_minutes')))
            ->latest()->first();
    }

    public static function hasRecentSessionByPhone(string $phone): bool
    {
        return !!static::recentSessionByPhone($phone);
    }

    public function updateSessionId(string $sessionId): self
    {
        $this->update(['session_id' => $sessionId]);
        return $this;
    }

    /**
     * @return MorphMany|mixed
     */
    public function orders(): MorphMany
    {
        return $this->morphMany(OrderRequest::class,'userable');
    }
}
