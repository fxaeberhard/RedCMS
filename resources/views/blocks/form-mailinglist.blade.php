<form class="form-horizontal" data-submit="mailinglist">
  <input type="hidden" name="_subject" value="Nouvelle inscription">
  <input type="hidden" name="_target" value="{{$block->target}}">

  <div class="row">
    <div class="col-sm-6">
      <!-- <div class="form-group"> -->
        <!-- <label for="email" class="control-label col-md-3">E-mail</label> -->
        <!-- <div class="col-md-9"> -->
          <input type="email" class="form-control" name="email" placeholder="@lang('app.mailing_email')" required>
          <!-- <span class="floating-label">Your email</span> -->
        <!-- </div> -->
      <!-- </div> -->
    </div>

    <div class="col-sm-6">
      <!-- <div class="form-group"> -->
        <!-- <label for="location" class="control-label col-md-3">@lang("app.mailinglocation")</label> -->
        <!-- <div class="col-md-9"> -->
          <input type="text" class="form-control" name="location" placeholder="@lang('app.mailing_location')">
          <!-- <span class="floating-label">Your location (optional)</span> -->
        <!-- </div> -->
      <!-- </div> -->
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
      <!-- <div class="form-group"> -->
        <!-- <label for="email" class="control-label col-md-3">E-mail</label> -->
        <!-- <div class="col-md-9"> -->
          <input type="text" class="form-control" name="firstname" placeholder="@lang('app.mailing_firstname')">
          <!-- <span class="floating-label">Your first name (optional)</span> -->
        <!-- </div> -->
      <!-- </div> -->
    </div>

    <div class="col-sm-6">
      <!-- <div class="form-group"> -->
        <!-- <label for="location" class="control-label col-md-3">@lang("app.mailinglocation")</label> -->
        <!-- <div class="col-md-9"> -->
          <input type="text" class="form-control" name="lastname" placeholder="@lang('app.mailing_lastname')">
          <!-- <span class="floating-label">Your last name (optional)</span> -->
        <!-- </div> -->
      <!-- </div> -->
    </div>
  </div>


  <div class="text-center">
    <button type="submit" class="btn btn-default btn-lg"><i class="fa fa-paper-plane"></i> @lang('app.mailing_button')</button>
  </div>

  <div class="done">You have been successfully added.</div>
</form>
