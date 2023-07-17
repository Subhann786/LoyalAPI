<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function purchase(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'product_id' => 'required|exists:products,product_id',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $user = User::find($request->user_id);
        $product = Product::find($request->product_id);

        // Add earned points 
        $user->earned_points += $product->points;
        $user->save();

        // order record 
        $order = new Order();
        $order->user_id = $request->user_id;
        $order->product_id = $request->product_id;
        $order->save();

        $response = [
            'success' => true,
            'message' => 'Purchase successful',
            'data' => [
                'user_id' => $request->user_id,
                'product_id' => $request->product_id
            ]
        ];

        return response()->json($response, 200);
    }
      
    public function redeem(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $user = User::find($request->user_id);
        $product = Product::find($request->product_id);

        //  check enough earned points 
        if ($user->earned_points >= $product->points) {
            // Deductuction 
            $user->earned_points -= $product->points;
              
            // user's redeemed_points field
            $user->redeemed_points += $product->points;

            $user->save();

            // order record 
            $order = new Order();
            $order->user_id = $request->user_id;
            $order->product_id = $request->product_id;
            $order->save();

            $response = [
                'success' => true,
                'message' => 'Redemption successful',
                'data' => [
                    'user_id' => $request->user_id,
                    'product_id' => $request->product_id
                ]
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Insufficient points for redemption'
            ];
        }

        return response()->json($response, 200);
    }

}
