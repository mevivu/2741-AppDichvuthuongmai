<span>
    @foreach ($toppings as $item)
        @if ($loop->last)
            <x-link :href="route('admin.topping.edit', $item['id'])" :title="$item['name']" />
        @else
            <x-link :href="route('admin.topping.edit', $item['id'])" :title="$item['name']" />,&nbsp;
        @endif
    @endforeach
</span>