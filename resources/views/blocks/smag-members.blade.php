<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <?php

    $comitee = App\Group::find(2);
    $members = App\Group::find(3);
    $oldmembers = App\Group::find(4);
    $users = App\User::with('groups')->orderBy('lastname')->get()
      ->reject(function($u) use ($comitee, $members, $oldmembers) {
        return !$u->groups->contains($comitee) && !$u->groups->contains($members) && !$u->groups->contains($oldmembers);
      })->all();

    usort($users, function($a, $b) use ($comitee, $members, $oldmembers) {
      if ($a->groups->contains($comitee) && !$b->groups->contains($comitee)) return -1;
      if (!$a->groups->contains($comitee) && $b->groups->contains($comitee)) return 1;
      if ($a->groups->contains($members) && !$b->groups->contains($members)) return -1;
      if (!$a->groups->contains($members) && $b->groups->contains($members)) return 1;
      if ($a->groups->contains($oldmembers) && !$b->groups->contains($oldmembers)) return -1;
      if (!$a->groups->contains($oldmembers) && $b->groups->contains($oldmembers)) return 1;
      return strcmp($a->lastname, $b->lastname);
    })
  ?>
  @foreach ($users as $i => $user)
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="heading{{$i}}">
        <h4 class="panel-title">
          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
            <div class="row">
              <div class="col-sm-4">
                {{$user->firstname}} {{$user->lastname}}
              </div>
              <div class="col-sm-5 text-muted">
                {{$user->company}}
              </div>
              <div class="col-sm-3 text-muted">
                <?php
                  $groups = [];
                  if ($user->groups->contains($comitee)) $groups[] = $comitee->name;
                  else if ($user->groups->contains($members)) $groups[] = $members->name;
                  else if ($user->groups->contains($oldmembers)) $groups[] = $oldmembers->name;
                  echo implode($groups);
                 ?>
              </div>
            </div>
          </a>
        </h4>
      </div>
      <div id="collapse{{$i}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$i}}">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-2 text-center">
              <img src="//www.gravatar.com/avatar/{{md5(strtolower($user->email))}}?s=100&default=mm" class="round"/>
            </div>
            <div class="col-sm-5">
              <strong>{{$user->firstname}} {{$user->lastname}}</strong>
              <p>{{$user->company}}</p>
              <a href="mailto:{{$user->email}}">{{$user->email}}</a><br />
            </div>
            <div class="col-sm-5">
              @if ($user->phone)<p>Tél.: {{$user->phone}}</p>@endif
              @if ($user->phonepro)<p>Tél pro.: {{$user->phonepro}}</p>@endif
              @if ($user->mobile)<p>Mobile: {{$user->mobile}}</p>@endif
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5 col-sm-offset-2">
              @if ($user->adress)
                <h4 class="margin-bottom-0">Adresse privée</h4>
                <p>
                  {{$user->adress}}<br />
                  {{$user->adress_zip}} {{$user->adress_city}}
                </p><br />
              @endif
            </div>
            <div class="col-sm-5">
              @if ($user->adresspro)
                <h4 class="margin-bottom-0">Adresse professionnelle</h4>
                <p>
                  {{$user->adresspro}}<br />
                  {{$user->adresspro_zip}} {{$user->adresspro_city}}
                </p>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">

            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
