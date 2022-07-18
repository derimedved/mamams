{{-- 
  Template Name: Profile orders Template 
--}}

@php
$user = wp_get_current_user();

$user_id = $user->ID;

$fields = ['avatar','age','phone','newsletter_messenger','dob','waiting','children','themes','archive_orders'];
foreach($fields as $field) {
    $$field = get_field($field,'user_'.$user_id) ?: '';
}

$email = $user->user_email ?: '';

$name=[];
$name[] = $first_name = get_userdata($user_id)->first_name;
$name[] = $last_name = get_userdata($user_id)->last_name;
$name = !empty($name) ? implode(" ", $name) : '';
@endphp

@extends('layouts.app')

@section('content')


    <section class="profile-wrapper">
        <div class="container profile-container-courses">

            @include('partials.profile-sidebar')

            <div class="profile-main">
                <div class="profile-courses-wrapper">
                    <div class="profile-courses-list">
                        <h3>{{ $title }}</h3>
                        <div class="profile-courses-header">
                            <div class="row">
                                <div class="c-date-wrap">
                                    <div class="c-date">
                                        <strong>{{ $title_order_date }}</strong>
                                    </div>
                                    <div class="c-expire">
                                        <strong>{{ $title_expiration_date }}</strong>
                                    </div>
                                </div>
                                <div class="c-id">
                                    <strong>{{ $title_transaction }}</strong>
                                </div>
                                <div class="c-title">
                                    <strong>{{ $title_course }}</strong>
                                </div>
                                <div class="c-summ">
                                    <strong>{{ $title_payroll }}</strong>
                                </div>
                                <div class="c-discount">
                                    <strong>{{ $title_voucher }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="profile-courses-table">
                            @if ($archive_orders)

                                @foreach ($archive_orders as $order)
                                <div class="item">
                                    <div class="row">
                                        <div class="c-date-wrap">
                                            <div class="c-date">
                                                <strong>{{ $title_order_date }}</strong>
                                                <p>{{ $order['date_start'] }}</p>
                                            </div>
                                            <div class="c-expire">
                                                <strong>{{ $title_expiration_date }}</strong>
                                                <p>{{ $order['date_end'] }}</p>
                                            </div>
                                        </div>
                                        <div class="c-id">
                                            <strong>{{ $title_transaction }}</strong>
                                            <p>{{ $order['mail'] }}</p>
                                        </div>
                                        <div class="c-title">
                                            <strong>{{ $title_course }}</strong>
                                            <p>{!! $order['course'] !!}</p>
                                        </div>
                                        <div class="c-summ">
                                            <strong>{{ $title_payroll }}</strong>
                                            <p>{!! $order['paid'] !!}</p>
                                        </div>
                                        <div class="c-discount">
                                            <strong>{{ $title_voucher }}</strong>
                                            <p>{{ $order['coupon'] }}</p>
                                        </div>
                                    </div>
                                </div> 
                                @endforeach
                            
                            @endif
                        </div>
                    </div>


                    @php

                    $posts_per_page=6;
                    $post_type='lp_course';

                    $query = new WP_Query ( array(
                        'posts_per_page' => $posts_per_page,
                        'post_type' => $post_type,
                        'post_status' => 'future',
                    ) );

                    @endphp
                    @if ($query->have_posts())
                    <h3>Vous allez aussi aimer :</h3>
                    <div class="profile-items-slider">
                        <div class="profile-coming-soon__wrap">

                            @while ($query->have_posts()) @php $query->the_post(); @endphp
                                @include('partials.profile-'.$post_type.'-soon')
                            @endwhile
                            @php wp_reset_postdata(  ); @endphp
                            
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

@endsection
