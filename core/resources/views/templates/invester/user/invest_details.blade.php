@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-inner">
        <div class="mb-4">
            <p>@lang('Investment')</p>
            <h3>@lang('Investment Details')</h3>
        </div>
        <div class="row gy-3">
            <div class="col-xl-4">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="title">@lang('Plan & User Information')</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Plan Name')
                                <span>{{ __($invest->plan->name) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Investable Amount')
                                <span>
                                    @if ($invest->plan->fixed_amount > 0)
                                        {{ $general->cur_sym }}{{ showAmount($invest->plan->fixed_amount) }}
                                    @else
                                        {{ $general->cur_sym }}{{ showAmount($invest->plan->minimum) }} - {{ $general->cur_sym }}{{ showAmount($invest->plan->maximum) }}
                                    @endif
                                </span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Full Name')
                                <span>{{ $invest->user->fullname }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Username')
                                <span>{{ $invest->user->username }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Mobile')
                                <span>{{ $invest->user->mobile }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Email')
                                <span>{{ $invest->user->email }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="title">@lang('Basic Information')</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Invest Amount')
                                <span>{{ $general->cur_sym }}{{ showAmount($invest->amount) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Invested')
                                <span>{{ showDateTime($invest->created_at) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Interest Amount')
                                <span>{{ $general->cur_sym }}{{ showAmount($invest->interest) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Total Payable')
                                <span>
                                    @if ($invest->period != -1)
                                        {{ $invest->period }} @lang(' times')
                                    @else
                                        @lang('Lifetime')
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Interest Interval')
                                <span>@lang('Every ') {{ $invest->time_name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Status')
                                <span>
                                    @if ($invest->status)
                                        <span class="badge badge--success">@lang('Running')</span>
                                    @else
                                        <span class="badge badge--dark">@lang('Closed')</span>
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="title">@lang('Other Information')</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Total Paid')
                                <span>{{ $general->cur_sym }}{{ showAmount($invest->paid) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Total Paid Amount')
                                <span>{{ $invest->return_rec_time }} @lang(' times')</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Should Pay')
                                <span>
                                    @if ($invest->should_pay != -1)
                                        {{ $general->cur_sym }}{{ showAmount($invest->interest) }}
                                    @else
                                        **
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Last Paid Time')
                                <span>{{ showDateTime($invest->last_time) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Next Pay Time')
                                <span>{{ showDateTime($invest->next_time) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Capital Back')
                                <span>
                                    @if ($invest->capital_status)
                                        @lang('Yes')
                                    @else
                                        @lang('No')
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-2 mt-4">@lang('All Interests')</h4>
        <div class="accordion table--acordion" id="transactionAccordion">
            @forelse($transactions as $transaction)
                <div class="accordion-item transaction-item">
                    <h2 class="accordion-header" id="h-{{ $loop->iteration }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c-{{ $loop->iteration }}">
                            <div class="col-lg-4 col-sm-5 col-8 order-1 icon-wrapper">
                                <div class="left">
                                    <div class="icon tr-icon @if ($transaction->trx_type == '+') icon-success @else icon-danger @endif">
                                        <i class="las la-long-arrow-alt-right"></i>
                                    </div>
                                    <div class="content">
                                        <h6 class="trans-title">{{ __(keyToTitle($transaction->remark)) }} - {{ __(keyToTitle($transaction->wallet_type)) }}</h6>
                                        <span class="text-muted font-size--14px mt-2">{{ showDateTime($transaction->created_at, 'M d Y @g:i:a') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12 order-sm-2 order-3 content-wrapper mt-sm-0 mt-3">
                                <p class="text-muted font-size--14px"><b>#{{ $transaction->trx }}</b></p>
                            </div>
                            <div class="col-lg-4 col-sm-3 col-4 order-sm-3 order-2 text-end amount-wrapper">
                                <p>
                                    <b>{{ showAmount($transaction->amount) }} {{ $general->cur_text }}</b><br>
                                    <small class="fw-bold text-muted">@lang('Balance'): {{ showAmount($transaction->post_balance) }} {{ $general->cur_text }}</small>
                                </p>

                            </div>
                        </button>
                    </h2>
                    <div id="c-{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="h-1" data-bs-parent="#transactionAccordion">
                        <div class="accordion-body">
                            <ul class="caption-list">
                                <li>
                                    <span class="caption">@lang('Post Balance')</span>
                                    <span class="value">{{ showAmount($transaction->post_balance) }} {{ $general->cur_text }}</span>
                                </li>
                                <li>
                                    <span class="caption">@lang('Details')</span>
                                    <span class="value">{{ __($transaction->details) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- transaction-item end -->
            @empty
                <div class="accordion-body text-center">
                    <h4 class="text--muted"><i class="far fa-frown"></i> {{ __($emptyMessage) }}</h4>
                </div>
            @endforelse
        </div>


        @if ($transactions->hasPages())
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
@endsection
