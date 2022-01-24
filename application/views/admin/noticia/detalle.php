<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Vertical Tab</h4>
                <h6 class="card-subtitle">Use default tab with class <code>vtabs & tabs-vertical</code></h6>
                <!-- Nav tabs -->
                <div class="vtabs">
                    {{imagenes}}
                <img  v-if=" imagenes != ''" v-bind:src="url_image + imagenes[0].nombreimagen" class="img-responsive  product" alt="Responsive image" width="20%">
                                               
                </div>
            </div>
        </div>
    </div>
</div>