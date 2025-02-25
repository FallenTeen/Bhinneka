<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\Registration;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationRejected;

class AdminReviewRegistration extends Component
{
    use WithPagination;

    public $search = '', $perPage = 10, $sortField = 'created_at', $sortAsc = false;
    public $showModal = false, $viewingRegistration = null, $showDescriptionModal = false, $showAvatarModal = false;
    public $selectedRegistration = null;
    public $showRejectionModal = false;
    public $rejectionMessage = '';
    public $registrationIdToReject = null;

    protected $listeners = ['refreshRegistrations' => '$refresh'];

    public function showDetails($registrationId)
    {
        $this->selectedRegistration = Registration::with(['user.channels', 'user.investors'])->findOrFail($registrationId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedRegistration = null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function approveRegistration($registrationId)
    {
        $registration = Registration::findOrFail($registrationId);
        $registration->status = 'approved';
        $registration->save();

        if ($registration->registration_type === 'Creator') {
            $registration->user->role_id = 3;
            $registration->user->save();

            if ($registration->user->channels->count() > 0) {
                foreach ($registration->user->channels as $channel) {
                    $channel->verified = true;
                    $channel->save();
                }
            }
        } elseif ($registration->registration_type === 'Investor') {
            $registration->user->role_id = 2;
            $registration->user->save();

            if ($registration->user->investors->count() > 0) {
                foreach ($registration->user->investors as $investor) {
                    $investor->verified = true;
                    $investor->save();
                }
            }
        }

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Registration approved successfully!'
        ]);

        if ($this->selectedRegistration && $this->selectedRegistration->id === $registrationId) {
            $this->closeModal();
        }
    }
    public function openRejectionModal($registrationId)
    {
        $this->registrationIdToReject = $registrationId;
        $this->rejectionMessage = '';
        $this->showRejectionModal = true;
    }

    public function closeRejectionModal()
    {
        $this->showRejectionModal = false;
        $this->registrationIdToReject = null;
        $this->rejectionMessage = '';
    }
    public function confirmRejection()
    {
        if (!$this->registrationIdToReject) {
            return;
        }

        $registration = Registration::where('id', $this->registrationIdToReject)->first();

        if (!$registration) {
            $this->dispatch('notification', [
                'type' => 'error',
                'message' => 'Registration not found.'
            ]);
            $this->closeRejectionModal();
            return;
        }

        $userId = $registration->user_id;
        $registration->status = 'rejected';
        $registration->save();

        if ($registration->registration_type === 'Creator') {
            $channels = \App\Models\Channel::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($registration->registration_type === 'Investor') {
            $investorProfiles = \App\Models\InvestorProfile::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        Mail::to($registration->user->email)->send(new RegistrationRejected($registration, $this->rejectionMessage));

        $this->dispatch('notification', [
            'type' => 'info',
            'message' => 'Registration rejected and ownership of associated records has been transferred to history.'
        ]);

        if ($this->selectedRegistration && $this->selectedRegistration->id === $this->registrationIdToReject) {
            $this->closeModal();
        }

        $this->closeRejectionModal();
    }

    public function resetStatus($registrationId)
    {
        $registration = Registration::findOrFail($registrationId);
        $registration->status = 'pending';
        $registration->save();
        if ($registration->registration_type === 'Creator' && $registration->user->channels->count() > 0) {
            foreach ($registration->user->channels as $channel) {
                $channel->verified = false;
                $channel->save();
            }
        } elseif ($registration->registration_type === 'Investor' && $registration->user->investors->count() > 0) {
            foreach ($registration->user->investors as $investor) {
                $investor->verified = false;
                $investor->save();
            }
        }

        $this->dispatch('notification', [
            'type' => 'info',
            'message' => 'Registration status has been reset to pending.'
        ]);
    }

    public function getDocumentPath($path, $type)
    {
        if (empty($path)) {
            return null;
        }
        $documentFolder = $type === 'Creator' ? 'channel_documents' : 'investor_documents';
        return asset('storage/' . $documentFolder . '/' . basename($path));
    }

    public function render()
    {
        $registrations = Registration::with('user.channels', 'user.investors')
            ->whereHas('user', function ($userQuery) {
                $userQuery->where(function ($query) {
                    $query->whereHas('channels', function ($channelQuery) {
                        $channelQuery->where('verified', false);
                    })->orWhereHas('investors', function ($investorQuery) {
                        $investorQuery->where('verified', false);
                    });
                })
                    ->where(function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%')
                            ->orWhereHas('channels', function ($channelQuery) {
                                $channelQuery->where('channel_name', 'like', '%' . $this->search . '%');
                            })
                            ->orWhereHas('investors', function ($investorQuery) {
                                $investorQuery->where('company_name', 'like', '%' . $this->search . '%');
                            });
                    });
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.component.admin-review-registration', [
            'registrations' => $registrations,
        ]);
    }
}