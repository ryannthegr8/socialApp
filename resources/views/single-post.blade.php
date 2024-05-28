<x-layout>
    <div class="container py-md-5 container--narrow">
        <div class="d-flex justify-content-between">
          <h2>{{$post->title}}</h2>

          {{-- Wrapping a condition that allows the user
             to be able to see the edit and delete icons or not --}}
            @can('update', $post)
                <span class="pt-2">

                    {{-- When edit is clicked it takes the user to edit page --}}
                        <a href="/post/{{$post->id}}/edit" class="text-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
                    <form class="delete-post-form d-inline" action="/post/{{$post->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
                    </form>
                </span>
          @endcan
        </div>

        <p class="text-muted small mb-4">
          <a href="#"><img class="avatar-tiny" src="https://gravatar.com/avatar/f64fc44c03a8a7eb1d52502950879659?s=128" /></a>
          Posted by <a href="#">{{$post->user->username}}</a> on {{$post->created_at->format('n/j/Y')}}
        </p>

        <div class="body-content">
            {{-- This method of using "!!" is not safe, it risks data getting hacked
            So use it when you really need to use it--}}
          {!! $post->body !!}
        </div>
      </div>
</x-layout>
