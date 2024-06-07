<x-profile :sharedData="$sharedData" doctitle=" Who {{$sharedData['username']}}'s following">
    @include('profile-following-only')
</x-profile>
