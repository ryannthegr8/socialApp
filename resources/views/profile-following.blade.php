<x-profile :sharedData="$sharedData">
    <div class="list-group">
        @foreach ($following as $follow)
        <a href="/profile/{{$follow->userBeingFollowed->username}}" class="list-group-item list-group-item-action">
          {{-- $post is used because the avatar in the post needs to be of the user who made the post --}}
          <img class="avatar-tiny" src="{{$follow->userBeingFollowed->avatar}}" />
          {{$follow->userBeingFollowed->username}}
        </a>
        @endforeach
      </div>
</x-profile>
