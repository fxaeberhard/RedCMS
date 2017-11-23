<form action="{{url('/mailinglist')}}" method="POST" data-submit data-success-msg="Votre message a été envoyée.">

  <input type="hidden" name="_subject" value="Formulaire de contact">
  <input type="hidden" name="_target" value="{{$block->target}}">

  <div class="form-group">
    <input type="email" class="form-control" name="from" id="from">
    <label for="from" class="control-label col-md-3">Votre email (optionnel)</label>
    <div class="help-block with-errors"></div>
  </div>

  <div class="form-group">
    <textarea class="form-control autosize" name="message" id="message" required  rows=1></textarea>
    <label for="message" class="control-label col-md-3">Message</label>
    <div class="help-block with-errors"></div>
  </div>

  <div class="text-center">
    <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-paper-plane"></i> Envoyer</button>
  </div>

</form>
