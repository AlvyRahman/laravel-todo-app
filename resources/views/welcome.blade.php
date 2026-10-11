<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>To-Do List</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <main class="app">
            @php
                $done = $listItems->where('is_complete', 1)->count();
                $active = $listItems->where('is_complete', 0)->count();
            @endphp

            <header class="app__header">
                <h1 class="app__title">To-Do List</h1>
                <span class="app__counter">{{ $active }} active &middot; {{ $done }} done</span>
            </header>

            @error('listItem')
                <p class="form-error">{{ $message }}</p>
            @enderror

            <div class="toolbar">
                <form method="post" action="{{ route('markAllComplete') }}">
                    @csrf
                    <button class="btn btn--success" type="submit">Mark all done</button>
                </form>

                <form method="post" action="{{ route('markAllIncomplete') }}">
                    @csrf
                    <button class="btn btn--warning" type="submit">Mark all active</button>
                </form>
            </div>

            <form class="search-form" method="get" action="{{ url('/') }}">
                <label class="sr-only" for="search">Search items</label>
                <input
                    id="search"
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search items&hellip;"
                    autocomplete="off"
                >
                <button class="btn" type="submit">Search</button>
                @if ($search)
                    <a class="btn btn--danger" href="{{ url('/') }}">Clear</a>
                @endif
            </form>

            @php $q = fn ($v) => request()->fullUrlWithQuery(['status' => $v]); @endphp

            <a href="{{ $q('all') }}"    class="pill {{ $status === 'all' ? 'pill--on' : '' }}">All</a>
            <a href="{{ $q('active') }}" class="pill {{ $status === 'active' ? 'pill--on' : '' }}">Active</a>
            <a href="{{ $q('done') }}"   class="pill {{ $status === 'done' ? 'pill--on' : '' }}">Done</a>

            <ul class="list">
                @forelse ($listItems as $listItem)
                    @php $isDone = $listItem->is_complete == 1; @endphp

                    <li class="item {{ $isDone ? 'item--done' : '' }}">
                        <form method="post" action="{{ route($isDone ? 'incomplete' : 'complete', $listItem->id) }}">
                            @csrf
                            <button
                                class="check"
                                type="submit"
                                title="{{ $isDone ? 'Mark as active' : 'Mark as done' }}"
                                aria-label="{{ $isDone ? 'Mark as active' : 'Mark as done' }}"
                            ></button>
                        </form>

                        <span class="item__name">{{ $listItem->name }}</span>

                        <form class="item__edit" method="post" action="{{ route('edit', $listItem->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="text" name="listItem" value="{{ $listItem->name }}" required>
                            <button class="btn btn--primary btn--sm" type="submit">Save</button>
                            <button class="btn btn--sm" type="button" onclick="cancelEdit(this)">Cancel</button>
                        </form>

                        <button class="btn btn--primary btn--sm edit-btn" type="button" onclick="startEdit(this)">Edit</button>

                        <form
                            class="item__remove"
                            method="post"
                            action="{{ route('remove', $listItem->id) }}"
                        >
                            @csrf
                            <button class="btn btn--danger btn--sm" type="submit">Remove</button>
                        </form>
                    </li>
                @empty
                    <li class="empty">No items yet &mdash; add one below.</li>
                @endforelse
            </ul>

            <form class="add-form" method="post" action="{{ route('saveItem') }}">
                @csrf
                <label class="sr-only" for="listItem">New item</label>
                <input
                    id="listItem"
                    type="text"
                    name="listItem"
                    value="{{ old('listItem') }}"
                    placeholder="Add a new item&hellip;"
                    autocomplete="off"
                    required
                    autofocus
                >
                <button class="btn btn--primary" type="submit">Add</button>
            </form>
        </main>

        @if (session('undo'))
            @php $undoSeconds = \App\Models\ListItem::UNDO_SECONDS; @endphp

            <div class="toast" id="undo-toast">
                <span class="toast__text">&ldquo;{{ session('undo.name') }}&rdquo; deleted</span>

                <form method="post" action="{{ route('restore', session('undo.id')) }}">
                    @csrf
                    <button class="btn btn--primary btn--sm" type="submit">Undo</button>
                </form>

                <span class="toast__bar" style="animation-duration: {{ $undoSeconds }}s"></span>
            </div>

            <script>
                setTimeout(() => document.getElementById('undo-toast')?.remove(), {{ $undoSeconds * 1000 }});
            </script>
        @endif
    </body>
</html>
