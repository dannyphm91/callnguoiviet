@extends('frontend.layouts.dashboard')

@section('title', __('verify_account'))
@section('breadcrumb')
<x-frontend.breadcrumb.breadcrumb :links="[['text' => 'Dashboard', 'url' => '/'], ['text' => 'Verify Account']]" />
@endsection
@section('dashboard-content')
    @if ($resubmit)
        @livewire('verify-account', ['user' => $user])
    @else
        @if ($document_verified)
            @if ($document_verified->status == 'pending')
                <div class=" border shadow-md border-gray-100 p-5 rounded">
                    <div class=" flex flex-col gap-4 justify-center items-center">
                        <div class=" text-primary-500">
                            <x-svg.account-verification.pending-icon />
                        </div>
                        <div class=" text-center">
                            <h2 class=" heading-05 mb-2">{{ __('thank_you') }} !</h2>
                            <p>
                                {{ __('your_document_verification_request_submitted_successful_please_wait_until_review') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            @if ($document_verified->status == 'rejected')
                <div class="  border shadow-md border-gray-100 p-5 rounded">
                    <div class=" flex flex-col gap-4 justify-center items-center">
                        <div class=" text-red-500">
                            <x-svg.account-verification.rejected-icon />
                        </div>
                        <div class="text-center">
                            <h2 class=" heading-05 mb-2">{{ __('rejected') }} !</h2>
                            <p>
                                {{ $document_verified->rejected_reason }}
                            </p>
                            <a class="btn-primary mt-3" href="{{ route('frontend.resubmit.verify.account') }}">
                                {{ __('submit_again') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            @if ($document_verified->status == 'approved')
                <div class=" border shadow-md border-gray-100 p-5 rounded">
                    <div class=" flex flex-col gap-4 justify-center items-center">
                        <div class=" text-primary-500">
                            <x-svg.account-verification.approved-icon />
                        </div>
                        <div class=" text-center">
                            <h2 class=" heading-05 mb-2">{{ __('congratulations') }} !</h2>
                            <p>
                                {{ __('your_account_fully_verified') }} !
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @else
            @livewire('verify-account', ['user' => $user])
        @endif
    @endif
@endsection
@push('js')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('uploadProfile', () => ({
                image: null,
                handleFileInput(event) {
                    const file = event.target.files[0]; // Get the first file
                    this.readFile(file).then(imageDataURL => {
                        this.image = {
                            url: imageDataURL,
                            name: file.name
                        };
                    });
                },
                readFile(file) {
                    return new Promise((resolve) => {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            resolve(event.target.result);
                        };
                        reader.readAsDataURL(file);
                    });
                },
                removeImage() {
                    this.image = null;
                }
            }))
        })
    </script>
@endpush
