@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card border-secondary px-2">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ __('Assigned tickets') }}
                    </h3>
                    <!-- @if(session('success'))
                        <h6 class="card-subtitle alert alert-success">
                            {{ session('success') }}
                        </h6>
                    @endif -->
                </div>
                @forelse ($assigned_tickets as $ticket)
                    <div class="card border-dark my-3">

                        <div class="card-header">
                            <h6 class="card-title">
                                {{ __('Submitted') }} {{ __('by') }}: <strong>{{ $ticket->submitting_user->name }}</strong> {{ __('on') }} <em>{{ $ticket->created_at->toFormattedDateString() }}</em>
                            </h6>
                        </div>

                        <div class="card-body">
                            <a href="{{ route('ticket_show', ['ticket' => $ticket]) }}">
                                <h5 class="card-title">
                                    {{ __('Title') }}: {{ $ticket->title }}
                                </h5>
                            </a>
                            <p class="card-text">
                                {{ __('Description') }}: {!! nl2br(e($ticket->description)) !!}
                            </p>
                        </div>

                        <div class="card-footer">
                            {{ __('Status') }}: {{ $ticket->status->description }}
                        </div>

                    </div>
                @empty
                    <p>{{ __('No tickets available...') }}</p>
                @endforelse
            </div>

        </div>

        <div class="col-md-6">

            <div class="card border-secondary px-2">
                <div class="card-header">
                    <h3 class="card-title">
                    {{ __('Unassigned tickets') }}
                    </h3>
                    <!-- @if(session('success'))
                        <h6 class="card-subtitle alert alert-success">
                            {{ session('success') }}
                        </h6>
                    @endif -->
                </div>
                @forelse ($unassigned_tickets as $ticket)
                    <div class="card border-dark my-3">

                        <div class="card-header">
                            <h6 class="card-title">
                                {{ __('Submitted') }} {{ __('by') }}: <strong>{{ $ticket->submitting_user->name }}</strong> {{ __('on') }} <em>{{ $ticket->created_at->toFormattedDateString() }}</em>
                            </h6>
                        </div>

                        <div class="card-body">
                            <a href="{{ route('ticket_show', ['ticket' => $ticket]) }}">
                                <h5 class="card-title">
                                    {{ __('Title') }}: {{ $ticket->title }}
                                </h5>
                            </a>
                            <p class="card-text">
                                {{ __('Description') }}: {!! nl2br(e($ticket->description)) !!}
                            </p>
                        </div>

                        <div class="card-footer">
                            {{ __('Status') }}: {{ $ticket->status->description }}
                        </div>

                    </div>
                @empty
                    <p>{{ __('No tickets available...') }}</p>
                @endforelse
            </div>

        </div>

    </div>
</div>
@endsection
