<?php

namespace App\Domain\User\Actions;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsController;

class StoreUserAction
{
    use AsController;

    public function asController(ActionRequest $request)
    {

    }

    public function rules(): array
    {
        return [];
    }
}
