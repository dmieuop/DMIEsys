@extends('layouts.dmiesys.app')

@section('title', '| Inbox')
@section('chat-icon', 'hidden')
@section('back_page', 'Go back to Dashboard')
@section('back_link') {{ route('dashboard') }} @endsection

@section('content')


<div class="md:w-3/4 mx-auto">

    <div class="flex">
        <div class="font-semibold text-4xl mb-3 dark:text-gray-200">Inbox</div>
        <div class="w-full">
            <a href="{{ route('messages.create') }}" class="btn btn-purple rounded-full md:rounded-none float-right">
                <i class="bi bi-send"></i> New Message</a>
        </div>
    </div>

    @php
    $noOldMessages = true;
    @endphp
    {{ $threads->links() }}

    <p class="text-xl font-semibold dark:text-gray-400 mt-3">Unread Messages</p>
    @forelse ($unread_threads as $thread)
    @include('dmiesys.messenger.partials.thread')
    @empty
    <div
        class="bg-gray-200 px-2 py-3 my-4 italic text-gray-500 font-semibold dark:bg-gray-600 dark:text-gray-400 rounded-lg md:rounded-none">
        (No new messages)
    </div>
    @endforelse

    <x-section-border />

    <p class="text-xl font-semibold dark:text-gray-400">All Messages</p>
    @forelse ($threads as $thread)
    @if (!$thread->isUnread(Auth::id()))
    @php
    $noOldMessages = false;
    @endphp
    @include('dmiesys.messenger.partials.thread')
    @endif
    @empty
    @endforelse
    @if ($noOldMessages)
    <div
        class="bg-gray-200 px-2 py-3 mt-4 italic text-gray-500 font-semibold dark:bg-gray-600 dark:text-gray-400 rounded-lg md:rounded-none">
        (No Messages)
    </div>
    @endif

</div>


@endsection