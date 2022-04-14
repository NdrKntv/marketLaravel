@props(['rating'])

<div id="comment-div" class="p-2 mt-3 rounded"
     @switch($rating)
     @case('dislike')
     style="background: #ff00005e"
     @break
     @case('like')
     style="background: #1bff005e"
     @break
     @default
     style="background: #ffff005e"
    @endswitch
>
    {{$slot}}
</div>
