@extends('admin.admin_master')

@section('admin')



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




		<div class="container">
        <div class="row">
					<div class="col-md-12 col-sm-6 col-xs-6">
						<div class="owl-carousel owl-theme slide" id="featured">
							<div class="item">
								<article class="featured">
									<div class="overlay"></div>
									<figure>
										<img  src="{{ asset('assets/images/news/best-online-bill-payment.png') }}" alt="Sample Article">
									</figure>
									<div class="details">
										<div class="category"><a href="category.html">Check here</a></div>
										<h1><a href="single.html">Choose the right online payment for your seamless B2B Payment</a></h1>
									</div>
								</article>
							</div>
            </div>
					</div>
					<div class="col-xs-5 col-md-4 col-xs-12 sidebar"  id="sidebar">
						<div class="sidebar-title for-tablet">Sidebar</div>
						<div style="align:right" id="result">
						<button id="get" value="get" class="btn btn-sm btn-rounded btn-primary">Get Status</button>
					</div>
						<aside>				
						</aside>
					</div>
				</div>
            <!-- <div class="banner">
							<a href="#">
								<img src="{{ asset('assets/images/ads.png')}}" alt="Sample Article">
							</a>
						</div> -->
  </div>


		 <script type="text/javascript">
			 $(document).on('click','#get',function(){
				let status = document.getElementById('result');
				$.ajax({
					url : "{{ route('get_prepaid_final_response') }}",
					type: "GET",
					success: function(data){
						console.log(data);
						$('#get').hide();
						if(data.status == "PENDING" || data.status == "REJECTED" || data.status == "ACCEPTED" ){
							// setTimeout(location.reload(),5000);
								$('#get').hide();
							
								// status.innerHTML = "the transaction is pending";
						}
						else if(data.status == "FAILED"){
								status.innerHTML = "the transaction is failed";
						}
						else{
							status.innerHTML = "the transaction is Rejected";
					
						}
						// if(data.status === 'ACCEPTED' || data.status === 'REJECTED' || data.status === 'PENDING'){
						// 	let status = document.getElementById('result');
						// 	status.innerHTML = data.status;	
						// }
					}
				});

});

// function executeQuery() {
	
//   let Call = $.ajax({
//     url: "{{ route('get_automatic_transaction') }}",
//     success: function(data) {
//       console.log(data);
// 			if(data.status === 'ACCEPTED'){
// 				//DO SOMETHING HERE
				
// 			}
// 			if(data.status === 'REJECTED' || data.status === 'FAILED'){
// 				//DO SOMETHING HERE
// 				let request;
// 				let status = document.getElementById('result');
// 				status.innerHTML = data.status;
// 				return xhr;	
// 			}

			
//     }
//   });
//   updateCall();

// }
// xhr.abort();

// function updateCall(){
// setTimeout(function(){executeQuery()}, 3000);

// }

	// $(document).ready(function() {
	//   executeQuery();
	// });

		 </script>

@endsection