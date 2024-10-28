# Yet Another Table

[![Laravel](https://img.shields.io/static/v1?label=laravel&message=%E2%89%A510.0&color=0078BE&logo=laravel&style=flat-square")](https://packagist.org/packages/fantismic/dynamic-settings)
[![Version](https://img.shields.io/packagist/v/fantismic/dynamic-settings)](https://packagist.org/packages/fantismic/yetanothertable)
[![Downloads](https://img.shields.io/packagist/dt/fantismic/yetanothertable)](https://packagist.org/packages/fantismic/yetanothertable)
[![Licence](https://img.shields.io/packagist/l/fantismic/yetanothertable)](https://packagist.org/packages/fantismic/yetanothertable)


Oh no, yet another laravel livewire table.
Why? Arrays.
For real tables, real use, serious needs please use [rappasoft laravel livewire table](https://rappasoft.com/packages/laravel-livewire-tables) or [livewire powergrid](https://livewire-powergrid.com/).

This is yet another laravel livewire table and come as is.
You can filter, you can sort, you can bulk, toggle columns, the basics. The data input is a collection, not a model, we are not fancy. 
Raw data, raw results.

## Requirements

- Laravel 10/11
- Livewire 3


## Installation

```
composer require fantismic/yetanothertable
```

You may want to let the user save the table arrange of columns. If so, publish the migrations...

```
php artisan vendor:publish --provider="Fantismic\\YetAnotherTable\\YATProvider" --tag="migrations"
```

...and run them.


```
php artisan migrate
```

That's it. You are ready to go.


### Optionals

You may want to publish the lang settings and change all the 6 keys. Up to you.

```
php artisan vendor:publish --provider="Fantismic\\YetAnotherTable\\YATProvider" --tag="lang"
```


## Creating a table

### The artisan way

To create a table you can run the following:

```
php artisan make:yatable MyBrandNewTable
```

### Rendering the table

This is nothing more than a livewire component, so the rendering is just the same:

#### Fullpage layout

Add the layout attribute right before the class with your layout:

```
#[Layout('layouts.app')]
class MyBrandNewTable extends YATBaseTable
```

#### Included in blade view

```
<livewire:mybrandnewtable />
```

[Livewire docs to render component](https://livewire.laravel.com/docs/components#rendering-components)


## Base functions

### settings(): void

Here you can set some settings to the table in general: title, column id, bulk, state handler, etc.

### data(): collection

Here you return the data. As is, a collection of arrays or objects, you return it we display it. When you create a table an example of data is in the stub in order to see what is expected.

### columns(): array

Here you return an array of column instances with the modifiers you want.

### filters(): array

Here you return an array of filter instances.

### options(): array

Here you return an array with function => label form. 

This will generate an "Options" button in the view that will display a dropdown with the options you set and they will call the function established as key. 

# Contents

## [Settings](#settings-1)

### [View](#view)
- [Set table title](#set-table-title)
- [Override title classes](#override-title-classes)
- [Set a custom header](#set-a-custom-header)

### [Sorting](#sorting-1)
- [Set default sort column](#set-default-sort-column)
- [Set default sort direction asc](#set-default-sort-direction-asc)
- [Set default sort direction desc](#set-default-sort-direction-desc)

### [Bulk](#bulk-1)
- [Enable bulk](#enable-bulk)
- [Get selected rows](#get-selected-rows)

### [Table state handler](#table-state-handler)
- [Enable state handler](#enable-state-handler)

### [Pagination](#pagination-1)
- [Set default per page rows value](#set-default-per-page-rows-value)
- [Set options for per page rows](#set-options-for-per-page-rows)

### [Misc](#misc-1)
- [Set column ID](#set-column-id)

## [Columns](#columns-1)

- [Styling](#styling-1)
- [Custom Data](#custom-data)
- [Hidding columns](#hidding-columns)
- [Hidding columns from selector](#hidding-columns-from-selector)
- [Hide column by default](#hide-column-by-default)
- [Boolean columns](#boolean-columns)
- [Link columns](#link-columns)

## [Filters](#filters-1)

- [String filter](#string-filter)
- [DateRange Filter](#daterange-filter)

## [Options](#options-1)

## Settings

### View

#### Set table title
`setTitle(string $title)`

By default the component shows only the table. Use this to display a title.

```
$this->setTitle('My brand new table');
```

#### Override title classes
`overrideTitleClasses(string $classes)`

The title is displayed in a single div, if you want to change the default styling you can use this function to override the default classes and apply your own.

> Tailwind classes only

```
$this->overrideTitleClasses('text-3xl text-red-700 dark:text-red-300');
```

#### Set a custom header
`setCustomHeader(string $html)`

If you want, you can add your own html in the header in order to replace the title at all or add some stuff.

This will render at the top of the component any html you pass.


```
$this->setCustomHeader('
    <div class="flex justify-between">
        <div class="text-2xl font-bold">My brand new table</div>
        <div><button href="/">Go back</button></div>
    </div>
');
```

### Sorting

#### Set default sort column

`setSortColumn(string $column)`

By default data is displayed as is, you can set a default sort by a column.

```
$this->setSortColumn('createtime');
```

#### Set default sort direction asc

`setSortDirectionAsc(bool $boolean)`

If *setSortColumn* is set, by default the order will be 'asc', but you can enforce that if necessary.

```
$this->setSortDirectionAsc(true);
```

#### Set default sort direction desc

`setSortDirectionDesc(bool $boolean)`

If *setSortColumn* is set, you can set the direction 'desc' by default.

```
$this->setSortDirectionDesc(true);
```

### Bulk

#### Enable bulk
`hasBulk(bool $boolean)`

Disabled by default. 
Set hasBulk to true to enable the functionality.
This will use the 'id' column to identify the row, if there is no 'id' column in your data you must set which column to use with [setColumnID](#set-column-id)

> Bulk functionality can be combined with [Options](#options)

#### Get selected rows

`getSelectedRows()`

This will return an array of ids of the current selected options.


```
$ids = $this->getSelectedWRows();
```

#### Remove row from table

`removeRowFromTable(string $id, ?bool $resetSelected = true)`

Remove a row by its id from the table.

> By default this function reset the selected rows, if you dont want that pass a `false` as a second parameter.


```
$this->removeRowFromTable(3);
```

### Table state handler

#### Enable state handler
`useStateHandler(bool $boolean)`

> In order to enable this feature you need to publish and run the migration of the package.

Disabled by default. When enabled in column toggle button the user can save the current set of column's visibility. Each time the component is reloaded the columns will be visibile according to user election.

This functionality distincts users and tables, you can have many to many, each will get their custom visualization per table.

```
$this->useStateHandler(true);
```

### Pagination

#### Set default per page rows value
`setPerPageDefault(int $number)`

By default 10 rows are displayed. Change this to show as many as you want per page.

```
$this->setPerPageDefault(25);
```

#### Set options for per page rows
`setPerPageOptions(int $number)`

Default value: ["10", "15", "25", "50"].

```
$this->setPerPageOptions(["10","20","50","100"]);
```

### Misc

#### Set column ID
`setColumnID(string $column)`

By default 'id' is the assumed column for identifying a row in order to use bulk functions. If you want to set another column of your data you can do that using this.

```
$this->setColumnID('ticket');
```


## Columns
`Column::make(string label, ?string $field)`
In order to render the data the way you need it, you have to create a "columns" function returning an array of any of the Column objects we provide.

```
public function columns(): array {
    return [
        Column::make('Name','name')
            ->styling('text-lg font-bold')
            ->hideFromSelector(true),

        Column::make('Hex Code','hex'),

        Column::make('Color')
            ->customData(function($row, $value){
                return '<span style="color:'.$row['hex'].'">██████████████</span>';
            })
            ->toHtml(),

        LinkColumn::make('Google it','name')
            ->href(function($row, $value){
                return "https://www.google.com/search?q=".$value;
            })
            ->text('Google'),

        BoolColumn::make('Primary','isPrimary')
    ];
}
```

### Column

The Column class provides several modifiers to customize your table:

#### Styling
`styling(string $classes)`

You can pass classes to add to all `<td>` in the column. The classes will be prefixed with `!` in order to override other conflicting classes.

```
Column::make('Big text column','bigtext')
    ->styling('text-7xl')
```

#### Custom Data
`customData(Closure $function)`

To customize the data of the column you can pass any html in a closure function with `$row` and `$value` variable available.

```
Column::make('Upper Name','name')
    ->customData(function($row, $value){
        return strtoupper($value);
    })
```

```
Column::make('Full Name')
    ->customData(function($row, $value){
        return $row['firstname'] . " " . $row['lastname'];
    })
```

> Tip: if you pass html, you need to add the ->toHtml() modifier

```
Column::make('Big Name','name')
    ->customData(function($row, $value){
        return '<div class="text-3xl">'.$value.'</div>';
    })->toHtml()
```

#### Hidding columns
`hideWhen(bool $bool)`

Hides the column from the view. When `true` the user cannot access this column at all.

```
Column::make('Only Admins','sensitive-row')
    ->hideWhen(Auth::user()->isAdmin)
```

#### Hidding columns from selector
`hideFromSelector(bool $bool)`

Hides the column from the toggle dropdown.

```
Column::make('Always visible','force-data')
    ->hideFromSelector(true)
```

#### Hide column by default
`isVisible(bool $bool)`

By default all columns are visible. IF you set this to `true` the table will render with this column hidden, but the user can display it any time with the column toggle switch.

```
Column::make('Not so important data','meh-column')
    ->isVisible(false)
```

#### Boolean columns
`BoolColumn::make(string $label, string $field)`

You can use this column to boolean values, they will render in table view as ✔️ and ❌.

```
BoolColumn::make('User status','isActive'),
```

#### Link columns
`LinkColumn::make(string $label, ?string $field)`

Link column takes an destination and generates a link with the closure function.

```
LinkColumn::make('Edit user','id')
    ->text('Edit')
    ->href(function($row, $value){
        return '/edit/'.$value;
    })
```


## Filters
`[Filter]::make(string label, ?string $column)`

In addition to the search input that filters globally on the table, you can add filters by column.

> Note: if you pass only the *label* parameter, the filter will search for a column with same label and match, if you want to specify a column use the second parameter to assign the filter to the column label you want.

To enable filters, you need to create a "filters" function that returns an array of any of the Filter objects we provide.

```
public function filters(): array {
    return [
        FilterString::make('name'),
        FilterDateRange::make('Created At')
    ];
}
```

### String filter
`FilterString::make(string $label, ?string $column)`

This filter will search in column with label `$label` and filter the table accordingly.

```
FilterString::make('name') # This will search in column with label 'name'
```

```
FilterString::make('Edad', 'age') # This will search in column with label 'age'
```

### DateRange Filter
`FilterDateRange::make(string $label, ?string $column)`

This filter uses flatpickr to display a date range select and filter the table based on user input.

```
FilterDateRange::make('created_at') # This will search in column with label 'name'
```

## Options

You can add an additional button next to the column toggle to display a list of custom options/actions.
This options/actions will 'wire:click' the key given.

```
public function options(): array {
    return [
        'export' => 'Export selected rows',
        'remove' => 'Delete selected rows',
    ];
}

public function remove() {
    foreach ($this->getSelectedRows() as $id) {
        $this->removeRowFromTable($id);
    }
}
```

In this example, when user clicks on 'Delete selected rows' the function 'remove' will be called.

> Make sure you implement this functions in your component in order to avoid errors.
---

[![Image description](https://i.postimg.cc/SxB7b1T0/fantismic-no-background.png)](https://github.com/fantismic)
