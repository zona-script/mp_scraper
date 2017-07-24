@extends('admin.template.master')

@section('pagetitle')
    Categories {!! link_to('/admin/categories/create', '+') !!}
@stop

@section('content')
	
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-body">
                <ul>
                @foreach($roots as $root)
                    <li>
                        {{ $root->name }} 
                        <div class="pull-right">
                            <i class="fa fa-{{ $root->icon }}"></i>
                            ({!! link_to('/admin/categories/'.$root->id.'/edit', 'Edit') !!})
                        </div>
                        
                    </li>    
                @endforeach
                </ul>    
            </div>   

            <div class="box-footer">
                
            </div>
        </div>
    </div>
</div>

@stop