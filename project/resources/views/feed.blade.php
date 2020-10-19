@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form method="POST" action="{{ route('rss.create') }}">
            @csrf
            <div class="form-group form-row">
                <label for="rssfeed" class="col-form-label">{{ __('RSS Feed') }}</label>
                <div class="col-md-8">
                    <input id="url" type="text" placeholder="https://example.com/rss" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" required>
                    @error('url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Add new Feed') }}
                </button>
            </div>
        </form>
    </div>
    <hr/>
    <div class="card-columns">
    @foreach($feed->stream as $entry)
        <div class="card" style="min-width: 200px;">
            @if($entry->hasImage())
                <img class="card-img-top" src="{{$entry->getImage()}}" alt="Card image cap">
            @endif
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">{{$entry->getMainTitle()}}</h6>
                <h5 class="card-title">{{$entry->getTitle()}}</h5>
                <p class="card-text">{{strip_tags($entry->getDescription())}}</p>
                <a href="{{$entry->getLink()}}" class="btn btn-primary">Read more</a>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endsection
