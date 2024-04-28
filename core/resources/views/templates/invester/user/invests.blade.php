@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-inner">
        <div class="mb-4">
            <p>@lang('Investment')</p>
            <h3>@lang('My Investment Statistics')</h3>
        </div>

        <div class="mt-4">
            @include($activeTemplate.'partials.invest_history',['invests'=>$invests])
            <div class="mt-3">
                {{ $invests->links() }}
            </div>
        </div>
    </div>
@endsection
