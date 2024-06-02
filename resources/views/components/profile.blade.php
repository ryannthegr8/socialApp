{{--NOTE: If you are passing a simple string of text, the colon is not needed.
    1. The colon is used when you want to pass a PHP variable as a string attribute
    2. In other cases when you are passing either a string or {{This kind of dynamic data}}, the colon wont be needed
    3. Note the difference between PHP variable and {{This kind of dynamic data}}, It might be a little confusing --}}

<x-layout :doctitle="$doctitle">
    <div class="container py-md-5 container--narrow">
        <h2>
          <img class="avatar-small" src="{{$sharedData['avatar']}}" /> {{$sharedData['username']}}
          {{-- @auth is used so that only the logged in user can see the buttons --}}
          @auth
            {{-- Follow button --}}
          @if (!$sharedData['currentlyFollowing'] AND auth()->user()->username != $sharedData['username'])
          <form class="ml-2 d-inline" action="/create-follow/{{$sharedData['username']}}" method="POST">
            @csrf
            <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
          </form>
          @endif
            {{-- Unfollow Button --}}
          @if ($sharedData['currentlyFollowing'])
                <form class="ml-2 d-inline" action="/remove-follow/{{$sharedData['username']}}" method="POST">
                @csrf
                    <button class="btn btn-danger btn-sm">Unfollow <i class="fas fa-user-times"></i></button>
                </form>
            @endif
            @if (auth()->user()->username == $sharedData['username'])
                <a href="/manage-avatar" class="btn btn-secondary -btn-sm">Manage Avatar</a>
            @endif
          @endauth
        </h2>

        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="/profile/{{$sharedData['username']}}" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "" ? "active" : ""}}">Posts: {{$sharedData['postCount']}}</a>
          <a href="/profile/{{$sharedData['username']}}/followers" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "followers" ? "active" : ""}}">Followers: {{$sharedData['followerCount']}}</a>
          <a href="/profile/{{$sharedData['username']}}/following" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "following" ? "active" : ""}}">Following: {{$sharedData['followingCount']}}</a>
        </div>

        <div class="profile-slot-content">
            {{$slot}}
        </div>
      </div>
</x-layout>
