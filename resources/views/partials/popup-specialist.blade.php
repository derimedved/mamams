
@if ($id)
<div class="specialists-pop-up__photo">
    @if (has_post_thumbnail($id))
        <img src="<?= get_the_post_thumbnail_url($id,'200x200');?>" alt="specialist">
    @endif   
</div>
<div class="specialists-pop-up__wrap">
    <div class="specialists-pop-up__title">
        <h5>{!! get_the_title($id) !!}</h5>
        <p>{{ get_field('position',$id) }}</p>
    </div>
    <hr>
    @if ($about = get_field('about',$id))
    <div class="specialists-pop-up__description">
        <p>{{ $about['label']?:'À PROPOS DU SPÉCIALISTE' }}</p>
        {!! $about['text']  !!}
    </div>
    <hr>
    @endif
    @if ($specializations = get_field('specializations',$id))
    <div class="specialists-pop-up__description">
        <p>{{ $specializations['label']?:'SPÉCIALISATION' }}</p>
        {!! $specializations['text']  !!}
    </div>
    <hr>
    @endif
    @if ($contact = get_field('contact',$id))
    <div class="specialists-pop-up__description">
        <p>{{ $contact['label']?:'INFORMATIONS PRATIQUES' }}</p>
        @if ($social = $contact['social'])
        <div class="socila-wrap">
            @if ($social['facebook'])
            <div class="socila-wrap__item">
                <a href="{{ $social['facebook'] }}" target="_blank">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.527 2.53943H3.47261C2.95711 2.53943 2.53857 2.95713 2.53857 3.47348V18.528C2.53857 19.0444 2.95711 19.4626 3.47261 19.4626H11.5774V12.909H9.3722V10.3546H11.5774V8.47086C11.5774 6.28538 12.9119 5.09469 14.8619 5.09469C15.7968 5.09469 16.5984 5.16463 16.8322 5.195V7.47941L15.4797 7.47997C14.4194 7.47997 14.2149 7.98405 14.2149 8.72332V10.3537H16.7445L16.4137 12.9079H14.2146V19.4618H18.5267C19.0428 19.4618 19.4616 19.043 19.4616 18.528V3.47292C19.4613 2.95713 19.043 2.53943 18.527 2.53943Z" fill="#726364"/>
                    </svg>
                </a>
            </div>
            @endif
            @if ($social['twitter'])
            <div class="socila-wrap__item">
                <a href="{{ $social['twitter'] }}" target="_blank">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.1154 7.01834C17.801 6.61462 18.3141 5.97891 18.5587 5.22992C17.9144 5.60644 17.2095 5.87167 16.4744 6.01414C15.4552 4.95233 13.8405 4.69394 12.5324 5.38334C11.2244 6.07274 10.5468 7.53926 10.8784 8.96345C8.23923 8.83295 5.78037 7.60512 4.11369 5.58549C3.24388 7.0631 3.68837 8.95199 5.12947 9.90211C4.60835 9.88561 4.09879 9.74665 3.64328 9.49681C3.64328 9.51037 3.64328 9.52393 3.64328 9.53749C3.64358 11.0767 4.74501 12.4025 6.27681 12.7075C5.79344 12.837 5.28643 12.8561 4.79444 12.7633C5.22523 14.0796 6.45698 14.9813 7.8609 15.0082C6.69814 15.907 5.26216 16.3945 3.78402 16.3921C3.52202 16.3925 3.26022 16.3776 3 16.3476C4.50102 17.2976 6.24802 17.8019 8.03224 17.8001C10.5145 17.8169 12.9001 16.8531 14.6553 15.1242C16.4105 13.3954 17.3889 11.0459 17.3716 8.60109C17.3716 8.46097 17.3683 8.32161 17.3617 8.18299C18.0045 7.72542 18.5593 7.15857 19.0001 6.50908C18.4012 6.77054 17.7659 6.94219 17.1154 7.01834Z" fill="#726364"/>
                    </svg>
                </a>
            </div>
            @endif
            @if ($social['linkedin'])
            <div class="socila-wrap__item">
                <a href="{{ $social['linkedin'] }}" target="_blank">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.1453 16.6919H8.94868V7.10238H12.1453V8.70063C12.8266 7.83378 13.8599 7.317 14.9622 7.29177C16.9446 7.30277 18.5442 8.9159 18.5384 10.8982V16.6919H15.3418V11.2978C15.214 10.4049 14.4482 9.74235 13.5462 9.74429C13.1516 9.75676 12.7792 9.92951 12.5148 10.2227C12.2505 10.5158 12.117 10.9041 12.1453 11.2978V16.6919ZM7.35039 16.6919H4.15381V7.10238H7.35039V16.6919ZM5.7521 5.50412C4.86939 5.50412 4.15381 4.78856 4.15381 3.90587C4.15381 3.02318 4.86939 2.30762 5.7521 2.30762C6.63481 2.30762 7.35039 3.02318 7.35039 3.90587C7.35039 4.32975 7.182 4.73628 6.88226 5.03601C6.58252 5.33574 6.17599 5.50412 5.7521 5.50412Z" fill="#726364"/>
                    </svg>
                </a>
            </div>
            @endif
            @if ($social['insta'])
            <div class="socila-wrap__item">
                <a href="{{ $social['insta'] }}" target="_blank">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="4" width="14" height="14" rx="3" fill="#726364"/>
                        <path d="M13.9999 11C13.9999 12.6569 12.6567 14 10.9999 14C9.34313 14 8 12.6569 8 11C8 9.34313 9.34313 8 10.9999 8C12.6567 8 13.9999 9.34313 13.9999 11Z" fill="#726364" stroke="#FBF9F8" stroke-width="2"/>
                        <circle cx="15" cy="6.99951" r="1" fill="#FBF9F8"/>
                    </svg>
                </a>
            </div>
            @endif
        </div>
        @endif
    </div>
    @endif
</div>
@endif