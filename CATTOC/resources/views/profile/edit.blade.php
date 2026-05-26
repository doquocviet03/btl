@extends('user.layouts.app')
@section('title', 'Hồ sơ cá nhân - Barber House')
@section('content')
<section class="hero-bg py-14">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-orange-500 font-black uppercase tracking-widest text-sm">Account</p>
        <h1 class="section-title mt-3">Hồ sơ cá nhân</h1>
    </div>
</section>

<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
    <div class="glass rounded-[2rem] p-6 md:p-8">
        @include('profile.partials.update-profile-information-form')
    </div>
    <div class="glass rounded-[2rem] p-6 md:p-8">
        @include('profile.partials.update-password-form')
    </div>
    <div class="rounded-[2rem] p-6 md:p-8 bg-red-50 border border-red-100">
        @include('profile.partials.delete-user-form')
    </div>
</section>
@endsection
