@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Tickets</div>

                <div class="card-body">
                    @forelse ($tickets as $ticket)
                        <div class="ticket">
                            <p>Ticket name: {{ $ticket->title }}, last update at {{ $ticket->updated_at }}</p>
                        </div>
                    @empty
                        <p>{{ __('No tickets available...') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
