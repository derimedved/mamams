@php
$_fields = [
    'logo_f',
    'copyright',
    'menu_title_1',
    'menu_title_2',
    'newsletter_title',
    'socials',
    'remind_form',
    'remind_title',
    'thank_you_title',
    'thank_you_description',
    'thank_you_btn',
    'sticky_bar_text',
    'sticky_bar_text_center',
    'sticky_bar_button',
    'choose_plan_page',
    'cf_popups',
];
if($_fields)
foreach($_fields as $_field) {
    $$_field = get_field($_field,'options');
}
@endphp
@if (!$without_footer)
 
    <footer class="footer">
        <div class="container footer__wrap">
            <div class="logo-wrap">
                @if ($logo_f)
                <a href="{{ get_home_url() }}" class="header__logo footer__logo"><img height="50px" width="50px" src="{{ $logo_f['sizes']['100x100'] }}" alt="{{ $logo_f['alt'] }}"></a>
                @endif
            </div>
            @if ($copyright)
            <p class="footer__signature">{{ sprintf($copyright, date('Y')) }}</p>
            @endif
            <div class="footer__wrap-link">
                @if (has_nav_menu('footer_navigation_1'))
                <div class="footer__wrap-list">
                    <p>{{ $menu_title_1 }}</p>
                    <ul class="footer__list-wrap">
                        {!! wp_nav_menu([
                            'theme_location' => 'footer_navigation_1',
                            'menu_id'        => '',
                            'menu_class'      => '',
                            'container'       => '',
                            'container_class' => '',
                            'container_id'    => '',
                            'items_wrap' => '%3$s',
                        ]) !!}
                    </ul>
                </div>
                @endif
                @if (has_nav_menu('footer_navigation_2'))
                <div class="footer__wrap-list">
                    <p>{{ $menu_title_2 }}</p>
                    <ul class="footer__list-wrap">
                        {!! wp_nav_menu([
                            'theme_location' => 'footer_navigation_2',
                            'menu_id'        => '',
                            'menu_class'      => '',
                            'container'       => '',
                            'container_class' => '',
                            'container_id'    => '',
                            'items_wrap' => '%3$s',
                        ]) !!}
                    </ul>
                </div>
                @endif
            </div>
            
            <div class="footer__wrap-list footer__wrap-social">
                <p>{{ $newsletter_title }}</p>
                {!! do_shortcode('[contact-form-7 id="446" title="NEWSLETTER"]') !!}
                @if ($socials)
                <div class="socila-wrap">
                    @if ($socials['facebook'])
                    <div class="socila-wrap__item">
                        <a href="{{ $socials['facebook'] }}" target="_blank">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.527 2.53943H3.47261C2.95711 2.53943 2.53857 2.95713 2.53857 3.47348V18.528C2.53857 19.0444 2.95711 19.4626 3.47261 19.4626H11.5774V12.909H9.3722V10.3546H11.5774V8.47086C11.5774 6.28538 12.9119 5.09469 14.8619 5.09469C15.7968 5.09469 16.5984 5.16463 16.8322 5.195V7.47941L15.4797 7.47997C14.4194 7.47997 14.2149 7.98405 14.2149 8.72332V10.3537H16.7445L16.4137 12.9079H14.2146V19.4618H18.5267C19.0428 19.4618 19.4616 19.043 19.4616 18.528V3.47292C19.4613 2.95713 19.043 2.53943 18.527 2.53943Z" fill="#726364"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                    @if ($socials['twitter'])
                    <div class="socila-wrap__item">
                        <a href="{{ $socials['twitter'] }}" target="_blank">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.1154 7.01834C17.801 6.61462 18.3141 5.97891 18.5587 5.22992C17.9144 5.60644 17.2095 5.87167 16.4744 6.01414C15.4552 4.95233 13.8405 4.69394 12.5324 5.38334C11.2244 6.07274 10.5468 7.53926 10.8784 8.96345C8.23923 8.83295 5.78037 7.60512 4.11369 5.58549C3.24388 7.0631 3.68837 8.95199 5.12947 9.90211C4.60835 9.88561 4.09879 9.74665 3.64328 9.49681C3.64328 9.51037 3.64328 9.52393 3.64328 9.53749C3.64358 11.0767 4.74501 12.4025 6.27681 12.7075C5.79344 12.837 5.28643 12.8561 4.79444 12.7633C5.22523 14.0796 6.45698 14.9813 7.8609 15.0082C6.69814 15.907 5.26216 16.3945 3.78402 16.3921C3.52202 16.3925 3.26022 16.3776 3 16.3476C4.50102 17.2976 6.24802 17.8019 8.03224 17.8001C10.5145 17.8169 12.9001 16.8531 14.6553 15.1242C16.4105 13.3954 17.3889 11.0459 17.3716 8.60109C17.3716 8.46097 17.3683 8.32161 17.3617 8.18299C18.0045 7.72542 18.5593 7.15857 19.0001 6.50908C18.4012 6.77054 17.7659 6.94219 17.1154 7.01834Z" fill="#726364"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                    @if ($socials['linkedin'])
                    <div class="socila-wrap__item">
                        <a href="{{ $socials['linkedin'] }}" target="_blank">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.1453 16.6919H8.94868V7.10238H12.1453V8.70063C12.8266 7.83378 13.8599 7.317 14.9622 7.29177C16.9446 7.30277 18.5442 8.9159 18.5384 10.8982V16.6919H15.3418V11.2978C15.214 10.4049 14.4482 9.74235 13.5462 9.74429C13.1516 9.75676 12.7792 9.92951 12.5148 10.2227C12.2505 10.5158 12.117 10.9041 12.1453 11.2978V16.6919ZM7.35039 16.6919H4.15381V7.10238H7.35039V16.6919ZM5.7521 5.50412C4.86939 5.50412 4.15381 4.78856 4.15381 3.90587C4.15381 3.02318 4.86939 2.30762 5.7521 2.30762C6.63481 2.30762 7.35039 3.02318 7.35039 3.90587C7.35039 4.32975 7.182 4.73628 6.88226 5.03601C6.58252 5.33574 6.17599 5.50412 5.7521 5.50412Z" fill="#726364"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                    @if ($socials['instagram'])
                    <div class="socila-wrap__item">
                        <a href="{{ $socials['instagram'] }}" target="_blank">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="4" y="4" width="14" height="14" rx="3" fill="#BEB9B9"/>
                                <path d="M13.9999 11C13.9999 12.6569 12.6567 14 10.9999 14C9.34313 14 8 12.6569 8 11C8 9.34313 9.34313 8 10.9999 8C12.6567 8 13.9999 9.34313 13.9999 11Z" fill="#BEB9B9" stroke="#56494A" stroke-width="2"/>
                                <circle cx="15" cy="6.99951" r="1" fill="#56494A"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </footer>
    
