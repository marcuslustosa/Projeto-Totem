<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Lead;
use App\Models\Template;
use App\Traits\DynamoDBTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Response;

class DashboardController extends Controller
{

    use DynamoDBTrait;

    public function index()
    {


        $clientsByGender = Client::where('studio_id', selectedStudioId())->get()->groupBy('gender')->map->count();

        //$clientsByAge[0] = Lead::where('studio_id', selectedStudioId())->whereBetween('birth', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();


        $leadsByStatus = Lead::where('studio_id', selectedStudioId())->where('status', '<', 4)->get()->groupBy('status')->map->count();

        //$getAverageCompletionTime = Lead::where('studio_id', selectedStudioId())/->select(DB::raw("AVG(created_at)"))/->get();

        $leads = Lead::where('studio_id', selectedStudioId())->orderBy('updated_at', 'DESC')->limit(9)->get();


        $leadsByDate[0] = Lead::where('studio_id', selectedStudioId())->whereDate('created_at', Carbon::now())->count();
        $leadsByDate[1] = Lead::where('studio_id', selectedStudioId())->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $leadsByDate[2] = Lead::where('studio_id', selectedStudioId())->whereMonth('created_at', Carbon::now()->month())->count();

        $leadsByDate[3] = Lead::where('studio_id', selectedStudioId())->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();

        // $templates = Template::orderBy('updated_at', 'DESC')->limit(8)->get();
        $templates = Template::where('type', 2)->orderBy('created_at', 'DESC')->limit(4)->get();

        return view('dashboard.index', [
            'leads' => $leads,
            'leadsByStatus' => $leadsByStatus,
            'leadsByDate' => $leadsByDate,
            'templates' => $templates,
            'clientsByGender' => $clientsByGender,
            'studioID' => selectedStudioId(),
        ]);
    }

    public function tablesList()
    {
        $cacheKey = "tablesSummary";
        if (!Cache::has($cacheKey))  Artisan::call('dynamo:get-tables-summary');

        if (Cache::has($cacheKey)) {
            return view('dashboard.tables', [
                'tables' => Cache::get($cacheKey)
            ]);
        }
    }
}
