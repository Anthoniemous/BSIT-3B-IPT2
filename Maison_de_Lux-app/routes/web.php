<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//Giunsa nimo pag-secure ang imong Admin routes?"
//Tubag: "Naggamit ko og Middleware Group sa web.php nga naay auth, is_admin, ug verified. 
// Kini nagsiguro nga ang naka-login ra, admin ra, 
//ug verified ra ang email ang maka-access sa admin dashboard.
//"Sa imong Google Login, unsaon nimo pag-handle kung ang user wala pa'y account?"
//Tubag: "Kung ang email sa Google user wala pa sa akong database, 
//i-redirect nako sila sa register page uban ang ilang 
//Google name ug email aron dili na sila mag-type og balik.
//Google OAuth 2.0 API,Laravel Socialite (Internal API Wrapper),Laravel Eloquent API,RESTful Route Architecture(get,post,patch,delete)
/*
|--------------------------------------------------------------------------
| GOOGLE AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])
    ->name('google.auth'); //tugot sa mga users nga maka-login o maka-register sa app 
                            //gamit ang Google account imbes nga mag-type pa sila og username ug password.

Route::get('auth/google/callback', [GoogleAuthController::class, 'callbackGoogle']);

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
//Ang purpose niani nga code mao ang pag-set sa imong Landing Page o ang Homepage sa website.
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| SHOP ROUTES (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/shop', [ProductController::class, 'userShop'])->name('shop'); //– Gigamit aron ipakita ang listahan sa mga baligya.
Route::get('/product/{product}', [ProductController::class, 'userShow'])->name('user.product.show');

/*
|--------------------------------------------------------------------------
| USER DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('user.home');
})->middleware(['auth:web', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
//Gigamit na aron i-grupo ang mga routes nga kinahanglan og Authentication. Buot pasabot, 
// ang mga routes sa sulod (sama sa Profile, Cart, Checkout) 
// dili ma-access sa user kung dili sila naka-login. 
// Ang auth:web nagsiguro nga ang 'web' guard ang gamiton.



Route::middleware(['auth:web'])->group(function () { 

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); //Gi-update lang ang specific fields sa imong profile.
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CART
    Route::get('/cart', [CartController::class, 'show'])->name('cart'); //Gigamit aron makita ang sulod sa cart.
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add'); //Nagdugang og bag-ong item sa cart.
    Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');

    // WISHLIST
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add', [WishlistController::class, 'store'])->name('wishlist.add'); //Nagpasa og data aron i-save sa wishlist.
    Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'destroy'])->name('wishlist.remove');
    Route::post('/wishlist/move-to-cart/{productId}', [WishlistController::class, 'moveToCart'])
        ->name('wishlist.moveToCart');

    // CHECKOUT
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');

    // ORDERS
    Route::get('/myorders', function () { //Ang tawag niana kay Eager Loading. Gigamit nako ang with() aron ma-minimize ang SQL queries. Imbes nga mag-query sa database matag order para makuha ang items (N+1 problem), usa ra ka query ang buhaton sa Laravel para makuha tanan related items.
    $orders = Auth::user()
        ->orders()
        ->with('orderItems')
        ->latest()
        ->get();

    return view('user.myorders.index', compact('orders')); 
})->name('myorders');

    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');//kuha ug data
    Route::patch('/orders/{order}/update', [OrderController::class, 'update'])->name('orders.update');//edit ug data
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');//magapasa ug data padulong sa server
    Route::delete('/orders/{order}/delete', [OrderController::class, 'delete'])->name('orders.delete');//e-remove ang data

    // TRANSACTIONS (CUSTOMER)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (ADMIN GUARD ONLY)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin', 'verified'])->group(function () {//tanan routes magsugod sa,something added at the beggining, for /admin, it means pang admin lang na dashboard etc..
    //Aron tanan routes sa sulod niana nga grupo automatic na nga naay /admin sa ilang URL 
    // (pananglitan: /admin/dashboard, /admin/products). 
    // Nakatabang sab ni sa pag-organize sa code para sa Admin functionalities ra gyud.
    //kung dli admin e block sa is_admin
    // ADMIN DASHBOARD
    Route::get('/dashboard', function () { // ang purpose nko ani kay ang pag-generate sa Admin Dashboard statistics, which is ge compute niya ang sulod sa database aron ipakita ang summary

        $totalProducts = \App\Models\Product::count(); //kani Laravel Eloquent API
        $totalSalesToday = \App\Models\Order::whereDate('created_at', today())->sum('total_amount');
        $totalSalesMonth = \App\Models\Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        $totalSalesYear = \App\Models\Order::whereYear('created_at', now()->year)->sum('total_amount');

        $totalOrders = \App\Models\Order::count();
        $pendingShipments = \App\Models\Order::where('status', 'pending')->count();
        $cancelledOrders = \App\Models\Order::where('status', 'cancelled')->count();
        $totalCustomers = \App\Models\User::where('role', 'user')->count();

        $lowStockProducts = \App\Models\Product::where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity', 'asc')
            ->limit(10)
            ->get();

        $topSellingProducts = \App\Models\OrderItem::select(
                'products.product_name',
                'products.product_image',
                \DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->groupBy(
                'order_items.product_id',
                'products.product_name',
                'products.product_image'
            )
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('totalProducts',
            'totalSalesToday',
            'totalSalesMonth',
            'totalSalesYear',
            'totalOrders',
            'pendingShipments',
            'totalCustomers',
            'cancelledOrders',
            'lowStockProducts',
            'topSellingProducts'
        ));
    })->name('dashboard');

    // ADMIN MANAGEMENT ROUTES
    Route::resource('products', ProductController::class); //shortcut sa laravel para dili na mag-tagsa-tagsa ug himo sa index,create,show,edit,update,destroy
    Route::resource('orders', OrderController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('shippings', ShippingController::class);

    Route::patch('/transactions/{id}/status', [TransactionController::class, 'updateStatus'])
        ->name('transactions.updateStatus'); //Ang "status" ra sa transaction ang gi-usab, dili ang tibuok transaction data.
                                            //Tungod kay ang PATCH maoy saktong HTTP method kung 'partial update' lang ang buhaton (sama sa pag-usab sa status ra), 
                                            // samtang ang POST kasagaran para sa paghimo og bag-ong data.
    // CUSTOMERS
    Route::get('/customers', function () { //Gibuhat nako ni para sa dali nga pag-retrieve sa statistics (Total Sales, Orders, etc.) para sa dashboard view
        $customers = \App\Models\User::where('role', 'user')->paginate(10);
        return view('admin.customers.index', compact('customers'));
    })->name('customers.index');

    // XML EXPORT ,Tungod kay gawas sa standard CRUD, kinahanglan nako og feature para sa Data Portability. 
    // Kini nga route nag-trigger sa XmlStorageService aron i-convert ang product data ngadto sa XML format, 
    // nga usa sa mga requirements sa project rubric ubos sa Documentation/Functionality."
    Route::get('/products/export-xml/all', [ProductController::class, 'exportAllToXml'])
        ->name('products.export.xml');

    Route::get('/products/{product}/xml', [ProductController::class, 'viewXml'])
        ->name('products.view.xml');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
