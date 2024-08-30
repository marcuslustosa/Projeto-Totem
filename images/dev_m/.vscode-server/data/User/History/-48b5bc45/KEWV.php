<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Studio;
use App\Models\Address;
use App\Traits\StudioTrait;

class LandingpageController extends Controller
{
    use StudioTrait;

    public function index($slug)
    {
        $studio = Studio::where('slug', $slug)->firstOrFail();
        $images = $this->getStudioImages($studio->id);
        $sliderImages = array('images/lp/1.jpg', 'images/lp/2.jpg');
        $trainers = $this->getDynamoStudioTrainers($studio->id);

        return view('pages.landing-page', compact('studio', 'images', 'trainers', 'sliderImages'));
    }

    public function indexWithCampaign($slug, $campaignCode, $origin)
    {
        $studio = Studio::where('slug', $slug)->firstOrFail();
        $address = Address::where('id', $studio->studioAddressId)->firstOrFail();
        $campaign = Campaign::where('code', $campaignCode)->firstOrFail();
        $trainers = $this->getDynamoStudioTrainers($studio->id);
        $images = $this->getStudioImages($studio->id);
        $sliderImages = array('images/lp/1.jpg', 'images/lp/2.jpg');
        return view('pages.landing-page', compact('studio','address', 'campaign', 'origin', 'trainers', 'images', 'sliderImages'));
    }
}
