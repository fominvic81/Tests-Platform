
@foreach ($errors->all() as $error)
    <div class="text-red-500">{{ $error }}</div>
@endforeach