@endif


<section class="pop-up specialists-pop-up">
    <button class="pop-up__close"></button>
    <div class="output_pop-up" style="height:80vh"></div>
</section>

@if (is_front_page())
<section class="pop-up quick-view quick-view_authorized">
    <button class="pop-up__close"></button>
    <div class="output_pop-up" style="height:80vh"></div>
</section>
@endif


@if ($remind_form)
<section class="pop-up pop-up-remind">
    <button class="pop-up__close"></button>

    <?php if (App::isPremium())  {
        $remind_title = explode('.', $remind_title)[0];
    } ?>

    <p>{{ $remind_title?:'We will send you an email when the course is opened' }}</p>
    {!! do_shortcode("[contact-form-7 id='$remind_form']") !!}
</section>
@endif

<section class="pop-up pop-up-remind pop-up-thank-you pop-up-default">
    <button class="pop-up__close"></button>
    <p>{{ $thank_you_title?:'Thank you' }}</p>
    <span>{{ $thank_you_description?:'While you are waiting - check our opened cources. We sure you may find something interesting there too.' }}</span>
    @if ($thank_you_btn)
        <a href="{{ $thank_you_btn['url'] }}" class="double-btn double-btn_red">{{ $thank_you_btn['title'] }}</a>
    @endif
</section>

@if ($cf_popups)
    @foreach ($cf_popups as $cf_popup)
        @if($cf_popup['form'])
        <section class="pop-up pop-up-remind pop-up-thank-you pop-up-{{ $cf_popup['form'] }}" data-cf_id="{{ $cf_popup['form'] }}">
            <button class="pop-up__close"></button>
            <p>{{ $cf_popup['title']?:'Thank you' }}</p>
            <span>{{ $cf_popup['description']?:'While you are waiting - check our opened cources. We sure you may find something interesting there too.' }}</span>
            @if ($cf_popup['button'])
                <a href="{{ $cf_popup['button']['url'] }}" class="double-btn double-btn_red">{{ $cf_popup['button']['title'] }}</a>
            @endif
        </section>
        @endif
    @endforeach
