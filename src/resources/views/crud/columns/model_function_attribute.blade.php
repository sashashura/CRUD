{{-- custom return value via attribute --}}
@php
	$model_function = $entry->{$column['function_name']}(...($column['function_parameters'] ?? []));

	if ($model_function) {
	    $value = $model_function->{$column['attribute']};
	} else {
		$value = '';
    }
    $column['escaped'] = $column['escaped'] ?? false;
    $text = (array_key_exists('prefix', $column) ? $column['prefix'] : '').str_limit($value, array_key_exists('limit', $column) ? $column['limit'] : 40, "[...]").(array_key_exists('suffix', $column) ? $column['suffix'] : '');
@endphp
<span>
        @include('crud::columns.inc.column_wrapper',['text' => $text])
</span>
