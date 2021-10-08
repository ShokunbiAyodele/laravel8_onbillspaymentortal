@extends('admin.admin_master')

@section('admin')

<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-10 col-xs-10">	
						<div class="owl-carousel owl-theme slide" id="featured">
							<div class="item">
								<article class="featured">
									<div class="overlay"></div>
									<figure>
										<img src="{{ asset('assets/images/news/best-online-bill-payment.png') }}" alt="Sample Article">
									</figure>
									<div class="details">
										<div class="category"><a href="{{ route('billers.category_view')}}">Check Here</a></div>
										<h1><a href="single.html">Choose the right online payment for your seamless B2B Payment</a></h1>
									</div>
								</article>
							</div>
						</div>
         </div>
  </div>
@endsection