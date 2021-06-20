@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Editer le materiel</h5>
    <div class="card-body">
    <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
      <form method="post" action="{{route('materiel.update',$materiel->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="price" class="col-form-label">Nom<span class="text-danger">*</span></label>
          <input id="price" type="text" name="nom" placeholder="Enter Nom"  value="{{$materiel->nom}}" class="form-control">
          @error('nom')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Resumé <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{$materiel->summary}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{$materiel->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
              <label for="location">Pour la location?</label><br>
              <input type="radio" name='location' value='1' id="choixb1" onclick="activer()"  
              <?php 
              if($materiel->Location==1){
        echo"checked=\"checked\"";
              }?> > Oui<br>
              <input type="radio" name='location' value='0' id="choixb2" onclick="desactive()" <?php 
              if($materiel->Location==0){
        echo"checked=\"checked\"";
        
              }?>  > Non

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
   
          <input id="inputprixlocation" type="text" name="prix_location" placeholder="Enter le prix"  value="{{$materiel->prix_location}}" class="form-control"       <?php
          if($materiel->Location==0){
            echo"disabled";
          }
          ?>>
        </div>

        <div class="form-group">
          <label for="cat_id">Categorie <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Selectionner categorie--</option>
              @foreach($categories as $key=>$cat_data)
                  <option value='{{$cat_data->id}}' {{(($materiel->cat_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->title}}</option>
              @endforeach
          </select>
        </div>
        @php 
          $sub_cat_info=DB::table('categories')->select('title')->where('id',$materiel->child_cat_id)->get();
        // dd($sub_cat_info);

        @endphp
        {{-- {{$materiel->child_cat_id}} --}}
        <div class="form-group {{(($materiel->child_cat_id)? '' : 'd-none')}}" id="child_cat_div">
          <label for="child_cat_id">Sous Ctegorie</label>
          <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">--Selectionner categorie--</option>
              
          </select>
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Prix<span class="text-danger">*</span></label>
          <input id="price" type="number" name="price" placeholder="Entrer prix"  value="{{$materiel->price}}" class="form-control">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="discount" class="col-form-label">Réduction(%)</label>
          <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount"  value="{{$materiel->discount}}" class="form-control">
          @error('discount')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="fournisseur_id">Fournisseur</label>
          <select name="fournisseur_id" class="form-control">
              <option value="">--Selectionner--</option>
             @foreach($fournisseurs as $fournisseur)
              <option value="{{$fournisseur->id}}" {{(($materiel->fournisseur_id==$fournisseur->id)? 'selected':'')}}>{{$fournisseur->nom}}</option>
             @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="condition">Condition</label>
          <select name="condition" class="form-control">
              <option value="">--Selectionner condition--</option>
              <option value="default" {{(($materiel->condition=='default')? 'selected':'')}}>Default</option>
              <option value="new" {{(($materiel->condition=='new')? 'selected':'')}}>Nouveau</option>
              <option value="hot" {{(($materiel->condition=='hot')? 'selected':'')}}>passionné</option>
          </select>
        </div>

        <div class="form-group">
          <label for="stock">Quantité <span class="text-danger">*</span></label>
          <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity"  value="{{$materiel->stock}}" class="form-control">
          @error('stock')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
          <div class="input-group">
          <input id="thumbnail" class="form-control" type="file" name="photo" value="{{$materiel->photo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputfiche_technique" class="col-form-label">Fiche_technique:<span class="text-danger">*</span></label>
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
            <option value="active" {{(($materiel->status=='active')? 'selected' : '')}}>Activer</option>
            <option value="inactive" {{(($materiel->status=='inactive')? 'selected' : '')}}>Desactiver</option>
        </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Modifier</button>
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
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail Description.....",
          tabsize: 2,
          height: 150
      });
    });
</script>

<script>
  var  child_cat_id='{{$materiel->child_cat_id}}';
        // alert(child_cat_id);
        $('#cat_id').change(function(){
            var cat_id=$(this).val();

            if(cat_id !=null){
                // ajax call
                $.ajax({
                    url:"/admin/categorie/"+cat_id+"/child",
                    type:"POST",
                    data:{
                        _token:"{{csrf_token()}}"
                    },
                    success:function(response){
                        if(typeof(response)!='object'){
                            response=$.parseJSON(response);
                        }
                        var html_option="<option value=''>--Select any one--</option>";
                        if(response.status){
                            var data=response.data;
                            if(response.data){
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data,function(id,title){
                                    html_option += "<option value='"+id+"' "+(child_cat_id==id ? 'selected ' : '')+">"+title+"</option>";
                                });
                            }
                            else{
                                console.log('no response data');
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

        });
        if(child_cat_id!=null){
            $('#cat_id').change();
        }
</script>
@endpush