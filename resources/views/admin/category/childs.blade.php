<ul>
@foreach($childs as $child)
	<li>
	    {{ $child->id }}. {{ $child->name }} 
	    <div class="pull-right">
		    
		   		(<a href ="/items/ct/{{$child->id}}">{{ App\Item::whereCategory_id($child->id)->get()->count() }} item</a>)
		   	

		    ({!! link_to('/categories/'.$child->id.'/edit', 'Edit') !!})
	    </div>
	    
		@if(count($child->child))
        	@include('category.childs',['childs' => $child->child])
        @endif
	</li>
@endforeach
</ul>