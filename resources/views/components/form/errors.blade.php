
@foreach ($errors->all() as $error)
    <div class="text-red-500 col-span-full">{{ $error }}</div>
@endforeach