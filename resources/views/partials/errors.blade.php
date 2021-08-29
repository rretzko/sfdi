@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors as $error)
            <li>{{count($errors)}}</li>
        @endforeach
    </ul>
</div>
@endif 