@endif

<div class="blackout"></div>

@if (is_singular('lp_course'))
    <?php


        $user        = learn_press_get_current_user();
        $course      = learn_press_get_the_course();
        $course_price = $course->get_price()?:__('Free','sage');
        $user_course = $user->get_course_data( get_the_ID() );
        $purchased = $user ? $user->has_enrolled_course( $course->get_id() ) : false;
        if(App::isPremium()) $purchased=true;
        $course_avaliable =   $purchased ? 'course_avaliable' : '';

    ?>
    <div class="new-sticky-bar <?= $course_avaliable ?>">
        <div class="container">



            <?php

            if(!$purchased) {  ?>
                <div class="btn-wrap">
                    <p class="price">€<?= $course_price*1.2 ?></p>


                    <div class="wrap">
                        <a href="<?= get_permalink( $choose_plan_page ) ?>" data-focus_course="<?= get_the_id() ?>" class="double-btn double-btn_red">OBTENIR CE COURS</a>
                    </div>
                </div>

            <?php } else { ?>


                <div class="btn-wrap">
                    <?php

                    $start_date_timestamp = $user_course->get_start_time()->getTimestamp();
                    $start_date = strftime("%e %B %Y",$start_date_timestamp);
                    $available = get_field('available', $course->get_id()) ;
                    if($start_date && $available):

                    $end_date = date('d/m/Y', strtotime($start_date. " + $available month"));
                    ?>
                

                    <div class="wrap">
                        <div class="banner-block__img-purchased"><span>Accessible jusqu'au</span> <?= $end_date; ?></div>
                    </div>

                        <?php endif; ?>
                </div>




            <?php } ?>


        </div>
    </div>
@endif
@if(!App::isPremium())
    @if (basename(get_page_template()) != "template-landing.blade.php"&&($sticky_bar_text||$sticky_bar_button))
    <div class="sticky-bar">
        <div class="sticky-bar__block container">
            <div class="sticky-bar__title">{{ $sticky_bar_text }}</div>
            <div class="sticky-bar__module-text">{{ $sticky_bar_text_center }}</div>
            <div class="sticky-bar__btn-wrap">
                @if ($sticky_bar_button)
                <a href="{{ $sticky_bar_button['url'] }}" class="red-btn">{{ $sticky_bar_button['title'] }}</a>
                @endif
            </div>
        </div>
    </div>
    @endif
@endif


@if (basename(get_page_template()) == "template-landing.blade.php"&&($acf_options->fix_info_title||$acf_options->fix_info_button))
<div class="fix-info">
    <div class="container">
        <div class="text-wrap">
            <p>{{ $acf_options->fix_info_title }}</p>
        </div>
        <div class="btn-wrap">
            @if ($acf_options->fix_info_button)
            <a href="#discover" class="red-btn fancybox">{{ $acf_options->fix_info_button->title }}</a>
            @endif
        </div>
        <a href="#" class="fix-close"></a>
    </div>
</div>
@endif

@if ($acf_options->discover_popup_title||$acf_options->discover_popup_bottom||$acf_options->discover_popup_form)
<div id="discover" class="popup-site popup-discover" style="display: none;">
    <div class="main-wrap">
        <div class="bg">
            <div class="left-top">
                <img src="https://ecoledesfuturesmamans.fr/wp-content/themes/mamams/resources/assets/img/img-1-1.png" alt="">
            </div>
            <div class="right-top">
                <img src="https://ecoledesfuturesmamans.fr/wp-content/themes/mamams/resources/assets/img/img-1-1.png" alt="">
            </div>
            <div class="left-bottom">
                <img src="https://ecoledesfuturesmamans.fr/wp-content/themes/mamams/resources/assets/img/img-1-1.png" alt="">
            </div>
            <div class="right-bottom">
                <img src="https://ecoledesfuturesmamans.fr/wp-content/themes/mamams/resources/assets/img/img-1-1.png" alt="">
            </div>
        </div>
       <div class="wrap">
           <p class="top">{!! $acf_options->discover_popup_title !!}
           </p>
            @if ($acf_options->discover_popup_form)
                {!! do_shortcode("[contact-form-7 id='$acf_options->discover_popup_form']") !!}
            @endif
           <p class="bottom">{{ $acf_options->discover_popup_bottom }}</p>
       </div>
    </div>
</div>
@endif


