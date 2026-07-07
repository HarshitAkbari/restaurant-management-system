{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
	<div class="container-fluid">
		<div class="row page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Advanced</a></li>
				<li class="breadcrumb-item"><a href="javascript:void(0)">lightGallery</a></li>
			</ol>
        </div>
		
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
					<div class="card-header">
						<h4 class="card-title">Light Gallery</h4>
					</div>
					<div class="card-body pb-1">
						<div id="lightgallery" class="row">
							<a href="images/big/img1.jpg" data-exthumbimage="images/big/img1.jpg" data-src="images/big/img1.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="images/big/img1.jpg" alt="" style="width:100%;"/>
							</a>
							<a href="images/big/img2.jpg" data-exthumbimage="images/big/img2.jpg" data-src="images/big/img2.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="images/big/img2.jpg" alt="" style="width:100%;" />
							</a>
							<a href="images/big/img3.jpg" data-exthumbimage="images/big/img3.jpg" data-src="images/big/img3.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="images/big/img3.jpg" alt="" style="width:100%;" />
							</a>
							<a href="images/big/img4.jpg" data-exthumbimage="images/big/img4.jpg" data-src="images/big/img4.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="images/big/img4.jpg" alt="" style="width:100%;" />
							</a>
							<a href="images/big/img5.jpg" data-exthumbimage="images/big/img5.jpg" data-src="images/big/img5.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="images/big/img5.jpg" alt="" style="width:100%;"/>
							</a>
							<a href="images/big/img6.jpg" data-exthumbimage="images/big/img6.jpg" data-src="images/big/img6.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="images/big/img6.jpg" alt="" style="width:100%;" />
							</a>
							<a href="images/big/img7.jpg" data-exthumbimage="images/big/img7.jpg" data-src="images/big/img7.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="images/big/img7.jpg" alt="" style="width:100%;" />
							</a>
							<a href="images/big/img8.jpg" data-exthumbimage="images/big/img8.jpg" data-src="images/big/img8.jpg" class="col-lg-3 col-md-6 mb-4">
								<img src="images/big/img8.jpg" alt="" style="width:100%;" />
							</a>
						</div>
					</div>
                </div>
                <!-- /# card -->
            </div>
        </div>
    </div>
@endsection