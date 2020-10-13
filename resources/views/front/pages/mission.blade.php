@extends('layouts.app')
@section('title', 'Mission & Vision')

@section('content')

    <section id="about-section" class="about_section">
        <div class="container pt-3">
            <section class="breadcrumbs ">
                <ul class="uk-breadcrumb">
                    <li><a href="{{ route('home.index') }}">Home</a></li>
                    <li><span>Mission & Vision</span></li>
                </ul>
            </section>
            <div class="heading pt-3">
                <h3> Mission & Vision</h3>
            </div>
            <hr>
        </div>
        <div class="container mb">
            <div class="our-vision mb">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <p>{!! getConfiguration('our_mission') !!}</p>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <img src="https://mutarecity.co.zw/images/vision2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

