<?php

namespace App\Http\Livewire;

use App\Models\Inventory;
use App\Traits\System;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class InventoryTable extends PowerGridComponent
{
    use ActionButton, System;

    /** @var bool */
    public bool $showUpdateMessages = true;
    /** @var string|null */
    public $itemCode = null;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox()->persist(['columns', 'filters']);

        return [
            Exportable::make('Inventory List')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Inventory>
     */
    public function datasource(): Builder
    {
        return Inventory::query();
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    public function ShowQR(string $value): void
    {
        $this->itemCode = $value;
        $this->emit('itemCodeChanged', $this->itemCode);
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('item_code')
            ->addColumn('action_buttons', function (Inventory $model) {
                return '<div class="flex gap-2"><button wire:click.prefetch="ShowQR(' . "'" . $model->item_code . "'" . ')" type="button" class="btn-sm btn-blue float-right" data-bs-toggle="modal" data-modal-toggle="showQRcode"><i class="bi bi-qr-code"></i></button><a target="_blank" href="' . route('inventory.show', $model->item_code) . '" class="btn-sm btn-green"><i class="bi bi-eye"></i></a></div>';
            })
            ->addColumn('item_name')
            ->addColumn('received_date_formatted', function (Inventory $model) {
                return Carbon::parse($model->received_date)->format('Y-m-d');
            })
            ->addColumn('indent_no')
            ->addColumn('supplier_name')
            ->addColumn('model')
            ->addColumn('serial_number')
            ->addColumn('properties', function (Inventory $model) {
                return $model->properties;
            })
            ->addColumn('book_no')
            ->addColumn('folio_no')
            ->addColumn('value', function (Inventory $model) {
                return ('Rs. ' . $model->value);
            })
            ->addColumn('budget_allocation')
            ->addColumn('location')
            ->addColumn('remark')
            ->addColumn('created_at_formatted', function (Inventory $model) {
                return Carbon::parse($model->created_at)->format('Y-m-d');
            })
            ->addColumn('updated_at_formatted', function (Inventory $model) {
                return Carbon::parse($model->updated_at)->format('Y-m-d');
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [

            Column::add()
                ->title('ITEM CODE')
                ->field('item_code')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('INFO')
                ->field('action_buttons'),

            Column::add()
                ->title('ITEM NAME')
                ->field('item_name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('RECEIVED DATE')
                ->field('received_date_formatted', 'received_date')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('received_date'),

            Column::add()
                ->title('INDENT No.')
                ->field('indent_no')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('SUPPLIER NAME')
                ->field('supplier_name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('MODEL')
                ->field('model')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('SERIAL NUMBER')
                ->field('serial_number')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('BOOK NO')
                ->field('book_no')
                ->editOnClick($this->can('edit inventory'))
                ->makeInputRange(),

            Column::add()
                ->title('FOLIO NO')
                ->field('folio_no')
                ->editOnClick($this->can('edit inventory'))
                ->makeInputRange(),

            Column::add()
                ->title('PROPERTIES')
                ->field('properties')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('VALUE')
                ->field('value')
                ->makeInputRange(),

            Column::add()
                ->title('BUDGET ALLOCATION')
                ->field('budget_allocation')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('LOCATION')
                ->field('location')
                ->sortable()
                ->searchable()
                ->editOnClick($this->can('edit inventory'))
                ->makeInputText(),

            Column::add()
                ->title('REMARK')
                ->field('remark')
                ->sortable()
                ->editOnClick($this->can('edit inventory'))
                ->searchable(),

            Column::add()
                ->title('CREATED AT')
                ->field('created_at_formatted', 'created_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('created_at'),

            Column::add()
                ->title('UPDATED AT')
                ->field('updated_at_formatted', 'updated_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('updated_at'),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Inventory Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            Button::add('delete-item')
                ->target('')
                ->caption('Delete')
                ->class('btn-sm btn-red')
                ->route('inventory.destroy', ['inventory' => 'id'])
                ->method('delete'),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Inventory Action Rules.
     *
     * @return array<int, RuleActions>
     */


    public function actionRules(): array
    {
        return [
            Rule::button('delete-item')
                ->when(fn ($item) => !$this->can('delete inventory'))
                ->hide()
        ];
    }

    public function update(array $data): bool
    {
        try {
            $updated = Inventory::query()->findOrFail($data['id'])
                ->update([
                    $data['field'] => $data['value'],
                ]);
        } catch (QueryException $exception) {
            $updated = false;
        }
        return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field'   => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field'   => __('Error updating custom field.'),
            ]
        ];

        $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

        return (is_string($message)) ? $message : 'Error!';
    }
}
