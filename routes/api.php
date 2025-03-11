    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ScheduledSmsController;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');



    Route::post('/schedule-sms', [ScheduledSmsController::class, 'scheduleSms']);
