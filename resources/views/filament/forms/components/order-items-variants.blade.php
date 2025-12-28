@if (!empty($variants) && count($variants))
<ul class="list-disc list-inside text-sm text-gray-500 dark:text-gray-400">
    @foreach ($variants as $variant)
    <li>{{ $variant }}</li>
    @endforeach
</ul>
@else
<span class="text-sm text-gray-500 dark:text-gray-400">-</span>
@endif