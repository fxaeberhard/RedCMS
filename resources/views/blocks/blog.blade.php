<div class="blog">

  @if (!Auth::guest() && Auth::user()->isAdmin())
    <button class="btn btn-default btn-red" data-toggle="redmodal" data-url='add?model=BlogPost&data={"blog_id":{{$block->id}}}'>
      <i class="fa fa-file-text-o"></i> Ajouter une nouvelle
    </button>
  @endif

  @foreach ($block->posts as $post)
    <div class="panel panel-default post feed" data-model-id="{{$post->id}}" data-model="BlogPost">
      <div class="panel-heading">
        <i class="fa fa-calendar fa-2x" aria-hidden="true"></i>
        <h3>{{$post->title}}</h3>
        <span class="sub">{{$post->user->name()}} le {{formatDate($post->created_at)}}</span>
      </div>
      <div class="panel-body">
        {!! $post->text !!}
      </div>

      @if (!$post->comments->isEmpty())
        <div class="panel-body">
          @foreach ($post->comments as $comment)
            <div class="panel panel-default margin-0" data-model-id="{{$comment->id}}" data-model="BlogComment">
              <div class="panel-heading">
                <span class="sub">{{$comment->user->name()}} le {{formatDate($post->created_at)}}</span>
              </div>
              <div class="panel-body">
                {!! $comment->text !!}
              </div>
            </div>
          @endforeach
        </div>
      @endif

      @if (!Auth::guest() && Auth::user()->isAdmin())
        <div class="panel-body">
          <a href="#" data-toggle="redmodal" data-url='add?model=BlogComment&data={"blog_post_id":{{$post->id}}}'>
            Comment
          </a>
        </div>
      @endif

    </div>
  @endforeach
</div>

@push('head')
@endpush

@push('scripts')
@endpush
