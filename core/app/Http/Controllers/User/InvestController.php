<?php

namespace App\Http\Controllers\User;

use App\Lib\HyipLab;
use App\Models\Plan;
use App\Models\Invest;
use App\Models\Transaction;
use App\Models\UserRanking;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;

class InvestController extends Controller
{
    public function invest(Request $request)
    {
        $request->validate([
            'amount'      => 'required|min:0',
            'plan_id'     => 'required',
            'wallet_type' => 'required',
        ]);
        $user = auth()->user();
        $plan = Plan::with('timeSetting')->whereHas('timeSetting', function ($time) {
            $time->where('status', 1);
        })->where('status', 1)->findOrFail($request->plan_id);
        $amount = $request->amount;

        //Check limit
        if ($plan->fixed_amount > 0) {
            if ($amount != $plan->fixed_amount) {
                $notify[] = ['error', 'Please check the investment limit'];
                return back()->withNotify($notify);
            }
        } else {
            if ($request->amount < $plan->minimum || $request->amount > $plan->maximum) {
                $notify[] = ['error', 'Please check the investment limit'];
                return back()->withNotify($notify);
            }
        }

        $wallet = $request->wallet_type;

        //Direct checkout
        if ($wallet != 'deposit_wallet' && $wallet != 'interest_wallet') {

            $gate = GatewayCurrency::whereHas('method', function ($gate) {
                $gate->where('status', 1);
            })->find($request->wallet_type);

            if (!$gate) {
                $notify[] = ['error', 'Invalid gateway'];
                return back()->withNotify($notify);
            }

            if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
                $notify[] = ['error', 'Please follow deposit limit'];
                return back()->withNotify($notify);
            }

            $data = PaymentController::insertDeposit($gate, $request->amount, $plan);
            session()->put('Track', $data->trx);
            return to_route('user.deposit.confirm');
        }

        if ($request->amount > $user->$wallet) {
            $notify[] = ['error', 'Your balance is not sufficient'];
            return back()->withNotify($notify);
        }

        $hyip = new HyipLab($user, $plan);
        $hyip->invest($amount, $wallet);

        $notify[] = ['success', 'Invested to plan successfully'];
        return back()->withNotify($notify);
    }

    public function statistics()
    {
        $pageTitle  = 'Invest Statistics';
        $invests    = Invest::where('user_id', auth()->id())->orderBy('id', 'desc')->with('plan')->where('status', 1)->paginate(getPaginate(10));
        $activePlan = Invest::where('user_id', auth()->id())->where('status', 1)->count();

        $investChart = Invest::where('user_id', auth()->id())->with('plan')->groupBy('plan_id')->select('plan_id')->selectRaw("SUM(amount) as investAmount")->orderBy('investAmount', 'desc')->get();
        return view($this->activeTemplate . 'user.invest_statistics', compact('pageTitle', 'invests', 'investChart', 'activePlan'));
    }

    public function log()
    {
        $pageTitle = 'Invest Logs';
        $invests   = Invest::where('user_id', auth()->id())->orderBy('id', 'desc')->with('plan')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.invests', compact('pageTitle', 'invests'));
    }

    public function details($id)
    {
        $pageTitle    = 'Investment Details';
        $invest       = Invest::with('plan', 'user')->where('user_id', auth()->id())->findOrFail(decrypt($id));
        $transactions = Transaction::where('invest_id', $invest->id)->orderBy('id', 'desc')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.invest_details', compact('pageTitle', 'invest', 'transactions'));
    }

    public function ranking()
    {
        if(!gs()->user_ranking){
            abort(404);
        }
        
        $pageTitle = 'User Ranking';
        $userRankings = UserRanking::active()->get();
        $user = auth()->user()->load('userRanking', 'referrals');

        return view($this->activeTemplate.'user.user_ranking', compact('pageTitle','userRankings', 'user'));
    }

}
