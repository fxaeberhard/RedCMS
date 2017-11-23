<!-- Submit Button -->
<div class="text-center">
  <div class="btn-group">
    {!! Form::submit(isset($label) ? $label : 'Save', ['class' => 'btn btn-lg btn-red']) !!}
    <button type="reset" class="btn btn-default btn-lg" data-dismiss="modal">Cancel</button>
  </div>
</div>
