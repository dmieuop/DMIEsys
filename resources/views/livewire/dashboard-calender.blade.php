<div class="mb-3 rounded-xl bg-white p-2 p-3 shadow-md dark:bg-gray-800 dark:shadow-gray-900/80">
    <div class="bg-white dark:bg-gray-800">
        <div class="flex justify-center text-lg font-normal text-gray-800 dark:text-gray-500 px-2 mb-3">
            <span class="pl-2 font-semibold">
                {{ date('l', time()) }}
            </span>
            <span>
                {{ date(', M Y', time()) }}
            </span>
        </div>
        <div class="flex items-center justify-between overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="pb-3">
                            <div class="h-full w-full">
                                <div class="flex w-full items-center justify-center rounded-full">
                                    <p
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 text-base font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                        Mo
                                    </p>
                                </div>
                            </div>
                        </th>
                        <th class="pb-3">
                            <div class="h-full w-full">
                                <div class="flex w-full items-center justify-center rounded-full">
                                    <p
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 text-base font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                        Tu
                                    </p>
                                </div>
                            </div>
                        </th>
                        <th class="pb-3">
                            <div class="h-full w-full">
                                <div class="flex w-full items-center justify-center rounded-full">
                                    <p
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 text-base font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                        We
                                    </p>
                                </div>
                            </div>
                        </th>
                        <th class="pb-3">
                            <div class="h-full w-full">
                                <div class="flex w-full items-center justify-center rounded-full">
                                    <p
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 text-base font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                        Th
                                    </p>
                                </div>
                            </div>
                        </th>
                        <th class="pb-3">
                            <div class="h-full w-full">
                                <div class="flex w-full items-center justify-center rounded-full">
                                    <p
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 text-base font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                        Fr
                                    </p>
                                </div>
                            </div>
                        </th>
                        <th class="pb-3">
                            <div class="h-full w-full">
                                <div class="flex w-full items-center justify-center rounded-full">
                                    <p
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-400 text-base font-medium text-gray-800 dark:bg-gray-500 dark:text-gray-200">
                                        Sa
                                    </p>
                                </div>
                            </div>
                        </th>
                        <th class="pb-3">
                            <div class="h-full w-full">
                                <div class="flex w-full items-center justify-center rounded-full">
                                    <p
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-400 text-base font-medium text-gray-800 dark:bg-gray-500 dark:text-gray-200">
                                        Su
                                    </p>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @for ($i = 1; $i <= count($days); $i++) <td>
                            @if (date('Y-m-d', $days[$i - 1]) == $today)
                            @if (date('l', $days[$i - 1]) == 'Saturday' || date('l', $days[$i - 1]) == 'Sunday')
                            <div class="h-full w-full">
                                <div onclick="showDayEvents({{ $days[$i - 1] }})"
                                    class="flex w-full cursor-pointer items-center justify-center rounded-full">
                                    <p
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-500 text-base font-medium text-white dark:bg-gray-200 dark:text-black">
                                        {{ date('d', $days[$i - 1]) }}
                                    </p>
                                </div>
                            </div>
                            @else
                            <div class="h-full w-full">
                                <div onclick="showDayEvents({{ $days[$i - 1] }})"
                                    class="flex w-full cursor-pointer items-center justify-center rounded-full">
                                    <p
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-cyan-500 text-base font-medium text-white dark:bg-gray-200 dark:text-black">
                                        {{ date('d', $days[$i - 1]) }}
                                    </p>
                                </div>
                            </div>
                            @endif
                            @else
                            <div class="relative">
                                <div onclick="showDayEvents({{ $days[$i - 1] }})"
                                    class="flex w-full cursor-pointer justify-center px-2 py-2">
                                    <p
                                        class="@if ($this_month == date('m', $days[$i - 1])) text-gray-500 dark:text-gray-100 @else text-gray-300 dark:text-gray-600 @endif text-base font-medium">
                                        {{ date('d', $days[$i - 1]) }}
                                    </p>
                                </div>
                                @if (date('Y-m-d', $days[$i - 1]) < $today) @if (in_array(date('Y-m-d', $days[$i - 1]),
                                    $incomplete_maintain_events)) <span
                                    class="absolute top-0 left-7 h-3 w-3 rounded-full border-2 border-white bg-red-500 dark:border-gray-800">
                                    </span>
                                    @elseif (in_array(date('Y-m-d', $days[$i - 1]), $complete_maintain_events))
                                    <span
                                        class="absolute top-0 left-7 h-3 w-3 rounded-full border-2 border-white bg-green-300 dark:border-gray-800"></span>
                                    @elseif (in_array(date('Y-m-d', $days[$i - 1]), $normal_events))
                                    <span
                                        class="absolute top-0 left-7 h-3 w-3 rounded-full border-2 border-white bg-blue-400 dark:border-gray-800"></span>
                                    @endif
                                    @elseif (date('Y-m-d', $days[$i - 1]) > $today)
                                    @if (in_array(date('Y-m-d', $days[$i - 1]), $incomplete_maintain_events))
                                    <span
                                        class="absolute top-0 left-7 h-3 w-3 rounded-full border-2 border-white bg-amber-500 dark:border-gray-800"></span>
                                    @elseif (in_array(date('Y-m-d', $days[$i - 1]), $complete_maintain_events))
                                    <span
                                        class="absolute top-0 left-7 h-3 w-3 rounded-full border-2 border-white bg-green-500 dark:border-gray-800"></span>
                                    @elseif (in_array(date('Y-m-d', $days[$i - 1]), $normal_events))
                                    <span
                                        class="absolute top-0 left-7 h-3 w-3 rounded-full border-2 border-white bg-blue-500 dark:border-gray-800"></span>
                                    @endif
                                    @endif
                            </div>
                            @endif
                            </td>
                            @if (!fmod($i, 7))
                    </tr>
                    <tr>
                        @endif
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
