@props(['question', 'answer'])

<div class="grid grid-cols-2">
    <div>
        @foreach ($question->data['options'] as $option)
            <div class="flex items-center">
                <div class="mr-1 pr-1 font-bold border-r-4">{{ $loop->iteration }}</div>
                @isset($option['image'])
                    <x-common.image :src="App\Helpers\ImageHelper::url($option['image'])"></x-common.image>
                @endisset
                <div class="ml-1 my-2">{!! clean($option['text']) !!}</div>
            </div>
        @endforeach
    </div>
    <div>
        @foreach ($question->data['variants'] as $variant)
            <div class="flex items-center">
                <div class="mr-1 pr-1 font-bold border-r-4">{{ chr(65 + $loop->index) }}</div>
                @isset($variant['image'])
                    <x-common.image :src="App\Helpers\ImageHelper::url($variant['image'])"></x-common.image>
                @endisset
                <div class="ml-1 my-2">{!! clean($variant['text']) !!}</div>
            </div>
        @endforeach
    </div>
    <div class="col-span-full">
        <table>
            <thead>
                <tr>
                    <th></th>
                    @foreach ($question->data['variants'] as $variant)
                        <th>{{ chr(65 + $loop->index) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($question->data['options'] as $option)
                    <tr>
                        <th class="px-1">{{ $loop->index + 1 }}</th>
                        @foreach ($question->data['variants'] as $variant)
                            @php
                                $correct = $question->data['answer']['match'][$loop->parent->index] === $loop->index;
                                $chosen = ($answer->data['match'][$loop->parent->index] ?? -1) === $loop->index;
                            @endphp
                            <td>
                                <div @class(['w-6 h-6 rounded', 'bg-green-400' => $correct, 'bg-red-600' => $chosen && !$correct, 'bg-gray-200' => !$chosen && !$correct])></div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>