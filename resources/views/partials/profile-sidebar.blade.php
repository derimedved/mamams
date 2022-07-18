@php

$check_fields = ['first_name','last_name','age','phone','dob','waiting','children','themes'];
$total_fields = count($check_fields) ?: 0;
$filled_fields = 0; 
$percentage = 0;
foreach($check_fields as $field) {
    if($$field) ++$filled_fields;
}
$percentage = round(($filled_fields / $total_fields) * 100);

$avatar_url = $acf_options->image_sidebar_option ? $acf_options->image_sidebar_option->sizes->{'430x300'} : '../img/profile_01.png';
@endphp
<div class="profile-column">
    <div class="profile-image-wrap">
        <div class="profile-image-main" style="background: rgba(155, 132, 122, 0.4) url({{ $avatar_url }}) 50% bottom no-repeat">
            <div class="avatar_wrap">
                @if ($avatar = get_field('avatar','user_'.$user_id))
                    <figure><img src="{{ $avatar['sizes']['640x640'] }}" alt="{{ $avatar['alt'] }}" /></figure>
                @endif
            </div>
        </div>
        <form action="#" class="drop profile_main_avatar">
            <input name="file" type="file" />
        </form>
        <p>{!! $name !!}{{ $age&&$name ? ', '.$age : $age }}</p>
    </div>

    @php do_action( 'profile_notice' ); @endphp

    
    <div class="profile-children" data-child_title="{{ $acf_options->child_label ?: 'Votre enfant' }}">
        @if ($children)
        <p>{{ $acf_options->child_label ?: 'Votre enfant' }}</p>
        <ul>
            @foreach ($children as $child)
               <li>{{ $child['name'] }}{{ $child['name']&&$child['age'] ? ',' : '' }} {{ $child['age'] }}</li> 
            @endforeach
        </ul>
        @endif
    </div>


    <div class="profile-navigation">
        <ul>
            @if ($acf_options->profile_info_page)
                <li class="{{ $acf_options->profile_info_page==get_the_ID()?'active':'' }}"><a href="{{ get_permalink($acf_options->profile_info_page) }}">{!! get_the_title($acf_options->profile_info_page) !!}</a></li>
            @endif
            @if ($acf_options->profile_orders_page)
                <li class="{{ $acf_options->profile_orders_page==get_the_ID()?'active':'' }}"><a href="{{ get_permalink($acf_options->profile_orders_page) }}">{!! get_the_title($acf_options->profile_orders_page) !!}</a></li>
            @endif
        </ul>
    </div>
    <div class="profile-completion">
        <p>{{ $acf_options->profile_progress ?: 'Votre profil est actuellement complété à:' }}</p>
        <div class="percentage">
            <div class="c100 p{{ $percentage }} small" data-percentage="{{ $percentage }}">
                <span>{{ $percentage }}%</span>
                <div class="slice">
                    <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
        </div>
    </div>
</div>