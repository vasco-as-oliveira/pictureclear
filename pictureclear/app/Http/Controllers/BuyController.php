<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Chats;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use App\Models\Sale;
use App\Models\Tier;
use Stripe\Stripe;
use Stripe\Charge;
use Carbon\Carbon;

class BuyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'IsAdmin']);
    }

    public function index(Request $request)
    {
        $arrayOfTiers = Tier::select('id')
                        ->where('course_id', '=', $request->course)
                        ->where('user_id', '=', Auth::User()->id);
        $subscribedUsers = Sale::whereIn('tier_id', $arrayOfTiers)->get()->toArray();
        if (count($subscribedUsers)>0) {
            return back();
        }

        $course = Course::select('*')
                        ->where('id', '=', $request->course)->get()->toArray();

        $tiers = Tier::select('*')
                    ->where('course_id', '=', $request->course)->get()->toArray();
        return view("buyCourse", ["course"=>$course, "tiers" => $tiers]);
    }

    public function buy(Request $request)
    {
        $price = Tier::select('price')
                        ->where('id', '=', $request->tier)->get()->toArray();
        if ($request->saldo){
            if (Auth::user()->balance<$price[0]->price){
                return back();
                //RICK ROLL NO HACKER
            } else{
                $balance  = Auth::user()->balance;
                $balance = $balance - $price[0]->price;
                DB::update('update users set balance=? where id=?', [$balance,Auth::user()->id]);

                //$sellerId = DB::select("SELECT owner_id from courses where id =". $request->course);
                $sellerId = Course::select('owner_id')
                ->where('id', '=', $request->course)->get()->toArray();
                //$aux = DB::select("SELECT balance from users where id =". $sellerId[0]->owner_id);
                
                $aux = User::select('balance')
                ->where('id', '=', $sellerId[0]->owner_id)->get()->toArray();

                $sellerBalance = $aux[0]->balance + ($price[0]->price - $price[0]->price*0.03);
                DB::update('update users set balance=? where id=?', [$sellerBalance,$sellerId[0]->owner_id]);

                Sale::insert([
                    ['user_id' => Auth::user()->id, 'tier_id' => $request->tier]
                ]);
                
                //$tierBought = DB::select('SELECT * FROM tiers WHERE id ='.$request->tier);
                $tierBought = Tier::select('*')
                            ->where('id', '=', $request->tier)->get()->toArray();
                if($tierBought[0]->hasChatPerk){
                    Chats::insert(array(
                        'student_id' => Auth::user()->id,
                        'teacher_id' => $sellerId,
                    ));
                }
            }//
        } else {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $line_items[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Nome de curso'                    
                ],
                'unit_amount' => $price[0]->price *100
            ],
            'quantity' => 1
        ];

        //$sellerId = DB::select("SELECT owner_id from courses where id =". $request->course);
        $sellerId = Course::select('owner_id')
                        ->where('id', '=', $request->course)->get()->toArray();
        //$aux = DB::select("SELECT balance from users where id =". $sellerId[0]->owner_id);
        $aux = User::select('balance')
                    ->where('id', '=', $sellerId[0]->owner_id)->get()->toArray();
        $sellerBalance = $aux[0]->balance + ($price[0]->price - $price[0]->price*0.03);
        

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => url("/paymentSuccess?sellerId=".$sellerId[0]->owner_id . "&sellerBalance=" . $sellerBalance . "&tier=". $request->tier),
            'cancel_url' =>"https://www.youtube.com/watch?v=E9de-cmycx8&ab_channel=RickAstley"
        ]);
        return redirect($checkout_session->url);
        }
       
    }

    public function success(Request $request) {
        DB::update('update users set balance=? where id=?', [$request->sellerBalance,$request->sellerId]);
        Sale::insert([
            ['user_id' => Auth::user()->id, 'tier_id' => $request->tier]
        ]);

        //$tierBought = DB::select('SELECT * FROM tiers WHERE id ='.$request->tier);
        $tierBought = Tier::select('*')
                            ->where('id', '=', $request->tier)->get()->toArray();

        if($tierBought[0]->haschatperk){
            Chats::insert(array(
                'student_id' => Auth::user()->id,
                'teacher_id' => $request->sellerId,
            ));
        }

        return redirect(url("/home"));
    }

   

}