@extends('layouts.app')

@section('title', $page->title() ?? $page->name())
@section('title', $page->description())

@section('content')

  <div class="bread">{{$page->name()}}</div>
  @if (!Auth::guest() && Auth::user()->isAdmin())
    <button type=button class="btn btn-round btn-red" data-toggle="redmodal" data-url="edit?model=Page&modelId={{$page->id}}">
      <i class="fa fa-edit"></i><span class="sr-only">Edit page</span>
    </button>
  @endif
  <div class="clearfix"></div>

  @if ($page->id === 1)
    <div class="row">
      <div class="col-md-6">
        @foreach ($page->pageBlocks as $i => $pageBlock)
          <div data-block-id="{{$pageBlock->id}}" data-model="{{$pageBlock->shortType()}}" data-model-id="{{$pageBlock->block_id}}">
            @include($pageBlock->view, ['pageBlock' => $pageBlock, 'block' => $pageBlock->block])
          </div>
          @if ($i==1)
            </div><div class="col-md-6">
          @endif
        @endforeach
      </div>
    </div>
  @else
    @foreach ($page->pageBlocks as $pageBlock)
      <div data-block-id="{{$pageBlock->id}}" data-model="{{$pageBlock->shortType()}}" data-model-id="{{$pageBlock->block_id}}">
        @include($pageBlock->view, ['pageBlock' => $pageBlock, 'block' => $pageBlock->block])
      </div>
    @endforeach
  @endif

  @include('admin.menu-addblock')

@endsection
