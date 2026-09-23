<?php

namespace App\Http\Controllers\Pages\Traits;

trait InteractsWithToasts
{
    protected function toastSuccess(string $message, string $heading = 'Success'): void
    {
        $this->toast($message, 'success', $heading);
    }

    protected function toastWarning(string $message, string $heading = 'Warning'): void
    {
        $this->toast($message, 'warning', $heading);
    }

    protected function toastDanger(string $message, string $heading = 'Error'): void
    {
        $this->toast($message, 'danger', $heading);
    }

    protected function toast(string $message, string $variant = 'success', ?string $heading = null): void
    {
        session()->flash('toast', compact('message', 'variant', 'heading'));
    }
}
