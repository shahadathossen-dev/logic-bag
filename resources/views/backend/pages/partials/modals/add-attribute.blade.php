
<div class="modal-dialog modal-dialog-centered modal-dialog modal-lg" role="form">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline" style="margin-bottom: 0px !important;">
                        <div class="card-header">
                            <h3 class="card-title">Add Attribute</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="fa fa-minus-circle"></i></button>
                                <button type="button" class="btn btn-tool" data-dismiss="modal" aria-label="Close" title="Discard Attribute"><i class="fa fa-times-circle"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="attribute_form" method="POST" action="{{ route('admin.product.attribute.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="product_id" value="{{$product['id']}}">
                                        <input type="hidden" name="model" value="{{$product['model']}}">
                                        <input type="text" name="sku" class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}" value="{{ old("sku") }}" placeholder="SKU" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="stock" class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" value="{{ old("stock") }}" placeholder="Stock" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="text" name="color" class="form-control {{ $errors->has('color') ? 'is-invalid' : '' }}" value="{{ old("color") }}" placeholder="Color" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="meta_color" class="form-control {{ $errors->has('meta_color') ? 'is-invalid' : '' }}" value="{{ old("meta_color") }}" placeholder="Color" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                    
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="images[]" value="">
                                        <div id="dropZone" class="dropzone form-control {{ $errors->has('images') ? 'is-invalid' : '' }}">
                                            <div class="dz-message dz-default needsclick">
                                                <h3 class="sbold">Drop files here to upload</h3>
                                                <center>  <i class="far fa-images fa-4x" aria-hidden="true"></i></center>
                                                <span>You can also click to open file browser</span>
                                            </div>
                                            <button class="btn bg-light float-right start-upload"></button>
                                        </div>
                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>
                                <div class="form-group row mb-0 text-center">
                                    <div class="col-md-12">
                                        <input type="submit" name="submit" id="submit" value="Submit Product" class="btn btn-success">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>