@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

    <main class="text-page">
      <section data-aos="fade-up">
        <div class="container">
            <h3 style="margin-bottom:30px;">{!! App::title() !!}</h3>
            @php the_content() @endphp
        </div>
      </section>
    </main>
    
  @endwhile
@endsection
