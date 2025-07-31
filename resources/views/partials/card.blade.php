{{-- card --}}
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12 my-3">
                <div class="card-box bg-blue">
                    <div class="inner">
                        <h6 class="text-center"> ADMIN </h6>
                        <p>Order (Pcs)</p>
                        <h3 id="summaryAdmin"> - </h3>
                        <h6 class="text-center">CLOSED</h6>
                    </div>
                    <a href="{{ route('viewMoreAdmin') }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 my-3">
                <div class="card-box bg-green">
                    <div class="inner">
                        <h6 class="text-center"> PREPARE </h6>
                        <p>Order (Pcs)</p>
                        <h3 id="summaryPrepare"> - </h3>
                        <h6 class="text-center">PROGRESS</h6>
                    </div>
                    <a href="{{ route('viewMorePrepare') }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 my-3">
                <div class="card-box bg-orange">
                    <div class="inner">
                        <h6 class="text-center"> CHECKED </h6>
                        <p>Order (Pcs)</p>
                        <h3 id="summaryChecked"> - </h3>
                        <h6 class="text-center">OPEN</h6>
                    </div>
                    <a href="{{ route('viewMoreChecked')}}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12 my-3">
                <div class="card-box bg-grey">
                    <div class="inner">
                        <h6 class="text-center"> SURAT JALAN </h6>
                        <p> Order (Pcs)</p>
                        <h3 id="summarySJ"> - </h3>
                        <h6 class="text-center">OPEN</h6>
                    </div>
                    <a href="{{ route('viewMoreSJ') }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 my-3">
                <div class="card-box bg-red">
                    <div class="inner">
                        <h6 class="text-center"> LOADING </h6>
                        <p>Order (Pcs)</p>
                        <h3 id="summaryLoading"> - </h3>
                        <h6 class="text-center">OPEN</h6>
                    </div>
                    <a href="{{ route('viewMoreSJ') }}?loading=true" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
