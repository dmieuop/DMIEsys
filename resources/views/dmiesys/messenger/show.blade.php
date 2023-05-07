@extends('layouts.dmiesys.app')

@section('title', '| ' . $thread->subject)
@section('chat-icon', 'hidden')
@section('back_page', 'Go back to inbox')
@section('back_link') {{ route('messages.index') }} @endsection

@section('content')
<div class="screen">
    <div class="col-md-6">
        @include('dmiesys.messenger.partials.form-message', [
        'subject' => $thread->subject,
        ])
        @each('dmiesys.messenger.partials.messages', $thread->messages->reverse(), 'message')
    </div>
</div>
@stop

@push('scripts')
<script src="{{ asset('vendor/ckeditor5/build/ckeditor.js') }}"></script>
<script>
    const open_reply_box = document.getElementById("open_reply_box");
        const reply_box = document.getElementById("reply_box");
        ClassicEditor.create(document.getElementById("message"))

        function ShowReplyBox() {
            open_reply_box.style.display = "none";
            reply_box.style.display = "block";
        }
</script>
@endpush