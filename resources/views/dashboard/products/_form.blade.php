

<div class="card-body">

    <div class="form-group">
      <x-form.input label="Product Name" type="text" name="name"  :value="$product->name" id="name" placeholder="Enter Product Name" />
    </div>

    {{-- categories --}}
    <div class="form-group">
      <label for="category_id">Category</label>
      <select name="category_id" class="form-control form-select " id="category_id" >
        <option value="">Primary Category</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}"  @selected(old('category_id' , $product->category_id) ==  $category->id) >{{ $category->name }}</option>
        @endforeach
      </select>
        @error('parent_id')
            <div class="invalid-feedback">
            {{$message}}
            </div>
        @enderror
    </div>

    {{-- Stores --}}
    <div class="form-group">
      <label for="store_id">Stores</label>
      <select name="store_id" class="form-control form-select " id="store_id" >
        <option value="">Primary Store</option>
        @foreach ($stores as $store)
          <option value="{{ $store->id }}"  @selected(old('store_id' , $product->store_id) ==  $store->id) >{{ $store->name }}</option>
        @endforeach
      </select>
        @error('parent_id')
            <div class="invalid-feedback">
            {{$message}}
            </div>
        @enderror
    </div>

    <div class="form-group">
      <x-form.textarea 
        class="form-control"
        label="Product Description" 
        name="description"
        :value="$product->description"
        id="descriptiond" 
        placeholder="Enter Product Description"
      />

    </div>

    <div class="form-group">
      <x-form.input label="Product Image" type="file" name="image" accept="image/*" />

      @if($product->image)
        <img class="m-2" src="{{ asset('storage/' . $product->image) }}" alt="" height="50" width="50">
      @endif
    </div>

    <div class="form-group">
      <x-form.input label="Product Price" type="number" name="price"  :value="$product->price" id="price" placeholder="Enter product price" />
    </div>

    <div class="form-group">
      <x-form.input label="Product Compare Price" type="number" name="compare_price"  :value="$product->compare_price" id="compare_price" placeholder="Enter Product Compare Price" />
    </div>

    {{-- options --}}

    <div class="form-group">
      <x-form.input label="Product Rating" type="number" name="rating"  :value="$product->rating" id="rating" placeholder="Enter Product Rating" />
    </div>

    {{-- tags --}}
    <div class="form-group">
      <x-form.input label="Tags" type="text" name="tags" :value="$tags"   id="rating" placeholder="Enter Product Tags" />
    </div>

    <div class="form-group">
      <x-form.label id="status">Product Status</x-form.label>
      <div>
        <x-form.radio name="status" :checked="$product->status" :options="['active'=>'Active', 'draft' => 'Draft' , 'archived' => 'Archived']" />
      </div>
    </div>
    
  </div>
  <!-- /.card-body -->
  <div class=" text-center mb-5">
    <button type="submit" class="btn btn-primary w-50">{{ $button_label ?? 'Save' }}</button>
  </div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<script>
  var inputElem = document.querySelector( '[name=tags]' );
  var tagify = new Tagify(inputElem);
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush