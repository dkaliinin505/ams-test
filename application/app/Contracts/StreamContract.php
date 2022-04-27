<?php

namespace App\Contracts;

use App\Models\User;

interface StreamContract {
    public function getAll(User $objUser): array;
    public function createStream(array $request, User $objUser): bool;
    public function showStream(string $stream_id, User $objUser): object;
}
