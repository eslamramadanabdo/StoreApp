

<div class="card-body">

    <div class="form-group">
      <x-form.input label="Category Name" type="text" name="name"  :value="$category->name" id="name" placeholder="Enter Category Name" />
    </div>

    <div class="form-group">
      <label for="parentID">Category Parent</label>
      <select name="parent_id" class="form-control form-select @error('parent_id') is-invalid  @enderror" id="parentID" >
        <option value="">Primary Category</option>
        @foreach ($parents as $parent)
          <option value="{{ $parent->id }}"  @selected(old('parent_id', $category->parent_id) ==  $parent->id) >{{ $parent->name }}</option>
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
        label="Category Description" 
        name="description"
        :value="$category->description"
        id="descriptiond" 
        placeholder="Enter Category Description"
      />

    </div>

    <div class="form-group">
      <x-form.input label="Category Image" type="file" name="image" accept="image/*" />

      @if($category->image)
        <img class="m-2" src="{{ asset('storage/' . $category->image) }}" alt="" height="50" width="50">
      @endif
    </div>

    <div class="form-group">
      <x-form.label id="status">Category Status</x-form.label>
      <div>
        <x-form.radio name="status" :checked="$category->status" :options="['active'=>'Active' , 'archived' => 'Archived']" />
      </div>
    </div>
    
  </div>
  <!-- /.card-body -->
  <div class=" text-center mb-5">
    <button type="submit" class="btn btn-primary w-50">{{ $button_label ?? 'Save' }}</button>
  </div>