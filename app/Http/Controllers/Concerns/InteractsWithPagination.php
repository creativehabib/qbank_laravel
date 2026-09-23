<?php

namespace App\Http\Controllers\Concerns;

trait InteractsWithPagination
{
    public int $page = 1;

    public function resetPage(): void
    {
        $this->page = 1;
    }
}
