@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<section class="category">
		  <div class="container">
		    <div class="row">
		      <div class="col-md-12 text-left">
		        <div class="row">
		          <div class="col-md-12">        
		            <h1 class="page-title">Bill Payment Category</h1>
		          
		          </div>
		        </div>
		        <div class="line"></div>
		        <div class="row">
		          <article class="col-md-12 article-list">
		            <div class="inner">
		              <figure>
			              <a href="single.html">
			                <img src="{{ asset('assets/images/news/ekoImage.png')}}">
		                </a>
		              </figure>
		              <div class="details">
		                <h1><a href="single.html">EKO ELECTRCITY</a></h1>
										<p>
		                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                  tempor incididunt 
		                </p>
										<div class="row">
											<div class="form-group">
											<div class="col-md-3">
												<select  id="ek0-prepaid" class="form-control">
												<option type="text"  valiue="" id="prepaid">Select Type</option>
												<option type="text"  valiue="" id="prepaid">Eko Prepaid</option>
												<option type="text"  valiue="" id="prepaid">Eko Postpaid</option>
												</select>
                     </div>
											</div>
										 <div class="col-md-5">
										 
												
												</div>
												<div class="col-md-5">
										 
												
												</div>

                    </div>
		              </div>
		            </div>
		          </article>
		          <article class="col-md-12 article-list">
		            <div class="inner">
		              <figure>
			              <a href="single.html">
			                <img src="{{ asset('assets/images/news/phd.jpg')}}">
		                </a>
		              </figure>
		              <div class="details">
		                <h1><a href="single.html">PORTHARCOURT DISCO <b>Currently not available</b></a></h1>
		                <p>
		                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		                  quis nostrud exercitat...
		                </p>
		                <footer>
		                  <a href="#" class="love"><i class="ion-android-favorite-outline"></i> <div>78</div></a>
		                  <a class="btn btn-primary more" href="single.html">
		                    <div>More</div>
		                    <div><i class="ion-ios-arrow-thin-right"></i></div>
		                  </a>
		                </footer>
		              </div>
		            </div>
		          </article>
		          <article class="col-md-12 article-list">
		            <div class="inner">
		              <figure>
			              <a href="single.html">
			                <img src="{{ asset('assets/images/news/ibadan.png')}}">
		                </a>
		              </figure>
		              <div class="details">
		                <h1><a href="single.html">IBADAN DISCO</a></h1>
		                <p>
		                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		                  quis nostrud exercitat...
		                </p>
		                <footer>
		                  <a href="#" class="love"><i class="ion-android-favorite-outline"></i> <div>10</div></a>
		                  <a class="btn btn-primary more" href="single.html">
		                    <div>More</div>
		                    <div><i class="ion-ios-arrow-thin-right"></i></div>
		                  </a>
		                </footer>
		              </div>
		            </div>
		          </article>
		          <article class="col-md-12 article-list">
		            <div class="inner">
		              <figure>
			              <a href="single.html">
			                <img src="{{asset('assets/images/news/ikeja.png')}}">
		                </a>
		              </figure>
		              <div class="details">
		                <div class="detail">
		                  <div class="category">
		                   <a href="category.html">Film</a>
		                  </div>
		                  <div class="time">December 26, 2016</div>
		                </div>
		                <h1><a href="single.html">IKEJA ELECTRIC</a></h1>
		                <p>
		                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		                  quis nostrud exercitat...
		                </p>
		                <footer>
		                  <a href="#" class="love"><i class="ion-android-favorite-outline"></i> <div>1820</div></a>
		                  <a class="btn btn-primary more" href="single.html">
		                    <div>More</div>
		                    <div><i class="ion-ios-arrow-thin-right"></i></div>
		                  </a>
		                </footer>
		              </div>
		            </div>
		          </article>
		          <article class="col-md-12 article-list">
		            <div class="inner">
		              <figure>
			              <a href="single.html">
			                <img src="{{asset('assets/images/news/multichoice.png')}}">
		                </a>
		              </figure>
		              <div class="details">
		                <h1><a href="single.html">MULTICHOICE DSTV AND GOTV</a></h1>
		                <p>
		                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		                  quis nostrud exercitat...
		                </p>
		                <footer>
		                  <a href="#" class="love"><i class="ion-android-favorite-outline"></i> <div>739</div></a>
		                  <a class="btn btn-primary more" href="single.html">
		                    <div>More</div>
		                    <div><i class="ion-ios-arrow-thin-right"></i></div>
		                  </a>
		                </footer>
		              </div>
		            </div>
		          </article>
		          <article class="col-md-12 article-list">
		            <div class="inner">
		              <figure>
			              <a href="single.html">
			                <img src="{{asset('assets/images/news/startimes-logo.jpg')}}">
		                </a>
		              </figure>
		              <div class="details">
		                <h1><a href="single.html">STARTTIME</a></h1>
		                <p>
		                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		                  quis nostrud exercitat...
		                </p>
		                <footer>
		                  <a href="#" class="love"><i class="ion-android-favorite-outline"></i> <div>902</div></a>
		                  <a class="btn btn-primary more" href="single.html">
		                    <div>More</div>
		                    <div><i class="ion-ios-arrow-thin-right"></i></div>
		                  </a>
		                </footer>
		              </div>
		            </div>
		          </article>
		          <article class="col-md-12 article-list">
		            <div class="inner">
		              <figure>
			              <a href="single.html">
			                <img src="{{asset('assets/images/news/spectranet.jpg')}}">
		                </a>
		              </figure>
		              <div class="details">
		                <div class="detail">
		                  <div class="category">
		                   <a href="category.html">Film</a>
		                  </div>
		                  <div class="time">December 26, 2016</div>
		                </div>
		                <h1><a href="single.html">Lorem Ipsum Dolor Sit Consectetur Adipisicing Elit</a></h1>
		                <p>
		                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		                  quis nostrud exercitat...
		                </p>
		                <footer>
		                  <a href="#" class="love"><i class="ion-android-favorite-outline"></i> <div>78</div></a>
		                  <a class="btn btn-primary more" href="single.html">
		                    <div>More</div>
		                    <div><i class="ion-ios-arrow-thin-right"></i></div>
		                  </a>
		                </footer>
		              </div>
		            </div>
		          </article>
		          <article class="col-md-12 article-list">
		            <div class="inner">
		              <figure>
			              <a href="single.html">
			                <img src="{{asset('assets/images/news/smile.jpg')}}">
		                </a>
		              </figure>
		              <div class="details">
		                <h1><a href="single.html">SMLE RECHARGE AND BUNDLE</a></h1>
		                <p>
		                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		                  quis nostrud exercitat...
		                </p>
		                <footer>
		                  <a href="#" class="love"><i class="ion-android-favorite-outline"></i> <div>198</div></a>
		                  <a class="btn btn-primary more" href="single.html">
		                    <div>More</div>
		                    <div><i class="ion-ios-arrow-thin-right"></i></div>
		                  </a>
		                </footer>
		              </div>
		            </div>
		          </article>
		          <div class="col-md-12 text-center">
		            <ul class="pagination">
		              <li class="prev"><a href="#"><i class="ion-ios-arrow-left"></i></a></li>
		              <li class="active"><a href="{{ route('billers.category_view') }}">1</a></li>
		              <li class=""><a href="{{ route('billers_cate_two') }}">2</a></li>
		              <li><a href="#">3</a></li>
		              <li><a href="#">...</a></li>
		              <li><a href="#">97</a></li>
		              <li class="next"><a href="#"><i class="ion-ios-arrow-right"></i></a></li>
		            </ul>
		            <div class="pagination-help-text">
		            	Showing 8 results of 776 &mdash; Page 1
		            </div>
		          </div>
		        </div>
		      </div>
		      
		    </div>
		  </div>
		</section>

    @endsection