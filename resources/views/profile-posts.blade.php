<x-profile :sharedData="$sharedData">
    <div class="list-group">
        @foreach ($posts as $post)
        <a href="/post/{{$post->id}}" class="list-group-item list-group-item-action">
          {{-- $post is used because the avatar in the post needs to be of the user who made the post --}}
          <img class="avatar-tiny" src="{{$post->user->avatar}}" />
          <strong>{{$post->title}}</strong>  on {{$post->created_at->format('n/j/Y')}}
        </a>
        @endforeach
      </div>
</x-profile>
