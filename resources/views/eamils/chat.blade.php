@component('mail::message')
# Introduction

You have a new missed message!

@component('mail::button', ['url' => config('app.url')])
    Visit Site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
