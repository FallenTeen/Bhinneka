<?php

namespace App\Livewire\Component;

use Livewire\Component;
use App\Models\Registration;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationRejected;

class AdminListUserAll extends Component
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
            ->where('status', 'approved')
            ->whereHas('user', function ($userQuery) {
                $userQuery->where(function ($query) {
                    $query->whereHas('channels', function ($channelQuery) {
                        $channelQuery->where('verified', true);
                    })->orWhereHas('investors', function ($investorQuery) {
                        $investorQuery->where('verified', true);
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

        return view('livewire.component.admin-list-user-all', [
            'registrations' => $registrations,
        ]);
    }
}