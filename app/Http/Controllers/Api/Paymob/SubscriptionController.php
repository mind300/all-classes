<?php

namespace App\Http\Controllers\Api\Paymob;
// Controllers
use App\Http\Controllers\Controller;
// Illuminate
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
// Models
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionUser;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Card;

class SubscriptionController extends Controller
{
    // Retrieves token or refreshes it if expired
    protected function getToken()
    {
        return  Cache::remember('paymob_token', now()->addSeconds(30), function () {
            $response = Http::paymob()->post('api/auth/tokens', ['api_key' => env('PAYMOB_API_KEY'),]);
            return $response->successful() ? $response['token'] : null;
        });
    }

    // Generic request method with automatic token handling and retry on 401
    protected function paymobRequest($method, $endpoint, $data = [])
    {
        $token = $this->getToken(); // Get Token from caching

        $response = Http::paymob()->withToken($endpoint == 'v1/intention/' ? env('PAYMOB_SECRET_KEY') : $token)->$method($endpoint, $data);

        if ($response->status() === 401) {
            Cache::forget('paymob_token');
            $token = $this->getToken();
            $response = Http::paymob()->withToken($token)->$method($endpoint, $data);
        }

        return $response;
    }

    // =========================================== Subscriptions Plans ================================================= //
    // Create Subscription Plan using paymobRequest
    public static function createSubscriptionPlan($data)
    {
        $data = array_merge($data, ['webhook_url' => 'https://yellowgreen-raccoon-480548.hostingersite.com/api/subscription/callback']);
        $instance = new self();
        return $instance->paymobRequest('post', 'api/acceptance/subscription-plans', $data);
    }

    // Suspend Subscription Plan using paymobRequest
    public static function suspendSubscriptionPlan($subscription_id)
    {
        $instance = new self();
        return $instance->paymobRequest('post', "api/acceptance/subscription-plans/{$subscription_id}/suspend");
    }

    // Resume Subscription Plan using paymobRequest
    public static function resumeSubscriptionPlan($subscription_id)
    {
        $instance = new self();
        return $instance->paymobRequest('post', "api/acceptance/subscription-plans/{$subscription_id}/resume");
    }

    // Update Subscription Plan using paymobRequest
    public static function updateSubscriptionPlan($data)
    {
        $instance = new self();
        return $instance->paymobRequest('put', "api/acceptance/subscription-plans/{$data['subscription_plan_id']}", $data);
    }

    // =========================================== Subscripe User ================================================= //
    // Subscribe in plane using paymobRequest
    public static function intention($data)
    {
        $subscription = (new SubscriptionPlan)->setConnection('mind')->find($data['subscription_plan_id']);

        $data = array_merge($data, [
            'amount' => intval($subscription->amount_cents),
            'currency' => 'EGP',
            'subscription_plan_id' => intval($subscription->paymob_sub_id),
            'payment_methods' => [intval(env('PAYMOB_INTEGRATION_ID'))],
            'billing_data' => [
                'apartment' => 'dumy',
                'first_name' => auth()->user()->member->first_name,
                'last_name' => auth()->user()->member->last_name,
                'street' => 'dumy',
                'building' => 'dumy',
                'phone_number' => auth()->user()->member->mobile_number,
                'city' => 'cairo',
                'country' => 'egypt',
                'email' => $data['email'] ?? auth()->user()->email,
                'floor' => 'dumy',
                'state' => 'dumy'
            ],
        ]);

        $instance = new self();
        return $instance->paymobRequest('post', 'v1/intention/', $data);
    }

    public function callback(Request $request)
    {
        $data = $request->json()->all();
        // ======================================= Transaction Data ==================================== //
        if (isset($data['type']) && $data['type'] === 'TRANSACTION') {

            // Intialize Transaction Data
            $transactionData = $data['obj'] ?? [];

            // Check User
            $user = User::firstWhere('email', $transactionData['payment_key_claims']['billing_data']['email'] ?? '');

            if ($user) {
                // Add cards data
                $card = Card::firstOrCreate([
                    'user_id' => $user->id,
                    'card_number' => $transactionData['data']['card_num'] ?? 'N/A', 
                    'card_type' => $transactionData['data']['card_type'] ?? 'N/A',
                    'masked_pan' => $transactionData['source_data']['pan'] ?? 'N/A',
                ]);
            }

            // Check Subscription Plan
            $subscriptionPlans = (new SubscriptionPlan)->setConnection('mind')->firstWhere('paymob_sub_id', $transactionData['payment_key_claims']['subscription_plan_id']);

            // Add transaction data
            (new Transaction)->setConnection('mind')->create([
                'paymob_trans_id' => $transactionData['id'],
                'amount_cents' => $transactionData['amount_cents'],
                'currency' => $transactionData['order']['currency'],
                'first_name' => $transactionData['payment_key_claims']['billing_data']['first_name'] ?? 'N/A',
                'last_name' => $transactionData['payment_key_claims']['billing_data']['last_name'] ?? 'N/A',
                'email' => $transactionData['payment_key_claims']['billing_data']['email'] ?? 'N/A',
                'mobile_number' => $transactionData['payment_key_claims']['billing_data']['phone_number'] ?? 'N/A',
                'card_number' => $transactionData['data']['card_num'] ?? 'N/A',
                'card_type' => $transactionData['data']['card_type'] ?? 'N/A',
                'masked_pan' => $transactionData['source_data']['pan'] ?? 'N/A',
                'subscription_plan_id' => $subscriptionPlans->id,
                "success" => $transactionData['success'],
            ]);
            if ($transactionData['success']) {
                point_system('renew_subscription', false, $user->id);
            }
        }

        // ======================================= Subscription Data ==================================== //
        if (isset($data['subscription_data']) && $data['trigger_type'] === 'Subscription Created') {

            // Intialize Subscription Data
            $subscriptionData = $data['subscription_data'] ?? [];

            // Check User
            $user = User::firstWhere('email', $subscriptionData['client_info']['email'] ?? '');

            if ($user) {
                // Add subscription for the user
                SubscriptionUser::create([
                    'user_id' => $user->id,
                    'paymob_sub_id' => $subscriptionData['plan_id'] ?? null,
                    'plan_name' => $subscriptionData['name'] ?? 'N/A',
                    'amount_cents' => $subscriptionData['amount_cents'] ?? 0,
                    'starts_at' => $subscriptionData['starts_at'] ?? now(),
                    'next_billing' => $subscriptionData['next_billing'] ?? null,
                    'reminder_date' => $subscriptionData['reminder_date'] ?? null,
                    'hmac' => $data['hmac'] ?? null,
                    'card_token' => $data['card_data']['token'] ?? 'N/A',
                    'masked_pan' => $data['card_data']['masked_pan'] ?? 'N/A',
                    'transaction_id' => $data['transaction_id'] ?? null,
                ]);

                if (isset($data['card_data']['token'])) {
                    $masked_pan = substr($data['card_data']['masked_pan'], -4);
                    $card_token = $data['card_data']['token'];
                    $card = Card::firstWhere('masked_pan', $masked_pan);
                    if ($card) {
                        $card->primary == 1 ? $card->update(['card_token' => $card_token]) :  $card->update(['card_token' => $card_token, 'primary' => 1]);
                    }
                }
            }
        }
        return messageResponse();
    }
}
