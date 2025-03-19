<?php
namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $initials = $user ? $this->getInitials($user->name) : 'NA';
            $view->with('initials', $initials);
        });
    }

    private function getInitials($name)
    {
        $words = explode(' ', trim($name));
        $initials = '';
        if (count($words) >= 1) {
            $initials .= strtoupper(substr($words[0], 0, 1));
        }
        if (count($words) > 1) {
            $initials .= strtoupper(substr(end($words), 0, 1));
        }
        return $initials ?: 'NA';
    }
}