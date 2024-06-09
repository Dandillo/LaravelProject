<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Payment;
use App\Models\PaymentAward;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use League\Flysystem\Config;
use PHPUnit\Exception;
use YooKassa\Client;

class PaymentController extends Controller
{
    protected $rules = [
        'amount' => 'required',
    ];

//  Страница поддержать проект
    public function project_payment(Project $project)
    {
        if (!($project->status_id == 1 || $project->status_id == 2)) {
            abort('404');
        }
        $project->sum = $project->suc_payments->pluck('amount')->sum();
        $project->percent = round(($project->sum * 100) / $project->amount, 1);

        $awards = $project->awards;
        $checked_award = $_GET['award'] ?? null;
        return view('project.payment', compact(['project', 'awards', 'checked_award']));
    }

//  Обработка покупки, переадресация в юкассу
    public function requestYookassa(Project $project, Request $request)
    {
        if (!($project->status_id == 1 || $project->status_id == 2)) {
            abort('404');
        }
//      Проверка мин. суммы и наличия вознаграждения
        $award = Award::find($request->award_id);
        if (isset($award) && $award != []) {
            $paid_awards = $award->not_canc_payments->count();
            if ($paid_awards >= $award->quantity) {
                $validator = \Illuminate\Support\Facades\Validator::make([], []);
                $validator->getMessageBag()->add('amount', 'К сожалению, данное вознаграждение закончилось или недоступно');
                return Redirect::back()->withErrors($validator)->withInput();
            }
        }
        $min_cost = $award->min_cost ?? 100;
        $amount = $request->amount[$request->award_id ?? -1];

        if ($amount < $min_cost) {
            $validator = \Illuminate\Support\Facades\Validator::make([], []);
            $validator->getMessageBag()->add('amount', 'Минимальная стоимость ' . $min_cost . ' рублей');
            return Redirect::back()->withErrors($validator)->withInput();
        }

        //      Создания шлюза с юкассой
        $shop_id = env('YOOMONEY_SHOP');
        $secret = env('YOOMONEY_SECRET');

        try {
            $client = new Client();
            $client->setAuth($shop_id, $secret);
        } catch (\Exception $exception) {
            session()->flash('err_msg', 'Произошла ошибка оплаты. Проверьте ваше интернет подключение и попробуйте снова.');
            return Redirect::back();
        }

//      Создание чека
        $pay_check = Payment::create([
            'amount' => $amount,
            'project_id' => $project->id,
            'user_id' => Auth::id(),
        ]);

        if (isset($request->award_id)) {
            if (isset($award) && $award != []) {
                PaymentAward::create([
                    'award_id' => $request->award_id,
                    'payment_id' => $pay_check->id,
                ]);
            }
        }


//      Создание платежа
        try {
            $payment = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => $amount,
                        'currency' => 'RUB',
                    ),
                    'confirmation' => array(
                        'type' => 'redirect',
                        'return_url' => route('user.profile.payments'),
                    ),
                    'metadata' => array(
                        'award_id' => $request->award_id,
                        'amount' => $amount,
                        'payment_id' => $pay_check->id,
                    ),
                    'capture' => true,
                    'description' => "Покупка №" . $pay_check->id,
                ),
                uniqid('', true)
            );
        } catch (\Exception $exception) {
            session()->flash('err_msg', 'Произошла ошибка оплаты. Проверьте ваше интернет подключение и попробуйте снова.');
            $pay_check->update([
                'status' => 'canceled',
                'cancellation_reason' => $exception->getMessage() ?? null,
                'payment_created' => now(),
            ]);
            return Redirect::back();
        }

        if ($pay_check->amount != $payment->getAmount()->getValue()) {
            $error = 'Текущее значение чека ' . $pay_check->amount . 'руб.,
            а оплачено ' . $payment->getAmount()->getValue() . ' руб.';
        }
        if ($payment->getStatus() == 'canceled') {
            $cancellation_reason = $payment->getCancellationDetails()->getReason();
        }
//      обновление статуса чека
        $pay_check->update([
            'yoo_payment_id' => $payment->getId(),
            'status' => $payment->getStatus(),
            'description' => $error ?? $payment->getDescription(),
            'cancellation_reason' => $cancellation_reason ?? null,
        ]);

        return redirect($payment->getConfirmation()->getConfirmationUrl());
    }

//  Сохранение платежа
    public function store_payment(Request $request)
    {
        $payment = Payment::find($request->object['metadata']['payment_id']);

        if ($payment->yoo_payment_id == $request->object['id']) {
            if (isset($payment->object['cancellation_details']['reason'])) {
                $cancellation_reason = $payment->object['cancellation_details']['reason'];
            }

            $payment->update([
                'status' => $request->object['status'],
                'payment_created' => $request->object['created_at'],
                'cancellation_reason' => $cancellation_reason ?? null,
            ]);
        } else {
            Log::debug('Попытка записи данных в чек из ' . $request->ip());
        }
    }

