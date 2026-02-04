<?php

namespace App\Traits;

use App\Services\HashService;

trait HashIdRoute
{
    // Override getRouteKey to return Hashed ID
    public function getRouteKey()
    {
        return app(HashService::class)->encode($this->getKey());
    }

    // Override resolveRouteBinding to accept Hashed ID
    public function resolveRouteBinding($value, $field = null)
    {
        // If field is explicitly defined (e.g. 'slug'), use default behavior
        if ($field) {
            return parent::resolveRouteBinding($value, $field);
        }

        // Try to decode
        $decodedId = app(HashService::class)->decode($value);

        // If decoding failed (it returned raw value or null), try finding by raw ID just in case (optional, safe for backward compat)
        // But for strict security, we should only query if decoded ID is valid integer.

        if (!$decodedId) {
            return null;
        }

        return parent::resolveRouteBinding($decodedId, $field);
    }
}
