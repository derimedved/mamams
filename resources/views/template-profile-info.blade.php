{{-- 
    Template Name: Profile info Template 
--}}

@php
$user = wp_get_current_user();

$user_id = $user->ID;

$fields = ['avatar','age','phone','newsletter_messenger','dob','waiting','children','themes'];
foreach($fields as $field) {
    $$field = get_field($field,'user_'.$user_id) ?: '';
}

$email = $user->user_email ?: '';

$name=[];
$name[] = $first_name = get_userdata($user_id)->first_name;
$name[] = $last_name = get_userdata($user_id)->last_name;
$name = !empty($name) ? implode(" ", $name) : '';

$active_themes = [];
$default_themes = [];
foreach(get_field('default_themes','options') as $theme) {
    if(!$theme['theme']) continue;
    $default_themes[] = $theme['theme'];
}
if($themes)
foreach($themes as $theme) {
    if(!$theme['theme']) continue;
    $active_themes[] = $theme['theme'];
}
$custom_themes = $active_themes ? array_diff($active_themes, $default_themes) : [];
$total_themes = array_merge($default_themes,$custom_themes);




@endphp

@extends('layouts.app')

@section('content')

    <?php




                $profile       = learn_press_get_profile();
                $query         = $profile->query_courses( 'purchased', array( 'status' => $filter_status ) );



    ?>

    <section class="profile-wrapper">
        <div class="bg">
            <img src="/wp-content/themes/mamams/resources/assets/img/bg-501.png" alt="">
        </div>
        <div class="container profile-container">
            <div class="profile-left">
                <div class="top-line">


                    @if (App::isPremium())
                        <div class="item item-active  width-100 ">
                            <figure>
                                <img src="/wp-content/themes/mamams/resources/assets/img/icon-304.svg" alt="">
                                <span>
                                        <img src="/wp-content/themes/mamams/resources/assets/img/icon-305.svg" alt="">
                                        <b><?= $query->get_total() ?></b>
                                    </span>
                            </figure>
                            <div class="text-wrap">
                                <h3>PASS PREMIUM</h3>
                                <p>Vous avez l’accès à toutes les formations disponible sur le site.</p>
                                <div class="link-wrap">
                                    <a href="{{ get_permalink(246) }}">Voir les formations</a>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="item {{ $query->get_total() > 0 ? 'item-active' : '' }}  ">
                                <figure>
                                    <img src="/wp-content/themes/mamams/resources/assets/img/icon-304.svg" alt="">
                                    <span>
                                        <img src="/wp-content/themes/mamams/resources/assets/img/icon-305.svg" alt="">
                                        <b><?= $query->get_total() ?></b>
                                    </span>
                                </figure>
                                <div class="text-wrap">
                                    <h3>FORMATIONS DÉJÀ ACHETÉES: <?= $query->get_total() ?></h3>
                                    <div class="link-wrap">
                                        <a href="{{ get_permalink(246) }}?my=1">Voir les formations</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <figure>
                                    <img src="/wp-content/themes/mamams/resources/assets/img/icon-306.svg" alt="">
                                    <span>
                                        <img src="/wp-content/themes/mamams/resources/assets/img/icon-305.svg" alt="">
                                        <b><?= $query->get_total() ?></b>
                                    </span>
                                </figure>
                                <div class="text-wrap">
                                    <h3>Vous n'avez pas de pass premium</h3>
                                    <div class="link-wrap">
                                        <a href="{{ get_permalink(519) }}">SOUSCRIRE</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                </div>
                @include('partials.profile-sidebar')
            </div>


            <form action="#" class="profile-main ajax_profile_form_info">

                <div class="top-line">
                    @if (App::isPremium())
                        <div class="item item-active  width-100 ">
                            <figure>
                                <img src="/wp-content/themes/mamams/resources/assets/img/icon-304-1.svg" alt="">
                                <span>
                                <img src="/wp-content/themes/mamams/resources/assets/img/icon-305.svg" alt="">
                                <b><img src="/wp-content/themes/mamams/resources/assets/img/icon-304-2.svg" alt=""></b>
                            </span>
                            </figure>
                            <div class="text-wrap">
                                <h3>PASS PREMIUM</h3>
                                <p>Vous avez l’accès à toutes les formations disponible sur le site.</p>
                                <div class="link-wrap">
                                    <a href="{{ get_permalink(246) }}">Voir les formations</a>
                                </div>
                            </div>
                        </div>
                        @else
                    <div class="item {{ $query->get_total() > 0 ? 'item-active' : '' }} ">
                        <figure>
                            <img src="/wp-content/themes/mamams/resources/assets/img/icon-304.svg" alt="">
                            <span>
                                <img src="/wp-content/themes/mamams/resources/assets/img/icon-305.svg" alt="">
                                <b><?= $query->get_total() ?></b>
                            </span>
                        </figure>
                        <div class="text-wrap">
                            <h3>FORMATIONS DÉJÀ ACHETÉES: <?= $query->get_total() ?></h3>
                            <div class="link-wrap">
                                <a href="{{ get_permalink(246) }}?my=1">Voir les formations</a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <figure>
                            <img src="/wp-content/themes/mamams/resources/assets/img/icon-306.svg" alt="">
                            <span>
                                <img src="/wp-content/themes/mamams/resources/assets/img/icon-305.svg" alt="">
                                <b><?= $query->get_total() ?></b>
                            </span>
                        </figure>
                        <div class="text-wrap">
                            <h3>Vous n'avez pas de pass premium</h3>
                            <div class="link-wrap">
                                <a href="{{ get_permalink(519) }}">SOUSCRIRE</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="profile-form-wrap">

                    <h3>{{ $title }}</h3>
                    <div class="row">
                        <div class="field">
                            <label for="i1">{{ $title_field_name }}</label>
                            <input type="text" name="first_name" id="i1" value="{{ $first_name ?: '' }}" maxlength="10">
                        </div>
                        <div class="field">
                            <label for="i2">{{ $title_field_last_name }}</label>
                            <input type="text" name="last_name" id="i2" value="{{ $last_name ?: '' }}" maxlength="10">
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label for="i3">{{ $title_field_age }}</label>
                            <input type="text" name="age" id="i3" value="{{ $age }}" maxlength="8">
                        </div>
                    </div>
                    <div class="profile-form-contact">
                        <div class="row">
                            <div class="field">
                                <label for="i4">{{ $title_field_email }}</label>
                                <input type="email" id="i4" value="{{ $email }}" disabled>
                            </div>
                            <div class="field field-button">
                                <button type="button" class="double-btn double-btn_red btn-change"><img src="/wp-content/themes/mamams/resources/assets/img/icon-307.svg" alt=""></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="field">
                                <label for="i5">{{ $title_field_phone }}</label>
                                <input type="tel" name="phone" id="i5" value="{{ $phone }}" disabled>
                            </div>
                            <div class="field field-button">
                                <button type="button" class="double-btn double-btn_red btn-change"><img src="/wp-content/themes/mamams/resources/assets/img/icon-307.svg" alt=""></button>
                            </div>
                        </div>
                    </div>
                    <div class="row row-check">
                        <div class="field">
                            <input type="checkbox" name="newsletter_messenger" id="c1" {!! checked( $newsletter_messenger ) !!}>
                            <label for="c1">{{ $agreement }}</label>
                        </div>
                    </div>

                    <h3>{{ $title_personal_information }}</h3>
                    <div class="d-flex">
                        <div class="input-wrap">
                            <label class="small">{{ !$title_field_data&&$dob ? $placeholder_field_data : $title_field_data }}</label>
                            <div class="profile-date">
                                <div class="profile-date-field">
                                    <input type="text" name="dob" value="{{ $dob }}" class="datepicker-profile" readonly placeholder="{{ $placeholder_field_data }}">
                                    <span class="date-picked"><img src="/wp-content/themes/mamams/resources/assets/img/icon-308.svg" alt=""></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-wrap">
                            <label class="small">{{ $title_field_sex }}</label>
                            <div class="profile-dropdown">
                                <input type="text" name="waiting" class="dropdown-value" value="{{ $waiting }}" readonly>
                                <div class="dropdown-current">{{ $waiting ?: $field_sex->title_jumeaux }}</div>
                                <div class="dropdown-options">
                                    <div class="dropdown-item {{ $waiting=='Surprise!' ? 'active' : '' }}">{{ $field_sex->title_jumeaux }}</div>
                                    <div class="dropdown-item {{ $waiting=='Garçon' ? 'active' : '' }}">{{ $field_sex->title_garcon }}</div>
                                    <div class="dropdown-item {{ $waiting=='Fille' ? 'active' : '' }}">{{ $field_sex->title_fille }}</div>
                                    <div class="dropdown-item {{ !$waiting || $waiting=='Inconnu' ? 'active' : '' }}">{{ $field_sex->title_inconnu }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="input-wrap input-wrap-100">
                            <label class="small">{{ $title_field_kids }}</label>
                            <div class="profile-children-list">

                                <div class="item children-item-clone" style="display:none;">
                                    <div class="inner">
                                        <figure>
                                            <div class="child-drop">
                                                <input name="file" type="file" />
                                                <input class="child_img" name="" data-name="image" type="hidden" val="" />
                                            </div>
                                            <figcaption></figcaption>
                                        </figure>
                                        <div class="radio-toggler">
                                            <label class="female">
                                                <input type="radio" name="" data-name="gender" value="female">
                                                <span>{{ $field_sex->title_fille ?: 'Fille' }}</span>
                                            </label>
                                            <label class="male">
                                                <input type="radio" name="" data-name="gender" value="male">
                                                <span>{{ $field_sex->title_garcon ?: 'Garçon' }}</span>
                                            </label>
                                        </div>
                                        <div class="item-data">
                                            <div class="wrap">
                                                <input type="text" class="child_name child" name="" data-name="name" placeholder="Prénom" value="" maxlength="10">
                                                <span class=""><img src="/wp-content/themes/mamams/resources/assets/img/icon-313.svg" alt=""></span>
                                            </div>
                                           <div class="wrap">
                                               <input type="text" class="child_age child" name="" data-name="age" placeholder="Age" value="" maxlength="6">
                                               <span class=""><img src="/wp-content/themes/mamams/resources/assets/img/icon-313.svg" alt=""></span>
                                           </div>
                                        </div>
                                    </div>
                                    <button class="btn_remove_child"></button>
                                </div>

                                @if ($children)
                                    @foreach ($children as $key => $child)
                                        <div class="item">
                                            <div class="inner">
                                                <figure class="{{ $child['gender'] }}">
                                                    <figure class="dz-image-preview">
                                                        @if ($child['image'])
                                                            <img src="{{ $child['image']['sizes']['640x640'] }}" alt="{{ $child['image']['alt'] }}" />
                                                        @endif
                                                    </figure>

                                                    <div class="child-drop">
                                                        <input name="file" type="file" />
                                                        <input class="child_img" name="children[{{ $key }}][image]" data-name="image" type="hidden" value="{{ $child['image'] ? $child['image']['ID'] : '' }}" />
                                                    </div>

                                                    <figcaption>{{ $child['name'] }}{{ $child['name']&&$child['age'] ? ',' : '' }} {{ $child['age'] }}</figcaption>
                                                </figure>
                                                <div class="radio-toggler">
                                                    <label class="female">
                                                        <input type="radio" name="children[{{ $key }}][gender]" data-name="gender" value="female" {!! checked( $child['gender']=='female' )  !!}>
                                                        <span>{{ $field_sex->title_fille ?: 'Fille' }}</span>
                                                    </label>
                                                    <label class="male">
                                                        <input type="radio" name="children[{{ $key }}][gender]" data-name="gender" value="male" {!! checked( $child['gender']=='male' )  !!}>
                                                        <span>{{ $field_sex->title_garcon ?: 'Garçon' }}</span>
                                                    </label>
                                                </div>
                                                <div class="item-data">
                                                    <input type="text" class="child_name" name="children[{{ $key }}][name]" data-name="name" placeholder="Prénom" value="{{ $child['name'] }}" maxlength="10">
                                                    <input type="text" class="child_age"  name="children[{{ $key }}][age]" data-name="age" placeholder="Age" value="{{ $child['age'] }}" maxlength="6">
                                                </div>
                                            </div>
                                            <button class="btn_remove_child"></button>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="add-item">
                                    <button class="btn-add btn_add_child"><img src="/wp-content/themes/mamams/resources/assets/img/icon-310.svg" alt=""></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="status"></div> 
                    <div class="profile-submit">
                        <button type="submit" class="double-btn double-btn_red">{{ $button }}</button>
                    </div>

                </div>


                @php
                $order_ids = get_posts( array(
                    'numberposts' => -1,
                    'fields' => 'ids',
                    'post_type'   => 'lp_order',
                    'post_status' => 'lp-completed',
                    'meta_query' => [
                        [
                            'key' => 'is_premium',
                            'value' => true,
                        ],
                        [
                            'key' => '_user_id',
                            'value' => $user_id,
                        ]
                    ], 
                ) ); wp_reset_postdata(  );
                $subscription_end = $order_ids ? get_field('subscription_end',$order_ids) : '';
                @endphp

                

                @php wp_nonce_field( 'ajax-prifile_upd-nonce', 'security' ); @endphp
                <input type="hidden" name="action" value="prifile_upd">
                <input type="hidden" name="user_id" value="{{ $user_id }}">

            </form>
        </div>
    </section>

@endsection
