@props([
    'label' => 'Select options',
    'name' => 'permissions',
    'options' => [],
    'placeholder' => 'Pilih permission',
])

<div x-data="multiSelectComponent(@js($options), '{{ $name }}')" class="w-full">
    @if ($label)
        <label class="block mb-1 text-sm font-medium text-zinc-700 dark:text-zinc-300">
            {{ $label }}
        </label>
    @endif

    <!-- Hidden inputs untuk submit -->
    <template x-for="(value, index) in selected" :key="index">
        <input type="hidden" :name="inputName" :value="value">
    </template>

    <!-- Select box -->
    <div 
        @click="open = !open" 
        class="border rounded-md p-2 bg-white dark:bg-zinc-800 cursor-pointer min-h-[42px] flex items-center flex-wrap gap-1"
    >
        <!-- Selected tags -->
        <template x-for="(value, index) in selected" :key="index">
            <span class="bg-zinc-200 dark:bg-zinc-700 px-2 py-1 rounded text-sm flex items-center gap-1">
                <span x-text="options[value]"></span>
                <button 
                    @click.stop="remove(value)"
                    type="button"
                    class="text-red-600 hover:text-red-800"
                >×</button>
            </span>
        </template>

        <!-- Placeholder -->
        <span x-show="selected.length === 0" class="text-zinc-500">
            {{ $placeholder }}
        </span>
    </div>

    <!-- Dropdown -->
    <div 
        x-show="open" 
        @click.outside="open = false"
        x-transition
        class="border rounded-md mt-1 max-h-48 overflow-y-auto bg-white dark:bg-zinc-800 z-50"
    >
        <template x-for="(label, value) in options" :key="value">
            <div 
                @click="toggle(value)"
                class="cursor-pointer px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 flex items-center justify-between"
            >
                <span x-text="label"></span>
                <input type="checkbox" :checked="selected.includes(value)" class="pointer-events-none">
            </div>
        </template>
    </div>
</div>

<script>
    function multiSelectComponent(options, name) {
        return {
            open: false,
            options,
            selected: [],
            inputName: name + '[]',
            toggle(value) {
                if (this.selected.includes(value)) {
                    this.selected = this.selected.filter(v => v !== value);
                } else {
                    this.selected.push(value);
                }
            },
            remove(value) {
                this.selected = this.selected.filter(v => v !== value);
            }
        };
    }
</script>