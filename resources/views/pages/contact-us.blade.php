
@php
    $page['breadcrumb'] =   [
            'Home' => route('welcome'),
            'Contact Us' => route('contact-us'),
        ];
    $page['title'] = 'Contact Us';
    $customer = Auth::guard()->user(); 
    $keywords = 'Contact '.config('app.name');
@endphp
@extends('layouts.default')

@section('page_subtitle')
    {{$page['title']}}
@endsection

@section('meta_keywords')
    {{$keywords}}
@endsection

@section('meta_description')
We are introducing “Logic Manufacturing Co.” is one of the leading Bag & different IT related accessories manufacturers in Bangladesh. Logic Manufacturing Co. realizes that in order to achieve our mission and long-term goals, we must meet the needs of our valued customers and provide a safe and secure work environment for our working family. Logic is totally committed to being a company whose integrity and quality for service is unsurpassed in the bag & different IT related accessories industry. As a leading innovator in the design of computer carrying cases and travel bags, our mission is to provide travelers with more than just stylish and reliable bags. We strive for excellence and are passionate in our efforts to continue to shape and define the market for traveling bags. We aspire to be the best, focusing on the needs of travelers and producing solutions that meet their standards.
@endsection

@section('content')

@include('layouts.modules.preloader')
@include('layouts.modules.breadcrumb')

<!-- Contact Map Area -->
<section id="map">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-8">
                <div class="section-title">
                    <h5>Find Us on Map</h5>
                </div>
                <div id="google-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d116837.33367668092!2d90.37799240534764!3d23.77707829284571!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1slogitech+computers!5e0!3m2!1sen!2sus!4v1536240933016" style="border:0" allowfullscreen="" frameborder="0"></iframe> 
                </div>
            </div>
            <div class="col-md-6 col-lg-4 contact-wrap">
                <div class="contact-form">
                    <div class="section-title">
                        <h5>Get In Touch</h5>
                    </div>
                    @if (session('status'))
                        <div class="col-md-6 offset-md-4">
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        </div>
                    @elseif (session('warning'))
                        <div class="col-md-6 offset-md-4">
                            <div class="alert alert-danger" role="alert">
                                {{ session('warning') }}
                            </div>
                        </div>
                    @endif
                    <form action="{{route('message-us')}}" method="POST">
                        @csrf
                        @auth
                            <input type="hidden" name="customer_id" value="{{$customer->id}}">
                        @else
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="fname">Name</label>
                                <input class="input form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" placeholder="Your Name" required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="fname">Email</label>
                                <input class="input form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" placeholder="Your Email" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endauth
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="subject">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject of your message">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="message">Message</label>
                                <textarea name="message" id="message" name="message" cols="30" rows="5" class="form-control" placeholder="Say something..."></textarea>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="Send Message" class="btn btn-primary">
                        </div>
                    </form>     
                </div>
            </div>
        </div>
    </div>                  
</section>
<!-- End Contact Map Area -->

<!-- Contact Address List Area -->
<section id="contact">
    <div class="container">
        <div class="section-title">
            <h5>Contact Information</h5>
        </div>
        <div class="contact-info-wrap">
            <div class="row no-gutters">
                <div class="col-md-6">
                    <div class="contact-info">
                        <table class="table table-responsive">
                            <colgroup>
                                <col class="title"></col>
                                <col class="content"></col>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <div class="branch-title">
                                            <h6>Head Office</h6>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <p><span><i class="fa fa-map-marker"></i></span> Address</p>
                                    </th>
                                    <td>
                                        <p>: Chowrongi Bhaban (4th floor), 124/A, New Elephant Road, Dhaka-1205.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p><span><i class="fa fa-phone"></i></span> Tel</p>
                                    </th>
                                    <td>
                                        <p>: +8802-9665290, +8802-9666242</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p><span><i class="fa fa-mobile" style="font-size: 15px;"></i></span> Mobile</p>
                                    </th>
                                    <td>
                                        <p>: +01847-277630</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p><span><i class="fa fa-envelope-o"></i></span> Email</p>
                                    </th>
                                    <td>
                                        <p>: info@logitechcomputers.com, logitech_c@yahoo.com</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p><span><i class="fa fa-globe"></i></span> Website</p>
                                    </th>
                                    <td>
                                        <p>: www.logitechcomputers.com</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-info">
                        <table class="table table-responsive">
                            <colgroup>
                                <col class="title"></col>
                                <col class="content"></col>
                            </colgroup>
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <div class="branch-title">
                                            <h6>IDB Bhaban Branch</h6>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <p><span><i class="fa fa-map-marker"></i></span> Address</p>
                                    </th>
                                    <td>
                                        <p>: SR #309-310, BCS Computer City, IDB Bhaban, Agargaon, Dhaka-1207.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p><span><i class="fa fa-phone"></i></span> Tel</p>
                                    </th>
                                    <td>
                                        <p>: +8802-9183212</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p><span><i class="fa fa-mobile" style="font-size: 15px;"></i></span> Mobile</p>
                                    </th>
                                    <td>
                                        <p>: +01847-277632</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p><span><i class="fa fa-envelope-o"></i></span> Email</p>
                                    </th>
                                    <td>
                                        <p>:  idb@logitechcomputers.com, logitechcomputersbd@gmail.com</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <p><span><i class="fa fa-globe"></i></span> Website</p>
                                    </th>
                                    <td>
                                        <p>: www.logitechcomputers.com</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Address List Area -->

@include('layouts.modules.characteristics')
@include('layouts.modules.newsletter')

@endsection