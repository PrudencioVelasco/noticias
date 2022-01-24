<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Vertical Tab</h4>
                <h6 class="card-subtitle">Use default tab with class <code>vtabs & tabs-vertical</code></h6>
                <!-- Nav tabs -->
                <div class="vtabs">
                    <ul class="nav nav-tabs tabs-vertical" role="tablist">
                        <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#home4" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Detalle</span> </a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile4" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Comentarios</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages4" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Messages</span></a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane " id="home4" role="tabpanel">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" role="listbox">
                                        <div class="carousel-item active"> <img class="img-responsive" src="<?php echo base_url(); ?>/assets/backend/images/big/img4.jpg" alt="First slide"> </div>
                                        <div class="carousel-item"> <img class="img-responsive" src="<?php echo base_url(); ?>/assets/backend/images/big/img5.jpg" alt="Second slide"> </div>
                                        <div class="carousel-item"> <img class="img-responsive" src="<?php echo base_url(); ?>/assets/backend/images/big/img6.jpg" alt="Third slide"> </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                                </div>
                        </div>
                        <div class="tab-pane p-20" id="profile4" role="tabpanel">2</div>
                        <div class="tab-pane p-20" id="messages4" role="tabpanel">3</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>