@if(isset($users) && $users->count() > 0)
    @foreach($users as $user)
        <div class="d-flex flex-column">
            <x-link :href="route('admin.user.edit', $user->id)" :title="$user->fullname" />
        </div>
    @endforeach
@else
    <div>N/A</div>
@endif
