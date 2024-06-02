<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s followers">
    <div class="list-group">
        @foreach ($followers as $follow)
        <a href="/profile/{{$follow->userDoingTheFollowing->username}}" class="list-group-item list-group-item-action">
          {{-- $post is used because the avatar in the post needs to be of the user who made the post --}}
          <img class="avatar-tiny" src="{{$follow->userDoingTheFollowing->avatar}}" />
          {{$follow->userDoingTheFollowing->username}}
        </a>
        @endforeach
      </div>
</x-profile>
