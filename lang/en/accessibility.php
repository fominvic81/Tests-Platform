<?php

use App\Enums\Accessibility;

return [
    Accessibility::Public->value => 'Публічний',
    Accessibility::Hidden->value => 'Схований',
    Accessibility::Private->value => 'Приватний',
];