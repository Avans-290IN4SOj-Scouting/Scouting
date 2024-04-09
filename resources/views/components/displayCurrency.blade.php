@props(['price'])

{{__('currency.symbol') . number_format($price, 2, __('currency.seperator'), __('currency.thousands_serperator')) . '-'}}
