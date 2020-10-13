@extends('layouts.app')
@section('title', 'About Us')

@section('content')

    <section id="about-section" class="about_section">
        <div class="container pt-3">
            <section class="breadcrumbs ">
                <ul class="uk-breadcrumb">
                    <li><a href="{{ route('home.index') }}">Home</a></li>
                    <li><span>About Us</span></li>
                </ul>
            </section>
            <div class="heading pt-3">
                <h3> About us</h3>
            </div>
            <hr>
        </div>
        <div class="container mb">
            <div class="row">
                <div class="col-12">
                    <div class="our-history">
                        <p> {!! getConfiguration('who_we_are') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    {{-- <hr>
    <section class="team-area section-gap team-page-teams mb" id="team">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content ">
                    <div class="text-center heading">
                        <h3 class="mb-3">Experienced Mentor Team</h3>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6  ">
                    <div class="single-team">
                        <div class="thumb">
                            <img src="https://fortunedotcom.files.wordpress.com/2017/08/532010224.jpg" alt="">
                            <div class="align-items-center justify-content-center d-flex">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="meta-text mt-30 text-center">
                            <h4>Ethel Davis</h4>
                            <p>Managing Director (Sales)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ">
                    <div class="single-team">
                        <div class="thumb">
                            <img src="https://www.armytimes.com/resizer/C7gNbavnb9jp2Xlgb9YfCvY6jH8=/1200x0/filters:quality(100)/arc-anglerfish-arc2-prod-mco.s3.amazonaws.com/public/Y7NW2BHG6JGRLOE6XKOHO5WJR4.jpg"
                                 alt="">
                            <div class="align-items-center justify-content-center d-flex">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="meta-text mt-30 text-center">
                            <h4>Rodney Cooper</h4>
                            <p>Creative Art Director (Project)</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section> --}}

@endsection

