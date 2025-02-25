@component('mail::message')
# Pendaftaran Ditangguhkan

Dear {{ $registration->name }},

Kami ingin memberitahu anda bahwa pendaftaran anda Sebagai {{ $registration->registration_type }} @if ($registration->registration_type === 'Creator') {{ $registration->user->channels->first()->channel_name }} @elseif ($registration->registration_type === 'Investor') {{ $registration->user->investors->first()->company_name }} @endif di Bhinneka.Space ditangguhkan.

**Alasan:** {{ $rejectionMessage }}

Terima kasih atas kepercayaan anda.

@endcomponent