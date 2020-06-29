@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-dark p-2">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ __('Title') }}: {{ $ticket->title }}
                    </h3>
                    <div class="card-subtitle">
                        {{ __('Status') }}: {{ $ticket->status->description }}
                    </div>
                    @can( 'close', $ticket )
                        <form class="d-inline" action="{{ route('ticket_close', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button class="btn btn-danger" type="submit">{{ __('Close') }}</button>
                        </form>
                    @endcan
                    @can( 'claim', $ticket )
                        <form class="d-inline" action="{{ route('ticket_claim', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button class="btn btn-info" type="submit">{{ __('Claim') }}</button>
                        </form>
                    @endcan
                    @can( 'free', $ticket )
                        <form class="d-inline" action="{{ route('ticket_free', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button class="btn btn-secondary" type="submit">{{ __('Unclaim') }}</button>
                        </form>
                    @endcan
                    @can( 'escalate', $ticket )
                        <form class="d-inline" action="{{ route('ticket_escalate', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button class="btn btn-warning" type="submit">{{ __('Escalate') }}</button>
                        </form>
                    @endcan
                    @can( 'deescalate', $ticket )
                        <form class="d-inline" action="{{ route('ticket_deescalate', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button class="btn btn-primary" type="submit">{{ __('De-escalate') }}</button>
                        </form>
                    @endcan
                    @can( 'delegate', $ticket )
                        <button class="btn btn-info" type="button"
                            data-toggle="modal" data-target="#delegateModal">
                            {{ __('Delegate') }}
                        </button>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="card-text">
                        {{ __('Description') }}: {!! nl2br(e($ticket->description)) !!}
                    </div>
                </div>

                <div class="card-footer">
                    {{ __('Submitted') }} {{ __('on') }} <em>{{ $ticket->created_at->toFormattedDateString() }}</em> {{ __('by') }} {{ $ticket->submitting_user->name }}
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title" id="comments">
                            {{ __('Comments') }}
                        </h5>
                        @if(session('success'))
                            <h6 class="card-subtitle alert alert-success">
                                {{ session('success') }}
                            </h6>
                        @elseif(session('fail'))
                            <h6 class="card-subtitle alert alert-danger">
                                {{ session('fail') }}
                            </h6>
                        @endif
                    </div>
                </div>

                @forelse ($ticket->comments as $comment)

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                {{ $comment->contents }}
                            </div>
                            <div class="card-subtitle">
                                {{ __('by') }} {{ $comment->user->name }} {{ __('on') }} <em>{{ $comment->created_at->toFormattedDateString() }}</em>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="card">
                        <div class="card-body">
                            <div class="card-text">
                                {{ __('No comments available...') }}
                            </div>
                        </div>
                    </div>
                @endforelse

                <div class="card border-secondary bg-light">
                    @can( 'comment', $ticket )
                        <div class="card-header pb-0">
                            <form id="form" method="POST" action="{{ route('comment_save', ['ticket' => $ticket]) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="contents" class="col-md-3 col-form-label">{{ __('New comment') }}</label>

                                    <div class="col-md-9">
                                        <textarea id="contents" class="form-control @error('contents') is-invalid @enderror" name="contents" rows="2" cols="30">{{ old('contents') }}</textarea>

                                        @error('contents')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Submit comment') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif( !$ticket->isOpen() )
                        <div class="card-body">
                            <div class="card-text">
                                {{ __('This ticket is closed, no new comments allowed.') }}
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                                <div class="card-text">
                                    {{ __('You are not allowed to comment.') }}
                                </div>
                                <div class="card-text">
                                    {{ __('Only the submitting user or assigned assistant can comment.') }}
                                </div>
                            </div>
                    @endcan
                </div>

            </div>
        </div>
    </div>

    @can( 'delegate', $ticket )
        <div class="modal fade" id="delegateModal" tabindex="-1" 
            role="dialog" aria-labelledby="Delegate Ticket" aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Delegate ticket') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="d-inline" action="{{ route('ticket_delegate', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <select name="delegatable_user" id="delegatable_users">
                                @foreach($delegatable_users as $delegatable_user)
                                    <option value="{{ $delegatable_user->id }}">{{ $delegatable_user->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-info" type="submit">{{ __('Delegate') }}</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan

</div>
@endsection
