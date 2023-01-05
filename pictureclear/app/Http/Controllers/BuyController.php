<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use App\Models\Sale;
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
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {   
        $subscribed_users = DB::select('select user_id from sales where tier_id IN(select id from tiers where course_id=' . $request->course . ') and user_id=' . Auth::User()->id . '');
        if (count($subscribed_users)>0){
            return redirect("https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley");
            
        }
        $course = DB::select("SELECT * from courses where id =". $request->course);
        $tiers = DB::select("SELECT * from tiers where course_id =". $request->course);
        return view("buyCourse", ["course"=>$course, "tiers" => $tiers]);
    }

    public function buy(Request $request){
        
        $price = DB::select("SELECT price from tiers where id =". $request->tier);
        if ($request->saldo){
            if (Auth::user()->balance<$price[0]->price){
                return redirect("https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley");
                //RICK ROLL NO HACKER
            } else{
                $balance  = Auth::user()->balance;
                $balance = $balance - $price[0]->price;
                DB::update('update users set balance=? where id=?', [$balance,Auth::user()->id]);
                $sellerId = DB::select("SELECT owner_id from courses where id =". $request->course);
                $aux = DB::select("SELECT balance from users where id =". $sellerId[0]->owner_id);
                $sellerBalance = $aux[0]->balance + ($price[0]->price - $price[0]->price*0.03);
                DB::update('update users set balance=? where id=?', [$sellerBalance,$sellerId[0]->owner_id]);

                Sale::insert([
                    ['user_id' => Auth::user()->id, 'tier_id' => $request->tier]
                ]);
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

        $sellerId = DB::select("SELECT owner_id from courses where id =". $request->course);
        $aux = DB::select("SELECT balance from users where id =". $sellerId[0]->owner_id);
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

    public function success(Request $request){
        DB::update('update users set balance=? where id=?', [$request->sellerBalance,$request->sellerId]);
        Sale::insert([
            ['user_id' => Auth::user()->id, 'tier_id' => $request->tier]
        ]);
        echo "Compra efetuada e registada com sucesso. <br> Redirecionar para página o curso";
    }

   

}