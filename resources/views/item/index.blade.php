@extends('template.master')

@section('pagetitle')
Items {!! link_to('/items/create', '+') !!} | {{ $all }}
@stop

@section('content')
	
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marketplace{{ config('node_image_hzise') }}</th>
                            
                            <th>Title</th>
                            <th>Category</th>
                            <th>City</th>
                            <th>Price</th>
                            <th>Category</th>
                            
                            <th></th>
                        </tr>
                    </thead>        
                    <tbody>

                        @foreach($items as $item)
                        <tr>    
				            <td>{{ $item->id }}</td>
                            <td>{{ $item->feed->marketplace->name }}</td>
                            
                            <td>
                                    {{ $item->title ? link_to('/items/'. $item->id, $item->title) : "Unscraped" }}
                            
                            </td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->seller->name }}-{{ $item->seller->city->name }}</td>
                            <td>{{ $item->sell_price }}</td>
                            <td>
                                <div class="inline-block">
                                {!! link_to('/items/'.$item->id.'/edit', 'Edit', ['class' => 'btn btn-default']) !!}
                                {!! Form::open(['route' => ['items.destroy', $item->id], 'method' => 'delete']) !!}
                                {!! Form::button('Hapus',['type' => 'submit', 'class' => 'btn btn-default']) !!}
                                {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>                
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="box-footer">
                
            </div>

        </div>
    </div>
</div>

@stop