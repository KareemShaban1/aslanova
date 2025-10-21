<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SubProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json(['orders' => $orders], 200);
    }
    public function store(Request $request)
    {
        // التحقق من صحة الطلب
        $validator = Validator::make($request->all(), [
            'orders' => 'required|array',
            'orders.*.sub_products_id' => 'required|integer',
            'orders.*.Required_quantity' => 'required|integer',
            'orders.*.address' => 'required|string|max:255',
            'orders.*.totalprice' => 'required|numeric',
            'orders.*.status' => 'required|string|max:255',
            'orders.*.user_id' => 'required|integer'
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['errors' => $errors, 'input' => $request->all()], 400);
        }
    
        $orders = $request->orders;
    
        foreach ($orders as $orderData) {
            $product_id = $orderData['sub_products_id'];
            $requiredQuantity = $orderData['Required_quantity'];
            $order_number = uniqid(); // إنشاء رقم طلب عشوائي
            $address = $orderData['address'];
            $totalprice = $orderData['totalprice'];
            $status = $orderData['status'];
            $user_id = $orderData['user_id'];
    
            // البحث عن المنتج باستخدام معرف المنتج
            $product = SubProduct::find($product_id);
    
            if ($product) {
                // التأكد من توفر الكمية المطلوبة في المخزون
                if ($product->quantity >= $requiredQuantity) {
                    // تنقيص الكمية المطلوبة من المخزون
                    $product->quantity -= $requiredQuantity;
                    $product->save();
    
                    // إضافة تفاصيل البيع إلى جدول الفواتير
                    Order::create([
                        'sub_products_id' => $product_id,
                        'Required_quantity' => $requiredQuantity,
                        'order_number' => $order_number,
                        'address' => $address,
                        'totalprice' => $totalprice,
                        'status' => $status,
                        'user_id' => $user_id,
                    ]);
                } else {
                    return response()->json(['error' => 'الكمية المطلوبة غير متوفرة في المخزون.'], 400);
                }
            } else {
                return response()->json(['error' => 'المنتج غير موجود.'], 404);
            }
        }
    
        return response()->json(['success' => 'تم تنفيذ العملية بنجاح.'], 201);
    }
    
    public function show(Order $order)
    {
        return response()->json(['order' => $order], 200);
    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'order_number' => 'string|max:255',
            'user_id' => 'exists:users,id',
            'products_id' => 'exists:products,id',
            'address' => 'string|nullable',
            'totalprice' => 'numeric',
            'status' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $order->update($request->all());

        return response()->json(['order' => $order], 200);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'order deleted successfully'], 200);
    }


}
