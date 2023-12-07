
@php
    $limitTime = boolval(old('limit_time') ?? (isset($exam) ? $exam->settings->time : true));
@endphp

<div class="grid grid-cols-2 gap-3">
    <div class="grid grid-cols-2 gap-3 h-min">
        <x-form.input name="label" :value="old('label') ?? $exam->label ?? $test->name" label="Назва" placeholder="Назва" wrap-class="col-span-full"></x-form.input>
        <x-form.datetime name="begin_at" label="Початок" :value="old('begin') ?? App\Helpers\Timezone::getDatetime($exam->begin_at ?? null, 'Y-m-d H:00')"></x-form.datetime>
        <x-form.datetime name="end_at" label="Кінець" :value="old('end') ?? App\Helpers\Timezone::getDatetime($exam->end_at ?? now()->addDay(1), 'Y-m-d H:00')"></x-form.datetime>
    </div>
    <div class="grid grid-cols-2 gap-3">
        <x-form.input type="number" name="points_min" label="Мінімальні бали" :value="old('points_min') ?? $exam->settings->points_min ?? 2"></x-form.input>
        <x-form.input type="number" name="points_max" label="Максимальні бали" :value="old('points_max') ?? $exam->settings->points_max ?? 12"></x-form.input>
        <div class="col-span-full flex gap-1" x-data="{ enable: {{ $limitTime ? 'true' : 'false' }} }">
            <x-form.checkbox name="limit_time" label="Обмежити час на виконання" x-model="enable" :value="$limitTime"></x-form.checkbox>
            <x-form.time name="time" x-bind:disabled="!enable" :disabled="!$limitTime" :value="old('time') ?? date('H:i', strtotime($exam->settings->time ?? '00:40'))" class="w-24" wrap-class="flex items-center gap-1"></x-form.time>
        </div>

        <x-form.checkbox name="shuffle_questions" label="Перемішати питання" :value="old('shuffle_questions') ?? $exam->settings->shuffle_questions ?? false" wrap-class="col-span-full"></x-form.checkbox>
        <x-form.checkbox name="shuffle_options" label="Перемішати відповіді" :value="old('shuffle_options') ?? $exam->settings->shuffle_options ?? false" wrap-class="col-span-full"></x-form.checkbox>
        <x-form.checkbox name="show_result" label="Показати результат" :value="old('show_result') ?? $exam->settings->show_result ?? true" wrap-class="col-span-full"></x-form.checkbox>
        <x-form.checkbox name="show_answers" label="Показати відповіді" :value="old('show_answers') ?? $exam->settings->show_answers ?? false" wrap-class="col-span-full"></x-form.checkbox>
    </div>

    <x-form.errors></x-form.errors>
</div>