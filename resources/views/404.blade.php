@extends('layouts.app')

@section('content')
  
  <main class="all-courses">
    <section class="banner-block" data-aos="fade-up">
      <div class="all-courses__title">
        <h3>404</h3>
        <p>{{ __('Sorry, but the page you were trying to view does not exist.', 'sage') }}</p>
      </div>
      <a href="{{ get_home_url() }}" class="underline-btn">Home</a>
    </section>
  </main>

@endsection
