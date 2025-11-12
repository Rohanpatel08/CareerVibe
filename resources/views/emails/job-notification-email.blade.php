@component('mail::message')
# Hello {{ $employer->name }},

---

## 🧾 Job Details
**Title:** {{ $jobPost->title }}

---

## 👤 Employee Details

@component('mail::panel')
**Name:** {{ $user->name }} <br>
**Email:** {{ $user->email }} <br>
**Phone:** {{ $user->phone ?? 'N/A' }}
@endcomponent

@component('mail::button', ['url' => $url ?? '#'])
View Job Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent