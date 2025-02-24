<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\Registration;
use Livewire\WithPagination;

class AdminReviewRegistration extends Component
{
    use WithPagination;

    public $search = '', $perPage = 10, $sortField = 'created_at', $sortAsc = false;
    public $viewingRegistration = null;

    public $showModal = false;
    public $selectedRegistration = null;

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
        if ($registration->registration_type === 'Creator' && $registration->user->channels->count() > 0) {
            foreach ($registration->user->channels as $channel) {
                $channel->verified = true;
                $channel->save();
            }
        } elseif ($registration->registration_type === 'Investor' && $registration->user->investors->count() > 0) {
            foreach ($registration->user->investors as $investor) {
                $investor->verified = true;
                $investor->save();
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

    public function rejectRegistration($registrationId)
    {
        $registration = Registration::findOrFail($registrationId);
        $registration->status = 'rejected';
        $registration->save();

        $this->dispatch('notification', [
            'type' => 'info',
            'message' => 'Registration rejected.'
        ]);

        if ($this->selectedRegistration && $this->selectedRegistration->id === $registrationId) {
            $this->closeModal();
        }
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