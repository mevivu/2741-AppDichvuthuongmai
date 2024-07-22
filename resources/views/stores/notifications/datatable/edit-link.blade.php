@php
    $test = App\Models\User::find($user_id);
@endphp
<x-link :href="route('admin.user.edit', $test->id)" :title="$test->fullname" class="text-decoration-none" />
