@extends('layouts.frontend')

@section('content')
	<section class="banner-area relative" id="home">	
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Contact Us
					</h1>	
					<p class="text-white link-nav">
						<a href="{{ route('frontend.home') }}">Home </a> 
						<span class="lnr lnr-arrow-right"></span>Contact Us
					</p>
				</div>											
			</div>
		</div>
	</section>

	<section class="contact-page-area section-gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="text-center">Feel Free to Contact Us</h3>
					<div class="card">
						<div class="card-body">
							<div class="single-contact-address">
								<div class="contact-details">
									<div class="row">
										<div class="col-md-6">
											<h5><u>Civil Deparment</u></h5>
											<h5>
												<span class="lnr lnr-phone-handset"></span> {{ $contact_us->phone1 }} 
												<span style="font-size: 13px;">(Bishad Man Gubahaju)</span>
											</h5>
											<h5>
												<span class="lnr lnr-phone-handset"></span> {{ $contact_us->phone3 }} 
												<span style="font-size: 13px;">(Sunil Shrestha)</span>
											</h5>
										</div>
										<div class="col-md-6">	
											<h5><u>Computer Deparment</u></h5>
											<h5>
												<span class="lnr lnr-phone-handset"></span> {{ $contact_us->phone2 }} 
												<span style="font-size: 13px;">(Manoj Kumar Agrahari)</span></h5>
											<h5>
												<span class="lnr lnr-phone-handset"></span> {{ $contact_us->phone4 }} 
												<span style="font-size: 13px;">(Bishank Badgami)</span>
											</h5>
										</div>
										
									</div>
									<hr>
									<div class="row">
										<h5 class="col-md-6">
											<span class="lnr lnr-home"></span> {{ $contact_us->address }}
										</h5>
										<h5 class="col-md-6">
											<span class="lnr lnr-envelope"></span> {{ $contact_us->email }}
										</h5>
									</div>
									@if(isset($contact_us->facebook) || isset($contact_us->google_plus))
										<hr>
										<div class="col-xs-12 social-links">
											<h5>Follow us on</h5>
						                   <ul class="company-social">
						                   		@isset($contact_us->facebook)
							                        <li class="social-facebook">
							                        	<a href="{{ $contact_us->facebook }}" target="__blank"><i class="fa fa-facebook"></i></a>
							                        </li>
							                    @endisset
  						                   		@isset($contact_us->google_plus)
							                        <li class="social-google">
							                            <a href="{{ $contact_us->google_plus }}" target="__blank"><i class="fa fa-google-plus"></i></a>
							                        </li>
							                    @endisset
						                       </ul>
						                </div>
						            @endif
								</div>
							</div>
						</div>
					</div>													
				</div>

				@include('frontend.viewer-message')
				
				</div>
				@if(isset($contact_us->map_embedded_link))
					<div class="col-lg-12 map-wrap">
						<h3 class="text-center">Our Location</h3>
						{!! $contact_us->map_embedded_link !!}
					</div>
				@endif
			</div>
		</div>	
	</section>
@endsection