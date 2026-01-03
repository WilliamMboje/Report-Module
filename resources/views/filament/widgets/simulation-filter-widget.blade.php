<x-filament-widgets::widget>
    <x-filament::section>
        <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; gap: 1rem;">
            <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white shrink-0">
                A. LAP
            </h2>

            <div style="display: flex; flex-direction: row; align-items: center; gap: 1rem;">
                {{-- Mock Filters --}}
                <div style="width: 150px;">
                    <x-filament::input.wrapper>
                        <x-filament::input.select>
                            <option>Month</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>

                <div style="width: 150px;">
                    <x-filament::input.wrapper>
                        <x-filament::input.select>
                            <option>Year</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>

                <div style="width: 150px;">
                    <x-filament::input.wrapper>
                        <x-filament::input.select>
                            <option>Quarter</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>

                <x-filament::button color="success" class="shrink-0">
                    Apply Filters
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
