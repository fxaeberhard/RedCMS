
{!! Form::hidden('_class', $model->getClassName()) !!}
{{-- {!! Form::hidden('pageBlock.view', $model->pageBlock->view ?? null) !!}
{!! Form::hidden('pageBlock.admin_view', $model->pageBlock->admin_view ?? null) !!}--}}
{!! Form::hidden('pageBlock.page_id', $model->pageBlock->page_id ?? null) !!}

<div class="form-group debug">
  {!! Form::text('pageBlock.view', $model->pageBlock->view ?? null, ['class' => 'form-control', 'id' => 'pageBlock.view']) !!}
  {!! Form::label('pageBlock.view', 'View', ['class' => 'control-label']) !!}
</div>

<div class="form-group debug">
  {!! Form::text('pageBlock.admin_view', $model->pageBlock->admin_view ?? null, ['class' => 'form-control', 'id' => 'pageBlock.admin_view']) !!}
  {!! Form::label('pageBlock.admin_view', 'Admin view', ['class' => 'control-label']) !!}
</div>

<div class="form-group debug">
  {!! Form::text('pageBlock.position', $model->pageBlock->position ?? null, ['class' => 'form-control', 'id' => 'pageBlock.position']) !!}
  {!! Form::label('pageBlock.position', 'Position', ['class' => 'control-label']) !!}
</div>
