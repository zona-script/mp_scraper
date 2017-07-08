<div class="box-body">
	<div class="form-group">
		{!! Form::label('name', 'Category Name',['class'=>'control-label']) !!}
		{!! Form::text('name', null, ['class' => 'form-control']) !!}
		@if ($errors->has('name'))
		    <div class="label label-danger">
		        {{ $errors->first('name') }}
		    </div>
		@endif
	</div>

	<div class="form-group">
		{!! Form::label('icon', 'Icon',['class'=>'control-label']) !!}
		{!! Form::text('icon', null, ['class' => 'form-control']) !!}
		@if ($errors->has('icon'))
		    <div class="label label-danger">
		        {{ $errors->first('icon') }}
		    </div>
		@endif
	</div>
	
</div>

<div class="box-footer">
	<div class="form-group">
		{!! Form::submit('Simpan',  ['class' => 'btn btn-primary']) !!}
	</div>
</div>	