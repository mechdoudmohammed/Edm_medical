@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Modifier livreur</h5>
    <div class="card-body">
      <form method="post" action="{{route('livreur.update',$livreur->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputnom" class="col-form-label">Nom <span class="text-danger">*</span></label>
        <input id="inputnom" type="text" name="nom" placeholder="Enter nom"  value="{{$livreur->nom}}" class="form-control" require>
        @error('nom')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
        <label for="inputprenom" class="col-form-label">Prenom <span class="text-danger">*</span></label>
        <input id="inputprenom" type="text" name="prenom" placeholder="Enter prenom"  value="{{$livreur->prenom}}" class="form-control" require>
        @error('prenom')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>


        <div class="form-group">
          <label for="inputtelephone" class="col-form-label">Telephone <span class="text-danger">*</span></label>
        <input id="inputtelephone" type="text" name="telephone" placeholder="Enter telephone"  value="{{$livreur->telephone}}" class="form-control" require>
        @error('telephone')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputemail" class="col-form-label">Email <span class="text-danger">*</span></label>
        <input id="inputemail" type="text" name="email" placeholder="Enter title"  value="{{$livreur->email}}" class="form-control" require>
        @error('email')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">

        <div class="form-group">
          <label for="inputMotdepasse" class="col-form-label">Mot de passe<span class="text-danger">*</span></label>
        <input id="inputMotdepasse" type="password" name="password" placeholder="Enter mot de passe"  value="{{$livreur->password}}" class="form-control">
        @error('password')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description" value="{{$livreur->description}}"></textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
  
        <div class="form-group">
          <label for="inputadresse" class="col-form-label">Adresse <span class="text-danger">*</span></label>
        <input id="inputadresse" type="text" name="adresse" placeholder="Enter adresse"  value="{{$livreur->adresse}}" class="form-control"require>
        @error('adresse')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputcin" class="col-form-label">Cin <span class="text-danger">*</span></label>
        <input id="inputcin" type="text" name="cin" placeholder="Enter cin"  value="{{$livreur->cin}}" class="form-control"require>
        @error('cin')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputnumero_permis" class="col-form-label">Numero permis <span class="text-danger">*</span></label>
        <input id="inputnumero_permis" type="text" name="numero_permis" placeholder="Enter numero de permis"  value="{{$livreur->numero_permis}}" class="form-control"require>
        @error('numero_permis')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
              {{-- {{$livreurs}} --}}

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
          <div class="input-group">
          <input id="thumbnail" class="form-control" type="file" name="photo" value="{{$livreur->photo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Statut <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Initialiser</button>
           <button class="btn btn-success" type="submit">Modifier</button>
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