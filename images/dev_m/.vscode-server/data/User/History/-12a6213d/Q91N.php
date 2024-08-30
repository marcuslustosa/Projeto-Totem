<?php

use App\Models\Studio;
use App\Models\StudioExtras;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

function isAdmin()
{
    $hostsEnableds = explode(',', env('EMAILS_ADMIN'));

    return in_array(Auth::user()->email, $hostsEnableds);
}

function studioSelect()
{
    if (Auth::user()->role != 'STUDIO') return '';


    if (Session::has('selectedStudio')) {
        $selectedStudio = Session::get('selectedStudio');
    } else {
        return '';
    }

    $studios = Studio::select('id', 'name')->where('cognitoAuthId', Auth::user()->cognitoAuthId)->get();

    $html = '<div class="profile-box">' . $selectedStudio['name'] . '</div>';

    if (count($studios) > 1) {
        $html .= '<ul class="profile-dropdown onhover-show-div">';
        foreach ($studios as $studio) {
            if ($studio->id != $selectedStudio['id'])
                $html .= '<li><a href="/studios-select?studioID=' . $studio->id . '&returnTo=' . \Request::url() . '"><span>' . $studio->name . '</span></a></li>';
        }
        $html .= '</ul>';
    }

    return $html;
}

function selectedStudioId()
{
    try {
        $selectedStudio = Session::get('selectedStudio');
        return $selectedStudio['id'];
    } catch (\Throwable $th) {
        return '';
    }
}

function campaignOrigins($campaign = null)
{
    return [
        [
            'name' => 'Landing Page',
            'url' => $campaign ? $campaign->getBaseURL() . '/0' : ''
        ],
        [
            'name' => 'Facebook',
            'url' => $campaign ? $campaign->getBaseURL() . '/1' : ''
        ],
        [
            'name' => 'Google',
            'url' => $campaign ? $campaign->getBaseURL() . '/2' : ''
        ],
        [
            'name' => 'Instagram',
            'url' => $campaign ? $campaign->getBaseURL() . '/3' : ''
        ],
        [
            'name' => 'LinkedIn',
            'url' => $campaign ? $campaign->getBaseURL() . '/4' : ''
        ],
        [
            'name' => 'Presencial',
            'url' => $campaign ? $campaign->getBaseURL() . '/5' : ''
        ],
        [
            'name' => 'Telefone',
            'url' => $campaign ? $campaign->getBaseURL() . '/6' : ''
        ],
        [
            'name' => 'WhatsApp',
            'url' => $campaign ? $campaign->getBaseURL() . '/7' : ''
        ],
        [
            'name' => 'YouTube',
            'url' => $campaign ? $campaign->getBaseURL() . '/8' : ''
        ],
    ];
}

function studioExtra($type, $studio_id, $default = '')
{
    $studioExtra = StudioExtras::select('value')->where('type', $type)->where('studio_id', $studio_id)->first();
    if ($studioExtra) return $studioExtra->value;

    return $default;
}

function s3Image(string $path = null)
{
    Storage::setVisibility($path, 'public');
    return env('AWS_S3_PUBLIC_FOLDER') . $path;
}

function leadStatus($statusID = null)
{
    $statusList = config('familiaMetalife.lead-status');
    if (is_null($statusID)) return $statusList;
    return $statusList[$statusID];
}

function postType($typeID = null)
{
    $postTypeList = config('familiaMetalife.post-types');
    if (is_null($typeID)) return $postTypeList;

    foreach ($postTypeList as $value) {
        if ($value['id'] == $typeID) return $value;
    }
}

function dynamoTables()
{
    $tables = [
        'Address',
        'Class',
        'ClassSerie',
        'Client',
        'Contract',
        'FreeClient',
        'Image',
        'LessonPlan',
        'Notification',
        'PlanPackage',
        'Reservation',
        'Studio',
        'Trainer',
        'User',
    ];
    return $tables;
}


