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
                </div>

                <div class="card-body">
                    @can( 'close', $ticket )
                        <div class="card-text">
                            <form action="{{ route('ticket_close', ['ticket' => $ticket]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <button type="submit">{{ __('Sluit ticket') }}</button>
                            </form>
                        </div>
                    @endcan
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
</div>
@endsection
