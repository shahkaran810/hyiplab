@extends($activeTemplate.'layouts.master')
@section('content')
<div class="pb-60 pt-60">
    <div class="container">

        <div class="row notice"></div>
        
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if ($user->deposit_wallet <= 0 && $user->interest_wallet <= 0)
                    <div class="alert border border--danger" role="alert">
                        <div class="alert__icon d-flex align-items-center text--danger"><i
                                class="fas fa-exclamation-triangle"></i></div>
                        <p class="alert__message">
                            <span class="fw-bold">@lang('Empty Balance')</span><br>
                            <small><i>@lang('Your balance is empty. Please make') <a href="{{ route('user.deposit.index') }}"
                                        class="link-color">@lang('deposit')</a> @lang('for your next investment.')</i></small>
                        </p>
                    </div>
                @endif

                @if ($user->deposits->where('status',1)->count() == 1 && !$user->invests->count())
                    <div class="alert border border--success" role="alert">
                        <div class="alert__icon d-flex align-items-center text--success"><i class="fas fa-check"></i>
                        </div>
                        <p class="alert__message">
                            <span class="fw-bold">@lang('First Deposit')</span><br>
                            <small><i><span class="fw-bold">@lang('Congratulations!')</span> @lang('You\'ve made your first deposit successfully. Go to') <a
                                        href="{{ route('plan') }}" class="link-color">@lang('investment plan')</a>
                                    @lang('page and invest now')</i></small>
                        </p>
                    </div>
                @endif

                @if ($pendingWithdrawals)
                    <div class="alert border border--primary" role="alert">
                        <div class="alert__icon d-flex align-items-center text--primary"><i class="fas fa-spinner"></i>
                        </div>
                        <p class="alert__message">
                            <span class="fw-bold">@lang('Withdrawal Pending')</span><br>
                            <small><i>@lang('Total') {{ showAmount($pendingWithdrawals) }} {{ $general->cur_text }}
                                    @lang('withdrawal request is pending. Please wait for admin approval. The amount will send to the account which you\'ve provided. See') <a href="{{ route('user.withdraw.history') }}"
                                        class="link-color">@lang('withdrawal history')</a></i></small>
                        </p>
                    </div>
                @endif

                @if ($pendingDeposits)
                    <div class="alert border border--primary" role="alert">
                        <div class="alert__icon d-flex align-items-center text--primary"><i class="fas fa-spinner"></i>
                        </div>
                        <p class="alert__message">
                            <span class="fw-bold">@lang('Deposit Pending')</span><br>
                            <small><i>@lang('Total') {{ showAmount($pendingDeposits) }} {{ $general->cur_text }}
                                    @lang('deposit request is pending. Please wait for admin approval. See') <a href="{{ route('user.deposit.history') }}"
                                        class="link-color">@lang('deposit history')</a></i></small>
                        </p>
                    </div>
                    
                @endif

                @if (!$user->ts)
           
