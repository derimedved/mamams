{{--
    Template Name: Bonheur Reg
--}}

@extends('layouts.app_bonheur')
@section('content')

    <main>

        <div class="b_block_form" id="top_form">
            <div class="block_form_wrapper flex">
                <div class="block_image"><img src="{{ get_the_post_thumbnail_url(get_the_id(), 'full') }}" alt=""></div>
                <div class="block_form">
                    <div class="block_form_inner">
                        <div class="block_title">{{ the_title() }}</div>

                        <div class="form_wrapper">
                            <div class="form">

                                <div class="form">
                                    <div  class=""  >

                                        <form action="" method="post" class="ajax_form  "  >


                                            <div class="form_row">
                                                <span class="wpcf7-form-control-wrap text-216">
                                                    <input type="password" name="password" value="" size="40" class="wpcf7-form-control wpcf7-text form_control" aria-invalid="false" placeholder="Mot de passe">
                                                </span>
                                            </div>
                                            <div class="form_row">
                                                <span class="wpcf7-form-control-wrap text-217">
                                                    <input type="password" name="password2" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form_control" aria-required="true" aria-invalid="false" placeholder="Confirmez votre mot de passe">
                                                </span>
                                            </div>

                                            <input type="submit" value="Obtenir mon cours offert" class="wpcf7-form-control wpcf7-submit btn btn_template btn_send" aria-invalid="false">


                                            <input type="hidden" name="action" value="ajax_registration">
                                            <input type="hidden" name="email" value="{{ $_GET['email'] }}">
                                            <input type="hidden" name="phone" value="{{ $_GET['phone'] }}">
                                            <input type="hidden" name="c" value="{{ $_GET['c'] }}">
                                            @php wp_nonce_field( 'ajax-registration-nonce', 'security' ); @endphp

                                            <div class="status" aria-hidden="true"></div>
                                        </form>
                                    </div>
                                </div>


                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>



    </main>

@endsection