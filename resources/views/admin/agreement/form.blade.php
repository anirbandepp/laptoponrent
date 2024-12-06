{{-- <h3>Hit to create Agreement</h3>
<ul>
    <li></li>
</ul> --}}
@csrf
<div class="form-group mt-3">
    <label for="name">Agreement Name</label>
    <input type="text" name="name" id="name" value="{{ old('name') ?? $agreement->name }}"
        class="form-control @error('name') is-invalid @enderror" placeholder="Enter agreement name">
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <label for="content">Agreement Content</label>
    <textarea class="form-control @error('content') is-invalid @enderror" placeholder="Enter agreement content" name="content"
        id="content" rows="12">{{ old('content') ?? $agreement->content }}</textarea>
    @error('content')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@section('js')
<script>
  CKEDITOR.replace( 'content' );
</script>

    
@endsection
