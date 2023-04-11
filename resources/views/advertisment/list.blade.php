<table class="table table-responsive">
    <thead>
        <th>Name</th>
        <th>Distance</th>
    </thead>
    <tbody>
        @if(count($data)>0)
        @foreach($data as $key=>$val)
        <tr>
            <td>{{$val->name}}</td>
            <td>{{number_format($val->distance,2).' KM'}}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="">No Record Found</td>
        </tr>
        @endif
    </tbody>
</table>