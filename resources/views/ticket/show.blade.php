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
                    <div class="card-text">
                        Description: {!! nl2br(e($ticket->description)) !!}
                    </div>
                </div>

                <div class="card-footer">
                    Submitted on <em>{{ $ticket->created_at->toFormattedDateString() }}</em> by {{ $ticket->submitting_user->name }}
                </div>

                @forelse ($ticket->comments as $comment)

                    <div class="card">
                        <div class="card-body">
                            <div class="card-text">
                                $comment->contents
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
                    <form method="POST" action="{{ route('comment_save', ['id' => $ticket]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('Comment') }}</label>

                            <div class="col-md-6">
                                <textarea id="comment" class="form-control @error('comment') is-invalid @enderror" name="comment" rows="3" cols="40">{{ old('comment') }}</textarea>

                                @error('comment')
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
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
