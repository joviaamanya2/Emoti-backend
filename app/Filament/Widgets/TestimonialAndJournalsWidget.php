<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class TestimonialAndJournalsWidget extends Widget
{
    protected static string $view = 'filament.widgets.testimonials-journals';

    protected int|string|array $columnSpan = 'full';



    public function getColumns(): int
    {
        return 2;
    }
}

