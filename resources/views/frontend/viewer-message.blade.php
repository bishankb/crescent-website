@section('frontend-style')
	<style type="text/css">
	.error {
		color: red;
		margin-top : 5px;
	}
	</style>
@endsection

<div class="col-lg-12">
<h3 class="text-center">Get In Touch With Us</h3>
<div class="card">
	<div class="card-body">
		<form class="form-area" id="messageForm" action="{{ route('viewer-messages.send') }}" method="POST" class="contact-form text-right">
			{{ csrf_field() }}
			<div class="row">	
				<div class="col-lg-6 form-group">
					<input name="name" placeholder="Enter your name" class="common-input form-control" minlength="2" required type="text" value="{{ old('name') }}">
				</div>


				<div class="col-lg-6 form-group">
					<input name="email" placeholder="Enter your email address" class="common-input form-control" type="email" required type="text" value="{{ old('email') }}">
				</div>
			</div>


			<div class="row">
				<div class="col-lg-6 form-group">
					<input name="phone" placeholder="Enter your phone number" class="common-input form-control" minlength="5" value="{{ old('phone') }}">
				</div>

				<div class="col-lg-6 form-group">
					<input name="subject" placeholder="Enter your subject" class="common-input form-control" type="text"  minlength="2" value="{{ old('subject') }}">
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 form-group">
					<textarea class="common-textarea form-control" name="message" placeholder="Messege" required minlength="5" value="{{ old('message') }}"></textarea>
				</div>
			</div>		
			<button type="submit" class="primary-btn mt-10 text-white">Send Message</button>			
			</div>
		</form>	
	</div>
</div>

@section('frontend-script')
	<script>
		$("#messageForm").validate();
	</script>
@endsection