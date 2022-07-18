<div class="coming-soon__item coming-soon-item">
    <div class="inner">
        @if (has_post_thumbnail())
        <img src="{{ get_the_post_thumbnail_url(get_the_ID(),'710x410') }}" alt="thumbnail"> 
        @endif
        
        <div class="coming-soon-item__content">
            <h4>{!! get_the_title() !!}</h4>
            <p>{!! get_the_excerpt() !!}</p>                            
            <button class="double-btn double-btn_white" data-remind_course="{{ get_the_ID() }}">NOTIFIEZ MOI</button>
        </div>
    </div>
</div>