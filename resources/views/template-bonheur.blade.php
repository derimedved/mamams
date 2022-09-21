{{--
    Template Name: Bonheur
--}}

@extends('layouts.app_bonheur')
@section('content')

    <main data-lptitle="{{ get_the_title() }}">
      <div class="b_main_banner">
        <div class="main_banner flex">
          <div class="banner_image">
            <img src="{{ $banner_image->url }}" alt="">
          </div>
          <div class="banner_content flex">
            <div class="content_wrapper">
              <div class="content_inner">
                <div class="banner_title secondFont">
                  <h1>@php the_title() @endphp</h1>
                </div>
                <div class="content">{!! $text !!}</div>

                @if ($button)
                <div class="btn_wrapper">
                    <a class="btn btn_white jsScrollTo" href="{{$button->url}}" target="{{$button->target}}">{{$button->title}}</a>
                </div>
                @endif

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="b_section_content bg_template" style="background-image: url('{{$image_text_section->url}}');">
        <div class="single_content">
          <div class="container">
            <div class="content">{!! $text_1 !!}</div>
          </div>
        </div>
        <div class="mini_banner flex">
          <div class="banner_image">
            <div class="image_desktop"><img src="{{$image->url}}" alt=""></div>
            <div class="image_mobile"><img src="{{$image_mobile->url}}" alt=""></div>
          </div>
          <div class="banner_content flex">
            <div class="banner_content_wrapper">
              <div class="content_wrapper">{!! $text_2 !!}</div>
            </div>
          </div>
        </div>
        <div class="single_content">
          <div class="container">
            <div class="content">{!! $text_3 !!}</div>
          </div>
        </div>
      </div>
      <div class="b_cases">
        <div class="container"></div>
        <div class="cases_slider_wrapper">
          <div class="cases_slider jsCasesSlider">

            @foreach ($slider as $row)                   
                <div class="case_slide_item">
                  <div class="case_slide flex">
                    <div class="case_main_info flex">
                      <div class="info_inner">
                        <div class="case_info">
                          <div class="case_info_image">
                            <div class="info_image"><img src="{{ $row->image->url }}" alt=""></div>
                          </div>
                        </div>
                        <div class="case_content_inner">
                          <button class="btn_more" type="button"></button>
                          <div class="case_title secondFont">{{ $row->title }}</div>
                          <div class="case_description">
                            <p>{!! $row->text !!}</p>
                          </div>
                        </div>
                      </div>

                      @if ($row->button)
                      <div class="button_wrapper"><a class="btn btn_white jsScrollTo" href="{{ $row->button->url }}" target="{{ $row->button->target }}">{{ $row->button->title }}</a></div>
                      @endif

                    </div>
                    <div class="case_reviews flex">
                      <div class="case_reviews_inner flex">
                        <div class="case_reviews_slider jsCaseReviews">

                            @foreach ($row->reviews as $row_2)
                                <div class="case_review_slide">
                                    <div class="review_slide">
                                      <div class="review_block flex">
                                        <div class="user_image">
                                          <div class="image_wrap"><img src="{{ $row_2->image->url }}" alt=""></div>
                                        </div>
                                        <div class="user_content">
                                          <div class="title">{{ $row_2->title }}</div>
                                          <div class="content">
                                            <p>{!! $row_2->text !!}</p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        @if ($row->button)
                            <div class="mobile_button_wrapper"><a class="btn btn_white jsScrollTo" href="{{ $row->button->url }}" target="{{ $row->button->target }}">{{ $row->button->title }}</a></div>
                        @endif

                      </div>
                    </div>
                  </div>
                </div>
            @endforeach

          </div>
        </div>
      </div>
      <div class="b_block_form" id="top_form">
        <div class="block_form_wrapper flex">
          <div class="block_image"><img src="{{ $image_1->url }}" alt=""></div>
          <div class="block_form">
            <div class="block_form_inner">
              <div class="block_title">{{ $title }}</div>
              <div class="description">{!! $description !!}</div>
              <div class="form_wrapper">
                <div class="form">
                  @php echo do_shortcode('[contact-form-7 id="2197" title="COURS EN LIGNE"]') @endphp
                </div><a class="custom_link" href="#courses">decouvrir</a>
                <div class="block_info">
                  <p>Ils vous éclairent aussi à propos des idées reçues et lèvent le voile sur les tabous encore trop nombreux.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="b_experts">
        <div class="container">
          <div class="block_title text_center">{{ $title_1 }}</div>
          <div class="block_content text_center">{!! $text_4 !!}</div>
        </div>
        <div class="experts_wrapper">
          <div class="experts_list jsExpertsList">

            @foreach ($experts as $index => $post)
              <div class="expert_item">
                <div class="expert_image">
                  <div class="image_block jsOpenModals" data-href="expert_0{{ $index + 1 }}"><img src="@php echo get_the_post_thumbnail_url($post->ID) @endphp" alt=""></div>
                </div>
              </div>
            @endforeach

          </div>
        </div>
        <div class="experts_content_wrapper">
          <div class="experts_content">

            @foreach ($experts as $index => $post)
              <div class="expert_content" id="expert_0{{ $index + 1 }}">
                <div class="expert_content_inner flex">
                  <div class="expert_block flex">
                    <div class="content_wrapper">
                      <div class="expert_name secondFont">@php echo get_the_title($post->ID) @endphp</div>
                      <div class="expert_position">@php the_field('position', $post->ID) @endphp</div>
                      <div class="expert_advantages secondFont">
                        <ul>

                          @if (get_field('about', $post->ID)['label'])
                            <li>@php echo get_field('about', $post->ID)['label'] @endphp</li>
                          @endif

                          @if (get_field('specializations', $post->ID)['label'])
                            <li>@php echo get_field('specializations', $post->ID)['label'] @endphp</li>
                          @endif

                        </ul>
                      </div>
                      <div class="full_description">
                        <div class="content">

                          @if (get_field('about', $post->ID)['text'])
                            @php echo get_field('about', $post->ID)['text'] @endphp
                          @endif

                          @if (get_field('specializations', $post->ID)['text'])
                            @php echo get_field('specializations', $post->ID)['text'] @endphp
                          @endif

                        </div>
                      </div>
                      <div class="socials_wrapper">
                        <div class="socials_list flex">

                          @if (get_field('contact', $post->ID)['social']['facebook'])
                            <div class="social_item"><a class="social_link" href="@php echo get_field('contact', $post->ID)['social']['facebook'] @endphp"><img src="@php bloginfo('template_directory') @endphp/assets/images/social_facebook.svg" alt=""></a></div>
                          @endif
                          @if (get_field('contact', $post->ID)['social']['twitter'])
                              <div class="social_item"><a class="social_link" href="@php echo get_field('contact', $post->ID)['social']['twitter'] @endphp"><img src="@php bloginfo('template_directory') @endphp/assets/images/social_twitter.svg" alt=""></a></div>
                          @endif
                          @if (get_field('contact', $post->ID)['social']['linkedin'])
                              <div class="social_item"><a class="social_link" href="@php echo get_field('contact', $post->ID)['social']['linkedin'] @endphp"><img src="@php bloginfo('template_directory') @endphp/assets/images/social_linkedin.svg" alt=""></a></div>
                          @endif
                          @if (get_field('contact', $post->ID)['social']['insta'])
                              <div class="social_item"><a class="social_link" href="@php echo get_field('contact', $post->ID)['social']['insta'] @endphp"><img src="@php bloginfo('template_directory') @endphp/assets/images/social_instagram.svg" alt=""></a></div>
                          @endif

                        </div>
                      </div>
                      <div class="button_wrapper text_center">
                        <div class="btn_row"><a class="btn btn_template" href="#">MON 1ER COURS D'ESSAI</a></div>
                        <div class="btn_row"><button class="custom_link jsCloseModals" type="button">Fermer</button></div>
                      </div>
                    </div>
                    <div class="expert_image">
                      <div class="image_block"><img src="@php echo get_the_post_thumbnail_url($post->ID) @endphp" alt=""></div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach

          </div>
        </div>
        <div class="container">
          <div class="block_title text_center">{!! $title_experts !!}</div>

          @if ($button_experts)
            <div class="button_wrapper text_center"><a class="btn btn_white jsScrollTo" href="{{$button_experts->url}}" target="{{$button_experts->target}}">{{$button_experts->title}}</a></div>
          @endif

        </div>
      </div>
      <div class="b_courses" id="courses">
        <div class="container">
          <div class="block_title text_center">{{ $title_2 }}</div>
          <div class="courses_wrapper">
            <div class="courses_list flex">

                @foreach ($courses as $index => $post)

                  @php


                      $content = get_the_excerpt($post->ID);


                      preg_match('/src="([^"]+)"/',  get_field('top_video', $post->ID), $match);
                      $url = $match[1];
                  @endphp

                  <div class="course_item">
                      <div class="course_block">
                        <div class="course_image">
                          <div class="image_block">
                            <a href="{{ $url  }}" class="fancybox">
                            <img src="@php echo get_field('landing_image', $post->ID) ? get_field('landing_image', $post->ID)['url'] : get_the_post_thumbnail_url($post->ID) @endphp" alt="">
                            </a>
                          </div>
                        </div>
                        <div class="course_name secondFont">@php echo get_the_title($post->ID) @endphp</div>
                        <div class="course_description">


                          <div class="full_description" data-maxheight="627">
                            <div class="full_description_inner">
                              <div class="description">
                                {!! $content !!}
                              </div>
                              <div class="button_wrapper">
                                <div class="btn_row"><a class="btn btn_template jsScrollTo" href="#bottom_form">MON 1ER COURS D'ESSAI</a></div>
                                <div class="btn_row">
                                  <button class="single_link btn_less" type="button">Fermer</button>
                                </div>
                              </div>
                            </div>
                          </div>

                          
                        </div>
                      </div>
                  </div>
                @endforeach
                
            </div>
          </div>
        </div>
      </div>
      <div class="b_review_slider">
        <div class="container">
          <div class="block_title text_center">{{ $title_3 }}</div>
        </div>
        <div class="review_slider_wrapper">
          <div class="review_slider jsReviewSlider">

            @foreach ($reviews as $row)
              <div class="review_item">
                <div class="review_block">
                  <div class="personne_photo"><img src="{{ $row->photo->url }}" alt=""></div>
                  <div class="review_content">
                    <p>{{ $row->text }}</p>
                  </div>
                </div>
              </div>
            @endforeach

          </div>
        </div>
      </div>
      <div class="b_block_form" id="bottom_form">
        <div class="block_form_wrapper flex">
          <div class="block_form">
            <div class="block_form_inner right">
              <div class="block_title">{{ $title_4 }}</div>
              <div class="description">{!! $description_1 !!}</div>
              <div class="form_wrapper">
                <div class="form">
                  @php echo do_shortcode('[contact-form-7 id="2198" title="COURS EN LIGNE_copy"]') @endphp
                </div><a class="custom_link" href="#courses">decouvrir</a>
                <div class="block_info">{!! $description_2 !!}</div>
              </div>
            </div>
          </div>
          <div class="block_image"><img src="{{ $image_2->url }}" alt=""></div>
        </div>
      </div>
      <div style="display: none;" id="activecampaign_form">
        @php echo do_shortcode('[activecampaign form=7 css=0]') @endphp
      </div>
    </main>

@endsection