<?php $model = new App\User; ?>

<form action="User/signin" data-submit="post" data-success-msg="Votre demande d'adhésion a été enregistrée, nous prendrons bientôt contact avec vous.">

  <fieldset>

    {{ csrf_field() }}

    @include('admin.user-fields', ['showGroups' => false])

    <p>Cotisation annuelle : CHF 200.-</p>

    <!-- Submit Button -->
    <div class="text-center">
      {!! Form::submit('S\'inscrire', ['class' => 'btn btn-lg btn-red btn-primary']) !!}
    </div>

  </fieldset>

</form>