<script src="https://price-static.crypto.com/latest/public/static/widget/index.js"></script>
<div
  id="crypto-widget-CoinList"
  
  data-theme="dark"
  data-design="classic"
  data-coin-ids="1,166,136,382,1120,20,29,418,1986,1779,15195,4951,379,5253,2078,9114,11061,5230,1386,1746"></div>
  
		</div>
                    <div class="alert border border--warning" role="alert">
                        <div class="alert__icon d-flex align-items-center text--warning"><i
                                class="fas fa-user-lock"></i></div>
                        <p class="alert__message">
                            <span class="fw-bold">@lang('2FA Authentication')</span><br>
                            <small><i>@lang('To keep safe your account, Please enable') <a href="{{ route('user.twofactor') }}"
                                        class="link-color">@lang('2FA')</a> @lang('security').</i>
                                @lang('It will make secure your account and balance.')</small>
                        </p>
                    </div>
                @endif

                @if ($isHoliday)
                    <div class="alert border border--info" role="alert">
                        <div class="alert__icon d-flex align-items-center text--info"><i class="fas fa-toggle-off"></i>
                        </div>
                        <p class="alert__message">
                            <span class="fw-bold">@lang('Holiday')</span><br>
                            <small><i>@lang('Today is holiday on this system. You\'ll not get any interest today from this system. Also you\'re unable to make withdrawal request today.') <br> @lang('The next working day is coming after') <span id="counter"
                                        class="fw-bold text--primary fs--15px"></span></i></small>
                        </p>
                    </div>
                @endif

                @if ($user->kv == 0)
                    <div class="alert border border--info" role="alert">
                        <div class="alert__icon d-flex align-items-center text--info"><i class="fas fa-file-signature"></i>
                        </div>
                        <p class="alert__message">
                            <span class="fw-bold">@lang('KYC Verification Required')</span><br>
                            <small><i>@lang('Please submit the required KYC information to verify yourself. Otherwise, you couldn\'t make any withdrawal requests to the system.') <a href="{{ route('user.kyc.form') }}"
                                        class="link-color">@lang('Click here')</a> @lang('to submit KYC information').</i></small>
                        </p>
                    </div>
                @elseif($user->kv == 2)
                    <div class="alert border border--warning" role="alert">
                        <div class="alert__icon d-flex align-items-center text--warning"><i
                                class="fas fa-user-check"></i></div>
                        <p class="alert__message">
                            <span class="fw-bold">@lang('KYC Verification Pending')</span><br>
                            <small><i>@lang('Your submitted KYC information is pending for admin approval. Please wait till that.') <a href="{{ route('user.kyc.data') }}"
                                        class="link-color">@lang('Click here')</a> @lang('to see your submitted information')</i></small>
                        </p>
                    </div>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12 mt-lg-0 mt-5">
                <div class="row mb-none-30">
                    <div class="col-xl-4 col-sm-6 mb-30">
                        <div class="d-widget d-flex justify-content-between gap-5">
                            <div class="left-content">
                                <span class="caption">@lang('Deposit Wallet Balance')</span>
                                <h4 class="currency-amount">{{ $general->cur_sym }}{{ getAmount($user->deposit_wallet) }}</h4>
                            </div>
                            <div class="icon ms-auto">
                                <i class="las la-dollar-sign"></i>
                            </div>
                        </div><!-- d-widget-two end -->
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-30">
                        <div class="d-widget d-flex justify-content-between gap-5">
                            <div class="left-content">
                                <span class="caption">@lang('Interest Wallet Balance')</span>
                                <h4 class="currency-amount">
                                    {{ $general->cur_sym }}{{ getAmount($user->interest_wallet) }}</h4>
                            </div>
                            <div class="icon ms-auto">
                                <i class="las la-wallet"></i>
                            </div>
                        </div><!-- d-widget-two end -->
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-30">
                        <div class="d-widget d-flex justify-content-between gap-5">
                            <div class="left-content">
                                <span class="caption">@lang('Total Invest')</span>
                                <h4 class="currency-amount">
                                    {{ $general->cur_sym }}{{ getAmount($totalInvest) }}
                                </h4>
                            </div>
                            <div class="icon ms-auto">
                                <i class="las la-cubes "></i>
                            </div>
                        </div><!-- d-widget-two end -->
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-30">
                        <div class="d-widget d-flex justify-content-between gap-5">
                            <div class="left-content">
                                <span class="caption">@lang('Total Deposit')</span>
                                <h4 class="currency-amount">
                                    {{ $general->cur_sym }}{{ getAmount($user->deposits->where('status',1)->sum('amount')) }}
                                </h4>
                            </div>
                            <div class="icon ms-auto">
                                <i class="las la-credit-card"></i>
                            </div>
                        </div><!-- d-widget-two end -->
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-30">
                        <div class="d-widget d-flex justify-content-between gap-5">
                            <div class="left-content">
                                <span class="caption">@lang('Total Withdraw')</span>
                                <h4 class="currency-amount">
                                    {{ $general->cur_sym }}{{ getAmount($user->withdrawals->where('status',1)->sum('amount')) }}
                                </h4>
                            </div>
                            <div class="icon ms-auto">
                                <i class="las la-cloud-download-alt"></i>
                            </div>
                        </div><!-- d-widget-two end -->
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-30">
                        <div class="d-widget d-flex justify-content-between gap-5">
                            <div class="left-content">
                                <span class="caption">@lang('Referral Earnings')</span>
                                <h4 class="currency-amount">
                                    {{ $general->cur_sym }}{{ showAmount($referral_earnings) }}
                                </h4>
                            </div>
                            <div class="icon ms-auto">
                                <i class="las la-user-friends"></i>
                            </div>
                        </div><!-- d-widget-two end -->
                    </div>
                </div><!-- row end -->
                <div class="row mt-50">
                    <div class="col-lg-12">
                        <div class="table-responsive--md">
                            <table class="table style--two">
                                <thead>
                                    <tr>
                                        <th>@lang('Date')</th>
                                        <th>@lang('Transaction ID')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Wallet')</th>
                                        <th>@lang('Details')</th>
                                        <th>@lang('Post Balance')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $trx)
                                        <tr>
                                            <td>
                                                {{ showDatetime($trx->created_at,'d/m/Y') }}
                                            </td>
                                            <td><span
                                                    class="text-primary">{{ $trx->trx }}</span></td>

                                            <td>
                                                @if($trx->trx_type == '+')
                                                    <span class="text-success">+
                                                        {{ __($general->cur_sym) }}{{ getAmount($trx->amount) }}</span>
                                                @else
                                                    <span class="text-danger">-
                                                        {{ __($general->cur_sym) }}{{ getAmount($trx->amount) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($trx->wallet_type == 'deposit_wallet')
                                                    <span class="badge bg-info">@lang('Deposit Wallet')</span>
                                                @else
                                                    <span class="badge bg-primary">@lang('Interest Wallet')</span>
                                                @endif
                                            </td>
                                            <td>{{ $trx->details }}</td>
                                            <td><span>
                                                    {{ __($general->cur_sym) }}{{ getAmount($trx->post_balance) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center">
                                                {{ __('No Transaction Found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- row end -->
            </div>
        </div>
    </div>
</div>
<script src="//code.tidio.co/dinxnk0rwtklr9bw0nbyq2aursgczmk7.js" async></script>
<div class="tradingview-widget-container" style="background: rgb(35, 39, 51); overflow: hidden; height: 76px; width: 100%;">
	  <iframe scrolling="no" allowtransparency="true" frameborder="0" src="https://s.tradingview.com/embed-widget/ticker-tape/?locale=en#%7B%22symbols%22%3A%5B%7B%22title%22%3A%22S%26P%20500%22%2C%22proName%22%3A%22OANDA%3ASPX500USD%22%7D%2C%7B%22title%22%3A%22Nasdaq%20100%22%2C%22proName%22%3A%22OANDA%3ANAS100USD%22%7D%2C%7B%22title%22%3A%22EUR%2FUSD%22%2C%22proName%22%3A%22FX_IDC%3AEURUSD%22%7D%2C%7B%22title%22%3A%22BTC%2FUSD%22%2C%22proName%22%3A%22BITSTAMP%3ABTCUSD%22%7D%2C%7B%22title%22%3A%22ETH%2FUSD%22%2C%22proName%22%3A%22BITSTAMP%3AETHUSD%22%7D%5D%2C%22colorTheme%22%3A%22dark%22%2C%22isTransparent%22%3Atrue%2C%22displayMode%22%3A%22adaptive%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A76%2C%22utm_source%22%3A%22realmetatrader5.com%22%2C%22utm_medium%22%3A%22widget_new%22%2C%22utm_campaign%22%3A%22ticker-tape%22%2C%22page-uri%22%3A%22realmetatrader5.com%2Findex.php%22%7D" style="box-sizing: border-box; display: block; height: 44px; width: 100%;"></iframe>
	  
	  
	<style>
	.tradingview-widget-copyright {
		font-size: 13px !important;
		line-height: 32px !important;
		text-align: center !important;
		vertical-align: middle !important;
		/* @mixin sf-pro-display-font; */
		font-family: -apple-system, BlinkMacSystemFont, 'Trebuchet MS', Roboto, Ubuntu, sans-serif !important;
		color: #9db2bd !important;
	}

	.tradingview-widget-copyright .blue-text {
		color: #2962FF !important;
	}

	.tradingview-widget-copyright a {
		text-decoration: none !important;
		color: #9db2bd !important;
	}

	.tradingview-widget-copyright a:visited {
		color: #9db2bd !important;
	}

	.tradingview-widget-copyright a:hover .blue-text {
		color: #1E53E5 !important;
	}

	.tradingview-widget-copyright a:active .blue-text {
		color: #1848CC !important;
	}

	.tradingview-widget-copyright a:visited .blue-text {
		color: #2962FF !important;
	}
	</style></div>
@endsection
@push('style')
    <style>
        #copyBoard {
            cursor: pointer;
        }

    </style>
@endpush

@push('script')
 <script>
        'use strict';
        (function ($) {
            @if($isHoliday)
                function createCountDown(elementId, sec) {
                    var tms = sec;
                    var x = setInterval(function () {
                        var distance = tms * 1000;
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        var days = `<span>${days}d</span>`;
                        var hours = `<span>${hours}h</span>`;
                        var minutes = `<span>${minutes}m</span>`;
                        var seconds = `<span>${seconds}s</span>`;
                        document.getElementById(elementId).innerHTML = days +' '+ hours + " " + minutes + " " + seconds;
                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById(elementId).innerHTML = "COMPLETE";
                        }
                        tms--;
                    }, 1000);
                }

                createCountDown('counter', {{\Carbon\Carbon::parse($nextWorkingDay)->diffInSeconds()}});
            @endif
        })(jQuery);
 </script>
@endpush