@props(['question', 'answer'])

<div class="grid gap-2">
    @foreach ($question->data['options'] as $option)        
        <div class="flex items-center" key={ option.id }>
            <div class="mr-1 pr-1 font-bold border-r-4">{{ chr(65 + $loop->index) }}</div>
            @isset($option['image'])
                <x-common.image :src="App\Helpers\ImageHelper::url($option['image'])"></x-common.image>
            @endisset
            <div class="ml-1 my-2">{!! clean($option['text']) !!}</div>
        </div>
    @endforeach
    <table class="w-fit text-left">
        <tbody>
            <tr>
                <th>Правильна відповідь:</th>
                @foreach ($question->data['answer']['sequence'] as $index)
                    <td><div class="w-7 h-7 flex items-center justify-center font-semibold mx-1 border-2 rounded-full">{{ chr(65 + $index) }}</div></td>
                @endforeach
            </tr>
            @isset ($answer)
                <tr>
                    <th>Ваша відповідь:</th>
                    @foreach ($answer->data['sequence'] as $index)
                        <td><div class="w-7 h-7 flex items-center justify-center font-semibold mx-1 border-2 rounded-full">{{ chr(65 + $index) }}</div></td>
                    @endforeach
                </tr>
            @endisset
        </tbody>
    </table>
</div>