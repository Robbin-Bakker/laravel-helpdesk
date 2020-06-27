@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $ticket->title }}
                    </h3>
                    <div class="card-subtitle">
                        Status: {{ $ticket->status->description }}
                    </div>
                    @can( 'close', $ticket )
                        <form class="d-inline" action="{{ route('ticket_close', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button type="submit">{{ __('Close') }}</button>
                        </form>
                    @endcan
                    @can( 'claim', $ticket )
                        <form class="d-inline" action="{{ route('ticket_claim', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button type="submit">{{ __('Claim') }}</button>
                        </form>
                    @endcan
                    @can( 'free', $ticket )
                        <form class="d-inline" action="{{ route('ticket_free', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button type="submit">{{ __('Unclaim') }}</button>
                        </form>
                    @endcan
                    @can( 'escalate', $ticket )
                        <form class="d-inline" action="{{ route('ticket_escalate', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button type="submit">{{ __('Escalate') }}</button>
                        </form>
                    @endcan
                    @can( 'deescalate', $ticket )
                        <form class="d-inline" action="{{ route('ticket_deescalate', ['ticket' => $ticket]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button type="submit">{{ __('Deescalate') }}</button>
                        </form>
                    @endcan
                    @can( 'delegate', $ticket )
                        <button type="button"
                            data-toggle="modal" data-target="#delegateModal">
                            {{ __('Delegate') }}
                        </button>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="card-text">
                        Description: {!! nl2br(e($ticket->description)) !!}
                    </div>
                </div>

                <div class="card-footer">
                    Submitted on <em>{{ $ticket->created_at->toFormattedDateString() }}</em> by {{ $ticket->submitting_user->name }}
                </div>

                <div class="card">
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
                        <div class="card-body">
                            <div class="card-text">
                                {{ $comment->contents }}
                            </div>
                        </div>
                        <div class="card-footer">
                            <p>
                                by {{ $comment->user->name }} on <em>{{ $comment->created_at->toFormattedDateString() }}</em>
                            </p>
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

                <div class="card">
                    @can( 'comment', $ticket )
                        <form id="form" method="POST" action="{{ route('comment_save', ['ticket' => $ticket]) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="contents" class="col-md-4 col-form-label text-md-right">{{ __('Contents') }}</label>

                                <div class="col-md-6">
                                    <textarea id="contents" class="form-control @error('contents') is-invalid @enderror" name="contents" rows="3" cols="40">{{ old('contents') }}</textarea>

                                    @error('contents')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="card-header">
                            <div class="card-title">
                                {{ __('You are not allowed to comment') }}
                            </div>
                            <div class="card-subtitle">
                                {{ __('Only the submitting user or assigned assistant can comment') }}
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
                            <button type="submit">{{ __('Delegate') }}</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan

</div>
@endsection