function showCalendar($month, $year, $items = [])
{
    $date = mktime(12, 0, 0, $month, 1, $year);
    $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $offset = date("w", $date);
    $rowNumber = 1;



    function hasItem($day, $month, $year, $items)
    {
        if (isset($items[$year . '-' . $month . '-' . $day]))
            return true;

        return false;
    }

    function items($day, $month, $year, $items)
    {
        $html = '';
        if (isset($items[$year . '-' . $month . '-' . $day])) {
            foreach ($items[$year . '-' . $month . '-' . $day]['times'] as $key => $time) {
                $html .= $time['time']  . ' - ' . $time['reservations'] . '<br/>';
            }
        }
        return $html;
    }

    $html = "";
    $html .= "<div class='table-mobile-version table-responsive product-table'><table class='table table-bordered table-striped' style='text-align:center;'>";
    $html .= "<tr style='border-color:#000'><th  style='border-color:#000'>Dom</th><th  style='border-color:#000'>Seg</th><th  style='border-color:#000'>Ter</th><th  style='border-color:#000'>Qua</th><th  style='border-color:#000'>Qui</th><th  style='border-color:#000'>Sex</th><th  style='border-color:#000'>Sab</th></tr><tr  style='border-color:#000'>";
    for ($i = 1; $i <= $offset; $i++) {
        $html .= "<td  style='border-color:#000'></td>";
    }
    for ($day = 1; $day <= $numberOfDays; $day++) {
        if (($day + $offset - 1) % 7 == 0 && $day != 1) {
            $html .= "</tr> <tr style='border-color:#404040'>";
            $rowNumber++;
        }
        $html .= "<td style='padding:2px;height:44px; border-color:#404040; position:relative'><div style='text-align:right; color:#404040; font-size: .6rem;'>" . $day . "</div><div style='display:flex; flex-direction:column; align-items:center; padding: 5px; width:100px; margin: 5px auto; border-radius:5px; background-color:" . (hasItem($day, $month, $year, $items) ? '#00b1bc' : '') . ";'><div style='font-size:.7rem; color: #fff;'>" . items($day, $month, $year, $items) . "</div></div></td>";
    }
    while (($day + $offset) <= $rowNumber * 7) {
        $html .= "<td  style='border-color:#000'></td>";
        $day++;
    }
    $html .= "</tr></table></div>";

    return $html;
}

function accessLevelBadges(int $accessLevel)
{
    if ($accessLevel == 0) return '<span class="badge badge-success">A</span><span class="badge badge-warning">P</span><span class="badge badge-danger">E</span>';
    if ($accessLevel == 1) return '<span class="badge badge-warning">P</span><span class="badge badge-danger">E</span>';
    if ($accessLevel == 2) return '<span class="badge badge-danger">E</span>';

    return '-';
}


function userAccountStatus(string $status = null)
{

    $statusList = [
        'ACTIVE' => 'Ativo',
        'VALIDATING' => 'Validando',
        'PAYMENT_PENDING' => 'Pagamento pendente',
        'REFUSED' => 'Recusado',
        'CANCELED' => 'Cancelado',
    ];


    if (isset($status) && !empty($status)) {
        try {
            return $statusList[$status];
        } catch (\Throwable $th) {
            return '-';
        }
    }

    return $statusList;
}

function monthName(string $month)
{
    $months = [
        '01' => 'Janeiro',
        '02' => 'Fevereiro',
        '03' => 'Março',
        '04' => 'Abril',
        '05' => 'Maio',
        '06' => 'Junho',
        '07' => 'Julho',
        '08' => 'Agosto',
        '09' => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Dezembro',
    ];
    return $months[$month];
}


function fileSizeReadable($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function addAdminLog($message)
{
    Log::build([
        'driver' => 'single',
        'path' => storage_path('logs/admin-debug.log'),
    ])->info($message);
}
