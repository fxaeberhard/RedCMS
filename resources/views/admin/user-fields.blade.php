<div class="row">
  <div class="form-group col-md-6">
    <input name="firstname" id="firstname" value="{{$model->firstname}}" class="form-control" required/>
    <label for="firstname">@lang('auth.firstname')</label>
    <div class="help-block with-errors"></div>
  </div>
  <div class="form-group col-md-6">
    <input name="lastname" id="lastname" value="{{$model->lastname}}" class="form-control" required/>
    <label for="lastname">@lang('auth.lastname')</label>
    <div class="help-block with-errors"></div>
  </div>
</div>
<div class="clearfix"></div>

<div class="form-group">
  <input type="email" name="email" id="email" value="{{$model->email}}" required class="form-control"/>
  <label for="email">@lang('auth.email')</label>
  <div class="help-block with-errors"></div>
</div>

@if ((isset($showGroups) ? $showGroups : true) && Auth::check() && Auth::user()->isAdmin())
  <div class="form-group">
    <div>
      <?php $groups = array_map(create_function('$o', 'return $o["id"];'), $model->groups->toArray()) ?>
      @foreach (App\Group::all() as $g)
      <div class="checkbox inline-block margin-right-2 margin-bottom-0">
       <label>
         <input type="checkbox" name="groups[{{$g->id}}]" @if (in_array($g->id, $groups)) checked @endif> {{$g->name}}
       </label>
     </div>
      @endforeach
    </div>
    <label>@lang('auth.groups')</label>
  </div>
@endif

<div class="form-group">
  <input name="company" id="company" value="{{$model->company}}" class="form-control"/>
  <label for="company">@lang('auth.company')</label>
  <div class="help-block with-errors"></div>
</div>

<div class="form-group">
  <input type="password" name="password" id="password" value="" class="form-control"/>
  <label for="password">@lang('auth.password')</label>
  @if ($model->id)
    <span class="help-block">@lang('auth.password_info')</span>
  @endif
  <div class="help-block with-errors"></div>
</div>

<div class="form-group">
  <input name="phone" id="phone" value="{{$model->phone}}" class="form-control"/>
  <label for="phone">@lang('auth.phone')</label>
  <div class="help-block with-errors"></div>
</div>
<div class="form-group">
  <input name="phonepro" id="phonepro" value="{{$model->phonepro}}" class="form-control"/>
  <label for="phonepro">@lang('auth.phonepro')</label>
  <div class="help-block with-errors"></div>
</div>
<div class="form-group">
  <input name="mobile" id="mobile" value="{{$model->mobile}}" class="form-control"/>
  <label for="mobile">@lang('auth.mobile')</label>
  <div class="help-block with-errors"></div>
</div>

<h5 class="margin-top-3 text-primary">@lang('auth.adress')</h5>
<div class="form-group">
  <input name="adress" id="adress" value="{{$model->adress}}" class="form-control"/>
  <label for="adress">@lang('auth.street')</label>
  <div class="help-block with-errors"></div>
</div>
<div class="row">
  <div class="form-group col-sm-2">
    <input name="adress_zip" id="adress_zip" value="{{$model->adress_zip}}" class="form-control"/>
    <label for="adress_zip">@lang('auth.zip')</label>
    <div class="help-block with-errors"></div>
  </div>
  <div class="form-group col-sm-10">
    <input name="adress_city" id="adress_city" value="{{$model->adress_city}}" class="form-control"/>
    <label for="adress_city">@lang('auth.city')</label>
    <div class="help-block with-errors"></div>
  </div>
</div>
<div class="form-group">
  <!-- <input name="adress" value="{{$model->adress}}" class="form-control"/> -->
  @include('partials.countries', ['name' => 'adress_country', 'value' => $model->adress_country])
  <label for="adress_country">@lang('auth.country')</label>
</div>

<h5 class="margin-top-3 text-primary">@lang('auth.adresspro')</h5>
<div class="form-group">
  <input name="adresspro" id="adresspro" value="{{$model->adresspro}}" class="form-control"/>
  <label for="adresspro">@lang('auth.street')</label>
  <div class="help-block with-errors"></div>
</div>
<div class="row">
  <div class="form-group col-sm-2">
    <input name="adresspro_zip" id="adresspro_zip" value="{{$model->adresspro_zip}}" class="form-control"/>
    <label for="adresspro_zip">@lang('auth.zip')</label>
    <div class="help-block with-errors"></div>
  </div>
  <div class="form-group col-sm-10">
    <input name="adresspro_city" id="adresspro_city" value="{{$model->adresspro_city}}" class="form-control"/>
    <label for="adresspro_city">@lang('auth.city')</label>
    <div class="help-block with-errors"></div>
  </div>
</div>
<div class="form-group">
  @include('partials.countries', ['name' => 'adresspro_country', 'value' => $model->adresspro_country])
  <label for="adresspro_country">@lang('auth.country')</label>
  <div class="help-block with-errors"></div>
</div>

<h5 class="margin-top-3 text-primary">Parrains</h5>
<div class="form-group">
  <input name="sponsor1" id="sponsor1" class="form-control"/>
  <label for="sponsor1">Nom 1</label>
  <div class="help-block with-errors"></div>
</div>
<div class="form-group">
  <input name="sponsor2" id="sponsor2" class="form-control"/>
  <label for="sponsor2">Nom 2</label>
  <div class="help-block with-errors"></div>
</div>