//  Платежи пользователя
    public function user_payments()
    {
        $user = Auth::user();

        $payments = $user->payments()->orderByDesc('created_at')
            ->paginate(\Illuminate\Support\Facades\Config::get('paginate_count'));

        return view('user.user-payments', compact('payments'));

    }

//  Оформление возврата
    public function refund(Payment $payment)
    {
        $validator = \Illuminate\Support\Facades\Validator::make([], []);
        if (!($payment->status == 'succeeded')) {
            $validator->getMessageBag()->add('payment', 'Ошибка. Платеж еще не прошел');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $shop_id = env('YOOMONEY_SHOP');
        $secret = env('YOOMONEY_SECRET');
        $client = new Client();
        try {
            $client->setAuth($shop_id, $secret);
            $pay_info = $client->getPaymentInfo($payment->yoo_payment_id);
        } catch (\Exception $exception) {
            $validator->getMessageBag()->add('payment',
                'Ошибка подключение к Юкассе. '. $exception->getMessage());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if (!$pay_info->getRefundable()) {
            $validator->getMessageBag()->add('payment', 'Ошибка. Платеж нельзя вернуть или уже возвращен');
            return Redirect::back()->withErrors($validator)->withInput();
        }
//        Проверка соответствия сумм
        if ($payment->amount == $pay_info->getAmount()->getValue()) {
//            Создание возврата
            $idempotenceKey = uniqid('', true);
            try {
                $response = $client->createRefund(
                    array(
                        'payment_id' => $payment->yoo_payment_id,
                        'amount' => array(
                            'value' => $payment->amount,
                            'currency' => 'RUB',
                        ),
                    ),
                    $idempotenceKey
                );
            } catch (\Exception $exception) {
                $validator->getMessageBag()->add('payment',
                    'Ошибка обработки возврата в Юкассе. '. $exception->getMessage());
                return Redirect::back()->withErrors($validator)->withInput();
            }

//          Запись информации о возврате
            $payment->refund_status = $response->getStatus();
            $payment->refund_id = $response->getId();
            $payment->refund_amount = $response->getAmount()->getValue();
            $payment->save();
        } else {
            $validator->getMessageBag()->add('payment', 'Ошибка. Сумма платежа не соответсвует сумме на сайте');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        return Redirect::back();
    }
}


//"id":"294a84d3-000f-5000-8000-1474d6a69baa",
//"status":"pending",
//"recipient":
//{"account_id":"863722","gateway_id":"1925706"},
//"amount":{"value":"102.00","currency":"RUB"},
//"description":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u211611",
//"created_at":"2021-12-14T10:25:23.322+00:00",
//"confirmation":{"enforce":false,"confirmation_url":
//    "https:\/\/yoomoney.ru\/checkout\/payments\/v2\/contract?orderId=294a84d3-000f-5000-8000-1474d6a69baa","type":"redirect"},
//"paid":false,
//"refundable":false,
//"metadata":{"amount":"102","payment_id":"11"},"transfers":[],"test":true}

// Object from yookassa
//        $object = array(["id" => "294a7656-000f-5000-9000-119dd0b5f07b",
//            "status" => "succeeded",
//            "amount" => [
//                "value" => "5000.00",
//                "currency" => "RUB"],
//            "income_amount" => [
//                "value" => "4825.00", "currency" => "RUB"],
//            "description" => "\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u21167",
//            "recipient" => [
//                "account_id" => "863722",
//                "gateway_id" => "1925706"],
//            "payment_method" => [
//                "type" => "bank_card", "id" => "294a7656-000f-5000-9000-119dd0b5f07b", "saved" => false, "title" => "Bank card *1111", "card" => [
//                    "first6" => "411111", "last4" => "1111", "expiry_year" => "2022", "expiry_month" => "08", "card_type" => "Visa", "issuer_country" => "US"]],
//            "captured_at" => "2021-12-14T09:23=>42.479Z",
//            "created_at" => "2021-12-14T09:23:34.064Z",
//            "test" => true,
//            "refunded_amount" => [
//                "value" => "0.00", "currency" => "RUB"],
//            "paid" => true,
//            "refundable" => true,
//            "metadata" => [
//                "amount" => "5000", "payment_id" => "7"],
//            "authorization_details" => [
//                "rrn" => "552746135258094", "auth_code" => "668280", "three_d_secure" => [
//                    "applied" => false]]]);


