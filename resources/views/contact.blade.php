@extends('layouts.app')
@section('content')

<section class="contactus-container uk-margin-bottom">
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-5  box-shadow-2">

                <h3 class="py-2">
                    Contact us
                </h3>
                <section class="contactus_container uk-margin">
                    <form action="{{ route('contact.store') }}" class="contact-form" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" id="name" class="form-control" placeholder="Enter Your Name" name="name" value="" required="required">
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" class="form-control" placeholder="Enter Your Email" name="email" value="" required="required">
                        </div>
                        <div class="form-group">
                            <input type="text" id="phone" class="form-control" name="phone" value="" placeholder="Enter Your Phone" required="required">
                        </div>
                        <div class="form-group">
                            <input type="text" id="subject" class="form-control" name="subject" value="" placeholder="Your Subject..." required="required">
                        </div>
                        <textarea name="msg" class="form-control uk-margin-bottom" rows="8" id="message" placeholder="Message..." required="required"></textarea>

                        <div class="form-group">
                            <label class="" for="message_human">Human Verification</label>
                            <input type="text" class="form-control" name="message_human">
                            <span> + 3 = 5</span>
                        </div>

                        <button type="submit" class="uk-button ">Send Message</button>
                    </form>
                </section>
            </div>
            <div class="col-sm-6 offset-sm-1 box-shadow-2">
                <h3 class="py-2">
                    Contact address
                </h3>
                <p class="mb">
                    {{ getConfiguration('site_address') }}<br>
                    T: {{ getConfiguration('site_primary_phone') }}<br>
                    E: {{ getConfiguration('site_primary_email') }}
                </p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d113027.09345488723!2d85.26530461332472!3d27.714301374774557!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x39eb19732d41948d%3A0xe7546074c57056e0!2sanmol+jyoti+school!3m2!1d27.714319!2d85.3353449!5e0!3m2!1sen!2snp!4v1525417622166" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen=""></iframe>
            </div>
        </div>
    </div>
</section>

@endsection