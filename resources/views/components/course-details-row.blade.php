@foreach ($components as $component)
<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
    @if($loop->first)
    <td style="vertical-align: middle; width:5%; text-transform: capitalize;"
        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
        rowspan="{{ $basecourse['total_' . $name . 's'] ??  $basecourse['total_' . $name . 'zes'] }}">
        @if ($name == 'midquestion')
        Mid Exam
        @elseif ($name == 'endquestion')
        End Exam
        @elseif ($name == 'quiz')
        Quizzes
        @else
        {{ $name . 's' }}
        @endif
    </td>
    @endif
    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white" style="width: 3%">{{
        $loop->iteration }}</td>
    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
        {{ $component[$name . '_name'] ?? $itemname ?? '' }}</td>
    @if($loop->first)
    <td style="vertical-align: middle;"
        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-center"
        rowspan="{{ $basecourse['total_' . $name . 's'] ??  $basecourse['total_' . $name . 'zes'] }}">
        <?php
          $total = 0;
            foreach ($components as $item) {
              $total = $total + $item->lo_1 + $item->lo_2 + $item->lo_3 + $item->lo_4 + $item->lo_5 + $item->lo_6;
            }
            echo($total);
            ?>
    </td>
    @endif
    @for ($i = 1; $i <= $basecourse->total_los; $i++)
        <td
            class="py-4 px-6 text-sm font-medium @if($component['lo_'.$i]) text-gray-900 dark:text-white @else text-gray-300 dark:text-gray-600 @endif whitespace-nowrap text-center">
            @if($component['lo_'.$i]) {{ $component['lo_'.$i] }} @else - @endif</td>
        @endfor
        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
            {{ $component->lo_1 + $component->lo_2 + $component->lo_3 + $component->lo_4 + $component->lo_5 +
            $component->lo_6 }}
        </td>
</tr>
@if ($loop->last)
<tr>
    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
        colspan="{{ 5 + $basecourse->total_los }}"></td>
</tr>
@endif
@endforeach
