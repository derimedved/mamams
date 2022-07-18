{{-- 
    Template Name: Quiz Template 
--}}

@php
if(!is_user_logged_in()) {
   wp_redirect(get_home_url());
}
if(get_field('quiz','user_'.get_current_user_id())) {
    wp_redirect(get_home_url());
}
@endphp
@extends('layouts.app')

@section('content')

    <main class="quiz">
        <div class="container">
            <div class="quiz__container">
                <h4 class="quiz__title">{!! App::title() !!}</h4>
                
                <form action="#" id="quiz" class="quiz__fields ajax_form">
                
                    <div class="quiz__field">
                        <div class="quiz__field_title">{{ $pregnant_question }}</div>
                        <div class="quiz__field_choose">
                            <div class="quiz__field_radio">
                                <input class="field__radio" name="pregnant_answer" type="radio" id="pregnant_answer-yes" value="yes">
                                <label for="pregnant_answer-yes">{{ $yes?:'yes' }}</label>
                            </div>
                            <div class="quiz__field_radio">
                                <input class="field__radio" name="pregnant_answer" type="radio" id="pregnant_answer-no" value="no">
                                <label for="pregnant_answer-no">{{ $no?:'no' }}</label>
                            </div>
                        </div>
                        <div class="quiz__field_show quiz__field_data">
                            <div class="quiz__field_title">{{ $date_question }}</div>
                            <input type='text' name="pregnant_date" class='datepicker-input' id="datepicker" placeholder="{{ $date_placeholder }}" style="margin:0;" readonly />
                            <input type="hidden" name="pregnant_date_question" value="{{ $date_question }}">
                        </div>
                        <input type="hidden" name="pregnant_question" value="{{ $pregnant_question }}">
                    </div>

                    <div class="quiz__field holded">
                        <div class="quiz__field_title">{{ $children_question }}</div>
                        <div class="quiz__field_choose">
                            <div class="quiz__field_radio">
                                <input class="field__radio" name="children_answer" type="radio" id="children_answer-yes" value="yes">
                                <label for="children_answer-yes">{{ $yes?:'yes' }}</label>
                            </div>
                            <div class="quiz__field_radio">
                                <input class="field__radio" name="children_answer" type="radio" id="children_answer-no" value="no">
                                <label for="children_answer-no">{{ $no?:'no' }}</label>
                            </div>
                        </div>
                        <div class="quiz__field_show">
                            <div class="quiz__field_title">{{ $children_options_title }}</div>
                            @if ($children_options)
                            <div class="select" data-state="" id="course_one">
                                <div class="select__title" data-default=" ">{{ $children_options_title }}</div>
                                <div class="select__content">
                                    @foreach ($children_options as $option)
                                    <input id="children_option-{{ $loop->index }}" class="select__input" type="radio" name="children_option" value="{{ $option->number }}" @if ($loop->first) checked @endif />
                                    <label for="children_option-{{ $loop->index }}" class="select__label">{{ $option->text }}</label> 
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        <input type="hidden" name="children_question" value="{{ $children_question }}">
                    </div>

                    @if ($questions)
                        @foreach ($questions as $key => $question)
                        <div class="quiz__field holded">
                            @php 
                                $key = $show_date ? ++$key : $key;
                                $current_index_question = $loop->index;
                                $key_question="quiz[$key][question]";
                                $key_answer="quiz[$key][answer]";
                                $key_option="quiz[$key][option]";
                            @endphp
                            <div class="quiz__field_title">{{ $question->question }}</div>
                            <div class="quiz__field_choose">
                                <div class="quiz__field_radio">
                                    <input class="field__radio" name="{{ $key_answer }}" type="radio" id="yes-{{ $current_index_question }}" value="yes">
                                    <label for="yes-{{ $current_index_question }}">{{ $yes?:'yes' }}</label>
                                </div>
                                <div class="quiz__field_radio">
                                    <input class="field__radio" name="{{ $key_answer }}" type="radio" id="no-{{ $current_index_question }}" value="no">
                                    <label for="no-{{ $current_index_question }}">{{ $no?:'no' }}</label>
                                </div>
                            </div>
                            <div class="quiz__field_show">
                                <div class="quiz__field_title">{{ $question->question_options }}</div>
                                @if ($question->options)
                                <div class="select" data-state="" id="course_one">
                                    <div class="select__title" data-default=" ">{{ $question->options[0]->text }}</div>
                                    <div class="select__content">
                                        @foreach ($question->options as $option)
                                        <input id="answer-{{ $current_index_question }}-{{ $loop->index }}" class="select__input" type="radio" name="{{ $key_option }}" value="{{ $option->text }}" @if ($loop->first) checked @endif />
                                        <label for="answer-{{ $current_index_question }}-{{ $loop->index }}" class="select__label">{{ $option->text }}</label> 
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if (!$loop->last)
                            <div class="quiz__separator"></div>
                        @endif
                        <input type="hidden" name="{{ $key_question }}" value="{{ $question->question }}">
                        @endforeach
                    @endif

                    <div class="status"></div>
                    <a href="#" class="quiz__fields_submit main-btn red-btn form-submit holded">{{ $submit?:'submit' }}</a>
                    <a href="{{ get_home_url() }}">
                        <div class="skip">{{ $skip?:'SKIP' }}</div>
                    </a>
                    <input type="submit" style="display:none;" />
                    <input type="hidden" name="action" value="ajax_quiz">
                    <input type="hidden" name="user_id" value="{{ get_current_user_id() }}">
                    <script>
                    function submit(e) {                       
                        $('form input[type="submit"]').click();
                    }
                    </script>
                </form>
                
            </div>
        </div>
    </main>

@endsection
