<x-mail::message>
# Welcome

Thank you for registering for my laravelBlog

<x-mail::button :url="'/'">
Check Laravel
</x-mail::button>

<a href="/"><button>Return Home</button></a>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
