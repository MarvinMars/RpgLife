<?php

namespace App\Tables\Columns;

use Closure;
use Filament\Tables\Columns\Column;
use Illuminate\Contracts\View\View;
use Illuminate\View\ComponentAttributeBag;

class ProgressBar extends Column
{
    protected string $view = 'tables.columns.progress-bar';

    protected int | Closure $value = 0;
    protected int | Closure $maxValue = 100;

    public function value(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function maxValue(mixed $maxValue): static
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    public function getMaxValue()
    {
        return $this->evaluate($this->maxValue);
    }

    public function getValue()
    {
        return $this->evaluate($this->value);
    }

    public function calculatePercent(): float|int
    {
        if(!$this->getMaxValue()){
            return 0;
        }

        $percent = $this->getValue() / $this->getMaxValue() * 100;

        if($percent > 100) {
            $percent = 100;
        }

        return $percent;
    }
    public function render(): View
    {
        $this->viewData['percent'] = $this->calculatePercent();

        return view(
            $this->getView(),
            [
                'attributes' => new ComponentAttributeBag(),
                ...$this->extractPublicMethods(),
                ...(isset($this->viewIdentifier) ? [$this->viewIdentifier => $this] : []),
                ...$this->viewData,
            ],
        );
    }
}
