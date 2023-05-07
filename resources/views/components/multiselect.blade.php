<div>
    <select class="hidden" id="select" required>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->title }} {{ $user->name }}</option>
        @endforeach
    </select>

    <div x-data="dropdown()" x-init="loadOptions()" class="w-full md:w-full">

        <input name="recipients" type="hidden" class="hidden" x-bind:value="selectedValues()">
        <div class="inline-block relative w-full">
            <div class="flex flex-col relative">
                <div x-on:click="open" class="w-full">
                    <label for="recipients" class="form-label">{{ $To ?? 'To' }}</label>
                    <div id="recipients" class="my-2 p-1 flex border border-gray-500 dark:bg-cyan-100 bg-white w-full">
                        <div class="flex flex-auto flex-wrap">
                            <template x-for="(option,index) in selected" :key="options[option].value">
                                <div
                                    class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-green-700 dark:text-gray-700 bg-green-100 dark:bg-blue-200 border border-green-300 dark:border-gray-700">
                                    <div class="text-xs font-normal leading-none max-w-full flex-initial"
                                        x-model="options[option]" x-text="options[option].text"></div>
                                    <div class="flex flex-auto flex-row-reverse">
                                        <div x-on:click="remove(index,option)">
                                            <i class="bi bi-x"></i>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="selected.length == 0" class="flex-1">
                                <input placeholder="Select recipients"
                                    class="bg-transparent dark:bg-cyan-100 p-1 px-2 appearance-none outline-none h-full w-full text-gray-800 placeholder-gray-500"
                                    x-bind:value="selectedValues()">
                            </div>
                        </div>
                        <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200">

                            <button type="button" x-show="isOpen() === true" x-on:click="open"
                                class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                <i class="bi bi-chevron-up"></i>
                            </button>
                            <button type="button" x-show="isOpen() === false" @click="close"
                                class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div x-show.transition.origin.top="isOpen()"
                        class="absolute shadow top-100 bg-white dark:bg-yellow-100 z-40 w-full lef-0 max-h-select overflow-y-auto"
                        x-on:click.away="close">
                        <div class="flex flex-col w-full">
                            <template x-for="(option,index) in options" :key="option">
                                <div>
                                    <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-green-100 dark:hover:bg-yellow-200"
                                        @click="select(index,$event)">
                                        <div x-bind:class="option.selected ? 'border-green-600 dark:border-red-600' : ''"
                                            class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative">
                                            <div class="w-full items-center flex">
                                                <div class="mx-2 leading-6" x-model="option" x-text="option.text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script>
            function dropdown() {
                return {
                    options: [],
                    selected: [],
                    show: false,
                    open() {
                        this.show = true
                    },
                    close() {
                        this.show = false
                    },
                    isOpen() {
                        return this.show === true
                    },
                    select(index, event) {

                        if (!this.options[index].selected) {

                            this.options[index].selected = true;
                            this.options[index].element = event.target;
                            this.selected.push(index);

                        } else {
                            this.selected.splice(this.selected.lastIndexOf(index), 1);
                            this.options[index].selected = false
                        }
                    },
                    remove(index, option) {
                        this.options[option].selected = false;
                        this.selected.splice(index, 1);


                    },
                    loadOptions() {
                        const options = document.getElementById('select').options;
                        for (let i = 0; i < options.length; i++) {
                            this.options.push({
                                value: options[i].value,
                                text: options[i].innerText,
                                selected: options[i].getAttribute('selected') != null ? options[i].getAttribute(
                                    'selected') : false
                            });
                        }


                    },
                    selectedValues() {
                        return this.selected.map((option) => {
                            return this.options[option].value;
                        })
                    }
                }
            }
        </script>
    </div>
</div>
