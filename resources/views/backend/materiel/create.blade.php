@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Ajouter Materiel</h5>
    <div class="card-body">
    <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
      <form method="post" action="{{route('materiel.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputNom" class="col-form-label">Nom <span class="text-danger">*</span></label>
          <input id="inputNom" type="text" name="nom" placeholder="Entrer nom"  value="{{old('nom')}}" class="form-control">
          @error('nom')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Résumé <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

          <div class="form-group">
              <label for="location">Pour la location?</label><br>
       
              <input type="radio" name='location' value='1' id="choixb1" onclick="activer()" > Oui<br>
              <input type="radio" name='location' value='0' id="choixb2" onclick="desactive()"  checked="checked"> Non<br>
              <script  type="text/javascript">
              function desactive()  {
                  if(document.getElementById('choixb2').checked )  {
        document.getElementById('inputprixlocation').disabled=true;
                  }
                }
                function activer()  {
                  if(document.getElementById('choixb1').checked )  {
        document.getElementById('inputprixlocation').disabled=false;
                  }
                }
              </script>
              @error('location')
          <span class="text-danger">{{$message}}</span>
          @enderror
              <div class="form-group">
          <label for="inputprixlocation" class="col-form-label">prix de location <span class="text-danger">*</span></label>
          <input id="inputprixlocation" type="text" name="prix_location" placeholder="Entrer le prix" disabled value="{{old('prix_location')}}" class="form-control">
         
       
        </div>
          </div>

        <div class="form-group">
          <label for="is_featured">Le materiel est présenté dans le stock?</label><br>
          <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes
        </div>
              {{-- {{$categories}} --}}

        <div class="form-group">
          <label for="cat_id">Categorie <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Selectionner categorie--</option>
              @foreach($categories as $key=>$cat_data)
                  <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group d-none" id="child_cat_div">
          <label for="child_cat_id">Sous Categorie</label>
          <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">--Selectionner sous-categorie--</option>
              {{-- @foreach($parent_cats as $key=>$parent_cat)
                  <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
              @endforeach --}}
          </select>
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Prix <span class="text-danger">*</span></label>
          <input id="price" type="number" name="price" placeholder="Entrer prix"  value="{{old('price')}}" class="form-control">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="discount" class="col-form-label">Remise(%)</label>
          <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Entrer Remise"  value="{{old('discount')}}" class="form-control">
          @error('discount')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
    

        <div class="form-group">
          <label for="fournisseur_id">Fournisseur</label>
          {{-- {{$fournisseurs}} --}}

          <select name="fournisseur_id" class="form-control">
              <option value="">--Sélectionner Fournisseur--</option>
             @foreach($fournisseurs as $fournisseur)
              <option value="{{$fournisseur->id}}">{{$fournisseur->nom}}</option>
             @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="condition">État </label>
          <select name="condition" class="form-control">
              <option value="">--Sélectionner l'État  --</option>
              <option value="default">Défaut</option>
              <option value="new">Nouveau</option>
              <option value="hot">Offre spéciale</option>
          </select>
        </div>

        <div class="form-group">
          <label for="stock">Quantité <span class="text-danger">*</span></label>
          <input id="quantity" type="number" name="stock" min="0" placeholder="Entrer Quantité"  value="{{old('stock')}}" class="form-control">
          @error('stock')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo: <span class="text-danger">*</span></label>
          <div class="input-group">
          <input id="thumbnail" class="form-control" type="file" name="photo" value="{{old('photo')}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputfiche_technique" class="col-form-label">Fiche_technique:</label>
          <div class="input-group">
          <input id="thumbnail" class="form-control" type="file" name="fiche_technique" value="{{old('fiche_technique')}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('fiche_technique')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Statut <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Activer</option>
              <option value="inactive">Desactiver</option>
          </select>
          @error('status')
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Ecrire une petite description.....",
          tabsize: 2,
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Ecrire le detail de description.....",
          tabsize: 2,
          height: 150
      });
    });
    // $('select').selectpicker();

</script>

<script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/categorie/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Selectionner le sous categoriee----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script>
@endpush
