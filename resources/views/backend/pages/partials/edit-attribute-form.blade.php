<form id="edit_attribute_form" method="POST" action="{{ route('admin.product.attribute.update') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <div class="col-md-6">
            <input type="hidden" name="id" value="{{$attribute->id}}">
            <input type="hidden" name="product_id" value="{{$attribute->product->id}}">
            <input type="hidden" name="model" value="{{$attribute->product->model}}">
            <input type="text" name="sku" class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}" value="{{ $attribute->sku }}" placeholder="SKU" readonly>

            <span class="invalid-feedback" role="alert"></span>
        </div>
        <div class="col-md-6">
            <input type="text" name="stock" class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" value="{{ $attribute->stock }}" placeholder="Stock" required>

            <span class="invalid-feedback" role="alert"></span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <input type="text" name="color" class="form-control {{ $errors->has('color') ? 'is-invalid' : '' }}" value="{{ $attribute->color }}" placeholder="Color" required>

            <span class="invalid-feedback" role="alert"></span>
        </div>

        <div class="col-md-6">
            <input type="text" name="meta_color" class="form-control {{ $errors->has('meta_color') ? 'is-invalid' : '' }}" value="{{ $attribute->meta_color }}" placeholder="Color" required>
            
            <span class="invalid-feedback" role="alert"></span>
        </div> 
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <input type="hidden" name="images[]" value="">
            <div id="editAttributeDropZone" class="dropzone uploadZone form-control {{ $errors->has('images') ? 'is-invalid' : '' }}">
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