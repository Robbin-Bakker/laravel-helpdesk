@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        All Tickets
                    </h3>
                    @if(session('success'))
                        <h6 class="card-subtitle alert alert-success">
                            {{ session('success') }}
                        </h6>
                    @endif
                </div>
                @forelse ($tickets as $ticket)
                    <div class="card">

                        <div class="card-header">
                            Submitting user: {{ $ticket->submitting_user->name }}
                            <em>{{ $ticket->created_at->toFormattedDateString() }}</em>
                        </div>

                        <div class="card-body">
                            <a href="{{ route('ticket_show', ['ticket' => $ticket]) }}">
                                <h5 class="card-title">
                                    {{ $ticket->title }}
                                </h5>
                            </a>
                            <p class="card-text">
                                {!! nl2br(e($ticket->description)) !!}
                            </p>
                        </div>

                        <div class="card-footer">
                            {{ $ticket->status->description }}
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
