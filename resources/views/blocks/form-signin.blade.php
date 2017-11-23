<!-- {-- {!! Form::model($model, ['url' => 'User/'.$model->id, 'class' => 'form-horiznontal', 'data-submit' => $model->id ?'put': 'post']) !!} --} -->
<form method="post" action="User/">
  <fieldset>

    <div class="form-group">
      <input name="firstname" id="firstname" value="{{$model->firstname}}" class="form-control" placeholder=" "/>
      <label for="firstname">Prénom</label>
    </div>
    <div class="form-group">
      <input name="lastname" id="lastname" value="{{$model->lastname}}" class="form-control" placeholder=" "/>
      <label for="lastname">Nom de famille</label>
    </div>

    <div class="form-group">
      <input name="company" id="company" value="{{$model->company}}" class="form-control" placeholder=" "/>
      <label for="company">Établissement</label>
    </div>

    <div class="form-group">
      <input type="email" name="email" id="email" required class="form-control" placeholder=" "/>
      <label for="email">Email</label>
    </div>
    <div class="form-group">
      <input type="password" name="password" id="password" class="form-control" placeholder=" "/>
      <label for="password">Mot de passe</label>
      <!-- <span class="help-block">Leave blank to keep previous password</span> -->
    </div>
    <div class="form-group">
      <input name="phone" id="phone" value="{{$model->phone}}" class="form-control" placeholder=" "/>
      <label for="phone">Téléphone privé</label>
    </div>
    <div class="form-group">
      <input name="phonepro" id="phonepro" value="{{$model->phonepro}}" class="form-control" placeholder=" "/>
      <label for="phonepro">Téléphone professionnel</label>
    </div>
    <div class="form-group">
      <input name="mobile" id="mobile" value="{{$model->mobile}}" class="form-control" placeholder=" "/>
      <label for="mobile">Téléphone mobile</label>
    </div>

    <div class="form-group">
      <input name="adress" id="adress" value="{{$model->adress}}" class="form-control" placeholder=" "/>
      <label for="adress">Adress privéé</label>
    </div>
    <div class="row">
      <div class="form-group col-sm-2">
        <input name="adress_zip" id="adress_zip" value="{{$model->adress_zip}}" class="form-control" placeholder=" "/>
        <label for="adress_zip">Zip</label>
      </div>
      <div class="form-group col-sm-10">
        <input name="adress_city" id="adress_city" value="{{$model->adress_city}}" class="form-control" placeholder=" "/>
        <label for="adress_city">Ville</label>
      </div>
    </div>
    <div class="form-group">
      @include('partials.countries', ['name' => 'adress_country', 'value' => $model->adress_country])
      <label for="adress_country">Pays</label>
    </div>

    <div class="form-group">
      <input name="adresspro" id="adresspro" value="{{$model->adresspro}}" class="form-control" placeholder=" "/>
      <label for="adresspro">Adress privéé</label>
    </div>
    <div class="row">
      <div class="form-group col-sm-2">
        <input name="adresspro_zip" id="adresspro_zip" value="{{$model->adresspro_zip}}" class="form-control" placeholder=" "/>
        <label for="adresspro_zip">Zip</label>
      </div>
      <div class="form-group col-sm-10">
        <input name="adresspro_city" id="adresspro_city" value="{{$model->adresspro_city}}" class="form-control" placeholder=" "/>
        <label for="adresspro_city">Ville</label>
      </div>
    </div>
    <div class="form-group">
      @include('partials.countries', ['name' => 'adresspro_country', 'value' => $model->adresspro_country])
      <label for="adresspro_country">Pays</label>
    </div>

    @include('admin.buttons')

  </fieldset>

{!! Form::close()  !!}
