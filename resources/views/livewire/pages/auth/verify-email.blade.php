<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.c-guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            // Redirect berdasarkan role jika email sudah terverifikasi
            switch ($user->role) {
                case 'Admin':
                    $route = route('admin.dashboard');
                    break;
                case 'Creator':
                    $route = route('creator.dashboard');
                    break;
                case 'Investor':
                    $route = route('investor.dashboard');
                    break;
                default:
                    $route = route('home'); 
                    break;
            }

            $this->redirectIntended($route, navigate: true);
            return;
        }

        // Kirim ulang email verifikasi
        $user->sendEmailVerificationNotification();

        // Flash message untuk memberi tahu pengguna
        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirimkan melalui email. Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkannya kembali.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
        {{ __('Email verifikasi berhasil dikirimkan.') }}
    </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <x-primary-button wire:click="sendVerification">
            {{ __('Kirim ulang email verifikasi') }}
        </x-primary-button>

        <button wire:click="logout" type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            {{ __('Log Out') }}
        </button>
    </div>
</div>