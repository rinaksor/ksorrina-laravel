<h2>Demo view Unicode</h2>
@if(session('mess'))
    <div class="alert alert-success">
        {{ session('mess')}}
    </div>
@endif
<form action="" method="post">
    <input type="text" name="username" placeholder="Username..." value="{{old('username')}}"/>
    <button type="submit">Submit</button>
    @csrf
</form>