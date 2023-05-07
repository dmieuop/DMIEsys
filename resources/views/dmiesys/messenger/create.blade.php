@extends('layouts.dmiesys.app')

@section('title', '| Send a new message')
@section('chat-icon', 'hidden')
@section('back_page', 'Go to Inbox')
@section('back_link') {{ route('messages.index') }} @endsection

@section('content')

<div class="w-full">
    <form action="{{ route('messages.store') }}" method="post">
        @csrf @honeypot
        <div
            class="lg:w-1/2 md:w-2/3 px-8 py-4 mx-auto bg-white dark:bg-gray-800 shadow-md dark:shadow-gray-900/80 mt-7">

            @include('components.error-message')

            @if ($users->count() > 0)
            @include('components.multiselect', ['users' => $users])
            @endif

            <!-- Subject Form Input -->
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-input" id="subject" name="subject" placeholder="Subject"
                    value="{{ old('subject') }}" required>
            </div>

            <!-- Message Form Input -->
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" id="message" class="w-full hidden" placeholder="Message" required>
                        {{ old('message') }}
                    </textarea>
            </div>


            <!-- Submit Form Input -->
            <div class="mb-3">
                <button type="submit"
                    class="px-5 py-2 bg-cyan-400 hover:bg-cyan-500 dark:bg-green-700 dark:hover:bg-green-800 w-full text-center font-semibold dark:text-white">
                    <i class="bi bi-send"></i> Send</button>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script src="{{ asset('vendor/ckeditor5/build/ckeditor.js') }}"></script>
<script>
    ClassicEditor.create(document.getElementById("message"))
</script>
@endpush