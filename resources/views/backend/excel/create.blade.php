@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Ajouter Model Excel</h5>
    <div class="card-body">
    <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
      <form method="post" action="{{route('excel.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Titre <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="titre" placeholder="Entrer titre"  value="{{old('titre')}}" class="form-control">
        @error('titre')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Fichier<span class="text-danger">*</span></label>
        <input id="price" type="file" name="fichier"  value="{{old('ficheir')}}" class="form-control">
        @error('fichier')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Initialiser</button>
           <button class="btn btn-success" type="submit">Ajouter</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Rédigez une brève description .....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush